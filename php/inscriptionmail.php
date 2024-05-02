<?php
// Include Mailjet configuration
include('../api/mailJet/mailJet.php'); // Adjust the path as necessary to where your mailJet.php file is located.

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clientMail'], $_POST['clientName'])) {
    $clientName = $_POST['clientName'];
    $clientEmail = $_POST['clientMail'];

    $url = 'https://api.mailjet.com/v3.1/send';

    // Prepare data for both emails
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
                'Subject' => "Confirmation of Your Request on MyDoorCenter",
                'data' => [
                    'clientName' => $clientName
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
        header("Location: ../connexion.php"); // Redirect to contact page on error
        exit();
    } else {
        error_log('Mailjet Response: ' . $response);
        header("Location: ../connexion.php"); // Redirect to contact page on success
        exit();
    }

    curl_close($ch);
} else {
    // Log an error if the script is accessed without proper POST data
    error_log("Access attempt without POST data on contactmail.php");
    header("Location: ../creationCompte.php"); // Redirect if accessed directly without POST
    exit();
}
?>
