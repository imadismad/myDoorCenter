<?php
require_once "../php/UserUtils.php";
require_once "../php/Redirect.php";

function getProjectPath() {
    $path = strpos($lower = strtolower($scriptPath = $_SERVER['SCRIPT_NAME']), $projectFolder = 'mydoorcenter') !== false ?
            substr($scriptPath, 0, strpos($lower, $projectFolder) + strlen($projectFolder)) :
            '/';
    return rtrim($path, '/') . '/';
}
define('BASE_DIR_STATIC', getProjectPath());

if (!isset($_POST["mail"]) || !isset($_POST["password"])) {
    http_response_code(400);
    exit();
}

$isConnect = UserUtils::connect($_POST["mail"], $_POST["password"]);
$redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : BASE_DIR_STATIC;
if (!$isConnect) {
    saveRedirect(BASE_DIR_STATIC."connexion.php?error=true");
}

$_GET["redirect"] = BASE_DIR_STATIC."espaceClient.php";
goToRedirect();