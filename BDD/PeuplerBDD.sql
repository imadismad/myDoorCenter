USE DW;

INSERT INTO Produit (id, nom, type, prixUnitaire, description, nomImage) VALUES 
(DEFAULT, "Porte blindée en fer forgé", "Porte", 349.56, "Porte de ferme avec un design élégant", "937dfe65a4522ed19262e70e3b179549.webp"),
(DEFAULT, "Porte PVC pour jardin", "Porte", 249.23, "Porte légger et résistant à l'usure", "e1d777ab7e3eede2e184122b004fba64.webp"),
(DEFAULT, "Porte en bois massif", "Porte", 479.87, "Porte imposante faite de bois massif", "ee1cea3113416700cf49597102afe43a.webp"),
(DEFAULT, "Porte vitrée", "Porte", 549.01, "Porte transparente permettant une vision", "19c9a011fbb5af034227ddc7382c31c3.webp"),
(DEFAULT, "Porte coulissante en aluminium", "Porte", 799.45, "Cette porte d'exception s'intègre parfaitement dans tout type d'intérieur, apportant une touche d'élégance et de modernité. Fini les pièces sans ouverture pour y pénétrer. Idéale pour les amateurs de design, elle saura mettre en valeur votre espace de vie. Cet objet de confort s'adresse à tous ceux qui souhaitent pouvoir entrer dans une pièce, ainsi qu'en ressortir.", "4cb65f46159d95e4188b8f384041806b.webp");

INSERT INTO Materiau (id, nom, densite, masseVolumique, type) VALUES
(DEFAULT, "Chêne", 0.70, 704, "Bois"),
(DEFAULT, "Acacia", 0.77, 770, "Bois"),
(DEFAULT, "Granit", 2.67, 2674, "Roche"),
(DEFAULT, "Andésite", 2.95, 2950, "Roche"),
(DEFAULT, "Grès", 3.19, 3186, "Roche"),
(DEFAULT, "Béton", 2.3, 2300, "Roche"),
(DEFAULT, "Cuivre", 8.94, 8940, "Métal"),
(DEFAULT, "Or", 11.5, 11500, "Métal"),
(DEFAULT, "Acier", 7.5, 7500, "Métal"),
(DEFAULT, "Aluminium", 2.7, 2700, "Métal"),
(DEFAULT, "Plomb", 11.4, 11400, "Métal"),
(DEFAULT, "Verre", 2.30, 2300, "Verre")
(DEFAULT, "Eau", 1.00, 1000, "Liquide");

INSERT INTO Composer (idProduit, idMateriau) VALUES
(5, 12), (5, 13), (5, 6);