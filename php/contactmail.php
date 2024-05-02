<?php
// Include Mailjet configuration
include('../api/mailJet/mailJet.php'); // Adjust the path as necessary to where your mailJet.php file is located.

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clientMail'], $_POST['clientName'])) {
    $clientName = $_POST['clientName'];
    $clientEmail = $_POST['clientMail'];
    $requestType = $_POST['requestType'];
    $productName = $_POST['productName'];
    $requestDetails = $_POST['requestDetails'];

    $url = 'https://api.mailjet.com/v3.1/send';

    // Prepare data for both emails
    $data = json_encode([
        'Messages' => [
            [
                // Email to the client
                'From' => [
                    'Email' => "contact@mydoorcenter.com",
                    'Name' => "Contact from MyDoorCenter"
                ],
                'To' => [
                    [
                        'Email' => $clientEmail,
                        'Name' => $clientName
                    ]
                ],
                'TemplateID' => MAILJET_TEMPLATE_ID,
                'TemplateLanguage' => true,
                'Subject' => "Confirmation of Your Request on MyDoorCenter",
                'Variables' => [
                    'clientName' => $clientName,
                    'clientEmail' => $clientEmail,
                    'requestType' => $requestType,
                    'productName' => $productName,
                    'requestDetails' => $requestDetails
                ]
            ],
            [
                // Email to the contact address
                'From' => [
                    'Email' => "contact@mydoorcenter.com",
                    'Name' => "Contact from MyDoorCenter"
                ],
                'To' => [
                    [
                        'Email' => "contact@mydoorcenter.com",
                        'Name' => "Contact"
                    ]
                ],
                'Subject' => "New Request Submitted",
                'TextPart' => "A new request has been submitted:\n\nClient Name: $clientName\nClient Email: $clientEmail\nRequest Type: $requestType\nProduct Name: $productName\nRequest Details: $requestDetails",
                'HTMLPart' => "<h3>New Request Submitted</h3><p><strong>Client Name:</strong> $clientName<br><strong>Client Email:</strong> $clientEmail<br><strong>Request Type:</strong> $requestType<br><strong>Product Name:</strong> $productName<br><strong>Request Details:</strong> $requestDetails</p>"
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
        header("Location: ../contact.php"); // Redirect to contact page on error
        exit();
    } else {
        error_log('Mailjet Response: ' . $response);
        header("Location: ../contact.php"); // Redirect to contact page on success
        exit();
    }

    curl_close($ch);
} else {
    // Log an error if the script is accessed without proper POST data
    error_log("Access attempt without POST data on contactmail.php");
    header("Location: ../contact.php"); // Redirect if accessed directly without POST
    exit();
}
?>
