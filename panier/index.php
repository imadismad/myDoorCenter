<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="js/panier/index.js"></script>
    <title>Panier</title>
</head>
<body>
    <h1>Panier</h1>
    <form action="/panier/commande.php">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Quantité</th>
                    <th>Prix unitaire HT</th>
                    <th>TVA (20%)</th>
                    <th>Prix total TTC</th>
                </tr>
            </thead>
            <tbody id="cartTable">

            </tbody>
        </table>

        <label>Code promo : <input type="text" name="codePromo"></label><br />

        <input type="submit" value="Commander">
    </form>
</body>
</html>