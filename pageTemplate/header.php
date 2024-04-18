
  <header class="container-fluid fixed-top" id="mainHeader">
  <!-- <div class="overlay"></div>
  <div class="row header-top align-items-center">
    <div class="col-2 col-md-1 sidebar-small">
      <button id="sidebarToggleButton" title="Menu" class="btn btn-light bi bi-list blue-button" style="font-size: 2rem;"></button>
    </div>
    <div class="col-4 col-md-3">
      <img src="images/logo.png" alt="Logo" height="100">
    </div>
    <div class="col-12 col-md-4 d-flex">
      <label title="Rechercher" for="search"><button class="btn btn-light bi bi-search blue-button" style="font-size: 1rem;"></button></label>
      <input type="text" name="search" class="form-control" placeholder="Recherche...">
    </div>
    <div class="col-3 col-md-1">
      <span><b>01 23 45 67 89 <i class="bi bi-telephone"></i></b></span>
    </div>
    <div class="col-3 col-md-2 row">
      <div class="col-6">
        <a href="espaceClient.php"><button title="Espace client" class="btn btn-light bi bi-cart3" style="font-size: 2rem;"></button></a>
      </div>
      <div class="col-6">
        <a href="espaceClient.php"><button title="Espace client" class="btn btn-light bi bi-person-circle blue-button" style="font-size: 2rem;"></button></a>
      </div>
    </div>
  </div> -->

  <div class="overlay"></div>
  <div class="row header-top align-items-center">
    <!-- Groupe de bouton menu et logo -->
    <div class="col-6 col-md-3 d-flex align-items-center">
      <div class="col-4 px-0 sidebar-small">
        <button id="sidebarToggleButton" title="Menu" class="btn btn-light bi bi-list blue-button" style="font-size: 2rem;"></button>
      </div>
      <div class="col-8 px-1">
        <img src="images/logo.png" alt="Logo" height="100"> <!-- Taille du logo ajustée -->
      </div>
    </div>
    
    <!-- Barre de recherche pour grands écrans -->
    <div class="d-none d-md-block col-md-4 px-md-2">
      <div class="input-group">
        <div class="input-group-prepend">
          <button class="btn btn-light bi bi-search blue-button" style="font-size: 1rem;"></button>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Recherche...">
      </div>
    </div>
    
    <!-- Numéro de téléphone et icônes Espace Client -->
    <div class="col-6 col-md-4 d-flex justify-content-end align-items-center px-2">
      <div class="col-6">
        <span><b>01 23 45 67 89 <i class="bi bi-telephone"></i></b></span>
      </div>
      <div class="col-6 d-flex justify-content-between">
        <a href="panier"><button title="Panier" class="btn btn-light bi bi-cart3" style="font-size: 1.5rem;"></button></a>
        <a href="espaceClient.php"><button title="Espace client" class="btn btn-light bi bi-person-circle blue-button" style="font-size: 1.5rem;"></button></a>
      </div>
    </div>

    <!-- Barre de recherche pour petits écrans -->
    <div class="col-12 d-md-none d-flex mt-2">
      <div class="input-group">
        <div class="input-group-prepend">
          <button class="btn btn-light bi bi-search blue-button" style="font-size: 1rem;"></button>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Recherche...">
      </div>
    </div>
  </div>

    <div class="row">
      <div class="col-md-12 align-center">
        <ul class="nav nav-tabs">
          <li class="nav-item dropdown">
            <a class="nav-link nav-link-top dropdown-toggle" href="#" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Portes
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Blindées</a>
              <a class="dropdown-item" href="#">Intérieures</a>
              <a class="dropdown-item" href="#">Extérieures</a>
              <a class="dropdown-item" href="#">Porte-fenêtres</a>
              <a class="dropdown-item" href="#">Personnalisées</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link nav-link-top dropdown-toggle" href="#" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Blocs
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Blindés</a>
              <a class="dropdown-item" href="#">Intérieurs</a>
              <a class="dropdown-item" href="#">Extérieurs</a>
              <a class="dropdown-item" href="#">Porte-fenêtres</a>
              <a class="dropdown-item" href="#">Personnalisés</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-top" href="#">Poignées</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-top" href="#">Accessoires</a>
          </li>
        </ul>
      </div>
    </div>
  </header>