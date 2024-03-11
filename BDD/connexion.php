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
    echo var_dump($_POST);
    if (isset($_POST["submit"])) {
        echo "Process ...";
        $genre=$_POST['sex'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['mail'];

        $naissance = $_POST['naissance'];
        $pays = $_POST['pays'];
        
        $telephone = $_POST['tel'];

        $ville = $_POST['ville'];
        $rue = $_POST['rue'];
        $CP= $_POST['postal'];

        echo "Process ... ($pays)";
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $donnees = array(
            "id" => 12,
            "genre" => $genre,
            "nom"=> $nom,
            "prenom"=> $prenom,
            "mail"=> $email,
            "naissance"=> $naissance,
            "pays"=> $pays,
            "telephone"=> $telephone,
            "ville"=> $ville,
            "rue"=> $rue,
            "CP"=> $CP,
            "mdp"=> $password
        );
        // $stmt = $connexion->prepare("INSERT INTO Client (genre) VALUES ($genre)");
        insererDonnees("Client", $donnees);
        header("Location: ../connexion.html");
    }
?>