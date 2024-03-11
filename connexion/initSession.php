<?php
session_start();
include_once("../BDD/config.php");
require_once "../BDD/functionsSQL.php";
require_once "../BDD/connexion.php";
$mail = $_POST["mail"];
$motdepasse = $_POST["password"];
$donnees = recupererDonneesParValeur("Client", "id", 12);
$trouve = false;
foreach ($donnees as $row) {
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
        break; // Sortir de la boucle dès que vous avez trouvé une correspondance
    }
}
if ($trouve){
    header("Location: ../index.php");
    exit();
}
else{
    header("Location: ../connexion.html");
    exit();
}
?>