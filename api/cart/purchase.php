<?php
require_once __DIR__."/../../php/Redirect.php";
require_once __DIR__."/../../php/UserUtils.php";
require_once __DIR__."/../../php/Cart.php";
if (session_status() === PHP_SESSION_NONE) session_start();
include('../mailJet/mailJet.php'); // Adjust the path as necessary to where your mailJet.php file is located.

if (!UserUtils::isConnect()) 
    goToURL("/connexion.php", "/panier/commande.php");

/*
 * Param need :
 * Not empty
 * firstname-bill : string
 * lastname-bill: string
 * address-bill: string
 * postal-code-bill: string (5 digits)
 * city-bill: string
 * country-bill: string
 * phone: string (valide french phone number)
 * firstname: string
 * lastname: string
 * address: string
 * postal-code: string (5 digits)
 * city: string
 * delivery-mode: string (shopDelivery or homeDelivery)
 * cardNumber: string (16 digits start with 4 (Visa) or 5 (MasterCard), remove dash and space)
 * cardholderName: string
 * cardExpiryDate: string (MM/YY and < than now)
 * cardCVV: string (3 digits)
 */
$notEmptyKeys = [
    "firstname-bill",
    "lastname-bill",
    "address-bill",
    "postal-code-bill",
    "city-bill",
    "country-bill",
    "phone",
    "firstname",
    "lastname",
    "address",
    "postal-code",
    "city",
    "delivery-mode",
    "cardNumber",
    "cardholderName",
    "cardExpiryDate",
    "cardCVV"
];

foreach ($notEmptyKeys as $key) {
    if (!isset($_POST[$key])) {
        goToURL("/panier/commande.php?error=Missing+key+$key");
    }

    if (!is_string($_POST[$key])) {
        goToURL("/panier/commande.php?error=Not+a+string+$key");
    }

    if (empty($_POST[$key]) || $_POST[$key] === "") {
        goToURL("/panier/commande.php?error=Empty+key+$key");
    }
}

// Check postal code
if (!preg_match("/^\d{5}$/", $_POST["postal-code-bill"])) {
    goToURL("/panier/commande.php?error=Invalid+postal+code+for+the+bill+post+code");
}

if (!preg_match("/^\d{5}$/", $_POST["postal-code"])) {
    goToURL("/panier/commande.php?error=Invalid+postal+code+for+the+delivery+post+code");
}

// Check phone number
if (!preg_match("/^(\+330?|0)[1-9]\d{8}$/", str_replace([" ", "-"], "", $_POST["phone"]))) {
    goToURL("/panier/commande.php?error=Invalid+phone+number");
}

// Check delivery mode
if ($_POST["delivery-mode"] !== "shopDelivery" && $_POST["delivery-mode"] !== "homeDelivery") {
    goToURL("/panier/commande.php?error=Invalid+delivery+mode");
}

// Check card number
if (!preg_match("/^(4|5)\d{15}$/", str_replace([" ", "-"], "", $_POST["cardNumber"]))) {
    goToURL("/panier/commande.php?error=Invalid+card+number");
}

// Check card expiry date
if (!preg_match("/^(0[1-9]|1[0-2])\/\d{2}$/", $_POST["cardExpiryDate"])) {
    goToURL("/panier/commande.php?error=Invalid+card+expiry+date");
}

$now = explode("/", date("m/y"));
$expiry = explode("/", $_POST["cardExpiryDate"]);
if ($expiry[1] < $now[1] || ($expiry[1] === $now[1] && $expiry[0] < $now[0])) {
    goToURL("/panier/commande.php?error=Card+expiry+date+can't+be+after+now");
}

// Check card CVV
if (!preg_match("/^\d{3}$/", $_POST["cardCVV"])) {
    goToURL("/panier/commande.php?error=Invalid+card+CVV");
}

// Data are validate, check if Cart is valid
$cart = Cart::getUserCart();
if ($cart -> isEmpty()) {
    goToURL("/panier/commande.php?error=Cart+is+empty");
}

// Everything should be good, we can now purchase the cart content

// Thank's Imad, you can send your mail right here, right now



// Function to send email
// function sendEmailInvoice($cart, $clientName,$clientfirstName, $clientEmail) {
// Assuming cart has user data, or fetch from session/user context
// $clientEmail = $_SESSION['user_email']; // Example: Fetching from session
// $clientName = $_SESSION['user_name'];


function sendEmailInvoice($cart, $notEmptyKeys) {
    $clientEmail = $_SESSION['mail'] ?? 'default-email@example.com';
    $clientName = $_SESSION['nom'] ?? 'No Name';
    $clientFirstName = $_SESSION['prenom'] ?? 'No First Name';
    $logoUrl = "https://mydoorcenter.com/images/logo.png"; // Adjust this to the actual URL of your logo

    // Start HTML email body preparation with inline styles for better email client compatibility
    $htmlContent = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice</title>
<style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
    .email-container { max-width: 600px; background: #fff; margin: 20px auto; padding: 20px; border: 1px solid #ddd; }
    .header { background-color: #437e80; color: #ffffff; padding: 10px 20px; text-align: center; }
    .header img { max-width: 180px; margin-bottom: 10px; }
    .content { padding: 20px; font-size: 16px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #ddd; }
    th { background-color: #437e80; color: #ffffff; }
    .footer { text-align: center; font-size: 14px; color: #777; padding: 10px 20px; }
</style>
</head>
<body>
<div class="email-container">
    <div class="header">
        <img src="$logoUrl" alt="Company Logo">
        <h1>Invoice Details</h1>
    </div>
    <div class="content">
        <p>Invoice to: $clientFirstName $clientName ($clientEmail)</p>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Options</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
HTML;

    foreach ($cart as $item) {
        $product = $item["product"];
        $quantity = $item["quantity"];
        $unitPrice = $product->getUnitaryPrice();
        $totalPrice = $quantity * $unitPrice;
        $optionsHtml = '';
        foreach ($item["optionArray"]->toRegularArray() as $option) {
            $optionPrice = $option->getPrice();
            $optionsHtml .= htmlspecialchars($option->getLibele()) . " (€" . $optionPrice . ")<br>";
        }

        $htmlContent .= "<tr><td>{$product->getName()}</td><td>$optionsHtml</td><td>$quantity</td><td>€$unitPrice</td><td>€$totalPrice</td></tr>";
    }

    $htmlContent .= <<<HTML
            </tbody>
        </table>
    </div>
    <div class="footer">
        <p>If you have any questions about this invoice, please contact us.</p>
    </div>
</div>
</body>
</html>
HTML;

    // API endpoint for Mailjet
    $url = 'https://api.mailjet.com/v3.1/send';
    $data = json_encode([
        'Messages' => [
            [
                'From' => ['Email' => "no-reply@mydoorcenter.com", 'Name' => "No-reply MyDoorCenter"],
                'To' => [['Email' => $clientEmail, 'Name' => $clientName]],
                'Subject' => "Your Invoice from MyDoorCenter",
                'HTMLPart' => $htmlContent
            ]
        ]
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, MAILJET_API_KEY . ":" . MAILJET_SECRET_KEY);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    if (!$response) {
        error_log('Mailjet Error: ' . curl_error($ch) . ' - Code: ' . curl_errno($ch));
        return false;
    }

    curl_close($ch);
    error_log('Mailjet Response: ' . $response);
    return true;
}






// Function to send email
// sendEmail($clientName,$clientfirstName, $clientEmail);
sendEmailInvoice($cart, $notEmptyKeys)


?>