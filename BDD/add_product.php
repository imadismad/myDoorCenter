<?php
include_once "config.php";
require_once "interBDDProduit.php";
// Connect to the database using MySQLi
$mysqli = new mysqli(SQL_SERVER, SQL_USER, SQL_PASSWORD, SQL_BDD_NAME);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$name = $mysqli->real_escape_string($_POST["product-name"]);
$type = $mysqli->real_escape_string($_POST["product-type"]);
$price = $mysqli->real_escape_string($_POST["product-price"]);
$description = $mysqli->real_escape_string($_POST["product-description"]);
$catalog = ($_POST['product-catalog'] == 'Yes') ? 'b\'1\'': 'b\'0\'';
$query  = "SELECT MAX(id) AS last_id FROM Produit";
$result = $mysqli->query($query);
$row = $result->fetch_assoc();
$id = $row['last_id'] + 1;

$query = "ALTER TABLE Produit AUTO_INCREMENT = $id";

$mysqli->query($query);


if (isset($_FILES['product-image']) && is_uploaded_file($_FILES['product-image']['tmp_name'])){
    $origine = $_FILES['product-image']['tmp_name'];
    $image = "../images/".$id."/".$_FILES['product-image']['name'];
    move_uploaded_file($origine,$image);
}

$query = "INSERT INTO Produit (nom, type, prixUnitaire, description, nomImage , estAuCatalogue) VALUES ('$name', '$type', '$price', '$description','$image', $catalog)";

if ($mysqli->query($query) === TRUE) {
    header("Location: ../admin/index.php");
} else {
    echo "Error: " . $query . "<br>" . $mysqli->error;
}

$mysqli->close();
?>