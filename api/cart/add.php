<?php
/*
 * Add a product to the cart
 * Response if ok (200):
 * Response if error (400):
 * - Type: application/json
 * - Content:
 *   - If action is ok : {"status": "ok"}
 *   - If Error Missing PARameters : {"status": "EMPAR"}
 *   - If Error Product Not Found : {"status": "EPNF"}
 *   - If Error Option Not Found : {"status": "EONF"}
 *   - If Error Quantity NUL : {"status": "EQNUL"}
 *   - If Error Not Enought In Stock : {"status": "ENOEIS", maxTotal=number}
 */
require_once __DIR__."/../../php/Cart.php";
require_once __DIR__."/../../php/Product.php";
require_once __DIR__."/../../php/OptionArray.php";

if (!isset($_GET["productId"]) || !isset($_GET["quantity"]) || is_array($_GET["optionsId"])) {
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode(["status" => "EMPAR"]);
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
            header("Content-Type: application/json");
            echo json_encode(["status" => "EONF"]);
            exit;
        }
        $optionArray -> append($optionObj);
    }
}


if ($quantity === 0) {
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode(["status" => "EQNUL"]);
    exit;
}

$product = Product::constructFromId($productId);
$cart = Cart::getUserCart();

if ($product === null) {
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode(["status" => "EPNF"]);
    exit;
}

$stock = $product->getQuantityInStock();
$total = $quantity + $cart -> getQuantity($product, $optionArray);
if ($stock === false || $stock < $total) {
    http_response_code(400);
    echo json_encode(["status" => "ENOEIS", "maxTotal" => $stock]);
    exit;
}

$cart-> addIntoCart($product, $quantity, $optionArray);
echo json_encode(["status" => "ok"]);
exit();
