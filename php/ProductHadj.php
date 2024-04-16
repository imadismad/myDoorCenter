<?php
include_once __DIR__."/../BDD/interactionBDD.php";
include_once __DIR__."/../BDD/functionsSQL.php";
include_once __DIR__."/../BDD/interBDDProduit.php";
class Product {
    private string $name;
    private int $id;
    private float $unitaryPrice;
    private string $type;
    private string $description;
    private string $imageName;
    private Array $materials;
    private int $catalogue;
    public function __construct(string $name, int $id, float $unitaryPrice, string $type, string $description, string $imageName, int $catalogue) {
        $this->name = $name;
        $this->id = $id;
        $this->unitaryPrice = $unitaryPrice;
        $this->type = $type;
        $this->description = $description;
        $this->imageName = $imageName;
        $this->catalogue = $catalogue;
        $this->materials = array();
    }        

    public static function constructFromId(int $id): Product | null {
        $res = getBasicProductData($id);

        if ($res === null) return null;

        $product = new Product($res["nom"], $res["id"], floatval($res["prixUnitaire"]), $res["type"], $res["description"], $res["nomImage"], $res["estAuCatalogue"]);
        $materials = getMaterialsByProduct($id);

        foreach ($materials as $material) {
            $product->addMaterial(new Material($material["id"], $material["nom"], $material["densite"], $material["masseVolumique"]));
        }

        return $product;
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

    public function getId(): int {
        return $this->id;
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
        $this->name = $name;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setUnitaryPrice(float $unitaryPrice) {
        $this->unitaryPrice = $unitaryPrice;
    }

    public function setType(string $type) {
        $this->type = $type;
    }

    public function setDescription(string $description) {
        $this->description = $description;
    }

    public function setImageName(string $imageName) {
        $this->imageName = $imageName;
    }

    public function addMaterial(Material $material) {
        array_push($this->materials, $material);
    }
}

class Material {
    private int $id;
    private string $name;
    private float $relativeDensity;
    private float $density;

    public function __construct(int $id, string $name, float $relativeDensity, float $density) {
        $this->id = $id;
        $this->name = $name;
        $this->relativeDensity = $relativeDensity;
        $this->density = $density;
    }

    public function getId(): int {
        return $this->id;
    }
    
    public function getName(): string {
        return $this->name;
    }
    
    public function getRelativeDensity(): float {
        return $this->relativeDensity;
    }

    public function getDensity(): float {
        return $this->density;
    }
}