<?php

require_once '../BDD/functionsSQL.php';
require_once '../BDD/interactionBDD.php';

/*

/*

//$a = quantitePortesEnStockParEntrepot(14);
//if ($a){
//    echo "Oui";
//}

// ID du client
$idClient = 1;

// Mode de paiement
$modePaiement = "Carte de crédit";

// Produits et quantités dans la commande
$produitsQuantites = array(
    1 => 1, // Produit d'ID 1 avec quantité 1
    8 => 2  // Produit d'ID 8 avec quantité 2
);

// Appeler la fonction creerCommande
creerCommande($idClient, $modePaiement, $produitsQuantites);

*/

$resultats = rechercherProduits("porte", null,null,500,0);
//function rechercherProduits($search = null, $type = null, $prixMin = null, $prixMax = null, $triNote = false) {


foreach ($resultats as $produit) {
    echo "ID : " . $produit['id'] . "\n";
    echo "Nom : " . $produit['nom'] . "\n";
    echo "Description : " . $produit['description'] . "\n";
    echo "Type : " . $produit['type'] . "\n";
    echo "Prix : " . $produit['prixUnitaire'] . "\n";
    echo "Note Moyenne : " . $produit['noteMoyenne'] . "\n";
    // Affichez d'autres informations selon vos besoins
    echo "\n";
}


?>