<?php
require_once "DBObject.php";

class Material extends DBObject{
    private const TABLE_NAME = "Materiau";
    private const NAME_DB_NAME = "nom";
    private const RELATIVE_DENSITY_DB_NAME = "densite";
    private const DENSITY_DB_NAME = "masseVolumique";
    private const TYPE_DB_NAME = "type";

    private string $name;
    private float $relativeDensity;
    private float $density;
    private string $type;

    public function __construct(string $name, float $relativeDensity, float $density, string $type) {
        parent::__construct(null, Material::TABLE_NAME);

        $this -> setName($name);
        $this -> setRelativeDensity($relativeDensity);
        $this -> setDensity($density);
        $this -> setType($type);
    }

    public static function constructFromId(int $id): Material|null {
        $res = getBasicMaterialData($id);

        if ($res === null) return null;

        $material = new Material(
            $res[Material::NAME_DB_NAME],
            floatval($res[Material::RELATIVE_DENSITY_DB_NAME]),
            floatval($res[Material::DENSITY_DB_NAME]),
            $res[Material::TYPE_DB_NAME]
        );

        $material -> setId($res["id"]);

        return $material;
    }

    /**
     * This function construct a list of all the material containing in a product
     * @param int $id The id of the product
     * @return array an array of Material object
     */
    public static function constructAllFromProduct(int $id): array {
        $materials = [];
        $resList = getMaterialsByProduct($id);

        foreach ($resList as $res) {
            array_push(
                $materials,
                new Material(
                    $res[Material::NAME_DB_NAME],
                    floatval($res[Material::RELATIVE_DENSITY_DB_NAME]),
                    floatval($res[Material::DENSITY_DB_NAME]),
                    $res[Material::TYPE_DB_NAME]
                )
            );

            $materials[sizeof($materials) - 1] -> setId($res["id"]);
        }

        return $materials;
    }

    public static function searchMaterial(Material $needle, Array $array): int|false {
        foreach($array as $index => $material) {
            if (
                ($needle -> getId() !== null && $needle -> getId() === $material -> getId()) ||
                (
                    $needle -> getId() === null && $needle -> getName() === $material -> getName()
                                                && $needle -> getRelativeDensity() === $material -> getRelativeDensity()
                                                && $needle -> getDensity() === $material -> getDensity()
                                                && $needle -> getType() === $material -> getType()
                )
            ) {
                return $index;
            }
        }
    
        return false;
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
    public function getType(): string {
        return $this->type;
    }

    public function setName(string $name) {
        $this -> addModification(Material::NAME_DB_NAME, $name);
        $this -> name = $name;
    }

    public function setRelativeDensity(float $relativeDensity) {
        $this -> addModification(Material::RELATIVE_DENSITY_DB_NAME, $relativeDensity);
        $this -> relativeDensity = $relativeDensity;
    }

    public function setDensity(float $density) {
        $this -> addModification(Material::DENSITY_DB_NAME, $density);
        $this -> density = $density;
    }

    public function setType(string $type) {
        $this -> addModification(Material::TYPE_DB_NAME, $type);
        $this -> type = $type;
    }
}