<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif</title>
</head>

<body>
    <h1>Récapitulatif</h1>
    <h2>Récapitulatif informations:</h2>
    <div class="recap">
        <div id="info_perso" class="perso">
            <ul>
                <li>Nom: <?php echo $_POST["nom"]; ?></li>
                <li>Prénom: <?php echo $_POST["prenom"]; ?></li>
                <li>Mail: <?php echo $_POST["mail"]; ?></li>
                <li>Date de naissance: <?php echo $_POST["naissance"]; ?></li>
                <li>Numéro de téléphone: <?php echo $_POST["tel"]; ?></li>
            </ul>
        </div>
        <div id="info_perso" class="livraison">
            <ul>
                <li>Ville: <?php echo $_POST["ville"]; ?></li>
                <li>Rue: <?php echo $_POST["rue"]; ?></li>
                <li>Code postal: <?php echo $_POST["postal"]; ?></li>
            </ul>
        </div>
        <?php
            if (isset($_POST["Confirmation"])){
                //header("Location: ../connexion.html");
                echo $_POST["nom"];
                exit;
            }
            elseif (isset($_POST["reedition"])){
                header("Location: ../creationCompte.html");
                exit;
            }
        ?>
        
        <a href="../connexion.html"><input type="submit" name="confirmation" id="confirmation" value="Confirmation"></a> 
        <form method="post">
            <!-- A confirmer pour la base donnée  et doit permettre la redirection vers connect -->
            <input type="submit" name="reedition" id="reedition" value="Réedition">
        </form>
    </div>
</body>

</html>