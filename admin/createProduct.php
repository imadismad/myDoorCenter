<?php
session_start();
if (!isset($_SESSION['admin'])){
    header("Location: ../admin.html");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout nouveau produit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un nouveau produit</h1>
        <form action="../BDD/add_product.php" method="post">
            <div class="form-group">
                <label for="product-name">Nom du produit:</label>
                <input type="text" class="form-control" id="product-name" name="product-name" required>
            </div>
            <div class="form-group">
                <label for="product-type">Type de produit:</label>
                <input type="text" class="form-control" id="product-type" name="product-type" required>
            </div>
            <div class="form-group">
                <label for="product-price">Prix unitaire:</label>
                <input type="number" step="0.01" class="form-control" id="product-price" name="product-price" required>
            </div>
            <div class="form-group">
                <label for="product-description">Description du produit:</label>
                <textarea class="form-control" id="product-description" name="product-description" required></textarea>
            </div>
            <div class="form-group">
                <label for="product-image">Nom de l'image:</label>
                <input type="text" class="form-control" id="product-image" name="product-image" required>
            </div>
            <div class="form-group">
                <label for="product-catalog">Dans le catalogue:</label>
                <select class="form-control" id="product-catalog" name="product-catalog" required>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter le produit</button>
        </form>
    </div>
</body>
</html>
