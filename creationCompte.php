<?php
require_once "php/Redirect.php";
define('BASE_DIR', getAbsoluteMyDoorCenterPath().'/');
define('BASE_DIR_STATIC', getProjectPath());

function getProjectPath() {
    $scriptPath = strtolower($_SERVER['SCRIPT_NAME']);
    $projectFolder = 'mydoorcenter';
    $pos = strpos($scriptPath, $projectFolder);
    if ($pos !== false) {
        return rtrim(substr($scriptPath, 0, $pos + strlen($projectFolder)), '/') . '/';
    }
    return '/';
}

function getAbsoluteMyDoorCenterPath() {
    $path = __DIR__;
    foreach (['mydoorcenter', 'wwwroot'] as $folder) {
        $pos = strpos(strtolower($path), $folder);
        if ($pos !== false) {
            return substr($path, 0, $pos + strlen($folder));
        }
    }
    return $path;
}
?>

<!-- Head with automatic CSS imports -->
<?php include BASE_DIR.'pageTemplate/head.php'; ?>

<body>
    <!-- Header and sidebar import -->
    <?php include BASE_DIR.'pageTemplate/header.php'; ?>
    <?php include BASE_DIR.'pageTemplate/sidebar.php'; ?>
    <main class="container-fluid pt-header-xs pt-header-sm pt-header-md pt-header-lg pt-header-xl">

                <div class="container"></div>
                <div class="col-md-12 content text-center">
                    <h1 class="welcome-title border rounded display-1"><b>Création compte</b></h1>

        <div class="container">
            <div class="d-flex align-items-center justify-content-center">
                <div class="w-50 p-3">
                    <div class="text-bg-light p-3">
                        <form action="/BDD/connexion.php" method="post" class="row g-3">

                            <!--info sur la personne-->
                            <h3>Information personnelle:</h3>
                            <div id="info_perso" class="row g-3">

                                <div class="col-md-3">
                                    <select name="sex" id="sex" class="form-select" required>
                                        <option value="">Genre</option>
                                        <option value="homme">Mr.</option>
                                        <option value="femme">Mme.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-label="Username"
                                    aria-describedby="basic-addon1" name="nom" id="nom" placeholder="Nom" required>
                            </div>

                            <div class="col-md-6">
                                <input type="text" class="form-control" aria-label="Username"
                                    aria-describedby="basic-addon1" name="prenom" id="prenom" placeholder="Prénom" required>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">@</span>
                                <input type="email" class="form-control" aria-label="Username"
                                    aria-describedby="basic-addon1" name="mail" id="mail" placeholder="Mail" required>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Date de naissance:</span>
                                <input type="date" name="naissance" arial-label="Username" id="naissance"
                                    class="form-control" aria-describedby="basic-addon1" required>
                            </div>
                            <span id="messageAge" class="error"></span>

                            <div class="col md-6">
                                <select name="pays" id="pays" class="form-select">
                                    <option value="France">France: +33</option>
                                    <option value="États-Unis">États-Unis: +1</option>
                                    <option value="Royaume-Uni">Royaume-Uni: +44</option>
                                    <option value="Allemagne">Allemagne: +49</option>
                                    <option value="Espagne">Espagne: +34</option>
                                    <option value="Italie">Italie: +39</option>
                                    <option value="Canada">Canada: +1</option>
                                    <option value="Australie">Australie: +61</option>
                                    <option value="Japon">Japon: +81</option>
                                    <option value="Brésil">Brésil: +55</option>
                                </select>
                            </div>
                            <div class="col md-6">
                                <input type="tel" class="form-control" aria-label="Username" aria-describedby="basic-addon1"
                                    name="tel" id="tel" placeholder="ex: +33712345678" minlength="3" maxlength="12"
                                    required><br>
                                <span id="messageErrorTel" class="error"></span><br>
                            </div>
                            <!--info livraison-->
                            <div id="info_perso" class="row g-3">
                                <h3>Adresse:</h3>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" aria-label="Username"
                                        aria-describedby="basic-addon1" name="ville" id="ville" placeholder="Ville"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" aria-label="Username"
                                        aria-describedby="basic-addon1" name="rue" id="rue" placeholder="Rue" required>
                                </div>

                                <div class="col-md-3">
                                    <input type="text" class="form-control" aria-label="Username"
                                        aria-describedby="basic-addon1" name="postal" id="postal" placeholder="Code postal"
                                        required>
                                </div>

                            </div>
                            <!--TODO à sécuriser-->
                            <!--Info sensible-->
                            <div id="sensible" class="row g-3">
                                <h3>Information confidentiels:</h3>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" aria-label="Username"
                                        aria-describedby="basic-addon1" name="password" id="password"
                                        placeholder="Mot de passe" minlength="8" required>
                                </div>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" aria-label="Username"
                                        aria-describedby="basic-addon1" name="password" id="confirmation"
                                        placeholder="Confirmation Mot de passe" required>
                                </div>

                                <span id="messageErrorPassw" class="error"></span><br>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" name="submit" id="submit"
                                        value="submit">Créer votre
                                        compte</button>
                                    <!-- <script src="js/module.creationCompte.js"></script> -->
                                </div>
                                <div class="col-12">
                                    <input class="btn btn-primary" type="button" value="Connexion"
                                        onclick=<?php echo "window.location='".getUrlWithSaveRedirect(BASE_DIR_STATIC.'connexion.php')."';"?>>
                                </div>
                                <br>
                            </div>
                    </div>
                </div>
            </div>


            </form>

        </div>
        </div>

        </div>
    </main>
    
    <!-- JavaScript imports -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>
</body>
<?php include BASE_DIR.'pageTemplate/footer.php'; ?>
