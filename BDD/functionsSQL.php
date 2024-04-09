<?php
include("config.php");

function insererDonnees($table, $donnees) {
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
    $types = str_repeat("s", count($donnees)); // Assumer que toutes les valeurs sont de type string
    $valeurs = array_values($donnees);
    $requete->bind_param($types, ...$valeurs);

    // Exécution de la requête
    if ($requete->execute() === TRUE) {
        echo "\nDonnées insérées avec succès\n";
    } else {
        echo "Erreur lors de l'insertion des données : " . $requete->error;
    }

    // Fermeture de la connexion
    $requete->close();
    $connexion->close();
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

    // Préparation de la requête de suppression
    $requete = $connexion->prepare("DELETE FROM $table WHERE $champReference = ?");

    // Liaison des valeurs des paramètres
    $requete->bind_param("s", $valeurReference);

    // Exécution de la requête
    if ($requete->execute() === TRUE) {
        echo "\nLigne supprimée avec succès.\n";
    } else {
        echo "Erreur lors de la suppression de la ligne : " . $requete->error;
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

    // Préparation de la requête de modification
    $requete = $connexion->prepare("UPDATE $table SET $champModification = ? WHERE $champReference = ?");

    // Liaison des valeurs des paramètres
    $requete->bind_param("ss", $nouvelleValeur, $valeurReference);

    // Exécution de la requête
    if ($requete->execute() === TRUE) {
        echo "\nDonnées modifiées avec succès\n";
    } else {
        echo "Erreur lors de la modification des données : " . $requete->error;
    }

    // Fermeture de la connexion
    $requete->close();
    $connexion->close();
}
