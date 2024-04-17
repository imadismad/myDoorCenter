<?php
require_once __DIR__."/../php/Cart.php";

define("PATH_BASE", "../");
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<?php include '../pageTemplate/head.php'; ?>
<body>
    <!-- Header import -->
    <?php include '../pageTemplate/header.php'; ?>

    <!-- Sidebar import -->
    <?php include '../pageTemplate/sidebar.php'; ?>

    <main class="container-fluid">
        <h1>Panier</h1>
        <div id="templatePanier">
            <?php include "../pageTemplate/panierTemplate.php"?>
        </div>
        <label>Code promo : <input type="text" name="codePromo"></label><br />

        <input type="submit" value="Commander">
    </main>

    <script src="/js/panier/index.js"></script>
    <?php include '../pageTemplate/jsImport.php'; ?>
</body>
<?php include '../pageTemplate/footer.php'; ?>