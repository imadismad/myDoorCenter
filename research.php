<?php 
require_once 'BDD/functionsSQL.php';
require_once 'BDD/interactionBDD.php';

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

$resultats = rechercherProduits($_GET["research"], "porte",0,1000,True);
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
            
            <div class="col-md-2 sidebar-large collapse overlay-sidebar" id="sidebarCollapse">
                <button type="button" class="btn close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#porteSubmenu">Portes</a>
                        <ul class="collapse list-unstyled" id="porteSubmenu">
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Blindées</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Intérieures</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Extérieures</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Porte-fenêtres</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Personnalisées</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#blocSubmenu">Blocs</a>
                        <ul class="collapse list-unstyled" id="blocSubmenu">
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Blindés</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Intérieurs</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Extérieurs</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Porte-fenêtres</a></li>
                            <li><a class="sidebar-subitem dropdown-item rounded border" href="#">Personnalisés</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#poigneeSubmenu">Poignées</a>
                    </li>
                </ul>
            </div>
            
            <form method="get" action="research.php" class="p-3">
              <div class="form-group">
                  <input id="research" name="research" type="text" class="form-control" placeholder="Rechercher des portes..." style="margin: 2%;">
              </div>
      
              <div class="row">
                  <div class="col-md-3 bg-light rounded">
                    <label class="filterCategory rounded">Trier par
                        <select name="material">
                            <option value="">Prix : Ordre croissant</option>
                            <option value="bois">Prix : Ordre décroissant</option>
                            <option value="acier">Mise en avant</option>
                            <option value="verre">Moyenne des commentaires</option>
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

                      <div class="row">
                        <?php

                          foreach ($resultats as $produit) {
                              $article = "";

                              

                              $article.= '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">';
                              $article.= '<a href="'.BASE_DIR_STATIC.'product.php?id='.$produit['id'].'">';
                              $article.= '<div class="card">';
                              $article.= '<div class="card-body">';
                              $article.= '<h5 class="card-title"><b>'.$produit['nom'].'</b></h5>';
                              $article.= '</div>';
                              $article.= '<img src="'.BASE_DIR_STATIC.'images/miniature/'.$produit['nomImage'].'" class="card-img-top" alt="...">';
                              $article.= '<div class="card-body">';
                              $article.= '<p class="card-text">';
                              $article.= 'Une belle porte';
                              $article.= '</p>';
                              $article.= '</div>';
                              $article.= '</div>';
                              $article.= '</a>';
                              $article.= '</div>';

                              


                              echo $article;

                          }


                        ?>
                  </div>
                  
                  </div>
                  
              </div>
              </div>
      
              
          </form>
        </div>
        </main>

<!-- JS Import -->
<?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

</body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>