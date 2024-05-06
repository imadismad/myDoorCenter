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
                        <input id="research" name="research" type="text" class="form-control" placeholder="Rechercher des portes..." value="<?php echo $_GET["search"] ?>">
                        <div class="input-group-append">
                            <button class="btn btn-light bi bi-search blue-button" style="font-size: 1rem;" type="submit"></button>
                        </div>
                    </div>

        
                <div class="row">
                    <div class="col-md-3 bg-light rounded">
                        <label class="filterCategory rounded">Trier par
                            <select id="sortList" name="material">
                                <option value="priceUp">Prix : Ordre croissant</option>
                                <option value="priceDown">Prix : Ordre décroissant</option>
                                <option value="suggestion">Mise en avant</option>
                                <option value="comments">Moyenne des commentaires</option>
                            </select>
                        </label>
                        <h3>Catégories</h3>
                        <div class="form-check">
                            <label><input type="checkbox" name="category" value="porte_blindée"> Portes blindées</label>
                            <br>
                            <label><input type="checkbox" name="category" value="porte_intérieure"> Portes intérieurs</label>
                            <br>
                            <label><input type="checkbox" name="category" value="porte_extérieure"> Portes extérieurs</label>
                            <br>
                            <label><input type="checkbox" name="category" value="porte_fenêtre"> Portes fenêtres</label>
                            <br>
                            <label><input type="checkbox" name="category" value="porte_personnalisée"> Porte personnalisable</label>
                            <br>
                            <label><input type="checkbox" name="category" value="poignée"> Poignées</label>
                            <br>
                            <label><input type="checkbox" name="category" value="canon"> Canon</label>
                            <br>
                            <label><input type="checkbox" name="category" value="bloque_complet"> Bloque complet</label>
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
                            <br>
                            <label class="filterCategory rounded">Matériaux
                                <select name="material">
                                    <option value="">Sélectionner</option>
                                    <option value="bois">Bois</option>
                                    <option value="acier">Acier</option>
                                    <option value="verre">Verre</option>
                                </select>
                            </label>
                            <br>
                            <label class="filterCategory rounded"><input type="checkbox" name="recent_article"> Article récent</label>
                            <br>
                            <label class="filterCategory rounded">Note des clients
                                <select name="rating">
                                    <option value="">Sélectionner</option>
                                    <option value="1">★☆☆☆☆</option>
                                    <option value="2">★★☆☆☆</option>
                                    <option value="3">★★★☆☆</option>
                                    <option value="4">★★★★☆</option>
                                    <option value="5">★★★★★</option>
                                </select>
                            </label>
                            <br>
                            <label class="filterCategory rounded">Couleurs disponibles
                                <select name="color">
                                    <option value="">Sélectionner</option>
                                    <option value="blanc">Blanc</option>
                                    <option value="noir">Noir</option>
                                    <option value="rouge">Rouge</option>
                                </select>
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