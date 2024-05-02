<?php
require_once __DIR__."/../BDD/config.php";
require_once __DIR__."/../BDD/functionsSQL.php";

/**
 * Vérifie si un utilisateur existe et si sont mot de passe est correct.
 * @param string $mail le mail de l'utilisateur
 * @param string $motdepasse le motdepasse de l'utilisateur
 * @return false|array false si l'utilisateur/mot de passe n'existe pas, les informations de l'utilsateur sinon
 */
function connexionUtilisateur(string $mail, string $motdepasse) {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $resultat = recupererDonneesParValeur("Client", "mail", $mail);
    $trouve = false;

    foreach ($resultat as $row) {
        if ($mail == $row["mail"] && password_verify($motdepasse, $row["mdp"])) {
            $trouve = $row;
        }
    }
    return $trouve;
}