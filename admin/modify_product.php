<?php
session_start();
require_once "../BDD/config.php";
require_once "../BDD/functionsSQL.php";
require_once "../php/Product.php";
// Get the modified product details from the POST request

if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $unitaryPrice = $_POST['price'];
    $description = $_POST['description'];
    $estAuCatalogue = $_POST['catalog'];
    $product = Product::constructFromId($id);
    if (isset($_FILES['delete-image']) && is_uploaded_file($_FILES['delete-image']['tmp_name'])) {
        $$deletePath = "../img/" . $id . "/" . $_FILES['delete-image']['name'];
        if (is_file($deletePath)) {
            unlink($deletePath);
        }
    }

    if (isset($_FILES['product-imageMod']) && is_uploaded_file($_FILES['product-imageMod']['tmp_name'])) {
        $origine = $_FILES['product-imageMod']['tmp_name'];
        $destination = "../img/" . $id . "/" . $_FILES['product-imageMod']['name'];
        move_uploaded_file($origine, $destination);
    } else {
        $destination = "No_image";
    }

    if (isset($_FILES['miniature-add']) && is_uploaded_file($_FILES['miniature-add']['tmp_name'])) {
        $origine = $_FILES['miniature-add']['tmp_name'];
        $miniaturePath = "../img/miniature/" . $_FILES['miniature-add']['name'];
        move_uploaded_file($origine, $miniaturePath);
        $product->setImageName($miniaturePath);
    } else {
        $miniaturePath = $product->getImageName();
    }
    if (isset($_FILES['miniature-delete']) && is_uploaded_file($_FILES['miniature-delete']['tmp_name'])) {
        $deleteMiniaturePath = "../img/miniature/" . $_FILES['miniature-delete']['name'];
        if (is_file($deleteMiniaturePath)) {
            unlink($deleteMiniaturePath);
        }
    }
    $product->setName($name);
    $product->setType($type);
    $product->setUnitaryPrice($unitaryPrice);

    $product->setCatalogue($estAuCatalogue);
    $product->setDescription($description);
    $product->updateDB();
    header("Location: index.php");
}
?>