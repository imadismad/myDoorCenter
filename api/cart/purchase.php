<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__."/../../php/Redirect.php";
require_once __DIR__."/../../php/UserUtils.php";
require_once __DIR__."/../../php/Cart.php";

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