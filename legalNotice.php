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
        <div style="margin: 1%">
            <h2>Éditeur du site</h2>
            Le site web MyDoorCenter est un projet fictif développé à des fins éducatives par les étudiants de CY-Tech. Ce site n'est pas un commerce réel et n'a pas pour but de conclure des ventes réelles avec des utilisateurs.
            <br>
            Adresse : CY-Tech, Av. du Parc, 95000 Cergy, France
            <br>

            <h2>Hébergement</h2>
            Le site MyDoorCenter est hébergé par Microsoft Azure, dont le siège social est situé à 37/45 37 QUAI DU PRESIDENT ROOSEVELT 92130 ISSY-LES-MOULINEAUX.

            <h2>Propriété intellectuelle</h2>
            Tout le contenu présenté sur MyDoorCenter, incluant, sans limitation, les graphismes, images, textes, vidéos, animations, sons, logos, gifs et icônes ainsi que leur mise en forme sont la propriété exclusive de l'équipe du projet à l'exception des marques, logos ou contenus appartenant à d'autres sociétés partenaires ou auteurs.
            <br>
            Toute reproduction, distribution, modification, adaptation, retransmission ou publication, même partielle, de ces différents éléments est strictement interdite sans l'accord exprès par écrit de CY-Tech. Cette représentation ou reproduction, par quelque procédé que ce soit, constitue une contrefaçon sanctionnée par les articles L.335-2 et suivants du Code de la propriété intellectuelle.
            <br>
            <h2>Limitation de responsabilité</h2>
            MyDoorCenter est un projet fictif ; les produits et services présentés ne peuvent être l'objet d'aucune commande ou transaction commerciale réelle. Les informations contenues sur ce site sont aussi précises que possible, et le site est périodiquement mis à jour, mais peut toutefois contenir des inexactitudes, des omissions ou des lacunes.
            <br>
            Les étudiants de CY-Tech ne pourront être tenus responsables pour toute omission, inexactitude ou carence dans la mise à jour des informations ou pour tout dommage résultant d'une intrusion frauduleuse d'un tiers ayant entraîné une modification des informations mises à disposition sur le site.
            <br>
            <h2>Gestion des données personnelles</h2>
            Dans le cadre de ce projet fictif, MyDoorCenter ne recueille aucune donnée personnelle concernant ses utilisateurs (pas de collecte de noms, adresses, numéros de téléphone, adresses e-mail, etc.).

            <h2>Contact</h2>
            Pour toute question ou demande concernant le projet fictif MyDoorCenter, veuillez contacter admin@mydoorcenter.com.
        </div>
        <!-- END OF CONTENT -->
    </main>

    <!-- JS Import -->
    <?php include BASE_DIR.'pageTemplate/jsImport.php'; ?>

    </body>

<?php include BASE_DIR.'pageTemplate/footer.php'; ?>