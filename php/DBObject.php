<?php
require_once __DIR__."/../BDD/interactionBDD.php";
require_once __DIR__."/../BDD/interBDDProduit.php";

/**
 * This class allow representation abstraction for DB object representation
 */
abstract class DBObject {
    private int|null $id;

    private array $editedValue;
    private string $tableName;

    public function __construct(int|null $id, string $tableName) {
        $this->id = $id;
        $this->editedValue = array();
        $this->tableName = $tableName;
    }

    /**
     * This function allow the user to construct an object from an id in the DB
     * @param int $id The id of the object in DB
     * @return DBObject|null The object associated in DB, null if the id can't be found
     */
    abstract public static function constructFromId(int $id): DBObject|null;

    /**
     * Return if the option is in the DB
     * The function check if the id existe
     * So, it's not because the option is in DB, that he is up to date with it.
     * @return bool if the object is in the DB
     */
    public function isInDB(): bool {
        return $this->getId() !== null;
    }

    /**
     * @param bool true if the object have modification or is not in DB
     */
    public function isUpToDate(): bool {
        return $this->isInDB() && sizeof($this->editedValue) === 0;
    }

    /**
     * This function need to be call in each setter of child and in constructor
     * It allow modification of object with DB update
     * @param string $key The field key use in DB
     * @param mixed $value The new value
     */
    public function addModification(string $key, mixed $value): void {
        $this->editedValue[$key] = $value;
    }

    public function updateDB(): void {
        if ($this->isUpToDate()) return;

        if(!$this->isInDB()) {
            $id = insererDonnees($this->tableName, $this->editedValue, true);
            $this -> setId($id);
        } else {
            modifierDonnees($this->tableName, array_keys($this->editedValue), array_values($this->editedValue), "id", $this->id);
        }

        $this -> editedValue = [];
    }

    /**
     * It's dangerous to edit the ID, please create a new object.
     * The objective of this class is to setId when they create themself in another place than __construct
     * And can't define in constructor id
     */
    protected function setId(int|null $id): void {
        if ($this->getId() !== null) 
            fwrite(STDERR, "WARNING in DBObject::setId : id is already set, this function should not be call !\n");
        else
            // Reset because it means that the product load from DB, otherwise id couldn't be set
            $this->editedValue = [];
        $this->id = $id;
    }

    /**
     * @return int|null The object id, if null the object to not have id
     */
    public function getId(): int|null {
        return $this->id;
    }

    
}