<?php
    session_start();
    include("config.php");
    include("functionsSQL.php");
    $idProd = $_POST["id"];
    echo "".$idProd."";
    removeProductFromCatalogue($idProd);
