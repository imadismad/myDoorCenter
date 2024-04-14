<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyDoorCenter</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Main css -->
  <link href="css/main.css" rel="stylesheet">
  <!-- Specific css -->
  <link href="css/index/style.css" rel="stylesheet">

</head>

<body>
  <?php include 'pageTemplate/header.php'; ?>


  <main class="container-fluid">
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

      <div class="col-md-12 content text-center">
        <h1 class="welcome-title border rounded display-1"><b>Bienvenue sur MyDoorCenter</b></h1>
        <div class="position-relative text-center">
          <img src="images/fresqueworker.png" alt="Logo" width="100%">
          <div class="rounded position-absolute top-50 start-50 translate-middle div-transparent">
            <h6 class="display-6"><b>Vous avez frappé <br>à la bonne porte !</b></h6>
          </div>
        </div>

        <div class="text-box">
          <h5 class="display-5">Nos services</h5>
          <div class="inner-text">
            <div class="container">
              <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <a href="research.html">
                    <div class="card">
                      <img src="images/porte.png" class="card-img-top" alt="...">
                      <div class="rounded position-absolute top-50 start-50 translate-middle div-transparent-dark">
                        <h6 class="display-6"><b>Produits</b></h6>
                      </div>
                    </div>
                  </a>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <a href="">
                    <div class="card">
                      <img src="images/blocporte.png" class="card-img-top" alt="...">
                      <div class="rounded position-absolute top-50 start-50 translate-middle div-transparent-dark">
                        <h6 class="display-6"><b>Installation</b></h6>
                      </div>
                    </div>
                  </a>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <a href="">
                    <div class="card">
                      <img src="images/poignee.png" class="card-img-top" alt="...">
                      <div class="rounded position-absolute top-50 start-50 translate-middle div-transparent-dark">
                        <h6 class="display-6"><b>Configurateur</b></h6>
                      </div>
                    </div>
                  </a>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <a href="">
                    <div class="card">
                      <img src="images/accessoire.png" class="card-img-top" alt="...">
                      <div class="rounded position-absolute top-50 start-50 translate-middle div-transparent-dark">
                        <h6 class="display-6"><b>FAQ</b></h6>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--                 
                <div class="text-box">
                    <h5 class="display-5">Avec notre large sélection, tous les projets sont à portée de main !</h5>
                    <div class="inner-text">
                        <div class="container">
                            <div class="row">

                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card">
                                  <img src="images/porte.png" class="card-img-top" alt="...">
                                  <div class="card-body">
                                    <p class="card-text">Porte</p>
                                  </div>
                                </div>
                              </div>

                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card">
                                  <img src="images/porte.png" class="card-img-top" alt="...">
                                  <div class="card-body">
                                    <p class="card-text">Porte</p>
                                  </div>
                                </div>
                              </div>

                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card">
                                  <img src="images/porte.png" class="card-img-top" alt="...">
                                  <div class="card-body">
                                    <p class="card-text">Porte</p>
                                  </div>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card">
                                  <img src="images/porte.png" class="card-img-top" alt="...">
                                  <div class="card-body">
                                    <p class="card-text">Porte</p>
                                  </div>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card">
                                  <img src="images/porte.png" class="card-img-top" alt="...">
                                  <div class="card-body">
                                    <p class="card-text">Porte</p>
                                  </div>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card">
                                  <img src="images/porte.png" class="card-img-top" alt="...">
                                  <div class="card-body">
                                    <p class="card-text">Porte</p>
                                  </div>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card">
                                  <img src="images/porte.png" class="card-img-top" alt="...">
                                  <div class="card-body">
                                    <p class="card-text">Porte</p>
                                  </div>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card">
                                  <img src="images/porte.png" class="card-img-top" alt="...">
                                  <div class="card-body">
                                    <p class="card-text">Porte</p>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                    </div>
                </div> -->
        <div class="text-box" style="background-color: #437e80;">
          <h5 class="display-5" style="color: white;">Actualités</h5>
          <div class="inner-text">
            <div class="container">
              <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title"><b>Portes ouvertes</b></h5>
                    </div>
                    <img src="images/magasin.png" class="card-img-top" alt="...">
                    <div class="card-body">
                      <p class="card-text">
                        Venez visiter la boutique MyDoorCenter et profiter de
                        présentations de nos produits et savoir-faire par nos experts artisans.
                        Retrouvez-nous du 15 au 26 mai 2024 au <b>88 rue du Do d'or, 17880 Les Portes-en-Ré </b>.
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title"><b>Semaine Mystère de la porte</b></h5>
                    </div>
                    <img src="images/porteinterro.png" class="card-img-top" alt="...">
                    <div class="card-body">
                      <p class="card-text">
                        Découvrez le frisson de l'inattendu avec notre <b>Semaine Mystère de la Porte</b> du 20 au 27
                        avril 2024 !
                        Chaque jour, une porte sélectionnée au hasard bénéficie d'une réduction surprise.
                      </p>
                    </div>
                  </div>
                </div>


                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title"><b>Portes fermées</b></h5>
                    </div>
                    <img src="images/porte.png" class="card-img-top" alt="...">
                    <div class="card-body">
                      <p class="card-text">
                        Tous les week-ends et la semaine de 18h à 8h,
                        venez contempler notre <b>devanture </b>!
                      </p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="footer">
    <span>&copy; 2024 MyDoorCenter</span>
  </footer>

  <!-- Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Main js -->
  <script src="js/sidebar.js"></script>
  <script src="js/reduce-header.js"></script>
</body>

</html>