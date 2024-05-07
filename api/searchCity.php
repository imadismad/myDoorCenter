<?php
require_once "../php/LocationSearch.php";

if (!isset($_GET) || !isset($_GET["q"])) {
    http_response_code(400);
    exit();
}

header("Content-Type: application/json; charset=utf-8");
echo searchCity($_GET["q"]);
