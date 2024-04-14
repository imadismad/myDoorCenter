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
    $requete = $connexion->prepare("SELECT idEntrepot, COUNT(*) AS quantite FROM Porte WHERE idProduit = ? AND idEntrepot <> 1000 GROUP BY idEntrepot");

    // Liaison des valeurs des paramètres
    $requete->bind_param("s", $referenceProduit);

    // Exécution de la requête
    $requete->execute();

    // Récupération des résultats
    $resultat = $requete->get_result();

    // Affichage des quantités de portes par entrepôt
    if ($resultat->num_rows === 0) {
        fwrite(STDERR, "La référence n'est pas en stock.");
        return false;
    } else {
        // Affichage des quantités de portes par entrepôt
        while ($row = $resultat->fetch_assoc()) {
            $idEntrepot = $row["idEntrepot"];
            $quantite = $row["quantite"];
            fwrite(STDOUT, "Entrepôt ID: $idEntrepot, Quantité: $quantite\n");
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

    // Vérifier le stock pour tous les produits d'abord
    foreach ($produitsQuantites as $idProduit => $quantite) {
        if (quantitePortesEnStockParEntrepot($idProduit) < $quantite) {
            $connexion->close();
            die("Le produit avec l'ID $idProduit n'est pas en stock en quantité suffisante.");
        }
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
            for ($i = 0; $i < $quantite; $i++) {
                // Récupérer l'ID de l'entrepôt correspondant à la porte retirée
                $requeteEntrepot = $connexion->prepare("SELECT id, idEntrepot FROM Porte WHERE idProduit = ? AND idEntrepot <> 1000 LIMIT 1");
                $requeteEntrepot->bind_param("i", $idProduit);
                $requeteEntrepot->execute();
                $resultatEntrepot = $requeteEntrepot->get_result();
                $rowEntrepot = $resultatEntrepot->fetch_assoc();

                if (isset($rowEntrepot['idEntrepot'])) {
                    $idEntrepot = $rowEntrepot['idEntrepot'];
                } else {
                    throw new Exception("L'entrepôt n'a pas été trouvé pour le produit avec l'ID $idProduit.");
                }

                $idPorte = $rowEntrepot['id'];
                $idEntrepot = $rowEntrepot['idEntrepot'];
                $requeteEntrepot->close();

                // Mettre à jour le stock actuel dans la table Entrepot
                $requeteStock = $connexion->prepare("UPDATE Entrepot SET stockActuel = stockActuel - 1 WHERE id = ?");
                $requeteStock->bind_param("i", $idEntrepot);
                $requeteStock->execute();
                $requeteStock->close();

                // Déplacer la porte vers l'entrepôt 1000
                $requeteDeplacement = $connexion->prepare("UPDATE Porte SET idEntrepot = 1000 WHERE id = ?");
                $requeteDeplacement->bind_param("i", $idPorte);
                $requeteDeplacement->execute();
                $requeteDeplacement->close();

                // Créer une livraison pour la porte
                $requeteLivraison = $connexion->prepare("INSERT INTO Livraison (arriveeEstimee, distance, nbPointsArrets, idCommande, idClient, idPorte) VALUES (?, ?, ?, ?, ?, ?)");
                $arriveeEstimee = date("Y-m-d H:i:s", strtotime("+1 week")); // Exemple de date d'arrivée estimée
                $distance = 100.0; // Exemple de distance
                $nbPointsArrets = 0; // Exemple de nombre de points d'arrêt
                $requeteLivraison->bind_param("siiiii", $arriveeEstimee, $distance, $nbPointsArrets, $idCommande, $idClient, $idPorte);
                $requeteLivraison->execute();
                $requeteLivraison->close();
            }
        }

        // Valider la transaction
        $connexion->commit();

        fwrite(STDOUT, "La commande a été créée avec succès.");
    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $connexion->rollback();
        fwrite(STDERR, "Erreur lors de la création de la commande : " . $e->getMessage());
    }

    // Fermeture de la connexion
    $connexion->close();
}


