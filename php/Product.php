<?php
require_once "DBObject.php";
require_once "Material.php";
require_once "Option.php";
require_once "Redirect.php";
require_once __DIR__."/../BDD/interactionBDD.php";
class Product extends DBObject {
    // Prduct table
    private const TABLE_NAME            = "Produit";
    private const NAME_DB_NAME          = "nom";
    private const TYPE_DB_NAME          = "type";
    private const UNITARY_PRICE_DB_NAME = "prixUnitaire";
    private const DESCRIPTION_DB_NAME   = "description";
    private const IMAGE_NAME_DB_NAME    = "nomImage";
    private const IN_CATALOGUE_DB_NAME  = "estAuCatalogue";

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

    private Array $newMaterials; // New material add to the product
    private Array $oldMaterials; // Old material remove from the product

    private int $catalogue;

    public function __construct(string $name, float $unitaryPrice, string $type, string $description, string $imageName, int $catalogue) {
        parent::__construct(null, Product::TABLE_NAME);
        
        if ($name === "") throw new Exception("Product name can't be empty");
        if ($unitaryPrice < 0) throw new Exception("Product price can't be negative");
        if ($type === "") throw new Exception("Product type can't be empty");
        if ($catalogue !== 0 && $catalogue !== 1) throw new Exception("Product catalogue must be 0 or 1");

        $this -> setName($name);
        $this -> setUnitaryPrice($unitaryPrice);
        $this -> setType($type);
        $this -> setDescription($description);
        $this -> setImageName($imageName);
        $this -> setCatalogue($catalogue);
        
        $this -> materials = array();
        $this -> newMaterials = array();
        $this -> oldMaterials = array();
    }        

    public static function constructFromId(int $id): Product | null {
        $res = getBasicProductData($id);

        if ($res === null) return null;

        $product = new Product(
            $res[Product::NAME_DB_NAME],
            floatval($res[Product::UNITARY_PRICE_DB_NAME]),
            $res[Product::TYPE_DB_NAME],
            $res[Product::DESCRIPTION_DB_NAME],
            $res[Product::IMAGE_NAME_DB_NAME],
            $res[Product::IN_CATALOGUE_DB_NAME]
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

    /**
     * @return array all compatible and active option as Option object
     */
    public function getCompatibleBuyingOption() {
        return Option::constructAllFromType($this -> type, true);
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
        if ($catalogue !== 0 && $catalogue !== 1) throw new Exception("Product catalogue must be 0 or 1");
        $this -> addModification(Product::IN_CATALOGUE_DB_NAME, $catalogue);
        $this -> catalogue = $catalogue;
    }
    public function setName(string $name) {
        if ($name === "") throw new Exception("Product name can't be empty");
        $this -> addModification(Product::NAME_DB_NAME, $name);
        $this -> name = $name;
    }

    public function setUnitaryPrice(float $unitaryPrice) {
        if ($unitaryPrice < 0) throw new Exception("Product price can't be negative");
        $this -> addModification(Product::UNITARY_PRICE_DB_NAME, $unitaryPrice);
        $this->unitaryPrice = $unitaryPrice;
    }

    public function setType(string $type) {
        if ($type === "") throw new Exception("Product type can't be empty");
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

    /**
     * Remove a material from the product
     * @param Material $material the material to remove
     */
    public function removeMaterial(Material $material) {
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

    /**
     * Add a material to the product
     * @param Material $material the material to add
     */
    public function addMaterial(Material $material) {
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

    /**
     * Remove a material from the product from its id in BD
     * @param int $idMaterial the id of the material to remove
     */
    public function removeMaterialFromId(int $idMaterial) {
        $this -> removeMaterial(Material::constructFromId($idMaterial));
    }

    /**
     * Add a material to the product from its id in BD
     * @param int $idMaterial the id of the material to add
     */
    public function addMaterialFromId(int $idMaterial) {
        $this -> addMaterial(Material::constructFromId($idMaterial));
    }

    /**
     * Return the current stock of the product for each warehouse
     * If the product is not in stock, return false
     * @return array|false the current stock of the product for each warehouse, false if not in stock
     */
    public function getCurrentStock(): array|false {
        $stock = quantitePortesEnStockParEntrepot($this -> getId());
        if ($stock === null) throw new Exception("Error while getting stock");
        return $stock;
    }

    /**
     * Return the total quantity in stock for the product given by the id
     * @param int $id the id of the product
     * @return array|false the current stock of the product for each warehouse, false if not in stock
     */
    public static function getCurrentStockFromId(int $id): array|false {
        $stock = quantitePortesEnStockParEntrepot($id);
        if ($stock === null) throw new Exception("Error while getting stock");
        return $stock;
    }

    /**
     * Return the total quantity in stock for the current product
     * @return int the total quantity in stock
     */
    public function getQuantityInStock(): int {
        $stock = $this -> getCurrentStock();
        if ($stock === false) return 0;

        $total = 0;
        foreach ($stock as $entrepot) {
            $total += $entrepot["quantite"];
        }

        return $total;
    }

    /**
     * Return the total quantity in stock for the product given by the id
     * @param int $id the id of the product
     */
    public static function getQuantityInStockFromId(int $id): int {
        $stock = Product::getCurrentStockFromId($id);
        if ($stock === false) return 0;

        $total = 0;
        foreach ($stock as $entrepot) {
            $total += $entrepot["quantite"];
        }

        return $total;
    }

    /**
     * Return true if the product has enough in stock, else return the quantity missing
     * @param int $quantity the quantity to check
     * @return bool|int true if enough in stock, else the quantity missing
     */
    public function hasEnoughInStock(int $quantity): bool | int {
        $quantityInStock = $this -> getQuantityInStock();
        return $quantityInStock >= $quantity ? true : $quantity - $quantityInStock;
    }

    /**
     * Return true if the product given by the id has enough in stock, else return the quantity missing
     * @param int $id the id of the product
     * @param int $quantity the quantity to check
     */
    public static function hasEnoughtInStockFromId(int $id, int $quantity): bool | int {
        $quantityInStock = Product::getQuantityInStockFromId($id);
        return $quantityInStock >= $quantity ? true : $quantity - $quantityInStock;
    }

    public static function searchProduct($search = null, $type = null, $prixMin = null, $prixMax = null, $triNote = false): array  {
        $arrayResult = rechercherProduits($search, $type, $prixMin, $prixMax, $triNote);
        $arrayProduct = array();

        foreach ($arrayResult as $value) {
            $product = new Product(
                $value[Product::NAME_DB_NAME],
                floatval($value[Product::UNITARY_PRICE_DB_NAME]),
                $value[Product::TYPE_DB_NAME],
                $value[Product::DESCRIPTION_DB_NAME],
                $value[Product::IMAGE_NAME_DB_NAME],
                $value[Product::IN_CATALOGUE_DB_NAME]
            );
            $product -> setId($value["id"]);
            $product -> materials = Material::constructAllFromProduct($product -> getId());

            array_push($arrayProduct, $product);
        }

        return $arrayProduct;
    }
}
