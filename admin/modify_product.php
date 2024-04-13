<?php
session_start();
require_once '../php/Product.php';
require_once "../BDD/config.php";
require_once "../BDD/functionsSQL.php";
// Get the modified product details from the POST request
$id = $_POST['id'];
$name = $_POST['name'];
$type = $_POST['type'];
$unitaryPrice = $_POST['price'];
$description = $_POST['description'];
$imageName = $_POST['image'];
$estAuCatalogue = $_POST['catalog'];

if (isset($_POST["submit"])) {
    $serveur = SQL_SERVER;
    $utilisateur = SQL_USER;
    $motdepasse = SQL_PASSWORD;
    $basededonnees = SQL_BDD_NAME;

    // Connexion à la base de données
    $connexion = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);

    // Vérifier la connexion
    if ($connexion->connect_error) {
        die("Erreur de connexion : " . $connexion->connect_error);
    }

    // Préparation de la requête de modification
    $requete = $connexion->prepare(
        "UPDATE Produit SET 
        nom = ?,
        type = ?,
        prixUnitaire = ?,
        description = ?,
        nomImage = ?,
        estAuCatalogue = ?
        WHERE id = ?"
    );

    // Liaison des valeurs des paramètres
    $requete->bind_param("ssdssii", $name, $type, $unitaryPrice, $description, $imageName, $estAuCatalogue, $id);

    // Exécution de la requête
    if ($requete->execute() === TRUE) {
        header("Location: index.php");
    } else {
        echo "Erreur lors de la modification des données : " . $requete->error;
    }

    // Fermeture de la connexion
    $requete->close();
    $connexion->close();
}
?>