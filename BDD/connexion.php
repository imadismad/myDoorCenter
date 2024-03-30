<!-- Faire la connexion en bdd et initialiser et recup les infos pour initialiser les infos puis rediriger vers une page-->
<?php
include_once("config.php");
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
try{
    if (isset($_POST["submit"])) {
        $genre = $_POST['sex'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['mail'];
    
        $naissance = $_POST['naissance'];
        $pays = $_POST['pays'];
    
        $telephone = $_POST['tel'];
        $id = 0;
        $ville = $_POST['ville'];
        $rue = $_POST['rue'];
        $CP = $_POST['postal'];
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
        header("Location: ../connexion.html");
    }
} catch (Exception $e) {
    echo"". $e->getMessage() ."";
    header("Location: ../creationCompte.html");
}


?>