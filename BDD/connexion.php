<!-- Faire la connexion en bdd et initialiser et recup les infos pour initialiser les infos puis rediriger vers une page-->
<?php
/*
 * THIS PHP USE ONLY Client TABLE
 */
include_once ("config.php");
require_once "functionsSQL.php";
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
try {
    if (isset($_POST["submit"])) {
        $genre = mysqli_real_escape_string($connexion, $_POST['sex']);
        $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
        $prenom = mysqli_real_escape_string($connexion, $_POST['prenom']);
        $email = mysqli_real_escape_string($connexion, $_POST['mail']);
        $naissance = mysqli_real_escape_string($connexion, $_POST['naissance']);
        $pays = mysqli_real_escape_string($connexion, $_POST['pays']);
        $telephone = mysqli_real_escape_string($connexion, $_POST['tel']);
        $id = 0;
        $ville = mysqli_real_escape_string($connexion, $_POST['ville']);
        $rue = mysqli_real_escape_string($connexion, $_POST['rue']);
        $CP = mysqli_real_escape_string($connexion, $_POST['postal']);

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $donnees = array(
            "id" => $id,
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
        );
        insererDonnees("Client", $donnees);
        header("Location: ../connexion");
    }
} catch (Exception $e) {
    fwrite(STDERR, "" . $e->getMessage() . "");
    header("Location: /creationCompte.php");
}


?>
