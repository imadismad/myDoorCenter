<?php
include_once "config.php";
require_once "interBDDProduit.php";
$serveur = SQL_SERVER;
$utilisateur = SQL_USER;
$motdepasse = SQL_PASSWORD;
$basededonnees = SQL_BDD_NAME;
// Connect to the database using MySQLi
$mysqli = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get form data
$name = $mysqli->real_escape_string($_POST["product-name"]);
$type = $mysqli->real_escape_string($_POST["product-type"]);
$price = $mysqli->real_escape_string($_POST["product-price"]);
$description = $mysqli->real_escape_string($_POST["product-description"]);
$catalog = ($_POST['product-catalog'] == 'Yes') ? 'b\'1\'': 'b\'0\'';
$image = "../images/".$mysqli->real_escape_string($_POST["product-image"]);

// Insert product data into database
$query = "INSERT INTO Produit (nom, type, prixUnitaire, description, nomImage, estAuCatalogue) VALUES ('$name', '$type', '$price', '$description', '$image', $catalog)";
if ($mysqli->query($query) === TRUE) {
    header("Location: ../admin/index.php");
} else {
    echo "Error: " . $query . "<br>" . $mysqli->error;
}

// Close database connection
$mysqli->close();
?>
