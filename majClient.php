<?php
session_start();
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
        <div class="col-md-12 content text-center">
            <h1 class="welcome-title border rounded display-1"><b>Mettre à jour mes informations</b></h1>
        </div>
        <div class="container">
            <div class="d-flex align-items-center justify-content-center">
                <div class="w-50 p-3">
                    <div class="text-bg-light p-3">
                        <form action="BDD/updateUser.php" method="post" class="row g-3">

                            <!--info sur la personne-->
                            <h3>Informations personnelles :</h3>
                            <div id="info_perso" class="row g-3">

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Numéro téléphone:</span>
                                    <input type="tel" name="tel" id="tel" placeholder="ex: +33712345678" minlength="3" maxlength="12"
                                        class="form-control" aria-describedby="basic-addon1" required>
                                    <span id="messageErrorTel" class="error"></span><br>
                                </div>
                            </div>

                            <!--info livraison-->
                            <div id="info_perso" class="row g-3">
                                <h3>Adresse:</h3>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Ville:</span>
                                    <input type="text" name="ville" id="ville" placeholder="Ville" class="form-control"
                                        aria-describedby="basic-addon1" required>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Rue:</span>
                                    <input type="text" name="rue" id="rue" placeholder="Rue" class="form-control"
                                        aria-describedby="basic-addon1" required>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Code postal:</span>
                                    <input type="text" name="postal" id="postal" placeholder="Code postal" class="form-control"
                                        aria-describedby="basic-addon1" required>
                                </div>
                            </div>
                            <!--TODO à sécuriser-->
                            <!--Info sensible-->
                            <div id="sensible" class="row g-3">
                                <h3>Information confidentiels:</h3>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Mot de passe:</span>
                                    <input type="password" name="password" id="password" class="form-control"
                                        aria-describedby="basic-addon1" required>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Confirmation Mot de passe:</span>
                                    <input type="password" name="password" id="password" class="form-control"
                                        aria-describedby="basic-addon1" required>
                                </div>

                                <span id="messageErrorPassw" class="error"></span><br>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" name="submit" id="submit"
                                        value="submit">Modifier informations</button>
                                    <script src="js/modification.js"></script>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

        </div>
        </form>
    </main>

   <!-- JS Import -->
   <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

</body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>