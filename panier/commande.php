<?php
require_once "../php/Cart.php";
require_once "../php/UserUtils.php";
require_once "../php/Redirect.php";
if (Cart::getUserCart()->isEmpty()) {
    header("Location: /");
    exit();
}

if (!UserUtils::isConnect()) {
    goToURL("/creationCompte.php", "/panier/commande.php");
}

define("CSS_CUSTOM_IMPORT", '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>');
define("JS_CUSTOM_IMPORT", '<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>');

function getProjectPath() {
    $path = strpos($lower = strtolower($scriptPath = $_SERVER['SCRIPT_NAME']), $projectFolder = 'mydoorcenter') !== false ?
            substr($scriptPath, 0, strpos($lower, $projectFolder) + strlen($projectFolder)) :
            '/';
    return rtrim($path, '/') . '/';
}

function getAbsoluteMyDoorCenterPath() {
    $path = __DIR__;
    foreach (['mydoorcenter', 'wwwroot'] as $folder) {
        if (($pos = strpos(strtolower($path), $folder)) !== false) return substr($path, 0, $pos + strlen($folder));
    }
    return $path;
}

define('BASE_DIR', getAbsoluteMyDoorCenterPath().'/');
define('BASE_DIR_STATIC', getProjectPath());
?>

<!-- Head with automatic css imports -->
<?php include BASE_DIR.'pageTemplate/head.php'; ?>

<body class="">
    <!-- Header import -->
    <?php include BASE_DIR.'pageTemplate/header.php'; ?>

    <!-- Sidebar import -->
    <?php include BASE_DIR.'pageTemplate/sidebar.php'; ?>

    <main class="container-fluid pt-header-xs pt-header-sm pt-header-md pt-header-lg pt-header-xl">
        <h1>Adresse de facturation</h1>
        <div class="mb-5" id="bill-info">
            <!-- TODO: autocomplet information base on current account -->
            <div class="form-floating mb-3">
                <input
                    class="form-control"
                    type="text"
                    id="firstname-bill"
                    name="firstname-bill"
                    value="<?php echo UserUtils::getFirstName() ?>"
                >
                <label for="firstname-bill">Prénom</label>
                <div class="invalid-feedback">
                    Veuillez entrer un prénom valide.
                </div>
            </div>

            <div class="form-floating mb-3">
                <input
                    class="form-control"
                    type="text"
                    id="lastname-bill"
                    name="lastname-bill"
                    value="<?php echo UserUtils::getLastName() ?>"
                >
                <label for="lastname-bill">Nom</label>
                <div class="invalid-feedback">
                    Veuillez entrer un nom valide.
                </div>
            </div>

            <div class="autocomplet-input form-floating mb-3">
                <input
                    class="form-control"
                    type="text"
                    id="address-bill"
                    name="address-bill"
                    value="<?php echo htmlentities(UserUtils::getStreet()) ?>"
                >
                <label for="address-bill">Adresse</label>
                <div id="address-bill-search-ul" class="list-group border position-absolute top-100"></div>
                <div class="invalid-feedback">
                    Veuillez entrer une adresse valide.
                </div>
            </div>

            <div class="form-floating mb-3">
                <input
                    class="form-control"
                    type="text"
                    id="postal-code-bill"
                    name="postal-code-bill"
                    value="<?php echo UserUtils::getPostCode() ?>"
                >
                <label for="postal-code-bill">Code postal</label>
                <div class="invalid-feedback">
                    Veuillez entrer un code postal valide.
                </div>
            </div>

            <div class="form-floating mb-3">
                <input
                    class="form-control"
                    type="text"
                    id="city-bill"
                    name="city-bill"
                    value="<?php echo UserUtils::getCity() ?>"
                >
                <label for="city-bill">Ville</label>
                <div class="invalid-feedback">
                    Veuillez entrer une ville valide.
                </div>
            </div>

            <div class="form-floating mb-3">
                <input
                    class="form-control"
                    type="text"
                    id="country-bill"
                    name="country-bill"
                    value="<?php echo UserUtils::getContry() ?>"
                >
                <label for="country-bill">Pays</label>
                <div class="invalid-feedback">
                    Veuillez entrer un pays valide.
                </div>
            </div>

            <div class="form-floating mb-3">
                <input
                    class="form-control"
                    type="text"
                    id="phone"
                    name="phone"
                    value="<?php echo UserUtils::getPhone() ?>"
                >
                <label for="phone">Numéro de portable</label>
                <div class="invalid-feedback">
                    Veuillez entrer un numéro de téléphone portable français valide.
                </div>
            </div>
        </div>
        <h1>Livraison</h1>
        <div>
            <div class="mb-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="delivery-mode" id="ptRelayInput" checked>
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
                    <div class="invalid-feedback">
                        Veuillez selectionner un point relais.
                    </div>
                    
                </div>

                <div id="point-relay-result">
                    <ul></ul>
                    <div id="map"></div>
                </div>
                
            </div>
            <div id="homeDelivery" class="home mb-5" hidden>
                <div id="sameAsFactInp" class="mb-3 col border border-2 rounded py-1 px-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="same-as-bill" checked>
                        <label class="form-check-label" for="same-as-bill">Même information que l'adresse de facturation.</label>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input
                        class="form-control"
                        type="text"
                        id="firstname"
                        name="firstname"
                        value="<?php echo UserUtils::getFirstName() ?>"
                    >
                    <label for="firstname">Prénom</label>
                    <div class="invalid-feedback">
                        Veuillez entrer un prénom valide.
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input
                        class="form-control"
                        type="text"
                        id="lastname"
                        name="lastname"
                        value="<?php echo UserUtils::getLastName() ?>"
                    >
                    <label for="lastname">Nom</label>
                    <div class="invalid-feedback">
                        Veuillez entrer un nom valide.
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input
                        class="form-control"
                        type="text"
                        id="address"
                        name="address"
                        value="<?php echo htmlentities(UserUtils::getStreet()) ?>"
                    >
                    <label for="address">Adresse</label>
                    <div class="invalid-feedback">
                        Veuillez entrer une adresse valide.
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input
                        class="form-control"
                        type="text"
                        id="postal-code"
                        name="postal-code"
                        value="<?php echo UserUtils::getPostCode() ?>"
                    >
                    <label for="postal-code">Code postal</label>
                    <div class="invalid-feedback">
                        Veuillez entrer un code postal valide.
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input
                        class="form-control"
                        type="text"
                        id="city"
                        name="city"
                        value="<?php echo UserUtils::getCity() ?>"
                    >
                    <label for="city">Ville</label>
                    <div class="invalid-feedback">
                        Veuillez entrer une ville valide.
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input
                        class="form-control"
                        type="text"
                        id="country"
                        name="country"
                        value="<?php echo UserUtils::getContry() ?>"    
                    >
                    <label for="country">Pays</label>
                    <div class="invalid-feedback">
                        Veuillez entrer un pays valide.
                    </div>
                </div>
            </div>
        </div>

        <h1>Paiement</h1>
        <div class="moyenn-payement" id="creditCardInfo">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="cardNumber" name="cardNumber">
                <label for="cardNumber">Numéro de carte de crédit</label>
                <div class="invalid-feedback">
                    Veuillez entrer un numéro de carte de crédit MasterCard ou Visa valide.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="cardholderName" name="cardholderName">
                <label for="cardholderName">Nom et prenom du titulaire</label>
                <div class="invalid-feedback">
                    Veuillez entrer un nom et prénom valide.
                </div>
            </div>
            <div class="row">
                <div class="form-floating mb-3 col">
                    <input type="text" class="form-control" id="cardExpiryDate" name="cardExpiryDate">
                    <label for="cardExpiryDate">Date d'expiration</label>
                    <div class="invalid-feedback">
                        Veuillez entrer une date d'expiration valide.
                    </div>
                </div>
                <div class="form-floating mb-3 col">
                    <input type="text" class="form-control" name="cardCVV" id="cardCVV">
                    <label for="cardCVV">Code cvv</label>
                    <div class="invalid-feedback">
                        Veuillez entrer un code cvv valide.
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary btn-lg mb-4" id="order-next-step">Payer</button>
    </main>

    <!-- JS Import -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>
</body>
<?php include BASE_DIR.'pageTemplate/footer.php'; ?>