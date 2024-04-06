<?php
session_start();
session_destroy();
$_SESSION = array();
$cookie_name = "prenom";
unset($_COOKIE[$cookie_name]);
setcookie($cookie_name, "", -1,"/"); 
header("Location: ../creationCompte.html");
?>