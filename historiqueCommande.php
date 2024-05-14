<?php
require_once "php/UserUtils.php";
require_once "php/Redirect.php";
require_once "php/OptionArray.php";
require_once "php/Option.php";
require_once "php/Product.php";

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

if (!UserUtils::isConnect()) {
    goToURL("/connexion.php", "historiqueCommande.php");
}

$historique = UserUtils::getHistoryOrder();
?>

<!-- Head with automatic css imports -->
<?php include BASE_DIR.'pageTemplate/head.php'; ?>


    <body>

    <!-- Header import -->
    <?php include BASE_DIR.'pageTemplate/header.php'; ?>

    <!-- Sidebar import -->
    <?php include BASE_DIR.'pageTemplate/sidebar.php'; ?>


    <main class="container-fluid pt-header-xs pt-header-sm pt-header-md pt-header-lg pt-header-xl">
        <?php
            if (count($historique )=== 0) {
                echo "<h1 class='text-center'>Il n'y a aucune commande à afficher.</h1>";
            } else {
                echo '
                <h1 class="text-center">Historique de vos commandes</h1>
                ';
                /*
                 *Array ( [id] => 11 [date] => 2024-05-06 [modePaiement] => CB [numFacture] => [idClient] => 6 [nom] => Louis [prenom] => Le Grand [rue] => 7 Rue du Chateau [CP] => 78000 [ville] => Versaille [pays] => France [telephone] => 06 666 666 66 [nomLivraison] => Louis [prenomLivraison] => Le Grand [rueLivraison] => 7 Rue du Chateau [CPLivraison] => 78000 [villeLivraison] => Versaille [paysLivraison] => France [produits] => Array ( [0] => Array ( [id] => 5 [quantite] => 5 [optionsId] => Array ( ) ) [1] => Array ( [id] => 5 [quantite] => 3 [optionsId] => Array ( [0] => 5 ) ) ) ) 
                 */
                $prixTotalCommande = 0;
                foreach ($historique as $order) {
                    $bufferTextProduit = "";
                    foreach ($order["produits"] as $product) {
                        $optionObjects = new OptionArray();
                        $price = 0;
                        foreach ($product["optionsId"] as $option) {
                            $opt = Option::constructFromId($option);
                            $optionObjects->append($opt);
                            $price += $opt->getPrice();
                        }
                
                        $productObject = Product::constructFromId($product["id"]);
                        $unitaryPrice = $productObject->getUnitaryPrice();
                        $price += $unitaryPrice;
                        $priceTotal = $price * $product["quantite"];
                
                        $bufferTextProduit .= '
                        <tr>
                            <td>'.$productObject->getName().'</td>
                            <td>'.$product["quantite"].'</td>
                            <td>'.$unitaryPrice.'&euro;</td>
                            <td>'.$priceTotal.'&euro;</td>
                        </tr>';
                
                        if (count($product["optionsId"]) > 0) {
                            $bufferTextProduit .= '
                            <tr>
                                <td colspan="4">
                                    <ul class="list-unstyled">';
                            for ($i = 0; $i < $optionObjects->count(); $i++) {
                                $optionObject = $optionObjects->get($i);
                                $bufferTextProduit .= '<li>'.$optionObject->getLibele().'</li>';
                            }
                            $bufferTextProduit .= '
                                    </ul>
                                </td>
                            </tr>';
                        }
                
                        $prixTotalCommande += $priceTotal;
                    }
                
                    echo '
                    <div class="container mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h3>Commande du : '.$order["date"].'</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Détails de la commande</h5>
                                        <table class="table table-bordered">
                                            <tr><th>Mode de paiement</th><td>'.$order["modePaiement"].'</td></tr>
                                            <tr><th>Numéro de facture</th><td>'.$order["numFacture"].'</td></tr>
                                            <tr><th>Coût total</th><td>'.$prixTotalCommande.'&euro; TTC</td></tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Adresse de facturation</h5>
                                        <table class="table table-bordered">
                                            <tr><th>Nom</th><td>'.$order["nom"].'</td></tr>
                                            <tr><th>Prénom</th><td>'.$order["prenom"].'</td></tr>
                                            <tr><th>Rue</th><td>'.$order["rue"].'</td></tr>
                                            <tr><th>Code postal</th><td>'.$order["CP"].'</td></tr>
                                            <tr><th>Ville</th><td>'.$order["ville"].'</td></tr>
                                            <tr><th>Pays</th><td>'.$order["pays"].'</td></tr>
                                            <tr><th>Téléphone</th><td>'.$order["telephone"].'</td></tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <h5>Adresse de livraison</h5>
                                        <table class="table table-bordered">
                                            <tr><th>Nom</th><td>'.$order["nomLivraison"].'</td></tr>
                                            <tr><th>Prénom</th><td>'.$order["prenomLivraison"].'</td></tr>
                                            <tr><th>Rue</th><td>'.$order["rueLivraison"].'</td></tr>
                                            <tr><th>Code postal</th><td>'.$order["CPLivraison"].'</td></tr>
                                            <tr><th>Ville</th><td>'.$order["villeLivraison"].'</td></tr>
                                            <tr><th>Pays</th><td>'.$order["paysLivraison"].'</td></tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h5>Produits</h5>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nom du produit</th>
                                                    <th>Quantité</th>
                                                    <th>Prix unitaire</th>
                                                    <th>Prix total</th>
                                                </tr>
                                            </thead>
                                            <tbody>'.
                                                $bufferTextProduit.'
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
                
            }
        ?>
    </main>

    <!-- JS Import -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

    </body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>