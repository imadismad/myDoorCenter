<?php

// Inclure le fichier contenant les fonctions SQL
require_once 'functionsSQL.php';

function quantitePortesEnStockParEntrepot($referenceProduit) {
    // Informations de connexion à la base de données
    $serveur = SQL_SERVER;
    $utilisateur = SQL_USER;
    $motdepasse = SQL_PASSWORD;
    $basededonnees = SQL_BDD_NAME;

    // Connexion à la base de données
    $connexion = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);

    // Vérifier la connexion
    if ($connexion->connect_error) {
        die("Erreur de connexion : " . $connexion->connect_error);
    }

    // Préparation de la requête de sélection
    $requete = $connexion->prepare("SELECT idEntrepot, COUNT(*) AS quantite FROM Porte WHERE idProduit = ? GROUP BY idEntrepot");

    // Liaison des valeurs des paramètres
    $requete->bind_param("s", $referenceProduit);

    // Exécution de la requête
    $requete->execute();

    // Récupération des résultats
    $resultat = $requete->get_result();

    // Affichage des quantités de portes par entrepôt
    if ($resultat->num_rows === 0) {
        echo "La référence n'est pas en stock.";
        return false;
    } else {
        // Affichage des quantités de portes par entrepôt
        while ($row = $resultat->fetch_assoc()) {
            $idEntrepot = $row["idEntrepot"];
            $quantite = $row["quantite"];
            echo "Entrepôt ID: $idEntrepot, Quantité: $quantite\n";
        }
    }

    // Fermeture de la connexion
    $requete->close();
    $connexion->close();
    return true;
}

function creerCommande($idClient, $modePaiement, $produitsQuantites) {
    // Informations de connexion à la base de données
    $serveur = SQL_SERVER;
    $utilisateur = SQL_USER;
    $motdepasse = SQL_PASSWORD;
    $basededonnees = SQL_BDD_NAME;

    // Connexion à la base de données
    $connexion = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);

    // Vérifier la connexion
    if ($connexion->connect_error) {
        die("Erreur de connexion : " . $connexion->connect_error);
    }

    // Début de la transaction
    $connexion->begin_transaction();

    try {
        // Insérer la commande
        $date = date("Y-m-d");
        $requeteCommande = $connexion->prepare("INSERT INTO Commande (date, modePaiement, idClient) VALUES (?, ?, ?)");
        $requeteCommande->bind_param("sss", $date, $modePaiement, $idClient);
        $requeteCommande->execute();
        $idCommande = $requeteCommande->insert_id; // Récupérer l'ID de la commande insérée
        $requeteCommande->close();

        // Pour chaque produit et quantité dans la commande
        foreach ($produitsQuantites as $idProduit => $quantite) {
            // Vérifier si le produit est en stock
            if (quantitePortesEnStockParEntrepot($idProduit) < $quantite) {
                throw new Exception("Le produit avec l'ID $idProduit n'est pas en stock en quantité suffisante.");
            }

            // Insérer les entrées dans la table Concerner
            $requeteConcerner = $connexion->prepare("INSERT INTO Concerner (id, idProduit, idCommande, quantite) VALUES (DEFAULT, ?, ?, ?)");
            $requeteConcerner->bind_param("iii", $idProduit, $idCommande, $quantite);
            $requeteConcerner->execute();
            $requeteConcerner->close();

            // Récupérer l'ID de l'entrepôt correspondant à la porte retirée
            $requeteEntrepot = $connexion->prepare("SELECT idEntrepot FROM Porte WHERE idProduit = ?");
            $requeteEntrepot->bind_param("i", $idProduit);
            $requeteEntrepot->execute();
            $resultatEntrepot = $requeteEntrepot->get_result();
            $rowEntrepot = $resultatEntrepot->fetch_assoc();
            $idEntrepot = $rowEntrepot['idEntrepot'];
            $requeteEntrepot->close();

            // Mettre à jour le stock actuel dans la table Entrepot
            $requeteStock = $connexion->prepare("UPDATE Entrepot SET stockActuel = stockActuel - ? WHERE id = ?");
            $requeteStock->bind_param("ii", $quantite, $idEntrepot);
            $requeteStock->execute();
            $requeteStock->close();

            // Supprimer la porte en stock dans la table Porte
            $requeteSuppression = $connexion->prepare("UPDATE Porte SET idEntrepot = 1000 WHERE idEntrepot = ? LIMIT 1");
            $requeteSuppression->bind_param("i", $idEntrepot);
            $requeteSuppression->execute();
            $requeteSuppression->close();

            // Créer une livraison par porte pour chaque produit
            $requeteLivraison = $connexion->prepare("INSERT INTO Livraison (arriveeEstimee, distance, nbPointsArrets, idCommande, idClient, idPorte) SELECT ?, ?, ?, ?, ?, p.id FROM Porte p WHERE p.idProduit = ?");
            $arriveeEstimee = date("Y-m-d H:i:s", strtotime("+1 week")); // Exemple de date d'arrivée estimée
            $distance = 100.0; // Exemple de distance
            $nbPointsArrets = 0; // Exemple de nombre de points d'arrêt
            $requeteLivraison->bind_param("siiiii", $arriveeEstimee, $distance, $nbPointsArrets, $idCommande, $idClient, $idProduit);
            $requeteLivraison->execute();
            $requeteLivraison->close();
        }

        // Valider la transaction
        $connexion->commit();

        echo "La commande a été créée avec succès.";
    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $connexion->rollback();
        echo "Erreur lors de la création de la commande : " . $e->getMessage();
    }

    // Fermeture de la connexion
    $connexion->close();
}

/**
 * Return the data of a product in a DB
 * Here are the fild : id, nom, type, prixUnitaire, lienPage, description and nomImage
 */
function getBasicProductData(int $id){
    // Check if id is a int
    if(!is_int($id)) throw new InvalidArgumentException("\$id need to be an integer");

    $result = recupererDonneesParValeur("Produit", "id", $id);
    return $result[0];
}

/**
 * Return all materials data composing a given product
 * Here are the field : id, nom, densite, masseVolumique
 */
function getMaterialsByProduct(int $id) {
    // Check if id is a int
    if(!is_int($id)) throw new InvalidArgumentException("\$id need to be an integer");

    // Informations de connexion à la base de données
    $serveur = SQL_SERVER;
    $utilisateur = SQL_USER;
    $motdepasse = SQL_PASSWORD;
    $basededonnees = SQL_BDD_NAME;

    // Connexion à la base de données
    $connexion = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);

    // Vérifier la connexion
    if ($connexion->connect_error) {
        die("Erreur de connexion : " . $connexion->connect_error);
    }

    // Début de la transaction
    $connexion->begin_transaction();
    try {
        $requete = $connexion->prepare(
            "SELECT m.* FROM Materiau m
             INNER JOIN Composer c ON m.id = c.idMateriau
             WHERE c.idProduit = ?"
        );

        $requete -> bind_param("i", $id);
        $requete -> execute();

        $resultat = $requete->get_result();
        $donnees = array();
        while ($row = $resultat->fetch_assoc()) {
            // Ajouter les données de chaque ligne au tableau
            $donnees[] = $row;
        }

        $requete->close();
        $connexion->close();
        return $donnees;

    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $connexion->rollback();
        echo "Erreur lors de la création de la commande : " . $e->getMessage();
    }

}

function removeProductFromCatalogue(int $id) {
    modifierDonnees("Produit", "estAuCatalogue", 0, "id", $id);
}

?>