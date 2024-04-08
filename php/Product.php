<?php
include_once __DIR__."/../BDD/product.php";

class Product {
    private string $name;
    private int $id;
    private float $unitaryPrice;
    private string $type;
    private string $description;
    private string $imageName;
    private string $pageLink;

    public function __construct(string $name, int $id, float $unitaryPrice, string $type, string $description, string $imageName, string $pageLink) {
        $this->name = $name;
        $this->id = $id;
        $this->unitaryPrice = $unitaryPrice;
        $this->type = $type;
        $this->description = $description;
        $this->imageName = $imageName;
        $this->pageLink = $pageLink;
    }        

    public static function constructFromId(int $id): Product {
        $res = getBasicProductData($id);
        return new Product($res["nom"], $res["id"], floatval($res["type"]), $res["prixUnitaire"], $res["lienPage"], $res["description"], $res["nomImage"]);
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
        return $this->pageLink;
    }

    // Setters
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

    public function setPageLink(string $pageLink) {
        $this->pageLink = $pageLink;
    }
}
?>