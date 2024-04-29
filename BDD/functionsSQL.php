<?php
include_once "../php/checkDefine.php";
include_once "config.php";

function connexionBDD(): mysqli {
    // Informations de connexion Azure SQL Server
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

    return $connexion;
}

/**
 * Fonction qui transforme le résultata d'une requête DEJA EXECUTE en tableau associatif
 * Les clefs sont les champs défini dans la requête, ou à défaut ceux de les champs de la table
 * @param mysqli_stmt $sqliRequest La reqête DEJA EXECUTE
 * @return array Le tableau associatif représentant la réponse
 */
function reponseVersArray(mysqli_stmt|bool $sqliRequest): array {
    $resultat = $sqliRequest->get_result();
    $donnees = array();

    if ($resultat === false) {
        throw new Exception("Erreur de requête : ".$sqliRequest->error);
    }

    while ($row = $resultat->fetch_assoc()) {
        // Ajouter les données de chaque ligne au tableau
        $donnees[] = $row;
    }

    return $donnees;
}

function insererDonnees($table, $donnees, bool $recupererId=false) {
    // Informations de connexion Azure SQL Server
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

    // Préparation de la requête d'insertion
    $champs = implode(", ", array_keys($donnees));
    $valeurs = array_fill(0, count($donnees), "?");
    $valeurs = implode(", ", $valeurs);
    $requete = $connexion->prepare("INSERT INTO $table ($champs) VALUES ($valeurs)");

    // Liaison des valeurs des paramètres
    $types = recupType(array_values($donnees)); // Fonction pour récupèrer chaque type dans un tableau

    $valeurs = array_values($donnees);
    $requete->bind_param($types, ...$valeurs);

    // Exécution de la requête
    if ($requete->execute() === TRUE) {
        fwrite(STDOUT, "\nDonnées insérées avec succès\n");
    } else {
        fwrite(STDERR, "Erreur lors de l'insertion des données : " . $requete->error);
    }

    $newId = null;
    if ($recupererId) {
        $newId = $connexion->insert_id;
    }

    // Fermeture de la connexion
    $requete->close();
    $connexion->close();

    return $newId;
}

function supprimerLigne($table, $champReference, $valeurReference) {
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

    if (is_string($champReference)) {
        // Préparation de la requête de suppression
        $requete = $connexion->prepare("DELETE FROM $table WHERE $champReference = ?");

        // Liaison des valeurs des paramètres
        $requete->bind_param("s", $valeurReference);
    } else if (
        is_array($champReference) &&
        is_array($valeurReference) &&
        sizeof($champReference) === sizeof($valeurReference) &&
        sizeof($champReference) !== 0
    ) {
        $str = "DELETE FROM $table WHERE ".$champReference[0]." = ?";
        for ($i = 1; $i < sizeof($valeurReference); $i++) {
            $str .= " AND ".$champReference[$i]." = ?";
        }
        $str .= ";";

        $requete = $connexion->prepare($str);
        $requete->bind_param(recupType($valeurReference), ...$valeurReference);

    } else {
        throw new RuntimeException("Mauvais argument passé pour \$champReference et/ou \$valeurReference");
    }

    // Exécution de la requête
    if ($requete->execute() === TRUE) {
        fwrite(STDOUT, "\nLigne supprimée avec succès.\n");
    } else {
        fwrite(STDERR, "Erreur lors de la suppression de la ligne : " . $requete->error);
    }

    // Fermeture de la connexion
    $requete->close();
    $connexion->close();
}

function recupererDonneesParValeur($table, $champ, $valeur) {
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
    $requete = $connexion->prepare("SELECT * FROM $table WHERE $champ = ?");

    // Liaison des valeurs des paramètres
    $requete->bind_param("s", $valeur);

    // Exécution de la requête
    $requete->execute();

    // Récupération des résultats
    $resultat = $requete->get_result();

    // Création d'un tableau pour stocker les données récupérées
    $donnees = array();

    // Parcourir les lignes de résultats
    while ($row = $resultat->fetch_assoc()) {
        // Ajouter les données de chaque ligne au tableau
        $donnees[] = $row;
    }

    // Fermeture de la connexion
    $requete->close();
    $connexion->close();

    // Retourner les données récupérées
    return $donnees;
}

function modifierDonnees($table, $champModification, $nouvelleValeur, $champReference, $valeurReference) {
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

    // Une valeur passé en paramètre
    if (is_string($champModification )) {
        // Préparation de la requête de modification
        $requete = $connexion->prepare("UPDATE $table SET $champModification = ? WHERE $champReference = ?");
        // Liaison des valeurs des paramètres
        $requete->bind_param("ss", $nouvelleValeur, $valeurReference);
    } else if (is_array($champModification) && is_array($nouvelleValeur) && sizeof($champModification) === sizeof($nouvelleValeur)) {
        // On génère pour chaque champs la régle de mise a jour de valeur
        $paramValeurs = $champModification[0]." = ?";
        $type = recupType($nouvelleValeur[0]);
        for ($i = 1; $i < sizeof($champModification); $i++) {
            $paramValeurs .= ", ".$champModification[$i]." = ?";
            $type .= recupType($nouvelleValeur[$i]);
        }

        // Préparation de la requête de modification
        $requete = $connexion->prepare("UPDATE $table SET $paramValeurs WHERE $champReference = ?");
        // Liaison des valeurs des paramètres
        array_push($nouvelleValeur, $valeurReference);
        $requete->bind_param($type."s", ...$nouvelleValeur);
    } else {
        throw new Exception("Les paramètre de modification sont des tableaux de taille différente.");
    }

    // Exécution de la requête
    if ($requete->execute() === TRUE) {
        fwrite(STDOUT, "\nDonnées modifiées avec succès\n");
    } else {
        fwrite(STDOUT, "Erreur lors de la modification des données : " . $requete->error);
    }

    // Fermeture de la connexion
    $requete->close();
    $connexion->close();
}

function recupType(mixed $var): string {
    $base = "";

    if(is_array($var)) {
        if (sizeof($var) === 0) return $base;

        $base = recupType(array_slice($var, 1));
        $var = $var[0];
    }

    if (is_int($var)) return "i".$base;
    if (is_float($var)) return "d".$base;
    return "s".$base;
}