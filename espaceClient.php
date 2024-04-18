<?php
session_start();
if (!isset($_COOKIE["prenom"])) {
    header("Location: creationCompte.php");
} else {
    $cookie_name = "prenom";
    setcookie($cookie_name, $_SESSION["prenom"], time() + 60 * 60 * 24, "/");
}
?>
<!-- TODO Modif css espaceClient -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace client</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Css spécifique -->
    <link href="css/index/style.css" rel="stylesheet">
</head>

<body>
    <div class="overlay"></div>
    <header class="container-fluid fixed-top" id="mainHeader">
        <div class="row header-top align-items-center">
            <div class="col-md-1 sidebar-small">
                <button title="Menu" class="btn btn-light bi bi-list blue-button" style="font-size: 2rem;"></button>
            </div>
            <div class="col-md-3">
                <a href="index.html"><img src="images/logo.png" alt="Logo" height="100"></a>
            </div>
    </header>
    <main class="container-fluid">
        <div class="col-md-12 content text-center">
            <h1 class="welcome-title border rounded display-1"><b>Votre espace Client</b></h1>
    </main>

    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <div class="w-50 p-3">
                <ul class="nav justify-content-center nav-pills gap-3">
                    <li class="nav-item"><a class="nav-link active" href="majClient.php">Modifiez les informations</a>
                    </li>
                    <li class="nav-item"><a class="nav-link active" href="#">Vos
                            commandes</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Vos dernier
                            achat</a></li>
                </ul>
                <div class="text-bg-light p-3">
                    <div class="col-md-12">
                        <div class="container text-center">
                            <h1>Vos informations actuelles:</h1>
                            <div class="row">
                                <div class="col border-end-0">
                                    <p>Prénom:</p>
                                    <p>
                                        <?php printf($_COOKIE['prenom']) ?>
                                    </p>
                                </div>
                                <div class="col border-left-0">
                                    <p>Nom:</p>
                                    <p>
                                        <?php printf($_SESSION['nom']) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h3>Adresse complète</h3>
                                    <p>
                                        <?php printf("%s %s %s", $_SESSION["rue"], $_SESSION["ville"], $_SESSION["CP"]) ?>
                                    </p>
                                </div>
                                <div class="col">
                                    <h3>Adresse Mail:</h3>
                                    <p>
                                        <?php printf("%s", $_SESSION['mail']) ?>
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="mail">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <ul class="nav justify-content-center nav-pills gap-3">
            <li class="nav-item"><a class="nav-link" href="index.html">Aller à la page principale</a></li>
            <li class="nav-item"><a class="nav-link" href="api/disconnect.php">Se déconnecter</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Assistance</a></li>
        </ul>

    </div>
    </div>

</body>

</html>