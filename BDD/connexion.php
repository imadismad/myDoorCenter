<?php
ob_start();
require_once "../config.php";
require_once "../functionsSQL.php";

// Check if the form was submitted
if (!isset($_POST["submit"])) {
    header("Location: /creationCompte.php?error=invalid_access");
    exit();
}

// Database connection
$connexion = new mysqli(SQL_SERVER, SQL_USER, SQL_PASSWORD, SQL_BDD_NAME);
if ($connexion->connect_error) {
    die("Connection failed: " . $connexion->connect_error);
}

try {
    $genre = mysqli_real_escape_string($connexion, $_POST['sex']);
    $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
    $prenom = mysqli_real_escape_string($connexion, $_POST['prenom']);
    $email = mysqli_real_escape_string($connexion, $_POST['mail']);
    $naissance = mysqli_real_escape_string($connexion, $_POST['naissance']);
    $pays = mysqli_real_escape_string($connexion, $_POST['pays']);
    $telephone = mysqli_real_escape_string($connexion, $_POST['tel']);
    $ville = mysqli_real_escape_string($connexion, $_POST['ville']);
    $rue = mysqli_real_escape_string($connexion, $_POST['rue']);
    $CP = mysqli_real_escape_string($connexion, $_POST['postal']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $donnees = [
        "genre" => $genre,
        "nom" => $nom,
        "prenom" => $prenom,
        "mail" => $email,
        "naissance" => $naissance,
        "pays" => $pays,
        "telephone" => $telephone,
        "ville" => $ville,
        "rue" => $rue,
        "CP" => $CP,
        "mdp" => $password
    ];

    if (!insererDonnees("Client", $donnees)) {
        throw new Exception("Failed to insert data.");
    }

    header("Location: /connexion.php?success=account_created");
} catch (Exception $e) {
    error_log($e->getMessage());
    header("Location: /creationCompte.php?error=server_error");
}
exit();
ob_end_flush();
?>
