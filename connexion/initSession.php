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
    $mail = $_POST["mail"];

    $request = "SELECT * from Client WHERE mail = ?";
    $res = $connexion->prepare($request);
    $res->bind_param("s", $mail);
    $res->execute();
    $resultat = $res->get_result();
    $motdepasse = $_POST["password"];
    $trouve = false;
    // echo $email;
    foreach ($resultat as $row) {
        if ($mail == $row["mail"] && password_verify($motdepasse, $row["mdp"])) {
            $trouve = true;
        }
    }
    if (!$trouve) {
        header("Location: ../creationCompte.html");
    } else {
        $_SESSION["id"] = $row["id"];
        $_SESSION["nom"] = $row["nom"];
        $_SESSION["prenom"] = $row["prenom"];
        $_SESSION["mail"] = $row["mail"];
        $_SESSION["ville"] = $row["ville"];
        $_SESSION["genre"] = $row["genre"];
        $_SESSION["CP"] = $row["CP"];
        $_SESSION["tel"] = $row["telephone"];
        $_SESSION["naissance"] = $row["naissance"];
        $_SESSION["rue"] = $row["rue"];
        $_SESSION["pays"] = $row["pays"];
        $cookie_name = "prenom";
        setcookie($cookie_name, $_SESSION["prenom"], time() + 60 * 60 * 24, "/");
        header("Location: ../index.html");
    }
}
?>