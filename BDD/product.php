<?php
include "../functionSQL.php";

function getBasicProductData(int $id){
    // Check if id is a int
    if(!is_int($id)) throw new InvalidArgumentException("\$id need to be an integer");

    echo recupererDonneesParValeur("Produit", "id", $id);
}
?>