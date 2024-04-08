<?php
session_start();
include_once ("../BDD/config.php");
require_once "../BDD/functionsSQL.php";
$adminPass = password_hash($_POST["adminPass"], PASSWORD_DEFAULT);
if ($_POST["admin"] == "admin" && password_verify(ADMINPASSW, $adminPass)) {
    $_SESSION["admin"] = "admin";
    header("Location: index.html");
} else {
    header("Location: ../admin.html");
}

?>