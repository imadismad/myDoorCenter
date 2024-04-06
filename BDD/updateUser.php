<?php
session_start();
include_once ("../BDD/config.php");
require_once "../BDD/functionsSQL.php";
$serveur = SQL_SERVER;
$utilisateur = SQL_USER;
$motdepasse = SQL_PASSWORD;
$basededonnees = SQL_BDD_NAME;
if (isset($_POST["submit"])) {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    // Connexion à la base de données
    $connexion = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);
    $tel = mysqli_real_escape_string($connexion, $_POST["tel"]);
    $ville = mysqli_real_escape_string($connexion, $_POST["ville"]);
    $rue = mysqli_real_escape_string($connexion, $_POST["rue"]);
    $CP = mysqli_real_escape_string($connexion, $_POST["postal"]);
    if ($connexion->connect_error) {
        die("" . $connexion->connect_error);
    }
    
    $request = $connexion->prepare("UPDATE Client SET telephone = ?, ville = ?, rue = ?, CP = ? WHERE mail = ?");
    $request->bind_param("sssss", $tel, $ville, $rue, $CP, $_SESSION['mail']);
    $request->execute();
    $request->close();
    header("Location: deconnexion.php");
}
?>