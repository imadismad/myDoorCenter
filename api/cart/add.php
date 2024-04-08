<?php
require_once __DIR__ ."/../../php/Cart.php";
require_once __DIR__ ."/../../php/Product.php";

if (!isset($_POST["productId"]) || !isset($_POST["quantity"])) {
    http_response_code(400);
    exit;
}
$productId = intval($_POST["productId"]);
$quantity = intval($_POST["quantity"]);

if ($productId == 0 || $quantity == 0) {
    http_response_code(400);
    exit;
}

$cart = Cart::getUserCart();
$cart->addIntoCart(Product::constructFromId($productId), $quantity);
