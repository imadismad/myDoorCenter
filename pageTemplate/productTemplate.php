<?php
require_once __DIR__."/../php/Product.php";
if (session_status() === PHP_SESSION_NONE) session_start();
$products = Product::searchProduct();

?>