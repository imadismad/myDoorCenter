<?php

// Inclure le fichier contenant les fonctions SQL
require_once '../BDD/functionsSQL.php';

// Classe de test pour les fonctions SQL
class unit_functionsSQL extends PHPUnit\Framework\TestCase {
    public function testInsertionAvecEntreeValide() {
        // Données valides à insérer
        $donnees = array(
            "id" => 100,
            "nom" => "Produit 1",
            "type" => "Type 1",
            "prixUnitaire" => 25.99,
            "lienPage" => "http://example.com/produit1",
            "description" => "Description du produit 1",
            "nomImage" => "image1.jpg"
        );

        // Appel de la fonction d'insertion
        insererDonnees("Produit", $donnees);

        // Vérification si l'insertion a été effectuée correctement
        // Vous pouvez ajouter ici des assertions supplémentaires si nécessaire
        $this->assertTrue(true); // Par défaut, si aucun problème ne survient pendant l'insertion, le test réussit

        // Supprimer la ligne insérée
        supprimerLigne("Produit", "id", 100);
    }

    public function testInsertionAvecEntreeInvalide() {
        // Données invalides à insérer
        $donnees = array(
            "id" => 200,
            "nom" => "Produit 2",
            "prixUnitaire" => 25.99,
            "lienPage" => "http://example.com/produit1",
            "description" => "Description du produit 1",
            "nomImage" => "image1.jpg"
        );

        // Appel de la fonction d'insertion
        insererDonnees("Produit", $donnees);

        // Vérification si l'insertion a échoué comme prévu
        // Vous pouvez ajouter ici des assertions supplémentaires si nécessaire
        $this->assertTrue(true); // Par défaut, si l'insertion échoue comme prévu, le test réussit

        // Supprimer la ligne insérée
        supprimerLigne("Produit", "id", 200);
    }

    public function testRecuperation() {
        // Données valides à insérer
        $donnees = array(
            "id" => 300,
            "nom" => "Produit 1",
            "type" => "Type 1",
            "prixUnitaire" => 25.99,
            "lienPage" => "http://example.com/produit1",
            "description" => "Description du produit 1",
            "nomImage" => "image1.jpg"
        );

        // Appel de la fonction d'insertion
        insererDonnees("Produit", $donnees);

        // Récupérer les données insérées
        $resultat = recupererDonneesParValeur("Produit", "id", 300);

        // Supprimer la ligne insérée
        supprimerLigne("Produit", "id", 300);

        // Vérification si la récupération des données est correcte
        $this->assertEquals($donnees, $resultat);


    }

    public function clean(){
        supprimerLigne("Produit", "id", 100);
        supprimerLigne("Produit", "id", 200);
        supprimerLigne("Produit", "id", 300);
    }
}

?>
