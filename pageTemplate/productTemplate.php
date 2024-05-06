<?php
require_once __DIR__."/../php/Product.php";
if (session_status() === PHP_SESSION_NONE) session_start();

function getProjectPath() {
    $path = strpos($lower = strtolower($scriptPath = $_SERVER['SCRIPT_NAME']), $projectFolder = 'mydoorcenter') !== false ?
            substr($scriptPath, 0, strpos($lower, $projectFolder) + strlen($projectFolder)) :
            '/';
    return rtrim($path, '/') . '/';
}

function getAbsoluteMyDoorCenterPath() {
    $path = __DIR__;
    foreach (['mydoorcenter', 'wwwroot'] as $folder) {
        if (($pos = strpos(strtolower($path), $folder)) !== false) return substr($path, 0, $pos + strlen($folder));
    }
    return $path;
}

define('BASE_DIR', getAbsoluteMyDoorCenterPath().'/');
define('BASE_DIR_STATIC', getProjectPath());

$research = isset($_GET["research"]) ? $_GET["research"] : 'porte';
$minPrice = isset($_POST['minPrice']) ? floatval($_POST['minPrice']) : 0.0;
$maxPrice = isset($_POST['maxPrice']) ? floatval($_POST['maxPrice']) : 5000.0;
// $research = "porte";
// $minPrice = 0;
// $maxPrice = 5000;

$products = Product::searchProduct($research, null, $minPrice, $maxPrice, false);
// $products = Product::searchProduct($research, null, floatval(0), floatval(300), floatval(0), false);
// ($search = null, $type = null, $tri = 'nom', $prixMin = null, $prixMax = null, $triNote = false)

if(empty($products)) {
    echo "<p>Aucun produit trouvé pour la recherche : " . htmlspecialchars($research) . "</p>";
} else {
    foreach ($products as $value) {
        echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">';
        echo '<a href="'.BASE_DIR_STATIC.'product.php?id='.$value->getId().'" style="text-decoration: none;">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title"><b>'.$value->getName().'</b></h5>';
        echo '</div>';
        echo '<div class="container" style="height: 200px;">';
        echo '<img src="'.BASE_DIR_STATIC.'img/miniature/'.$value->getImageName().'" class="card-img-top" alt="'.$value->getImageName().'" style="object-fit: contain;">';
        echo '</div>';
        echo '<div class="card-body">';
        echo '<p class="card-text"><h3>'.$value->getUnitaryPrice().' €</h3>';
        echo mb_substr($value->getDescription(), 0, 60).'...';
        echo '</p>';
        echo '</div>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
    }
}
?>
