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

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Css spécifique -->
    <link href="css/index/style.css" rel="stylesheet">
</head>

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
        <div class="container justify-content-center">
            <div class="d-flex align-items-center justify-content-center">
                <div class="w-50 p-3">
                    <div class="text-bg-light p-3">
                        <h2>Connexion</h2>
                        <?php
                            if(isset($_GET['error']) && $_GET['error'] == "true") {
                                echo '
                                <div class="alert alert-danger" role="alert">
                                    Nom d\'utilisateur ou mot de passe incorrect
                                </div>
                                ';
                            }
                        ?>
                        <form action=<?php echo getUrlWithSaveRedirect("/api/connect.php"); ?> method="post" class="row g-4">

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
</body>

</html>