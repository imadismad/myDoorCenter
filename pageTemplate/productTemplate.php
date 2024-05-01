<?php
require_once __DIR__."/../php/Product.php";
if (session_status() === PHP_SESSION_NONE) session_start();

$research = $_GET["research"];

$products = Product::searchProduct($research);


foreach ($products as $produit => $value) {
    $article = "";

    

    $article.= '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">';
        $article.= '<a href="'.BASE_DIR_STATIC.'product.php?id='.$value -> getId().'" style="text-decoration: none;">';
            $article.= '<div class="card">';
                $article.= '<div class="card-body">';
                    $article.= '<h5 class="card-title"><b>'.$value -> getName().'</b></h5>';
                $article.= '</div>';
                $article.= '<div class="container" style="height: 200px;">';
                    $article.= '<img src="'.BASE_DIR_STATIC.'images/miniature/'.$value -> getImageName().'" class="card-img-top" alt="'.$value -> getImageName().'" style="object-fit: contain;">';
                $article.= '</div>';
                $article.= '<div class="card-body">';
                    $article.= '<p class="card-text">';
                        $article.= '<h3>'.$value -> getUnitaryPrice().' €</h3>';
                        $article.= mb_substr($value -> getDescription(), 0, 60).'...';
                    $article.= '</p>';
                $article.= '</div>';
            $article.= '</div>';
        $article.= '</a>';
    $article.= '</div>';


    echo $article;

}
?>