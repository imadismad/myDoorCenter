<?php
include_once ("../BDD/config.php");
require_once "../BDD/functionsSQL.php";
$serveur = SQL_SERVER;
$utilisateur = SQL_USER;
$motdepasse = SQL_PASSWORD;
$basededonnees = SQL_BDD_NAME;
$mysqli = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$name = $mysqli->real_escape_string($_POST["product-name"]);
$type = $mysqli->real_escape_string($_POST["product-type"]);
$price = $mysqli->real_escape_string($_POST["product-price"]);
$description = $mysqli->real_escape_string($_POST["product-description"]);
$image = "../images/" . $mysqli->real_escape_string($_POST["product-image"]);
// On utilise les caractères d'échapements pour transformer en binaire PS merci l'alternance !
$catalog = ($_POST['product-catalog'] == 'Yes') ? 'b\'1\'': 'b\'0\'';

$query = "INSERT INTO Produit (nom, type, prixUnitaire, description, nomImage, estAuCatalogue) VALUES ('$name', '$type', '$price', '$description', '$image', $catalog)";

if ($mysqli->query($query) === TRUE) {
    header("Location: ../admin/");
} else {
    echo "Error: " . $query . "<br>" . $mysqli->error;
}

$mysqli->close();
?>