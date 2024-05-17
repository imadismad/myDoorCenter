<?php 
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


    <main class="row container-fluid pt-header-xs pt-header-sm pt-header-md pt-header-lg pt-header-xl">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="row">
                
                    <div class="input-group" style="margin: 2%;">
                        <input id="research" name="research" type="text" class="form-control" placeholder="Rechercher des portes..." value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>">
                        <div class="input-group-append">
                            <button class="btn btn-light bi bi-search blue-button" style="font-size: 1rem;" type="submit"></button>
                        </div>
                    </div>

        
                <div class="row">
                    <div class="col-md-3 bg-light rounded">
                        <label class="filterCategory rounded">Trier par
                            <select id="sortList" name="material">
                                <option value="0">Mise en avant</option>
                                <option value="1">Prix : Ordre croissant</option>
                                <option value="2">Prix : Ordre décroissant</option>
                            </select>
                        </label>
                        <h3>Catégories</h3>
                        <div class="form-check">
                            <label>
                                <input id="allField" type="radio" name="category" value="porte"
                                <?php
                                    if (isset($_GET["porte"]) && isset($_GET["poignee"]) && isset($_GET["poignee"]))
                                        echo 'checked';
                                ?>
                                >
                                Tout
                            </label>
                            <br>
                            <label>
                                <input id="porteField" type="radio" name="category" value="porte"
                                <?php
                                    if (isset($_GET["porte"]) && $_GET["porte"] == "true") echo 'checked'; 
                                ?>
                                >
                                Porte
                            </label>
                            <br>
                            <label>
                                <input id="poigneeField" type="radio" name="category" value="poignee"
                                <?php
                                    if (isset($_GET["poignee"]) && $_GET["poignee"] == "true") echo 'checked'; 
                                ?>
                                >
                                Poignée
                            </label>
                            <br>
                            <label>
                                <input id="accessoireField" type="radio" name="category" value="accessoire"
                                <?php
                                    if (isset($_GET["accessoire"]) && $_GET["accessoire"] == "true") echo 'checked';
                                ?>
                                >
                                Accessoire
                            </label>
                        </div>

        
                        <h3>Plus de Filtres</h3>
                        <div class="form-group">
                            <label class="filterCategory rounded">Prix minimal
                                <input type="range" name="price" id="priceRangeMin" min="0" max="5000" value="0">
                                <input type="number" id="priceNumberMin" min="0" max="5000" value="0">
                                <span id="priceValueMin">0</span>€
                            </label>

                            <label class="filterCategory rounded">Prix maximal
                            <input type="range" name="price" id="priceRangeMax" min="0" max="5000" value="5000">
                            <input type="number" id="priceNumberMax" min="0" max="5000" value="5000">
                            <span id="priceValueMax">5000</span>€
                            </label>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </div>
        
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-12">
                                <h2>Résultats de la recherche</h2>
                            </div>
                        </div>
                        <div id="productResults" class="row">
                            <!-- PRODUCTS HERE -->
                        </div>
                    </div>
                    
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-1"></div>
        </main>

<!-- JS Import -->
<?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

</body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>