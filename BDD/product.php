<?php
include "functionsSQL.php";

/**
 * Return the data of a product in a DB
 * Here are the fild : id, nom, type, prixUnitaire, lienPage, description and nomImage
 */
function getBasicProductData(int $id){
    // Check if id is a int
    if(!is_int($id)) throw new InvalidArgumentException("\$id need to be an integer");

    $result = recupererDonneesParValeur("Produit", "id", $id);

    return $result[0];
}
?>