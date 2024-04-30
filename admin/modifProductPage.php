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
                    <input type="text" name="price" id="product-price" class="form-control">
                </div>
                <div class="form-group">
                    <label for="product-description">Description:</label>
                    <textarea id="product-description" name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <input type="hidden" name="MAX_FILE_SIZE" value="30000">
                    <input type="file" class="form-control" id="product-imageMod" name="product-imageMod" required>
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
                });
            });
        </script>
    </body>

    </html>

</body>

</html>