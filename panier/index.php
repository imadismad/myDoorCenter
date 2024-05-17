<?php
require_once __DIR__."/../php/Cart.php";

define("PATH_BASE", "../");
if (session_status() === PHP_SESSION_NONE) session_start();

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


    <body>
    <!-- Modal  creation-->
    <div class="modal fade" id="modale" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Supression article</h5>
                <button
                    type="button"
                    class="btn btn-danger close"
                    style="margin-left: auto;"
                    onclick="hideModal(false, 'RA')"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalDefaultMessage">
                Voulez-vous vraiment retirer cette article de votre panier ?.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="hideModal(false, 'RA')">Non</button>
                <button type="button" class="btn btn-danger" onclick="hideModal(true, 'RA')">Oui</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaleOFS" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Supression article</h5>
                    <button
                        type="button"
                        class="btn btn-danger close"
                        style="margin-left: auto;"
                        onclick="hideModal(true, 'OFS')"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Un article a été retiré de votre panier car il n'y a plus de stock.
                </div>
                <div class="modal-footer">
                    <a  id="modalOFSLink" href="" type="button" class="btn btn-secondary" onclick="hideModal(false, 'OFS')" >Voir la page du produit</a>
                    <button type="button" class="btn btn-danger" onclick="hideModal(true, 'OFS')">D'accord</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaleCC" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Modification du panier</h5>
                </div>
                <div class="modal-body">
                    Votre panier a été modifié car un ou plusieurs articles ne seront plus en quantité suffisante.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="hideModal(true, 'CC')">D'accord</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaleCAM" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Ajout au panier impossible</h5>
                </div>
                <div class="modal-body">
                    Vous ne pouvez pas mettre plus de cet article dans votre panier.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="hideModal(true, 'CAM')">D'accord</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Header import -->
    <?php include BASE_DIR.'pageTemplate/header.php'; ?>

    <!-- Sidebar import -->
    <?php include BASE_DIR.'pageTemplate/sidebar.php'; ?>


    <main class="container-fluid pt-header-xs pt-header-sm pt-header-md pt-header-lg pt-header-xl">
        <!-- CONTENT HERE -->
        <h1>Panier</h1>
        <div id="templatePanier">
            <?php include BASE_DIR."pageTemplate/panierTemplate.php"?>
        </div>
        <a style="margin-bottom: 1%;" role="button" class="btn btn-primary" href="<?php echo BASE_DIR_STATIC."panier/commande.php"; ?>">Commander</a>
    </main>

    <!-- JS Import -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

    </body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>