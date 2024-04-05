<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande</title>
    <link rel="stylesheet" href="/css/panier/commande.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <script type="module" src="/js/panier/commande.js"></script>
</head>
<body>
    <h1>Adresse de facturation</h1>
    <div class="info-perso">
        <!-- TODO: autocomplet information base on current account -->
        <div>
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname-bill" id="firstname-bill">
        </div>

        <div>
            <label for="lastname">Nom</label>
            <input type="text" name="lastname-bill" id="lastname-bill">
        </div>

        <div>
            <label for="address">Adresse</label>
            <input type="text" name="address-bill" id="address-bill">
        </div>

        <div>
            <label for="postal-code">Code postal</label>
            <input type="text" name="postal-code-bill" id="postal-code-bill">
        </div>
        
        <div>
            <label for="city">Ville</label>
            <input type="text" name="city-bill" id="city-bill">
        </div>

        <div>
            <label for="country">Pays</label>
            <input type="text" name="country-bill" id="country-bill">
        </div>

        <div>
            <label for="phone">Numéro de portable</label>
            <input type="text" name="phone-bill" id="phone-bill">
        </div>
    </div>
    <h1>Livraison</h1>
    <div class="livraison">
        <ul>
            <li>
                <label>
                    <input type="radio" name="delivery-mode" id="ptRelayInput">
                    Livraison en point relaie
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="delivery-mode" id="domicilInput">
                    Livraison à domicile
                </label>
            </li>
        </ul>
        <div class="point-relay" hidden>
            <div id="header-point-relay">
                <div class="autocomplet-input">
                    <label for="pt-relay-search">Code postal</label>
                    <input type="text" id="pt-relay-search">
                    <ul id="pt-relay-search-ul" class="absolute-ul"></ul>
                </div>
            </div>
            <div id="point-relay-result">
                <ul></ul>
                <div id="map"></div>
            </div>
            
        </div>
        <div class="home" hidden>
            <div class="home-check-div">
                <label for="same-as-bill">Même information que l'adresse de facturation.</label>
                <input type="checkbox" id="same-as-bill" checked>
            </div>

            <div>
                <label for="firstname">Prénom</label>
                <input type="text" name="firstname" id="firstname" disabled>
            </div>

            <div>
                <label for="lastname">Nom</label>
                <input type="text" name="lastname" id="lastname" disabled>
            </div>

            <div>
                <label for="address">Adresse</label>
                <input type="text" name="address" id="address" disabled>
            </div>

            <div>
                <label for="postal-code">Code postal</label>
                <input type="text" name="postal-code" id="postal-code" disabled>
            </div>
            
            <div>
                <label for="city">Ville</label>
                <input type="text" name="city" id="city" disabled>
            </div>

            <div>
                <label for="country">Pays</label>
                <input type="text" name="country" id="country" disabled>
            </div>
        </div>
    </div>
    <div class="moyenn-payement">
        <div>
            <label for="credit-card-number">Numéro de carte de crédit</label>
            <input type="text" name="credit-card-number" id="credit-card-number" disabled>
        </div>
        <div>
            <label for="creadit-card-name">Nom et prenom du titulaire</label>
            <input type="text" name="creadit-card-name" id="creadit-card-name" disabled>
        </div>
        <div>
            <label for="credit-card-date">Date d'expiration</label>
            <input type="text" name="credit-card-date" id="credit-card-date" disabled>
        </div>
        <div>
            <label for="credit-card-cvv">Code cvv</label>
            <input type="text" name="credit-card-cvv" id="credit-card-cvv" disabled>
        </div>
    </div>
</body>
</html>