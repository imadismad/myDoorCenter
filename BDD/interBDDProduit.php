<?php
include_once "../php/checkDefine.php";
// Inclure le fichier contenant les fonctions SQL
require_once 'functionsSQL.php';

/**
 * Return the data of a product in a DB
 * @param int $id The id of the product in DB
 * @return array Here are the field : id, nom, type, prixUnitaire, lienPage, description and nomImage
 */
function getBasicProductData(int $id) : array|null {
    // Check if id is a int
    if(!is_int($id)) throw new InvalidArgumentException("\$id need to be an integer");

    $result = recupererDonneesParValeur("Produit", "id", $id);
    if ($result[0] === false) return null;
    return $result[0];
}

/**
 * Return the data of a product in a DB
 * @param int $id The id of the product in DB
 * @return array Here are the field : id, nom, type, prixUnitaire, lienPage, description and nomImage
 */
function getBasicMaterialData(int $id) : array|null {
    // Check if id is a int
    if(!is_int($id)) throw new InvalidArgumentException("\$id need to be an integer");

    $result = recupererDonneesParValeur("Materiau", "id", $id);
    if ($result[0] === false) return null;
    return $result[0];
}

/**
 * Return all materials data composing a given product
 * @param int $id The id of the product in DB
 * @return array A doble array, containing all the materials. Here are the field : id, nom, densite, masseVolumique
 */
function getMaterialsByProduct(int $id): array {
    // Check if id is a int
    if(!is_int($id)) throw new InvalidArgumentException("\$id need to be an integer");

    // Connection à la BDD
    $connexion = connexionBDD();

    // Début de la transaction
    $connexion->begin_transaction();
    try {
        $requete = $connexion->prepare(
            "SELECT m.* FROM Materiau m
             INNER JOIN Composer c ON m.id = c.idMateriau
             WHERE c.idProduit = ?"
        );

        $requete -> bind_param("i", $id);
        $requete -> execute();

        $donnees = reponseVersArray($requete);

        $requete->close();
        $connexion->close();
        return $donnees;

    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $connexion->rollback();
        fwrite(STDERR, "Erreur lors de la création de la commande : " . $e->getMessage());
        throw $e;
    }

}

/**
 * Remove a product from the catalogue without removing it from DB
 * @param int $id The id of the product to remove
 */
function removeProductFromCatalogue(int $id): void {
    modifierDonnees("Produit", "estAuCatalogue", 0, "id", $id);
}

function removeMaterialFromProduct(int $materialId, int $productId) {
    supprimerLigne("Composer", ["idProduit", "idMateriau"], [$productId, $materialId]);
}

function addMaterialFromProduct(int $materialId, int $productId) {
    insererDonnees("Composer", ["idProduit" => $productId, "idMateriau" => $materialId]);
}
/**
 * This function return an array containing available option for a given product
 * By default, only active one are returned, but if you need all of them change $onlyActive to false
 * @param string $type The product type specified in DB for your product
 * @param bool $onlyActive By default true, specifies if all option are requiered or only active one.
 * @return array An array containing Option, here are the keys : id, libele, cout, typeProduit, active
 */
function getProductOption(string $type, bool $onlyActive = true): array {
    $connexion = connexionBDD();

    $type = strtoupper($type);

    if ($onlyActive)
        $requete = $connexion->prepare(
            "SELECT * FROM OptionAchat
             WHERE UPPER(typeProduit) = ?
               AND active = 1;
            "
        );
    else
        $requete = $connexion->prepare(
            "SELECT * FROM OptionAchat
            WHERE UPPER(typeProduit) = ?;
            "
        );
    
    $requete->bind_param("s", $type);
    $requete->execute();
    $donnees = reponseVersArray($requete);

    $requete->close();
    $connexion->close();
    return $donnees;
}

/**
 * Return the buying option data store in db base on is id
 * @param int $id The id of the option
 * @return array Here are the field : id, libele, cout, typeProduit, active
 */
function getBasicOptionData(int $id): array|null {
    // Check if id is a int
    if(!is_int($id)) throw new InvalidArgumentException("\$id need to be an integer");

    $result = recupererDonneesParValeur("OptionAchat", "id", $id);

    if ($result[0] === false) return null;
    return $result[0];
}
