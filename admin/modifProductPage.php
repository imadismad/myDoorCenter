<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification du produit</title>
</head>

<body>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Modify Product</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body>
        <div class="container">
            <h1>Modify Product</h1>
            <form enctype="multipart/form-data" action="modify_product.php" method="post" id="modify-product-form">
                <input type="hidden" name="id" id="product-id">
                <div class="form-group">
                    <label for="product-name">Name:</label>
                    <input type="text" name="name" id="product-name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="product-type">Type:</label>
                    <input type="text" name="type" id="product-type" class="form-control">
                </div>
                <div class="form-group">
                    <label for="product-price">Price:</label>
                    <input type="number" name="price" id="product-price" class="form-control" min="0">
                </div>
                <div class="form-group">
                    <label for="product-description">Description:</label>
                    <textarea id="product-description" name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="product-imageMod">Ajouter une image au produit:</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                    <input type="file" class="form-control" id="product-imageMod" name="product-imageMod" accept="image/webp, image/jpeg, image/png, image/jpg">
                </div>
                <div class="form-group">
                    <label for="delete-image">Supprimer une image:</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                    <input type="file" class="form-control" id="delete-image" name="delete-image" accept="image/webp, image/jpeg, image/png, image/jpg">
                </div>
                <div class="form-group">
                    <label for="miniature-add">Ajouter une miniature:</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                    <input type="file" class="form-control" id="miniature-add" name="miniature-add" accept="image/webp, image/jpeg, image/png, image/jpg">
                </div>
                <div class="form-group">
                    <label for="miniature-delete">Supprimer une miniature:</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000"> 
                    <input type="file" class="form-control" id="miniature-delete" name="miniature-delete" accept="image/webp, image/jpeg, image/png, image/jpg">
                </div>
                <div class="form-group">
                    <label for="modify-stock">Régler votre stock (0-500):</label>
                    <input type="number" name="modify-stock" id="modify-stock" min="0" max="500" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="entrepot">Sélectionnez l'entrepot que vous voulez modifier:</label><br>
                    <select name="entrepot" id="entrepot" class="form-select">
                        <option value="1">Entrepôt Paris</option>
                        <option value="2">Entrepôt Lyon</option>
                        <option value="3">Entrepôt Marseille</option>
                        <option value="4">Entrepôt Bordeaux</option>
                        <option value="5">Entrepôt Lille</option>
                        <option value="6">Entrepôt Nantes</option>
                        <option value="7">Entrepôt Toulouse</option>
                        <option value="8">Entrepôt Strasbourg</option>
                        <option value="9">Entrepôt Nice</option>
                        <option value="10">Entrepôt Rennes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="product-catalog">In Catalog:</label>
                    <select name="catalog" id="product-catalog" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <button name="submit" type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
        <script>
            $(document).ready(function () {
                // Get the product ID from the query string
                var productId = <?php echo $_GET['id']; ?>;
                // Fetch the product details from the server
                $.getJSON('fetch_product_details.php', { id: productId }, function (data) {
                    console.log(data);
                    // Populate the form fields with the product details
                    $('#product-id').val(data.id);
                    $('#product-name').val(data.nom);
                    $('#product-type').val(data.type);
                    $('#product-price').val(data.PrixUnitaire);
                    $('#product-description').val(data.description);
                    $('#product-image').val(data.nomImage);
                    $('#product-catalog').val(data.estAuCatalogue);
                    $('modify-stock').val(data.numberStockage);
                });
            });
        </script>
    </body>

    </html>

</body>

</html>