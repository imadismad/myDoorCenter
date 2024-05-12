<header class="container-fluid fixed-top" id="mainHeader">

  <div class="overlay"></div>
  <div class="row header-top align-items-center">
    <!-- Groupe de bouton menu et logo -->
    <div class="col-6 col-md-3 d-flex align-items-center">
      <div class="col-4 px-0 sidebar-small">
        <button id="sidebarToggleButton" title="Menu" class="btn btn-light bi bi-list blue-button" style="font-size: 2rem;"></button>
      </div>
      <div class="col-8 px-1">
        <a href="<?php echo BASE_DIR_STATIC; ?>">
          <img src="<?php echo BASE_DIR_STATIC . "img/logo.png"; ?>" alt="Logo" height="100"> <!-- Taille du logo ajustée -->
        </a>
      </div>
    </div>

    <!-- Barre de recherche pour grands écrans -->
    <div class="d-none d-md-block col-md-4 px-md-2">
      <form method="get" action="<?php echo BASE_DIR_STATIC . 'research.php'; ?>">
        <div class="input-group">
          <input type="text" name="search" class="form-control" placeholder="Recherche..." aria-label="Recherche">
          <div class="input-group-append">
            <button class="btn btn-light bi bi-search blue-button" style="font-size: 1rem;" type="submit"></button>
          </div>
        </div>
      </form>
    </div>


    <!-- Numéro de téléphone et icônes Espace Client -->
    <div class="col-6 col-md-4 d-flex justify-content-end align-items-center px-2">
      <div class="col-6" style="padding-left: 5%;">
        <span><b>01 23 45 67 89 <i class="bi bi-telephone"></i></b></span>
      </div>
      <div class="col-6 d-flex justify-content-between ">
        <a href="<?php echo BASE_DIR_STATIC . "espaceClient.php"; ?>"><button title="Espace client" class="btn btn-light bi bi-person-circle blue-button" style="font-size: 1.5rem;"></button></a>
        <a href="<?php echo BASE_DIR_STATIC . "panier"; ?>"><button title="Panier" class="btn btn-light bi bi-cart3" style="font-size: 1.5rem;"></button></a>
      </div>
    </div>

    <!-- Barre de recherche pour petits écrans -->
    <div class="col-12 d-md-none mt-2">
    <form method="get" action="<?php echo BASE_DIR_STATIC . 'research.php'; ?>">
        <div class="input-group">
          <input type="text" name="search" class="form-control" placeholder="Recherche..." aria-label="Recherche">
          <div class="input-group-append">
            <button class="btn btn-light bi bi-search blue-button" style="font-size: 1rem;" type="submit"></button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 align-center">
      <ul class="nav nav-tabs">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-top dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Portes
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?php echo BASE_DIR_STATIC . 'research.php?search=porte+blindée&porte=true'; ?>">Blindées</a>
            <a class="dropdown-item" href="<?php echo BASE_DIR_STATIC . 'research.php?search=porte+intérieure&porte=true'; ?>">Intérieures</a>
            <a class="dropdown-item" href="<?php echo BASE_DIR_STATIC . 'research.php?search=porte+extérieure&porte=true'; ?>">Extérieures</a>
            <a class="dropdown-item" href="<?php echo BASE_DIR_STATIC . 'research.php?search=porte-fenêtre&porte=true'; ?>">Porte-fenêtres</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-top" href="<?php echo BASE_DIR_STATIC . 'research.php?poignee=true'; ?>">Poignées</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-top" href="<?php echo BASE_DIR_STATIC . 'research.php?accessoire=true'; ?>">Accessoires</a>
        </li>
      </ul>
    </div>
  </div>
</header>