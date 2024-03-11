<!-- Faire la connexion en bdd et initialiser et recup les infos pour initialiser les infos puis rediriger vers une page-->
<?php

$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "XXXX";
$basededonnees = "DW";

// Connexion à la base de données
$connexion = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
}
?>

