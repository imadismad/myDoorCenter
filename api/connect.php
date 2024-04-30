<?php
ob_start();
?>
<?php
require_once "../php/UserUtils.php";
require_once "../php/Redirect.php";

if (!isset($_POST["mail"]) || !isset($_POST["password"])) {
    http_response_code(400);
    exit();
}

$isConnect = UserUtils::connect($_POST["mail"], $_POST["password"]);
$redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : "/";
if (!$isConnect) {
    saveRedirect("/connexion.php?error=true");
}
goToRedirect();
ob_end_flush();