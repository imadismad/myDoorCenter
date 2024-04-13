<?php
include_once ("../BDD/config.php");
require_once "../BDD/functionsSQL.php";
$id = $_GET['id'];
// Create connection
$connexion = new mysqli(SQL_SERVER, SQL_USER, SQL_PASSWORD, SQL_BDD_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE Produit SET estAuCatalogue = 0 WHERE id = ?";
$request = $connexion->prepare($sql);
$request->bind_param("d", $id);
// Exécution de la requête
if ($request->execute() === TRUE) {
    header("Location: index.php");
} else {
    echo "Erreur lors de la modification des données : " . $requete->error;
}

// Fermeture de la connexion
$request->close();
$connexion->close();
?>