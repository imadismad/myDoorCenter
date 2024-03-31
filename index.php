<?php
session_start();
$cookie_name = "prenom";
setcookie($cookie_name, $_SESSION[$cookie_name], time() + 60 * 60 * 24, "/");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Interactive PHP and HTML</title>
</head>

<body>
    <h1>Interactive PHP and HTML : Théo tu ne sers a rien :) ❤️ </h1>
    <p>
        <?php
            if (isset($_COOKIE[$cookie_name])) {
                // Generate a personalized greeting
                $name = $_COOKIE[$cookie_name];
                $greeting = "Hello, " . $name . "!";
                echo $greeting;
            }
        ?>
    </p>



    <form method="POST">
        <label for="name">Enter your name:</label>
        <input type="text" id="name" name="name" required>
        <input type="submit" value="Submit">
    </form>
    <a href="BDD/deconnexion.php"><button type="submit" name="submit" value="deconnexion">Déconnexion</button></a>
    <a href="index.html">Aller à la page d'acceuil</a>
</body>

</html>