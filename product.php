<?php
require_once __DIR__ ."/php/Product.php";

$product = Product::constructFromId(intval($_GET["id"]));
if (!isset($_GET["id"]) || $product === null ) {
    include __DIR__."/pageTemplate/404Product.html";
    http_response_code(404);
    exit;
}
?>
<!-- Info manquante dans la BDD pour la page du produit : Reference du produit, dimension disponibles, couleurs dispo -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyDoorCenter</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Main css -->
    <link href="css/main.css" rel="stylesheet">
    <!-- Specific css -->
    <link href="css/product/style.css" rel="stylesheet">

</head>

<body>
    <div class="overlay"></div>
    <header class="container-fluid fixed-top" id="mainHeader">
        <div class="row header-top align-items-center">
            <div class="col-md-1 sidebar-small">
                <button title="Menu" class="btn btn-light bi bi-list blue-button" style="font-size: 2rem;"></button>
            </div>
            <div class="col-md-3">
                <img src="images/logo.png" alt="Logo" height="100">
            </div>
            <div class="col-md-4 d-flex">
                <label title="Rechercher" for="search"><button class="btn btn-light bi bi-search blue-button"
                        style="font-size: 1rem;"></button></label>
                <input type="text" name="search" class="form-control" placeholder="Recherche...">
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <span><b>01 23 45 67 89 <i class="bi bi-telephone"></i></b></span>
            </div>
            <div class="col-md-1">
                <button title="Espace client" class="btn btn-light bi bi-person-circle blue-button"
                    style="font-size: 2rem;"></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 align-center">
                <ul class="nav nav-tabs">
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-top dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Portes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Blindées</a>
                            <a class="dropdown-item" href="#">Intérieures</a>
                            <a class="dropdown-item" href="#">Extérieures</a>
                            <a class="dropdown-item" href="#">Porte-fenêtres</a>
                            <a class="dropdown-item" href="#">Personnalisées</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-top dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Blocs
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Blindés</a>
                            <a class="dropdown-item" href="#">Intérieurs</a>
                            <a class="dropdown-item" href="#">Extérieurs</a>
                            <a class="dropdown-item" href="#">Porte-fenêtres</a>
                            <a class="dropdown-item" href="#">Personnalisés</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-top" href="#">Poignées</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-top" href="#">Accessoires</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="container-fluid">
        <div class="row">

            <div class="col-md-2 sidebar-large collapse overlay-sidebar" id="sidebarCollapse">
                <button type="button" class="btn close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#porteSubmenu">Portes</a>
                        <ul class="collapse list-unstyled" id="porteSubmenu">
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Blindées</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Intérieures</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Extérieures</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Porte-fenêtres</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Personnalisées</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#blocSubmenu">Blocs</a>
                        <ul class="collapse list-unstyled" id="blocSubmenu">
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Blindés</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Intérieurs</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Extérieurs</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Porte-fenêtres</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Personnalisés</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse"
                            data-bs-target="#poigneeSubmenu">Poignées</a>
                    </li>
                </ul>
            </div>

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
                            <img src="images/porte.png" id="main-image" alt="Image principale" class="img-fluid">
                        </div>
                        <div id="vignettes-container" class="d-flex flex-row rounded">
                            <?php
                                foreach ($product->getImagesPath() as $path) {
                                    echo '<img src="'.$path.'" class="vignette" alt="Image Accessoire">';
                                }
                            ?>
                            <img src="images/accessoire.png" class="vignette" alt="Image Accessoire">
                            <img src="images/blocporte.png" class="vignette" alt="Image Bloc Porte">
                            <img src="images/porte.png" class="vignette" alt="Image Porte">
                            <img src="images/porteinterro.png" class="vignette" alt="Image Porte">
                            <img src="images/magasin.png" class="vignette" alt="Image Porte">
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
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Options</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="cadre" id="optionCadre">
                                    <label class="form-check-label" for="optionCadre">Avec cadre</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="poignee" id="optionPoignee">
                                    <label class="form-check-label" for="optionPoignee">Avec poignée</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="vitre" id="optionVitre">
                                    <label class="form-check-label" for="optionVitre">Avec vitre</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="vitre" id="optionVitre">
                                    <label class="form-check-label" for="optionVitre">Avec porte</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="vitre" id="optionVitre">
                                    <label class="form-check-label" for="optionVitre">Avec installation</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="quantity-select" class="form-label">Quantité</label>
                                <input type="number" class="form-control" id="quantity-select" value="1" min="1"
                                    onchange="updatePrice(this, <?php echo $product -> getUnitaryPrice() ?>)">
                            </div>

                            <div class="mb-3">
                                <select class="form-control" id="dimensionSelect">
                                    <option selected disabled>Choisir une dimension</option>
                                    <option value="198x60">198x60 cm</option>
                                    <option value="198x66">198x66 cm</option>
                                    <option value="198x71">198x71 cm</option>
                                    <option value="198x76">198x76 cm</option>
                                    <option value="203x81">203x81 cm</option>
                                    <option value="203x86">203x86 cm</option>
                                </select>
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
                                        <li>Coût de l'installation: 50€</li>
                                        <li>Durée de l'installation: 30 minutes</li>
                                    </dd>

                                </ul>
                            </div>

                            <button type="button" class="btn btn-light">Ajouter au panier</button>
                        </form>
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

    <footer class="footer">
        <span>&copy; 2024 MyDoorCenter</span>
    </footer>

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Main js -->
    <script src="js/sidebar.js"></script>
    <script src="js/reduce-header.js"></script>
    <!-- Specific js -->
    <script src="js/product/productUtilities.js"></script>

    <script>
        // Init price
        updatePrice(document.getElementById("quantity-select"), <?php echo $product -> getUnitaryPrice() ?>)
    </script>
</body>

</html>