<?php
include_once "config.php";

function connexionBDD(): mysqli {
    // Establish database connection using configured settings
    $connexion = new mysqli(SQL_SERVER, SQL_USER, SQL_PASSWORD, SQL_BDD_NAME);
    if ($connexion->connect_error) {
        // Log error instead of displaying it
        error_log("Database connection error: " . $connexion->connect_error);
        throw new Exception("Database connection error: " . $connexion->connect_error);
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
    $valeurs = array_values($donnees);
    $requete->bind_param($types, ...$valeurs);

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

    if (is_string($champReference)) {
        // Préparation de la requête de suppression
        $requete = $connexion->prepare("DELETE FROM $table WHERE $champReference = ?");

        if (!$requete) {
            error_log("Prepare failed: " . $connexion->error);
            return false;
        }

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

        if (!$requete) {
            error_log("Prepare failed: " . $connexion->error);
            return false;
        }

        $requete->bind_param(recupType($valeurReference), ...$valeurReference);

    } else {
        throw new RuntimeException("Mauvais argument passé pour \$champReference et/ou \$valeurReference");
    }

    $success = $requete->execute();
    if (!$success) {
        error_log("Delete error: " . $requete->error);
        throw new Exception("Erreur lors de la suppression de la ligne");
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
    $donnees = reponseVersArray($requete);

    $requete->close();
    $connexion->close();
    return $donnees;
}

function modifierDonnees($table, $champModification, $nouvelleValeur, $champReference, $valeurReference) {
    $connexion = connexionBDD();
    if (!$connexion) return false; // Check connection

    if (is_string($champModification )) {
        $requete = $connexion->prepare("UPDATE $table SET $champModification = ? WHERE $champReference = ?");
        if (!$requete) {
            error_log("Prepare failed: " . $connexion->error);
            return false;
        }

        $requete->bind_param("ss", $nouvelleValeur, $valeurReference);
    }  else if (is_array($champModification) && is_array($nouvelleValeur) && sizeof($champModification) === sizeof($nouvelleValeur)) {
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

    $success = $requete->execute();
    if (!$success) {
        error_log("Update error: " . $requete->error);
    }

    $requete->close();
    $connexion->close();
    return $success;
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
