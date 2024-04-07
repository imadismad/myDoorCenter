<?php
session_start();
; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour informations</title>
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
            <h1 class="welcome-title border rounded display-1"><b>Mise à jour informations</b></h1>
    </main>
    <div class="container">
        <form action="BDD/updateUser.php" method="post">
            <h3>informations personnelle:</h3>
            <div id="info_perso" class="perso">
                <label for="pays">Pays:</label>
                <p id="pays">
                    <?php printf("%s", $_SESSION["pays"]) ?>
                </p>
                <label for="tel">Numéro téléphone:</label>

                <input type="tel" name="tel" id="tel" placeholder="ex: +33712345678" minlength="3" maxlength="12"
                    required><br>
                <span id="messageErrorTel" class="error"></span><br>
            </div>

            <div id="info_perso" class="livraison">
                <h3>Adresse:</h3>

                <label for="ville">Ville:</label>
                <input type="text" name="ville" id="ville" placeholder="Ville" required><br>

                <label for="rue">Rue:</label>
                <input type="text" name="rue" id="rue" placeholder="Rue" required><br>

                <label for="postal">Code postal:</label>
                <input type="text" name="postal" id="postal" placeholder="Code postal" required>

            </div>
            <label for="submit">Modifier informations</label>
            <button type="submit" name="submit" id="submit" value="submit">Confirmation Modification</button><br>
            <script src="js/modification.js"></script>
        </form>
    </div>

</body>

</html>