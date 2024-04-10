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
    <header class="container-fluid" id="mainHeader">
        <div class="row header-top align-items-center">
            <div class="col-md-3 container-fluid align-items-center">
                <a href="index.html"><img src="images/logo.png" alt="Logo" height="100"></a>
            </div>
            <main class="container-fluid sticky-top align-items-center">

                <div class="container"></div>
                <div class="col-md-12 content text-center">
                    <h1 class="welcome-title border rounded display-1"><b>Mise à jour informations</b></h1>
            </main>
    </header>

    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <div class="w-50 p-3">
                <div class="text-bg-light p-3">
                    <form action="BDD/updateUser.php" method="post" class="row g-3">

                        <!--info sur la personne-->
                        <h3>Information personnelle:</h3>
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

</body>

</html>
