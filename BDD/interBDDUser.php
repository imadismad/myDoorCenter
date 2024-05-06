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

/**
 * Recupère l'historique de commande d'un utilisateur
 * @param int $id l'id de l'utilisateur
 * @return array les commandes de l'utilisateur
 */
function recupererHistoriqueCommande(int $id, int $idCommande=null): array {
    if ($idCommande !== null) {
        $historique = recupererDonneesParValeur("Commande", "id", $idCommande);
        if (count($historique) === 0)
            throw new Exception("La commande n'existe pas");
        if ($historique[0]["idClient"] !== $id)
            throw new Exception("Vous n'avez pas le droit de voir cette commande");
    } else {
        $historique = recupererDonneesParValeur("Commande", "idClient", $id);
    }
   
    $connexion = connexionBDD();
    if (!$connexion)
        throw new Exception("Impossible de se connecter à la base de donnée");

    foreach($historique as $index => $commande) {
        $requeteConcerner = $connexion->prepare(
            "SELECT c.* FROM  Concerner c
            WHERE c.idCommande = ?
            ;"
        );
        $requeteConcerner -> bind_param("i", $commande["id"]);
        $requeteConcerner -> execute();
        $reponseConcerner = reponseVersArray($requeteConcerner);

        $produits = [];
        foreach($reponseConcerner as $concerner) {
            $requeteOption = $connexion->prepare(
                "SELECT idOption FROM AOption
                WHERE idConcerner = ?
                ;"
            );
            $requeteOption -> bind_param("i", $concerner["id"]);
            $requeteOption -> execute();
            $reponseOption = reponseVersArray($requeteOption);
    
            $optionsId = [];
            foreach($reponseOption as $option) {
                array_push($optionsId, $option["idOption"]);
            }
    
            $produit = [];
            $produit["id"] = $concerner["idProduit"];
            $produit["quantite"] = $concerner["quantite"];
            $produit["optionsId"] = $optionsId;
    
            array_push($produits, $produit);
        }

        $historique[$index]["produits"] = $produits;
    }
    return $historique;
}