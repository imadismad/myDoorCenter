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
print_r($historique);
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
                echo "<h1 class='text-center'>Il n'y a aucunne commande à afficher.</h1>";
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
                            $optionObjects -> append($opt);

                            $price += $opt -> getPrice();
                        }

                        $productObject = Product::constructFromId($product["id"]);
                        $price += $productObject -> getUnitaryPrice();
                        $price *= $product["quantite"];

                        $bufferTextProduit .= '<li>'.$productObject->getName().' x'.$product["quantite"].' ('.$price.'&euro; TTC)';

                        if (count($product["optionsId"]) > 0) {
                            $bufferTextProduit .= '<ul>';
                                                   
                            for ($i = 0; $i < $optionObjects -> count(); $i++) {
                                $optionObject = $optionObjects -> get($i);

                                $bufferTextProduit .= '<li>'.$optionObject -> getLibele().'</li>';
                            }
                            $bufferTextProduit .= '</ul>';
                        }
                        $bufferTextProduit .= '</li>';

                        $prixTotalCommande += $price;
                    }

                    echo '
                    <div class="mb-5">'.
                    '<div>Commande du : '.$order["date"].'</div>'.
                    '<div>Mode de paiement : '.$order["modePaiement"].'</div>'.
                    '<div>Numéro de facture : '.$order["numFacture"].'</div>'.
                    '<div>Nom : '.$order["nom"].'</div>'.
                    '<div>Prénom : '.$order["prenom"].'</div>'.
                    '<div>Rue : '.$order["rue"].'</div>'.
                    '<div>Code postal : '.$order["CP"].'</div>'.
                    '<div>Ville : '.$order["ville"].'</div>'.
                    '<div>Pays : '.$order["pays"].'</div>'.
                    '<div>Téléphone : '.$order["telephone"].'</div>'.
                    '<div>Nom de livraison : '.$order["nomLivraison"].'</div>'.
                    '<div>Prénom de livraison : '.$order["prenomLivraison"].'</div>'.
                    '<div>Rue de livraison : '.$order["rueLivraison"].'</div>'.
                    '<div>Code postal de livraison : '.$order["CPLivraison"].'</div>'.
                    '<div>Ville de livraison : '.$order["villeLivraison"].'</div>'.
                    '<div>Pays de livraison : '.$order["paysLivraison"].'</div>'.
                    '<div>Coût total de la commande : '.$prixTotalCommande.'&euro; TTC</div>'.
                    '<div>Produits : </div>'.
                    '<ul>'.
                    $bufferTextProduit.
                    '</ul>'.
                    '</div>';
                }
            }
        ?>
    </main>

    <!-- JS Import -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

    </body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>