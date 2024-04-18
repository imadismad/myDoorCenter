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
    $path = strpos($lower = strtolower($currentPath = __DIR__), $projectFolder = 'mydoorcenter') !== false ?
            substr($currentPath, 0, strpos($lower, $projectFolder) + strlen($projectFolder)) :
            $currentPath;
    return $path;
}

define('BASE_DIR', getAbsoluteMyDoorCenterPath().'/');
define('BASE_DIR_STATIC', getProjectPath());
?>

<!-- Head with automatic css imports -->
<?php include BASE_DIR.'pageTemplate/head.php'; ?>


    <body>

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

        <input type="submit" value="Commander">
        <!-- END OF CONTENT -->
    </main>

    <!-- JS Import -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

    </body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>