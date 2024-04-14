<?php
    session_start();
    include("config.php");
    include("functionsSQL.php");
    require_once "interBDDProduit.php";
    
    $idProd = $_POST["id"];
    fwrite(STDOUT, "".$idProd."");
    removeProductFromCatalogue($idProd);
