<?php
session_start();
if (!isset($_COOKIE["prenom"])) {
    header("Location: creationCompte.php");
} else {
    $cookie_name = "prenom";
    setcookie($cookie_name, $_SESSION["prenom"], time() + 60 * 60 * 24, "/");
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
<!-- Head with automatic css imports -->
<?php include BASE_DIR.'pageTemplate/head.php'; ?>


    <body>

    <!-- Header import -->
    <?php include BASE_DIR.'pageTemplate/header.php'; ?>

    <!-- Sidebar import -->
    <?php include BASE_DIR.'pageTemplate/sidebar.php'; ?>

    <main class="container-fluid pt-header-xs pt-header-sm pt-header-md pt-header-lg pt-header-xl text-center">
        <h1 class="welcome-title border rounded display-1"><b>Votre espace Client</b></h1>

        <div class="row">
            <!-- Navigation principale au-dessus des informations -->
            <div class="col-12">
                <ul class="nav justify-content-center nav-pills gap-3 mb-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="majClient.php">Modifier <i class="bi bi-pen"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="historiqueCommande.php">Vos commandes <i class="bi bi-list-check"></i></a>
                    </li>
                </ul>
            </div>
            
            <!-- Informations actuelles de l'utilisateur -->
            <div class="text-bg-light p-3 mb-4 col-12">
                <h1>Vos informations actuelles:</h1>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Prénom:</strong> <?php printf($_COOKIE['prenom']); ?></p>
                    </div>
                    <div class="col-12">
                        <p><strong>Nom:</strong> <?php printf($_SESSION['nom']); ?></p>
                    </div>
                    <div class="col-12">
                        <h3>Adresse complète</h3>
                        <p><?php printf("%s %s %s", $_SESSION["rue"], $_SESSION["ville"], $_SESSION["CP"]); ?></p>
                    </div>
                    <div class="col-12">
                        <h3>Adresse Mail:</h3>
                        <p><?php printf("%s", $_SESSION['mail']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Liens additionnels en dessous des informations -->
            <div class="col-12" style="margin-bottom: 10%;">
                <ul class="nav justify-content-center nav-pills gap-3">
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_DIR_STATIC.'index.php'; ?>">Aller à la page principale <i class="bi bi-house"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="api/disconnect.php">Se déconnecter <i class="bi bi-box-arrow-right"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Assistance <i class="bi bi-tools"></i></a></li>
                </ul>
            </div>
            
        </div>
    </main>




    <!-- JS Import -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

    </body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>