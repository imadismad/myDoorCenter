<?php
require_once '../php/ProductHadj.php';

// Get the product ID from the query string
$id = $_GET['id'];

// Construct the product object from the ID
$product = Product::constructFromId($id);

// Check if the product exists
if ($product === null) {
    // Handle the error
    http_response_code(404);
    echo "Product not found";
    exit;
}
if ($product->getImageName() == null){
    $product->setImageName("No Image");
}

// Encode the product details as a JSON object
$productDetails = json_encode([
    'id' => $product->getId(),
    'nom' => $product->getName(),
    'type' => $product->getType(),
    'PrixUnitaire' => $product->getUnitaryPrice(),
    'description' => $product->getDescription(),
    'nomImage' => $product->getImageName(),
    'estAuCatalogue' => $product->getCatalogue(),   
    'materials' => $product->getMaterialsName()
]);

// Output the JSON object
header('Content-Type: application/json');
echo $productDetails;
?>
