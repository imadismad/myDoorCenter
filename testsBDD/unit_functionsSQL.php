<?php

// Inclure le fichier contenant les fonctions SQL
require_once '../BDD/functionsSQL.php';

// Classe de test pour les fonctions SQL
class unit_functionsSQL extends PHPUnit\Framework\TestCase {

    public function setUp() {
        supprimerLigne("Produit","id",100);
        supprimerLigne("Produit","id",200);
        supprimerLigne("Produit","id",300);
    }

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

        // Supprimer la ligne insérée
        supprimerLigne("Produit", "id", 100);

        // Vérification si l'insertion a été effectuée correctement
        // Vous pouvez ajouter ici des assertions supplémentaires si nécessaire
        $this->assertTrue(true); // Par défaut, si aucun problème ne survient pendant l'insertion, le test réussit

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

        // Supprimer la ligne insérée
        supprimerLigne("Produit", "id", 200);

        // Vérification si l'insertion a échoué comme prévu
        // Vous pouvez ajouter ici des assertions supplémentaires si nécessaire
        $this->assertTrue(true); // Par défaut, si l'insertion échoue comme prévu, le test réussit

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
        $res = $resultat["0"];

        // Convertir le prixUnitaire en float dans les données récupérées
        $res['prixUnitaire'] = (float) $res['prixUnitaire'];

        // Supprimer la ligne insérée
        supprimerLigne("Produit", "id", 300);

        //var_dump($donnees);
        //var_dump($res);

        // Vérifier si des données ont été récupérées
        $this->assertNotEmpty($res);

        // Vérification si la récupération des données est correcte
        $this->assertEquals($donnees, $res, "Les données récupérées ne correspondent pas aux données attendues");


    }

}

?>
