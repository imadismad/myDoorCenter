<!DOCTYPE html>
<html>
<head>
    <title>Interactive PHP and HTML</title>
</head>
<body>
    <h1>Interactive PHP and HTML : Théo tu ne sers a rien :) ❤️ </h1>
    
    <?php
    // Check if the form is submitted
    session_start();

    $cookie_name = "prenom";
    // echo $_COOKIE[$cookie_name], $_SESSION['tel'];
    setcookie($cookie_name, $_SESSION[$cookie_name], time() + 60*60*24,"/"); 
    if (isset($_COOKIE[$cookie_name])) {
        // Generate a personalized greeting
        $greeting = "Hello, " . $_COOKIE[$cookie_name] . "!";
        echo "<p>" . $greeting . "</p>";
    }
    else {
        header("Location: connexion.html");
    }
    ?>
    
    <form method="POST">
        <label for="name">Enter your name:</label>
        <input type="text" id="name" name="name" required>
        <input type="submit" value="Submit">
        <a href="BDD/deconnexion.php">Se déconnecter</a>
    </form>
</body>
</html>
