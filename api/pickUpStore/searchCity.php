<?php
// https://www.mondialrelay.fr/_mvc/fr-FR/Ville/AutocompleteVilleSuggestions?pays=FR&mode=codePostal&term=9500
if (!isset($_GET) || !isset($_GET["pays"]) || !isset($_GET["mode"]) || !isset($_GET["term"]) ||
    ($_GET["mode"] !== "codePostal" && $_GET["mode"] !== "ville")) {
    http_response_code(400);
    exit();
}

header("Content-Type: application/json; charset=utf-8");
$curl = curl_init("https://www.mondialrelay.fr/_mvc/fr-FR/Ville/AutocompleteVilleSuggestions?pays=".$_GET["pays"]."&mode=".$_GET["mode"]."&term=".$_GET["term"]);
// Set the output as a string
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
echo curl_exec($curl);
?>