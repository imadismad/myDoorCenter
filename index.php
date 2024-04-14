<!DOCTYPE html>
<html lang="fr">

<!-- Head with automatic css imports -->
<?php include 'pageTemplate/head.php'; ?>


<body>

  <!-- Header import -->
  <?php include 'pageTemplate/header.php'; ?>

  <!-- Sidebar import -->
  <?php include 'pageTemplate/sidebar.php'; ?>


  <main class="container-fluid">
     <!-- CONTENT HERE -->
    <div class="row">      

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
    <!-- END OF CONTENT -->
  </main>

  <!-- JS Import -->
  <?php include 'pageTemplate/jsImport.php'; ?>

</body>

</html>