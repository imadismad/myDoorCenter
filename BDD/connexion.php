<?php
/*
 * THIS PHP USE ONLY Client TABLE
 */
ob_start();

require_once "config.php";
require_once "functionsSQL.php";

// Include Mailjet configuration
include('../api/mailJet/mailJet.php'); // Adjust the path as necessary to where your mailJet.php file is located.

// Function to send email
function sendEmail($clientName,$clientfirstName, $clientEmail) {
    $url = 'https://api.mailjet.com/v3.1/send';

    // Prepare data for the email
    $data = json_encode([
        'Messages' => [
            [
                // Email to the client
                'From' => [
                    'Email' => "no-reply@mydoorcenter.com",
                    'Name' => "No-reply MyDoorCenter"
                ],
                'To' => [
                    [
                        'Email' => $clientEmail,
                        'Name' => $clientName
                    ]
                ],
                'TemplateID' => MAILJET_TEMPLATE_ID_2,
                'TemplateLanguage' => true,
                'Subject' => "Welcome to MyDoorCenter ! ",
                'Variables' => [
                    'name' => $clientName,
                    'firstname' => $clientfirstName

                ]
            ]
        ]
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, MAILJET_API_KEY . ":" . MAILJET_SECRET_KEY);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    if (!$response) {
        error_log('Mailjet Error: ' . curl_error($ch) . ' - Code: ' . curl_errno($ch));
        return false;
    } else {
        error_log('Mailjet Response: ' . $response);
        return true;
    }

    curl_close($ch);
}


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

    sendEmail($_POST['nom'], $_POST['prenom'], $_POST['mail']);

    header("Location: /connexion.php");
    exit();
} catch (Exception $e) {
    error_log($e->getMessage());
    header("Location: /creationCompte.php");
}
ob_end_flush();
exit();
?>
