<?php
session_start();
session_destroy();
$_COOKIE = array();

header("Location: ../connexion.html");
?>