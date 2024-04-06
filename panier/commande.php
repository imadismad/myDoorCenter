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
    <div class="mb-5">
        <!-- TODO: autocomplet information base on current account -->
        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="firstname-bill" name="firstname-bill">
            <label for="firstname-bill">Prénom</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="lastname-bill" name="lastname-bill">
            <label for="lastname-bill">Nom</span>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="address-bill" name="address-bill">
            <label for="address-bill">Adresse</span>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="postal-code-bill" name="postal-code-bill">
            <label for="postal-code-bill">Code postal</span>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="city-bill" name="city-bill">
            <label for="city-bill">Ville</span>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="country-bill" name="country-bill">
            <label for="country-bill">Pays</span>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="phone" name="phone">
            <label for="phone">Numéro de portable</span>
        </div>
    </div>
    <h1>Livraison</h1>
    <div>
        <div class="mb-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="delivery-mode" id="ptRelayInput">
                <label class="form-check-label" for="ptRelayInput">Livraison en point relaie</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="delivery-mode" id="domicilInput">
                <label class="form-check-label" for="domicilInput">Livraison à domicile</label>
            </div>
        </div>

        <div id="point-relay" hidden>
            <div class="autocomplet-input form-floating">
                <input class="form-control" type="text" id="pt-relay-search">
                <label for="pt-relay-search">Adresse ou ville à proximité</label>
                <div id="pt-relay-search-ul" class="list-group border position-absolute top-100"></div>
                
            </div>

            <div id="point-relay-result">
                <ul></ul>
                <div id="map"></div>
            </div>
            
        </div>
        <div class="home mb-5" hidden>
            <div id="sameAsFactInp" class="mb-3 col border border-2 rounded py-1 px-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="same-as-bill" checked>
                    <label class="form-check-label" for="same-as-bill">Même information que l'adresse de facturation.</label>
                </div>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="firstname" name="firstname">
                <label for="firstname">Prénom</span>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="lastname" name="lastname">
                <label for="lastname">Nom</span>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="address" name="address">
                <label for="address">Adresse</span>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="postal-code" name="postal-code">
                <label for="postal-code">Code postal</span>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="city" name="city">
                <label for="city">Ville</span>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="country" name="country">
                <label for="country">Pays</span>
            </div>
        </div>
    </div>

    <h1>Paiement</h1>
    <div class="moyenn-payement">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="cardNumber" name="cardNumber">
            <label for="cardNumber">Numéro de carte de crédit</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="cardholderName" name="cardholderName">
            <label for="cardholderName">Nom et prenom du titulaire</label>
        </div>
        <div class="row">
            <div class="form-floating mb-3 col">
                <input type="text" class="form-control" id="cardExpiryDate" name="cardExpiryDate">
                <label for="cardExpiryDate">Date d'expiration</label>
            </div>
            <div class="form-floating mb-3 col">
                <input type="text" class="form-control" name="cardCVV" id="cardCVV">
                <label for="cardCVV">Code cvv</label>
            </div>
        </div>
    </div>
    
    <button class="btn btn-primary btn-lg mb-4">Payer</button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>