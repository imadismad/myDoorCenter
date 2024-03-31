<?php
    session_start();
    if (!isset($_COOKIE["prenom"])){
    header("Location: creationCompte.html");
    }
    else{
        $cookie_name = "prenom";
        setcookie($cookie_name,$_SESSION["prenom"], time() + 60*60*24,"/");
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace client</title>
    <link href="css/index/style.css" rel="stylesheet">
</head>
<body>
    <?php echo "Voir ce qu'il faut mettre";?>
</body>
</html>