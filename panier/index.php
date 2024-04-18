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
    $currentPath = __DIR__; // Obtient le chemin du dossier du script en cours.
    $lower = strtolower($currentPath); // Convertit le chemin en minuscules pour la recherche insensible à la casse.

    // Définition des noms de dossiers à rechercher.
    $projectFolder = 'mydoorcenter';
    $fallbackFolder = 'wwwroot';

    // Recherche du dossier 'mydoorcenter'.
    $projectPos = strpos($lower, $projectFolder);

    if ($projectPos !== false) {
        // Si 'mydoorcenter' est trouvé, extrait le chemin jusqu'à la fin de ce dossier.
        $path = substr($currentPath, 0, $projectPos + strlen($projectFolder));
    } else {
        // Si 'mydoorcenter' n'est pas trouvé, recherche de 'wwwroot'.
        $fallbackPos = strpos($lower, $fallbackFolder);
        if ($fallbackPos !== false) {
            // Si 'wwwroot' est trouvé, extrait le chemin jusqu'à la fin de ce dossier.
            $path = substr($currentPath, 0, $fallbackPos + strlen($fallbackFolder));
        } else {
            // Si aucun des deux dossiers n'est trouvé, utilise le chemin complet.
            $path = $currentPath;
        }
    }

    return $path;
}

define('BASE_DIR', getAbsoluteMyDoorCenterPath().'/');
define('BASE_DIR_STATIC', getProjectPath());
?>

<!-- Head with automatic css imports -->
<?php include BASE_DIR.'pageTemplate/head.php'; ?>


    <body>
    <?php echo BASE_DIR ?>
    <?php echo BASE_DIR_STATIC ?>
    CHANGE1
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
                    onclick="hideModal(false)"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment retirer cette article de votre panier ?.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="hideModal(false)">Non</a>
                <button type="button" class="btn btn-danger" onclick="hideModal(true)">Oui</button>
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
        <label>Code promo : <input type="text" name="codePromo"></label><br />

        <a role="button" class="btn btn-primary" href="panier/commande.php">Commander</a>
    </main>

    <!-- JS Import -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

    </body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>