<?php
require_once "DBObject.php";
require_once "Material.php";

class Product extends DBObject {
    // Prduct table
    private const TABLE_NAME            = "Produit";
    private const NAME_DB_NAME          = "nom";
    private const TYPE_DB_NAME          = "type";
    private const UNITARY_PRICE_DB_NAME = "prixUnitaire";
    private const DESCRIPTION_DB_NAME   = "description";
    private const IMAGE_NAME_DB_NAME    = "nomImage";

    // Compose table (for product and materials association)
    private const COMPOSE_TABLE_NAME           = "Composer";
    private const COMPOSE_PRODUCT_ID_DB_NAME    = "idProduit";
    private const COMPOSE_MATERIALS_ID_DB_NAME = "idMateriau";

    private string $name;
    private float $unitaryPrice;
    private string $type;
    private string $description;
    private string $imageName;
    private Array $materials;

    private int $catalogue;
    public function __construct(string $name, int $id, float $unitaryPrice, string $type, string $description, string $imageName, int $catalogue) {
    private Array $newMaterials; // New material add to the product
    private Array $oldMaterials; // Old material remove from the product



    public function __construct(string $name, float $unitaryPrice, string $type, string $description, string $imageName) {
        parent::__construct(null, Product::TABLE_NAME);
        $this->name = $name;
        $this->unitaryPrice = $unitaryPrice;
        $this->type = $type;
        $this->description = $description;
        $this->imageName = $imageName;
        $this->catalogue = $catalogue;
        $this->materials = array();
        $this->newMaterials = array();
        $this->oldMaterials = array();
    }        

    public static function constructFromId(int $id): Product | null {
        $res = getBasicProductData($id);

        if ($res === null) return null;


        $product = new Product($res["nom"], $res["id"], floatval($res["prixUnitaire"]), $res["type"], $res["description"], $res["nomImage"], $res["estAuCatalogue"]);
        $materials = getMaterialsByProduct($id);
        $product = new Product(
            $res[Product::NAME_DB_NAME],
            floatval($res[Product::UNITARY_PRICE_DB_NAME]),
            $res[Product::TYPE_DB_NAME],
            $res[Product::DESCRIPTION_DB_NAME],
            $res[Product::IMAGE_NAME_DB_NAME]
        );
        $product -> setId($res["id"]);
        $product -> materials = Material::constructAllFromProduct($product -> getId());

        return $product;
    }

    public function updateDB(): void {
        if ($this -> isUpToDate()) return;
        
        foreach ($this->oldMaterials as $material) {
            removeMaterialFromProduct($material -> getId(), $this -> getId());
        }
        $this->oldMaterials = [];

        foreach ($this->newMaterials as $material) {
            if ($material->getId() === null) $material -> updateDB();
            addMaterialFromProduct($material -> getId(), $this -> getId());
        }
        $this->newMaterials = [];

        parent::updateDB();
    }

    public function isUpToDate(): bool {
        return
            sizeof($this->newMaterials) === 0 &&
            sizeof($this->oldMaterials) === 0 &&
            parent::isUpToDate();
    }

    /**
     * Return the path to the miniature of the product
     */
    public function getMiniaturePath(): string {
        return "/images/miniature/".$this->getImageName();
    }

    public function getImagesPath(): Array {
        $images = [];
        foreach (new DirectoryIterator('./images/'.$this->getId()) as $file) {
            if($file->isDot()) continue;
            array_push($images, '/images/'.$this->getId()."/".$file->getFilename());
        }
        array_multisort($images);
        return $images;
    }

    /**
     * Return all materials name of the product
     */
    public function getMaterialsName(): array {
        $res = [];
        foreach ($this->materials as $material) {
            array_push($res, $material->getName());
        }
        return $res;
    }

    // Getters
    public function getName(): string {
        return $this->name;
    }

    public function getUnitaryPrice(): float {
        return $this->unitaryPrice;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getImageName(): string {
        return $this->imageName;
    }

    public function getPageLink(): string {
        return "/product.php?id=".$this->getId();
    }
    public function getCatalogue(): int{
        return $this->catalogue;
    }

    // Setters
    public function setCatalogue(int $catalogue){
        $this->catalogue = $catalogue;
    }
    public function setName(string $name) {
        $this -> addModification(Product::NAME_DB_NAME, $name);
        $this->name = $name;
    }

    public function setUnitaryPrice(float $unitaryPrice) {
        $this -> addModification(Product::UNITARY_PRICE_DB_NAME, $unitaryPrice);
        $this->unitaryPrice = $unitaryPrice;
    }

    public function setType(string $type) {
        $this -> addModification(Product::TYPE_DB_NAME, $type);
        $this->type = $type;
    }

    public function setDescription(string $description) {
        $this -> addModification(Product::DESCRIPTION_DB_NAME, $description);
        $this->description = $description;
    }

    public function setImageName(string $imageName) {
        $this -> addModification(Product::IMAGE_NAME_DB_NAME, $imageName);
        $this->imageName = $imageName;
    }

    public function removeMaterial(Material $material) {
        fwrite(STDERR, "AJOUTER LA MISE A JOUR DANS LA DB DES MATERIAUX");
        if (Material::searchMaterial($material, $this->oldMaterials) !== false) return;
        
        $indexM = Material::searchMaterial($material, $this->materials);
        if ($indexM === false) return;

         // S'il est dans newMaterials, alors il n'est pas dans la BDD, pas besoin de le retirer de la BDD
        if (($index = Material::searchMaterial($material, $this->newMaterials)) !== false) {
            array_splice($this -> newMaterials, $index, 1);
        } else {
            // N'est pas dans new materials, mais est dans materials => doit être retiré de la BDD
            array_push($this -> oldMaterials, $material);
        }
        
        array_splice($this -> materials, $indexM, 1);
    }

    public function addMaterial(Material $material) {
        fwrite(STDERR, "AJOUTER LA MISE A JOUR DANS LA DB DES MATERIAUX");
        if (Material::searchMaterial($material, $this->materials) !== false) return;

        if (($index = Material::searchMaterial($material, $this->oldMaterials)) !== false) {
            // Est dans oldMaterials, donc deja present dans la BDD
            array_splice($this -> oldMaterials, $index, 1);
        } else {
            // N'est pas dans oldMaterials => doit être ajouté à la bdd
            array_push($this->newMaterials, $material);
        }
            
        array_push($this->materials, $material);
    }

    public function removeMaterialFromId(int $idMaterial) {
        $this -> removeMaterial(Material::constructFromId($idMaterial));
    }

    public function addMaterialFromId(int $idMaterial) {
        $this -> addMaterial(Material::constructFromId($idMaterial));
    }
}
