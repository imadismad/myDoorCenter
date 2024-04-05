<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >
   <link rel="stylesheet" href="/css/panier/commande.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <script type="module" src="/js/panier/commande.js"></script>
</head>
<body class="container text-center">
    <h1>Adresse de facturation</h1>
    <div class="text-start">
        <!-- TODO: autocomplet information base on current account -->
        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="firstname-bill" name="firstname-bill">
            <label for="firstname-bill">Prénom</label>
        </div>

        <div class="input-group mb-3">
                <span class="input-group-text">Nom</span>
                <input class="form-control" type="text" name="lastname-bill">
        </div>

        <div class="input-group mb-3">
                <span class="input-group-text">Adresse</span>
                <input class="form-control" type="text" name="address-bill">
        </div>

        <div class="input-group mb-3">
                <span class="input-group-text">Code postal</span>
                <input class="form-control" type="text" name="postal-code-bill">
        </div>

        <div class="input-group mb-3">
                <span class="input-group-text">Ville</span>
                <input class="form-control" type="text" name="city-bill">
        </div>

        <div class="input-group mb-3">
                <span class="input-group-text">Pays</span>
                <input class="form-control" type="text" name="country-bill">
        </div>

        <div class="input-group mb-3">
                <span class="input-group-text">Numéro de portable</span>
                <input class="form-control" type="text" name="phone">
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
                <div class="home-check-div">
                    <label for="same-as-bill">Même information que l'adresse de facturation.</label>
                    <input type="checkbox" id="same-as-bill" checked>
                </div>
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

            <div class="input-group mb-3">
                    <span class="input-group-text">Prénom</span>
                    <input class="form-control" type="text" name="firstname">
            </div>

            <div class="input-group mb-3">
                    <span class="input-group-text">Nom</span>
                    <input class="form-control" type="text" name="lastname">
            </div>

            <div class="input-group mb-3">
                    <span class="input-group-text">Adresse</span>
                    <input class="form-control" type="text" name="address">
            </div>

            <div class="input-group mb-3">
                    <span class="input-group-text">Code postal</span>
                    <input class="form-control" type="text" name="postal-code">
            </div>

            <div class="input-group mb-3">
                    <span class="input-group-text">Ville</span>
                    <input class="form-control" type="text" name="city">
            </div>

            <div class="input-group mb-3">
                    <span class="input-group-text">Pays</span>
                    <input class="form-control" type="text" name="country">
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>