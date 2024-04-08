<?php

// Inclure le fichier contenant les fonctions SQL
require_once '../BDD/functionsSQL.php';

supprimerLigne("Produit","id",100);

$donnees = array(
    "id" => 100,
    "nom" => "Produit 1",
    "type" => "Type 1",
    "prixUnitaire" => 25.99,
    "lienPage" => "http://example.com/produit1",
    "description" => "Description du produit 1",
    "nomImage" => "image1.jpg"
);
insererDonnees("Produit",$donnees);

$donnees = recupererDonneesParValeur("Produit","id",100);
foreach ($donnees as $row) {
    foreach ($row as $key => $value) {
        echo "$key : $value <br>";
    }
    echo "<br>";
}

supprimerLigne("Produit","id",100);

modifierDonnees("Produit","description","ouioui","type","porte");

?>