<!DOCTYPE html>
<html>
<head>
    <title>Interactive PHP and HTML</title>
</head>
<body>
    <h1>Interactive PHP and HTML</h1>
    
    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        // Generate a personalized greeting
        $greeting = "Hello, " . $name . "!";
        echo "<p>" . $greeting . "</p>";
    }
    ?>
    
    <form method="POST">
        <label for="name">Enter your name:</label>
        <input type="text" id="name" name="name" required>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
