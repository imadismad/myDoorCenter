<?php
session_start();
if (!isset($_COOKIE["prenom"])) {
    header("Location: creationCompte.html");
} else {
    $cookie_name = "prenom";
    setcookie($cookie_name, $_SESSION["prenom"], time() + 60 * 60 * 24, "/");
}
?>
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

    <div class="client">
        <ul>
            <li><a href="majClient.html">Modifiez les informations</a></li>
            <li><a href="#">Vos commandes</a></li>
            <li><a href="#">Vos dernier achat</a></li>
        </ul>
        <div class="info">
            <h1>Vos informations actuelles:</h1>

            <div class="prenom">
                <p>Prénom:</p>
                <p>
                    <?php printf($_COOKIE['prenom']) ?>
                </p>
            </div>

            <div class="Nom">
                <p>Nom:</p>
                <p>
                    <?php printf($_SESSION['nom']) ?>
                </p>
            </div>
            <div class="adress">
                <p>Adress complète:</p>
                <p>
                    <?php printf("%s %s %s", $_SESSION["rue"], $_SESSION["ville"], $_SESSION["CP"]) ?>
                </p>
            </div>

            <div class="mail">
                <p>Adresse Mail:</p>
                <p>
                    <?php printf("%s", $_SESSION['mail']) ?>
                </p>
            </div>

        </div>
    </div>
    <a href="index.html">Aller à la page principale</a><br>
    <a href="BDD/deconnexion.php">Se déconnecter</a><br>
    <a href="#">Assistance</a>
</body>

</html>