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
    $quantite = $_POST['modify-stock'];
    $idEntrepot = $_POST['entrepot'];

    $conn = new mysqli(SQL_SERVER, SQL_USER, SQL_PASSWORD, SQL_BDD_NAME);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Grab the actual stock theorical
    $sql = "SELECT stockTheorique, stockActuel FROM Entrepot WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idEntrepot);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stockTheorique = $row["stockTheorique"];
    $stockActuel = $row["stockActuel"];
    
    if ($quantite + $stockActuel > $stockTheorique) {
        echo "The new stock value cannot be greater than the theoretical stock value.";
    } else {
        // Part modify Entrepot
        $sql = "UPDATE Entrepot SET stockActuel = stockActuel + ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $quantite, $idEntrepot);
        $stmt->execute();

        // Insert new rows into Porte table
        $sql = "INSERT INTO Porte (idProduit, idEntrepot) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id, $idEntrepot);

        for ($i = 0; $i < $quantite; $i++) {
            $stmt->execute();
        }
        $conn->close();
        // Part modify product
        $product = Product::constructFromId($id);
        if (isset($_FILES['delete-image']) && is_uploaded_file($_FILES['delete-image']['tmp_name'])) {
            $deletePath = "../img/" . $id . "/" . $_FILES['delete-image']['name'];
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
            $miniaturePath = $_FILES['miniature-add']['name'];
            $product->setImageName($miniaturePath);
            move_uploaded_file($origine, "../img/miniature/" . $miniaturePath);
        } else {
            $miniaturePath = $product->getImageName();
        }
        if (isset($_FILES['miniature-delete']) && is_uploaded_file($_FILES['miniature-delete']['tmp_name'])) {
            $deleteMiniaturePath = "../img/miniature/" . $_FILES['miniature-delete']['name'];
            if (is_file($deleteMiniaturePath)) {
                $miniaturePath = $product->getImageName();
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



}
?>