<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="/js/panier/commande.js"></script>
    <title>Commande</title>
    <link rel="stylesheet" href="/css/panier/commande.css">
</head>
<body>
    <h1>Adresse de facturation</h1>
    <div class="info-perso">
        <!-- TODO: autocomplet information base on current account -->
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" id="firstname">

        <label for="lastname">Nom</label>
        <input type="text" name="lastname" id="lastname">

        <label for="address">Adresse</label>
        <input type="text" name="address" id="address">

        <label for="postal-code">Code postal</label>
        <input type="text" name="postal-code" id="postal-code">

        <label for="city">Ville</label>
        <input type="text" name="city" id="city">

        <label for="country">Pays</label>
        <input type="text" name="country" id="country">

        <label for="phone">Numéro de portable</label>
        <input type="text" name="phone" id="phone">
    </div>
    <h1>Livraison</h1>
    <div class="livraison">
        <ul>
            <li><input type="radio" name="delivery-mode"></li>
            <li><input type="radio" name="delivery-mode"></li>
        </ul>
        <div class="point-relay">
            <div class="header-point-relay">
                <div class="autocomplet-input">
                    <label for="pt-relay-code-postal">Code postal</label>
                    <input type="text" id="pt-relay-code-postal">
                    <ul id="pt-relay-postal-ul" class="absolute-ul"></ul>
                </div>

                <div class="autocomplet-input">
                    <label for="pt-relay-nom-ville">Ville</label>
                    <input type="text" id="pt-relay-nom-ville">
                    <ul id="pt-relay-ville-ul" class="absolute-ul"></ul>
                </div>
            </div>
        </div>
    </div>
    <div class="moyenn-payement">
    </div>
</body>
</html>