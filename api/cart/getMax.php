<?php
/*
 * Get product max quantiity
 * Response if ok (200):
 * Response if error (400):
 * - Type: application/json
 * - Content:
 *   - If action is ok : {"status": "ok", "max": number}
 *   - If Error Missing PARameters : {"status": "EMPAR"}
 *   - If Error Product Not Found : {"status": "EPNF"}
 */
require_once __DIR__."/../../php/Product.php";

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

header("Content-Type: application/json");
echo json_encode(["status" => "ok", "max" => $product->getQuantityInStock()]);