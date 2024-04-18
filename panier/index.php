<?php
require_once __DIR__."/../php/Cart.php";

define("PATH_BASE", "../");
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<?php include '../pageTemplate/head.php'; ?>
<body>
    <!-- Modal  creation-->
    <div class="modal fade" id="modale" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Supression article</h5>
                <button
                    type="button"
                    class="btn btn-danger close"
                    style="margin-left: auto;"
                    onclick="hideModal(false)"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment retirer cette article de votre panier ?.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="hideModal(false)">Non</a>
                <button type="button" class="btn btn-danger" onclick="hideModal(true)">Oui</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Header import -->
    <?php include '../pageTemplate/header.php'; ?>

    <!-- Sidebar import -->
    <?php include '../pageTemplate/sidebar.php'; ?>

    <main class="container-fluid pt-header-xs pt-header-sm pt-header-md pt-header-lg pt-header-xl">
        <h1>Panier</h1>
        <div id="templatePanier">
            <?php include "../pageTemplate/panierTemplate.php"?>
        </div>
        <label>Code promo : <input type="text" name="codePromo"></label><br />

        <a role="button" class="btn btn-primary" href="panier/commande.php">Commander</a>
    </main>

    <?php include '../pageTemplate/jsImport.php'; ?>
    <script src="/js/panier/index.js"></script>
</body>
<?php include '../pageTemplate/footer.php'; ?>