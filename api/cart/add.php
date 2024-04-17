<?php
require_once __DIR__."/../../php/Cart.php";
require_once __DIR__."/../../php/Product.php";
require_once __DIR__."/../../php/OptionArray.php";

if (!isset($_GET["productId"]) || !isset($_GET["quantity"]) || is_array($_GET["optionsId"])) {
    http_response_code(400);
    exit;
}
$productId = intval($_GET["productId"]);
$quantity = intval($_GET["quantity"]);
$optionArray = new OptionArray();

$rawOption = explode("|", $_GET["optionsId"]);
if (count($rawOption) !== 1 || $rawOption[0] !== "") {
    foreach($rawOption as $option) {
        $optionId = intval($option);
        $optionObj = Option::constructFromId($optionId);
    
        if($optionObj === null) {
            http_response_code(400);
            exit;
        }
        $optionArray -> append($optionObj);
    }
}

if ($productId == 0 || $quantity == 0) {
    http_response_code(400);
    exit;
}

$cart = Cart::getUserCart();
$cart-> addIntoCart(Product::constructFromId($productId), $quantity, $optionArray);
