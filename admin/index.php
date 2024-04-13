<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../admin.html");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Products</h1>
    <table id="product-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Dans le catalogue</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.getJSON('fetch_data_product.php', function (data) {
            var tableBody = $('#product-table tbody');
            $.each(data, function (index, product) {
                var row = $('<tr></tr>');
                row.append('<td>' + product.id + '</td>');
                row.append('<td>' + product.nom + '</td>');
                row.append('<td>' + product.type + '</td>');
                row.append('<td>' + product.prixUnitaire + '</td>');
                row.append('<td>' + product.description + '</td>');
                row.append('<td><img src="' + product.nomImage + '" alt="' + product.nom + '"></td>');
                if (product.estAuCatalogue == 1) {
                    row.append('<td id=catalogue' + product.id + '>Yes</td>');
                } else {
                    row.append('<td id=catalogue' + product.id + '>No</td>');
                }
                row.append('<td><button class="delete-button" data-id="' + product.id + '">Delete</button> <button class="modify-button" data-id="' + product.id + '">Modify</button></td>');
                tableBody.append(row);
            });
        });
        // Supprimer produit
        $(document).on('click', '.delete-button', function () {
            var id = $(this).data('id');
            if (confirm('Voulez vous vraiment supprimer ce produit de votre catalogue')) {
                document.getElementById('catalogue' + id).innerHTML = "No";
                $.get("deleteCatalogue.php", { id: id }, function () {
                    window.location.assign('deleteCatalogue.php?id=' + id);
                });
            }
        });

        // Modification produit
        $(document).on('click', '.modify-button', function () {
            var id = $(this).data('id');
            if (confirm('Voulez vous vraiment modifier ce produit ?')) {
                $.get('modifProductPage.php', { id: id }, function () {
                    window.location.assign('modifProductPage.php?id=' + id);
                })
            }
        })

        // Ajout de nouveau produit
        $(document).on('click', '.add-button', function(){
            if (confirm("Vous allez ajouter un nouveau produit")){
                window.location.assign('createProduct.php');
            }
        })
    </script>
    <button class="add-button">Ajouter produit</button>
</body>

</html>