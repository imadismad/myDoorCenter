<?php
require_once __DIR__ ."/php/Product.php";

$product = Product::constructFromId(intval($_GET["id"]));
if (!isset($_GET["id"]) || $product === null ) {
    include __DIR__."/pageTemplate/404Product.html";
    http_response_code(404);
    exit;
}

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
<!-- Info manquante dans la BDD pour la page du produit : Reference du produit, dimension disponibles, couleurs dispo -->

<!-- Head with automatic css imports -->
<?php include BASE_DIR.'pageTemplate/head.php'; ?>


<body>
    <!-- Header import -->
    <?php include BASE_DIR.'pageTemplate/header.php'; ?>

    <!-- Sidebar import -->
    <?php include BASE_DIR.'pageTemplate/sidebar.php'; ?>

    <!-- Modal  creation-->
    <div class="modal fade" id="modale" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Article ajouté</h5>
                <button
                    type="button"
                    class="btn btn-danger close"
                    style="margin-left: auto;"
                    onclick="hideModal()"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Votre article a bien été ajouté au panier.
            </div>
            <div class="modal-footer">
                <a role="button" class="btn btn-secondary" href="panier">Voir mon panier</a>
                <button type="button" class="btn btn-primary" onclick="hideModal()">Cotinuer mes achats</button>
            </div>
            </div>
        </div>
    </div>

    

    <main class="container-fluid pt-header-xs pt-header-sm pt-header-md pt-header-lg pt-header-xl">
        <div class="row">

            <div class="col-md-12 content">
                <h2 style="padding: 3%;">
                    <strong>
                        <?php echo $product -> getName()?>
                    </strong>
                </h2>
                <div class="row">
                    <!-- Galerie d'images à gauche -->
                    <div class="col-md-5">
                        <div id="main-image-container" class="mb-3 rounded">
                            <?php
                                $images = $product->getImagesPath();
                                echo '<img src="'.$images[0].'" id="main-image" alt="Image principale" class="img-fluid">';
                            ?>
                        </div>
                        <div id="vignettes-container" class="d-flex flex-row rounded">
                            <?php
                                foreach ($images as $path) {
                                    echo '<img src="'.$path.'" class="vignette" alt="Image Accessoire">';
                                }
                            ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        Référence: BDD78 (static comme la liste en dessous)
                        <ul>
                            <li>Revêtement laminé premium texturé</li>
                            <li>Épaisseur de 44mm</li>
                            <li>Bords entièrement finis</li>
                            <li>Panneau de 16mm</li>
                            <li>Verre trempé de 4mm EN12150</li>
                            <li>Porte entière et matérielle</li>
                            <li>Noyau Homalight unique pour une stabilité accrue</li>
                            <li>Lisière en bois massif de 38mm</li>
                            <li>Usage interne</li>
                        </ul>
                        <p>
                            <?php echo $product -> getDescription()?>
                        </p>
                    </div>

                    <!-- Encadré de configuration à droite -->
                    <div class="col-md-3"
                        style="background-color: #f0f0f0; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <h3>
                            <div id="price">
                                <!--
                                    The price will be initializ at the end of the doc
                                    Usefull when web browser store a previous quantity when page reloading
                                -->
                            </div>
                        </h3>
                        <div class="mb-3">
                            <label class="form-label">Options</label>
                            <?php
                                foreach ($product -> getCompatibleBuyingOption() as $option) {
                                    echo
                                    '<div class="form-check">'.
                                        '<input class="form-check-input" type="checkbox" name="optionId" value="'.$option->getId().'" id="option-'.$option->getLibele().'">'.
                                        '<label class="form-check-label" for="optionCadre">'.$option->getLibele().' (+ '.$option->getPrice().' &euro;)</label>'.
                                    '</div>';
                                }
                            ?>
                        </div>

                        <div class="mb-3">
                            <label for="quantity-select" class="form-label">Quantité</label>
                            <input type="number" class="form-control" id="quantity-select" name="quantity" value="1" min="1"
                                onchange="updatePrice(this, <?php echo $product -> getUnitaryPrice() ?>)">
                        </div>

                        <div class="mb-3">
                            <h4>Modalités de livraison et d'installation:</h4>
                            <ul>
                                <dt>Livraison</dt>
                                <dd>
                                    <li>Frais de livraison: 20€</li>
                                    <li>Délai de livraison: 2 jours à partir du départ de l'entrepôt</li>
                                </dd>
                                <dt>Installation</dt>
                                <dd>
                                    <li>Durée de l'installation: 30 minutes</li>
                                </dd>

                            </ul>
                        </div>

                        <button
                            type="button"
                            class="btn btn-light"
                            id="ajoutPanier"
                            onclick=<?php echo "addProduct(".$product->getId().")" ?>
                        >
                            Ajouter au panier
                        </button>
                    </div>
                </div>
                <hr>
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Dimensions disponibles</th>
                                <th>Couleurs</th>
                                <th>Matériaux</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>198*60, 198*66, 198*71, 198*76, 203*81, 203*86, 0.2*16547</th>
                                <th>Noir, Blanc, Orange, Fushia, Jaune Citron, Marronnasse</th>
                                <th>
                                    <?php
                                        foreach ($product -> getMaterialsName() as $index=>$name) {
                                            if ($index !== 0) echo ", ";
                                            echo $name;
                                        }
                                    ?>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br style="margin: 5%;">

                <!-- Produits similaires en bas -->
                <div class="row mt-3">
                    <div class="col-12">
                        <h3>Produits similaires</h3>
                        <div class="card-group">
                            <div class="card">
                                <img src="images/porte.png" class="card-img-top" alt="Produit similaire 1">
                                <div class="card-body">
                                    <h5 class="card-title">Produit 1</h5>
                                    <p class="card-text">C'est une porte</p>
                                    <a href="#" class="btn btn-primary">Voir plus</a>
                                </div>
                            </div>
                            <div class="card">
                                <img src="images/porte.png" class="card-img-top" alt="Produit similaire 2">
                                <div class="card-body">
                                    <h5 class="card-title">Produit 2</h5>
                                    <p class="card-text">Ça aussi</p>
                                    <a href="#" class="btn btn-primary">Voir plus</a>
                                </div>
                            </div>
                            <div class="card">
                                <img src="images/porte.png" class="card-img-top" alt="Produit similaire 1">
                                <div class="card-body">
                                    <h5 class="card-title">Produit 1</h5>
                                    <p class="card-text">Ça aussi</p>
                                    <a href="#" class="btn btn-primary">Voir plus</a>
                                </div>
                            </div>
                            <div class="card">
                                <img src="images/porte.png" class="card-img-top" alt="Produit similaire 1">
                                <div class="card-body">
                                    <h5 class="card-title">Produit 1</h5>
                                    <p class="card-text">Ça aussi</p>
                                    <a href="#" class="btn btn-primary">Voir plus</a>
                                </div>
                            </div>
                            <div class="card">
                                <img src="images/porte.png" class="card-img-top" alt="Produit similaire 1">
                                <div class="card-body">
                                    <h5 class="card-title">Produit 1</h5>
                                    <p class="card-text">Ça aussi</p>
                                    <a href="#" class="btn btn-primary">Voir plus</a>
                                </div>
                            </div>
                            <div class="card">
                                <img src="images/porte.png" class="card-img-top" alt="Produit similaire 1">
                                <div class="card-body">
                                    <h5 class="card-title">Produit 1</h5>
                                    <p class="card-text">Ça non. Si en fait j'ai menti</p>
                                    <a href="#" class="btn btn-primary">Voir plus</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <br style="margin: 5%;">

            </div>

        </div>
    </main>

    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

    <script>
        // Init price
        updatePrice(document.getElementById("quantity-select"), <?php echo $product -> getUnitaryPrice() ?>)
    </script>
</body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>