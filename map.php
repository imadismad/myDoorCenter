<?php 
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

    <!-- Header import -->
    <?php include BASE_DIR.'pageTemplate/header.php'; ?>

    <!-- Sidebar import -->
    <?php include BASE_DIR.'pageTemplate/sidebar.php'; ?>


    <main class="container-fluid pt-header-xs pt-header-sm pt-header-md pt-header-lg pt-header-xl">
        <!-- CONTENT HERE -->
        <h1>Plan du site</h1>
        <ul>
            <li><a href="<?php echo BASE_DIR_STATIC; ?>">Accueil</a></li>
            <li><a href="<?php echo BASE_DIR_STATIC . 'connexion.php'; ?>">Connexion</a></li>
            <li><a href="<?php echo BASE_DIR_STATIC . 'creationCompte.php'; ?>">Création de compte</a></li>
            <li><a href="<?php echo BASE_DIR_STATIC . 'contact.php'; ?>">Assistance</a></li>
            <li><a href="<?php echo BASE_DIR_STATIC . 'espaceClient.php'; ?>">Espace client</a></li>
            <li><a href="<?php echo BASE_DIR_STATIC . 'legalNotice.php'; ?>">Mentions légales</a></li>
            <li><a href="<?php echo BASE_DIR_STATIC . 'research.php'; ?>">Recherche de produits</a></li>
        </ul>
        <!-- END OF CONTENT -->
    </main>

    <!-- JS Import -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

    </body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>