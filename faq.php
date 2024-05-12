<?php 
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
?>

<!-- Head with automatic css imports -->
<?php include BASE_DIR.'pageTemplate/head.php'; ?>


    <body>

    <!-- Header import -->
    <?php include BASE_DIR.'pageTemplate/header.php'; ?>

    <!-- Sidebar import -->
    <?php include BASE_DIR.'pageTemplate/sidebar.php'; ?>


    <main class="container-fluid pt-header-xs pt-header-sm pt-header-md pt-header-lg pt-header-xl">
        <!-- CONTENT HERE -->
        <h1 class="welcome-title border rounded display-1"><b>Foire aux questions</b></h1>
        <div class="container mt-5">
        
        <hr>
        <div class="accordion" id="faqAccordion">

            <!-- Question 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Qu'est-ce que mydoorcenter et quels services fournissez-vous ?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        mydoorcenter est un magasin en ligne spécialisé dans la vente de portes de haute qualité pour divers besoins. Nous proposons une large gamme de portes intérieures et extérieures, y compris des designs sur mesure.
                    </div>
                </div>
            </div>

            <!-- Question 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Comment puis-je passer une commande ?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Vous pouvez passer une commande directement sur notre site Web. Parcourez notre sélection, ajoutez des articles à votre panier, et finalisez la commande. Si vous avez besoin d'aide, notre équipe du service client est disponible par téléphone ou par e-mail.
                    </div>
                </div>
            </div>

            <!-- Question 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Quels modes de paiement acceptez-vous ?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Nous acceptons les principales cartes de crédit, PayPal et les virements bancaires. Pour les commandes sur mesure, nous acceptons également les paiements par virement.
                    </div>
                </div>
            </div>

            <!-- Question 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Quels sont les délais de livraison ?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Les délais de livraison dépendent du type de porte commandée. Les portes standard sont généralement livrées en 5 à 7 jours ouvrables. Les portes sur mesure peuvent nécessiter plus de temps en fonction de leur complexité. Vous recevrez un e-mail de confirmation avec une estimation de la date de livraison.
                    </div>
                </div>
            </div>

            <!-- Question 5 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        Proposez-vous des services d'installation ?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Oui, nous offrons des services d'installation dans certaines zones géographiques. Veuillez nous contacter avec vos informations pour voir si nous desservons votre région. Si ce n'est pas le cas, nous pouvons vous recommander des professionnels qualifiés près de chez vous.
                    </div>
                </div>
            </div>

            <!-- Question 6 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        Offrez-vous une garantie sur vos produits ?
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Oui, toutes nos portes sont couvertes par une garantie standard d'un an. Certaines portes bénéficient d'une garantie prolongée en fonction de leur matériau et de leur fabrication. Consultez les détails de chaque produit ou contactez-nous pour obtenir des informations spécifiques sur la garantie.
                    </div>
                </div>
            </div>

            <!-- Question 7 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSeven">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        Puis-je retourner ou échanger une porte si elle ne me convient pas ?
                    </button>
                </h2>
                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Vous pouvez retourner ou échanger une porte dans les 30 jours suivant la livraison, tant qu'elle n'a pas été installée et qu'elle est en parfait état. Veuillez consulter notre politique de retour pour plus de détails et contacter notre service client pour entamer la procédure.
                    </div>
                </div>
            </div>

            <!-- Question 8 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEight">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        Comment puis-je obtenir un devis pour une porte sur mesure ?
                    </button>
                </h2>
                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Pour obtenir un devis pour une porte sur mesure, vous pouvez remplir notre formulaire en ligne en fournissant les dimensions, le style et les matériaux souhaités. Vous pouvez également nous contacter directement par téléphone ou par e-mail, et l'un de nos conseillers se fera un plaisir de vous aider.
                    </div>
                </div>
            </div>

            <!-- Question 9 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingNine">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                        Comment puis-je suivre ma commande ?
                    </button>
                </h2>
                <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Une fois votre commande passée, vous recevrez un e-mail contenant un lien pour suivre votre colis. Vous pourrez voir son statut en temps réel. Si vous avez des questions, n'hésitez pas à contacter notre service client.
                    </div>
                </div>
            </div>

            <!-- Question 10 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                        Proposez-vous des conseils pour choisir la bonne porte ?
                    </button>
                </h2>
                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Oui, notre équipe d'experts est disponible pour vous aider à choisir la porte idéale en fonction de vos besoins et de votre budget. Vous pouvez également consulter notre blog ou nos guides en ligne pour plus d'informations.
                    </div>
                </div>
            </div>

            <!-- Question 11 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEleven">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                        Avez-vous un showroom où je peux voir les portes en personne ?
                    </button>
                </h2>
                <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Oui, nous avons un showroom où vous pouvez voir notre sélection de portes en personne. Consultez notre page de contact pour l'adresse et les horaires d'ouverture, ou contactez-nous pour prendre un rendez-vous.
                    </div>
                </div>
            </div>

            <!-- Question 12 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwelve">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                        Puis-je demander un échantillon de matériau avant de commander ?
                    </button>
                </h2>
                <div id="collapseTwelve" class="accordion-collapse collapse" aria-labelledby="headingTwelve" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Oui, nous proposons des échantillons de matériaux afin que vous puissiez voir la qualité et la couleur de nos portes avant de passer commande. Contactez notre service client pour demander un échantillon.
                    </div>
                </div>
            </div>


        </div>
    </div>
    <br>
        <!-- END OF CONTENT -->
    </main>

    <!-- JS Import -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

    </body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>