<?php

require_once __DIR__."/../php/Product.php";
if (session_status() === PHP_SESSION_NONE) session_start();
$products = Product::searchProduct();


foreach ($products as $produit) {
    $article = "";

    

    $article.= '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">';
    $article.= '<a href="'.BASE_DIR_STATIC.'product.php?id='.$produit['id'].'">';
    $article.= '<div class="card">';
    $article.= '<div class="card-body">';
    $article.= '<h5 class="card-title"><b>'.$produit['nom'].'</b></h5>';
    $article.= '</div>';
    $article.= '<img src="'.BASE_DIR_STATIC.'images/miniature/'.$produit['nomImage'].'" class="card-img-top" alt="...">';
    $article.= '<div class="card-body">';
    $article.= '<p class="card-text">';
    $article.= 'Une belle porte';
    $article.= '</p>';
    $article.= '</div>';
    $article.= '</div>';
    $article.= '</a>';
    $article.= '</div>';

    


    echo $article;

}
?>