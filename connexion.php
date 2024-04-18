<?php
require_once "php/Redirect.php";
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
            <h1 class="welcome-title border rounded display-1"><b>Connexion</b></h1>
        </div>


        <!-- Page de connexion -->
        <div class="container">
            <div class="d-flex align-items-center justify-content-center">
                <div class="w-50 p-3">
                    <div class="text-bg-light p-3">
                        <h2>Connexion</h2>
                        <form action=<?php echo getUrlWithSaveRedirect("api/connect.php"); ?> method="post" class="row g-4">

                            <div class="input-group input-group-lg">
                                <span class="input-group-text" id="inputGroup-sizing-lg">@</span>
                                <input type="email" id="mail" name="mail" class="form-control"
                                    aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="Email">
                            </div>

                            <div class="input-group input-group-lg">
                                <span class="input-group-text" id="inputGroup-sizing-lg">Mot de passe</span>
                                <input type="password" id="password" name="password" class="form-control"
                                    aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="submit" id="submit"
                                    value="connexion">Connexion</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </main>

    <!-- JS Import -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

    </body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>