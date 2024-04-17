<?php
require_once "DBObject.php";

// id, libele, cout, typeProduit, active
class Option extends DBObject{
    private const TABLE_NAME = "OptionAchat";
    private const LIBELE_DB_NAME = "libele";
    private const PRICE_DB_NAME = "cout";
    private const PRODUCT_TYPE_DB_NAME = "typeProduit";
    private const IS_ACTIVE_DB_NAME = "active";

    private string $libele;
    private float $price;
    private string $productType;
    private bool $isActive;

    public function __construct (string $libele, float $price, string $productType, bool $isActive) {
        parent::__construct(null, Option::TABLE_NAME); // Callig parent constructor
        $this -> setLibele($libele);
        $this -> setPrice($price);
        $this -> setProductType($productType);
        $this -> setActive($isActive);
    }

    public function __toString(): string {
        if (!$this -> isInDB()) return "Custom local option";
        return "Option id ".$this -> getId();
    }

    /*
     * From abstract methode
     */
    public static function constructFromId(int $id): Option|null {
        $res = getBasicOptionData($id);

        if ($res === null) return null;

        $option = new Option(
            $res[Option::LIBELE_DB_NAME],
            $res[Option::PRICE_DB_NAME],
            $res[Option::PRODUCT_TYPE_DB_NAME],
            $res[Option::IS_ACTIVE_DB_NAME]
        );
        $option->setId($res["id"]);
        return $option;
    }

    public static function constructAllFromType(string $type, bool $onlyActive): Array {
        $resList = getProductOption($type);
        $options = [];

        foreach($resList as $res) {
            $option = new Option(
                $res[Option::LIBELE_DB_NAME],
                $res[Option::PRICE_DB_NAME],
                $res[Option::PRODUCT_TYPE_DB_NAME],
                $res[Option::IS_ACTIVE_DB_NAME]
            );

            if ($option -> isActive || !$onlyActive) {
                array_push($options, $option);
                $option -> setId($res["id"]);
            }
        }

        return $options;
    }

    /*
     * Getteur
     */
    public function getLibele(): string {
        return $this->libele;
    }
    public function getPrice(): float {
        return $this->price;
    }
    public function getProductType(): string {
        return $this->productType;
    }
    public function isActive(): bool {
        return $this->isActive;
    }

    /*
     * Setteur 
     */
    public function setLibele(string $libele): void {
        $this->addModification(Option::LIBELE_DB_NAME, $libele);
        $this->libele = $libele;
    }
    public function setPrice(float $price): void {
        $this->addModification(Option::PRICE_DB_NAME, $price);
        $this->price = $price;
    }
    public function setProductType(string $productType): void {
        $this->addModification(Option::PRODUCT_TYPE_DB_NAME, $productType);
        $this->productType = $productType;
    }
    public function setActive(bool $isActive): void {
        $this->addModification(Option::IS_ACTIVE_DB_NAME, $isActive ? 1:0);
        $this->isActive = $isActive;
    }
}
