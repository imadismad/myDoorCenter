<?php
// Inclure le fichier contenant les fonctions SQL
require_once 'functionsSQL.php';
require_once __DIR__."/../php/LocationSearch.php";

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
    $arrayResult = array();

    // Affichage des quantités de portes par entrepôt
    if ($resultat->num_rows === 0) {
        error_log("La référence n'est pas en stock.");
        return false;
    } else {
        // Affichage des quantités de portes par entrepôt
        while ($row = $resultat->fetch_assoc()) {
            $idEntrepot = $row["idEntrepot"];
            $quantite = $row["quantite"];
            array_push($arrayResult, array("idEntrepot" => $idEntrepot, "quantite" => $quantite));
        }
    }

    // Fermeture de la connexion
    $requete->close();
    $connexion->close();
    return $arrayResult;
}

/**
 * Créer une commande pour un client avec les produits et quantités spécifiés.
 * infoFacturation et infoLivraison sont des tableaux associatifs contenant les informations de facturation et de livraison.
 * nom       infoFacturation et infoLivraison
 * prenom    infoFacturation et infoLivraison
 * rue       infoFacturation et infoLivraison
 * CP        infoFacturation et infoLivraison
 * ville     infoFacturation et infoLivraison
 * pays      infoFacturation et infoLivraison
 * telephone infoFacturation
 */
function creerCommande($idClient, $modePaiement, $produitsQuantites, $infoFacturation, $infoLivraison, $livraisonCoord, $productOption=[]) {
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
        $requeteCommande = $connexion->prepare("
            INSERT INTO Commande (date, modePaiement, idClient,
            nom, prenom, rue, CP, ville, pays, telephone,
            nomLivraison, prenomLivraison, rueLivraison, CPLivraison, villeLivraison, paysLivraison)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
        ");
        $requeteCommande->bind_param("ssssssssssssssss",
            $date, $modePaiement, $idClient,
            $infoFacturation["nom"], $infoFacturation["prenom"], $infoFacturation["rue"], $infoFacturation["CP"], $infoFacturation["ville"], $infoFacturation["pays"], $infoFacturation["telephone"],
            $infoLivraison["nom"], $infoLivraison["prenom"], $infoLivraison["rue"], $infoLivraison["CP"], $infoLivraison["ville"], $infoLivraison["pays"]
        );
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

                // Récupération des coordonées de l'entrepot
                $requeteCoord = $connexion->prepare("SELECT latitude, longitude FROM Entrepot WHERE id = ?");
                $requeteCoord->bind_param("i", $idEntrepot);
                $requeteCoord->execute();
                $resultatCoord = $requeteCoord->get_result();
                $rowCoord = $resultatCoord->fetch_assoc();

                // Ajouter la porte a la commande
                $requeteConcerner = $connexion->prepare("INSERT INTO Concerner (idProduit, idCommande) VALUES (?, ?)");
                $requeteConcerner->bind_param("ii", $idProduit, $idCommande);
                $requeteConcerner->execute();
                $idConcerner = $requeteConcerner->insert_id;
                $requeteConcerner->close();

                //Ajouter les options du produit si existant
                if (isset($productOption[$idProduit]) && count($productOption[$idProduit]) > 0) {
                    foreach ($productOption[$idProduit] as $optionId) {
                        $requeteOption = $connexion->prepare("INSERT INTO AOption (idConcerner, idOption) VALUES (?, ?)");
                        $requeteOption->bind_param("ii", $idConcerner, $optionId);
                        $requeteOption->execute();
                        $requeteOption->close();
                    }
                }

                // Créer une livraison pour la porte
                $requeteLivraison = $connexion->prepare("INSERT INTO Livraison (arriveeEstimee, distance, nbPointsArrets, idCommande, idClient, idPorte) VALUES (?, ?, ?, ?, ?, ?)");
                $arriveeEstimee = date("Y-m-d H:i:s", strtotime("+1 week")); // Exemple de date d'arrivée estimée
                $distance = vincentyGreatCircleDistance($livraisonCoord["lat"], $livraisonCoord["lon"], $rowCoord["latitude"], $rowCoord["longitude"]); // Exemple de distance
                $nbPointsArrets = 0; // Exemple de nombre de points d'arrêt
                $requeteLivraison->bind_param("siiiii", $arriveeEstimee, $distance, $nbPointsArrets, $idCommande, $idClient, $idPorte);
                $requeteLivraison->execute();
                $requeteLivraison->close();
            }
        }

        // Valider la transaction
        $connexion->commit();

    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $connexion->rollback();
        error_log("Erreur lors de la création de la commande : " . $e->getMessage());
        error_log(print_r($e, true));
    }

    // Fermeture de la connexion
    $connexion->close();
}


function rechercherProduits($search = null, $type = null, $prixMin = null, $prixMax = null, $triNote = false) {

/**
 * Recherche des produits dans la base de données en fonction des critères spécifiés.
 * 
 * ATTENTION : le tri par mots-clés est fait en dernier, ce qui implique que le tri
 * par note croissante ou décroissante est mélangée si une recherche par mots-clés
 * est faite en plus.
 *
 * @param string|null $search   La chaîne de recherche pour filtrer les résultats par pertinence.
 * @param string|null $type     Le type de produit à rechercher.
 * @param float|null  $prixMin  Le prix minimum des produits à rechercher.
 * @param float|null  $prixMax  Le prix maximum des produits à rechercher.
 * @param int|bool    $triNote  Le mode de tri des résultats par note moyenne (0 pour décroissant, 6 pour croissant, false pour ne pas trier par note, et entre 1 et 5 pour la moyenne correspondante).
 *
 * @return array              Un tableau associatif contenant les produits correspondant aux critères de recherche, triés par pertinence.
 */

    
    // Informations de connexion à la base de données
    $serveur = SQL_SERVER;
    $utilisateur = SQL_USER;
    $motdepasse = SQL_PASSWORD;
    $basededonnees = SQL_BDD_NAME;

    // Connexion à la base de données
    $connexion = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);

    if ($connexion->connect_error) {
        die("Erreur de connexion : " . $connexion->connect_error);
    }

    // Initialisation des variables
    $where = [];
    $bind_types = "";
    $bind_values = [];

    // Construction de la requête SQL
    $sql = "SELECT p.*, AVG(n.note) as noteMoyenne 
            FROM Produit p 
            LEFT JOIN Noter n ON p.id = n.idProduit";
    
    // Traitement du filtre par type
    if ($type !== null && !empty($type)) {
        $where[] = "p.type = ?";
        $bind_types .= "s";
        $bind_values[] = $type;
    }

    // Traitement de la fourchette de prix
    if ($prixMin !== null && is_numeric($prixMin)) {
        $where[] = "p.prixUnitaire >= ?";
        $bind_types .= "d";
        $bind_values[] = $prixMin;
    }

    if ($prixMax !== null && is_numeric($prixMax)) {
        $where[] = "p.prixUnitaire <= ?";
        $bind_types .= "d";
        $bind_values[] = $prixMax;
    }

    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    // Traitement du tri par la note
    if ($triNote !== false && is_numeric($triNote)) {
        if ($triNote == 0) {
            $sql .= " GROUP BY p.id ORDER BY noteMoyenne DESC";
        } elseif ($triNote == 6) {
            $sql .= " GROUP BY p.id ORDER BY noteMoyenne ASC";
        } else {
            $sql .= " GROUP BY p.id HAVING noteMoyenne >= ? AND noteMoyenne < ?";
            $bind_types .= "dd";
            $bind_values[] = $triNote;
            $bind_values[] = $triNote + 1;
        }
    } else {
        $sql .= " GROUP BY p.id ORDER BY p.nom";
    }

    // Exécution de la requête pour récupérer tous les produits
    $requete = $connexion->prepare($sql);
    if (!empty($bind_values)) {
        $requete->bind_param($bind_types, ...$bind_values);
    }
    $requete->execute();
    $resultat = $requete->get_result();

    if($search==null){
        // Fermeture de la connexion
        $requete->close();
        $connexion->close();
        return $resultat;
    }

    // Création du tableau associatif pour les résultats
    $resultats = [];
    while ($row = $resultat->fetch_assoc()) {
        // Calcul de la pertinence avec la distance de Levenshtein

        $pertinenceTitre = 0;
        foreach (explode(" ",$row["nom"]) as $word) {
            $pertinenceInter = 10 - damerauLevenshteinDistance($word,$search);
            $pertinenceTitre += $pertinenceInter < 0 ? 0 : $pertinenceInter;
        }

        $pertinenceDescription = 0;
        foreach (explode(" ",$row["description"]) as $word) {
            $pertinenceInter = 10 - damerauLevenshteinDistance($word,$search);
            $pertinenceDescription += $pertinenceInter < 0 ? 0 : $pertinenceInter;
        }

        $totalPertinence = $pertinenceTitre * 5 + $pertinenceDescription;

        // Filtrage des résultats ayant une pertinence suffisante
        if ($totalPertinence > 0) {
            $row['pertinenceTitre'] = $pertinenceTitre;
            $row['pertinenceDescription'] = $pertinenceDescription;
            $row['totalPertinence'] = $totalPertinence;
            $resultats[] = $row;
            // echo "ID : ".$row['id']." Pertinence : ".$totalPertinence."\n";
        }
    }

    // Tri des résultats par pertinence
    usort($resultats, function($a, $b) {
        return $b['totalPertinence'] <=> $a['totalPertinence'];
    });

    // Fermeture de la connexion
    $requete->close();
    $connexion->close();

    return $resultats;
}





//----------------------Utilitaire---------------------//

function damerauLevenshteinDistance($str1, $str2) {
    $lenStr1 = mb_strlen($str1);
    $lenStr2 = mb_strlen($str2);

    // Initialisation de la matrice
    $d = [];
    for ($i = 0; $i <= $lenStr1; $i++) {
        $d[$i] = [];
        $d[$i][0] = $i;
    }
    for ($j = 0; $j <= $lenStr2; $j++) {
        $d[0][$j] = $j;
    }

    // Calcul de la distance de Damerau-Levenshtein
    for ($i = 1; $i <= $lenStr1; $i++) {
        for ($j = 1; $j <= $lenStr2; $j++) {
            $cost = ($str1[$i - 1] !== $str2[$j - 1]) ? 1 : 0;
            $d[$i][$j] = min(
                $d[$i - 1][$j] + 1,     // Suppression
                $d[$i][$j - 1] + 1,     // Insertion
                $d[$i - 1][$j - 1] + $cost  // Substitution
            );
            if ($i > 1 && $j > 1 && $str1[$i - 1] === $str2[$j - 2] && $str1[$i - 2] === $str2[$j - 1]) {
                $d[$i][$j] = min($d[$i][$j], $d[$i - 2][$j - 2] + $cost); // Transposition
            }
        }
    }

    return $d[$lenStr1][$lenStr2];
}



?>