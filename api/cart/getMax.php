<?php
/*
 * Get product max quantity that can be added to the cart
 * Response if ok (200):
 * Response if error (400):
 * - Type: application/json
 * - Content:
 *   - If action is ok : {"status": "ok", "max": number}
 *   - If Error Missing PARameters : {"status": "EMPAR"}
 *   - If Error Product Not Found : {"status": "EPNF"}
 */
require_once __DIR__."/../../php/Product.php";
require_once __DIR__."/../../php/Cart.php";

$cart = Cart::getUserCart();

if (!isset($_GET["productId"])) {
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode(["status" => "EMPAR"]);
    exit;
}

$productId = intval($_GET["productId"]);
$product = Product::constructFromId($productId);

if ($product === null) {
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode(["status" => "EPNF"]);
    exit;
}

$stock = $product -> getQuantityInStock();
$maxQuantity = $stock - $cart -> getQuantityById($product -> getId());

header("Content-Type: application/json");
echo json_encode(["status" => "ok", "max" => $maxQuantity]);