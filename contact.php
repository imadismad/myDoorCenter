<?php 
function getProjectPath() {
    $path = strpos($lower = strtolower($scriptPath = $_SERVER['SCRIPT_NAME']), $projectFolder = 'mydoorcenter') !== false ?
            substr($scriptPath, 0, strpos($lower, $projectFolder) + strlen($projectFolder)) :
            '/';
    return rtrim($path, '/') . '/';
}

function getAbsoluteMyDoorCenterPath() {
    $path = strpos($lower = strtolower($currentPath = __DIR__), $projectFolder = 'mydoorcenter') !== false ?
            substr($currentPath, 0, strpos($lower, $projectFolder) + strlen($projectFolder)) :
            $currentPath;
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
        <div class="row">
            
            <div class="col-md-12 content">
                <div class="bg-dark text-white text-center p-3">
                    <h1>My Door Center - Contact Service Client</h1>
                </div>
            
                <div class="">
                    <h2>Contactez-nous</h2>
                    <form onsubmit="return sendEmail(this);">
                        <div class="form-group">
                            <label for="clientName">Votre nom</label>
                            <input type="text" class="form-control" id="clientName" name="clientName" required>
                        </div>
                        <div class="form-group">
                            <label for="clientMail">Votre e-mail</label>
                            <input type="email" class="form-control" id="clientMail" name="clientMail" required>
                        </div>
                        <div class="form-group">
                            <label for="requestType">Type de requête</label>
                            <select class="form-control" id="requestType" name="requestType" required>
                                <option value="achat">Suite à un achat</option>
                                <option value="paiement">Problème de paiement</option>
                                <option value="confidentialite">Compte et confidentialité</option>
                                <option value="signalement">Signalement</option>
                                <option value="accessibilite">Accessibilité</option>
                                <option value="autres">Autres</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="productName">Nom du produit</label>
                            <input type="text" class="form-control" id="productName" name="productName" placeholder="Nom du produit">
                        </div>
                        <div class="form-group">
                            <label for="requestDetails">Détails de la demande d'assistance</label>
                            <textarea class="form-control" id="requestDetails" name="requestDetails"></textarea>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                    
                    <hr>
                    <h3 class="mt-4">Vos derniers articles commandés</h3>
            
                    <ul class="list-group">
            
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Porte blindée Modèle A
                            <span><a href="#" class="btn btn-outline-primary btn-sm">Problème de réception</a> <a href="#" class="btn btn-outline-secondary btn-sm">Article endommagé</a></span>
                        </li>
            
                    </ul>
                    <br>
                </div>

            </div>
          
        </div>
    </main>

    <!-- JS Import -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

    </body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>