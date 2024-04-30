<?php
include_once "config.php";

function connexionBDD(): mysqli {
    // Establish database connection using configured settings
    $connexion = new mysqli(SQL_SERVER, SQL_USER, SQL_PASSWORD, SQL_BDD_NAME);
    if ($connexion->connect_error) {
        // Log error instead of displaying it
        error_log("Database connection error: " . $connexion->connect_error);
        return null; // Return null to indicate failure
    }
    return $connexion;
}

function reponseVersArray($result): array {
    // Convert query results to an associative array
    $donnees = [];
    while ($row = $result->fetch_assoc()) {
        $donnees[] = $row;
    }
    return $donnees;
}

function insererDonnees($table, $donnees, $recupererId = false) {
    $connexion = connexionBDD();
    if (!$connexion) return null; // Check connection

    $champs = implode(", ", array_keys($donnees));
    $placeholders = implode(", ", array_fill(0, count($donnees), "?"));
    $requete = $connexion->prepare("INSERT INTO $table ($champs) VALUES ($placeholders)");

    if (!$requete) {
        error_log("Prepare failed: " . $connexion->error);
        return null;
    }

    $types = recupType(array_values($donnees));
    $requete->bind_param($types, ...array_values($donnees));

    if ($requete->execute()) {
        $newId = $recupererId ? $connexion->insert_id : true;
    } else {
        error_log("Insert error: " . $requete->error);
        $newId = false;
    }

    $requete->close();
    $connexion->close();
    return $newId;
}

function supprimerLigne($table, $champReference, $valeurReference) {
    $connexion = connexionBDD();
    if (!$connexion) return false; // Check connection

    $requete = $connexion->prepare("DELETE FROM $table WHERE $champReference = ?");
    if (!$requete) {
        error_log("Prepare failed: " . $connexion->error);
        return false;
    }

    $requete->bind_param("s", $valeurReference);
    $success = $requete->execute();
    if (!$success) {
        error_log("Delete error: " . $requete->error);
    }

    $requete->close();
    $connexion->close();
    return $success;
}

function recupererDonneesParValeur($table, $champ, $valeur) {
    $connexion = connexionBDD();
    if (!$connexion) return []; // Check connection

    $requete = $connexion->prepare("SELECT * FROM $table WHERE $champ = ?");
    if (!$requete) {
        error_log("Prepare failed: " . $connexion->error);
        return [];
    }

    $requete->bind_param("s", $valeur);
    $requete->execute();
    $result = $requete->get_result();
    $donnees = reponseVersArray($result);

    $requete->close();
    $connexion->close();
    return $donnees;
}

function modifierDonnees($table, $champModification, $nouvelleValeur, $champReference, $valeurReference) {
    $connexion = connexionBDD();
    if (!$connexion) return false; // Check connection

    $requete = $connexion->prepare("UPDATE $table SET $champModification = ? WHERE $champReference = ?");
    if (!$requete) {
        error_log("Prepare failed: " . $connexion->error);
        return false;
    }

    $requete->bind_param("ss", $nouvelleValeur, $valeurReference);
    $success = $requete->execute();
    if (!$success) {
        error_log("Update error: " . $requete->error);
    }

    $requete->close();
    $connexion->close();
    return $success;
}

function recupType($donnees): string {
    $types = '';
    foreach ($donnees as $item) {
        if (is_int($item)) {
            $types .= 'i';
        } elseif (is_float($item)) {
            $types .= 'd';
        } elseif (is_string($item)) {
            $types .= 's';
        } else {
            $types .= 'b'; // Treat as binary data (blob)
        }
    }
    return $types;
}
