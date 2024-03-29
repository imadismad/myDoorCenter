<?php
session_start();
include_once("../BDD/config.php");
require_once "../BDD/functionsSQL.php";
require_once "../BDD/connexion.php";
// Connexion à la base de données
$connexion = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);
$mail = $_POST["mail"];
$motdepasse = $_POST["password"];
$trouve = false;
$res = $connexion->query("SELECT * FROM Client");
foreach ($res as $row) {
    if ( isset($row['mail']) && $mail == $row['mail'] && isset($row['mdp']) && password_verify($motdepasse, $row['mdp'])) {
        $trouve = true;
        $_SESSION["id"] = $row["id"]; 
        $_SESSION["nom"] = $row["nom"];
        $_SESSION["prenom"] = $row["prenom"];
        $_SESSION["mail"] = $row["mail"];
        $_SESSION["ville"] = $row["ville"];
        $_SESSION["genre"] = $row["genre"];
        $_SESSION["CP"] = $row["CP"];
        $_SESSION["tel"] = $row["tel"];
        $_SESSION["naissance"] = $row["naissance"];
        break;
    }
}
if ($trouve){
    header("Location: ../index.php");
    exit();
}
else{
    header("Location: ../connexion.php");
    exit();
}
?>