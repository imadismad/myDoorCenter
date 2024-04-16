USE DW;

INSERT INTO Produit (id, nom, type, prixUnitaire, description, nomImage) VALUES 
(DEFAULT, "Porte blindée en fer forgé", "Porte", 349.56, "Porte ferme avec un design élégant, son acier protégé contre la rouille gardera sa splendeur tout au long de sa vie. Ses quelque 748 kilos vous protégeront des intrusions, tire d'arme à feu, bélier et même explosif posé à proximité. Cette porte survivra à votre maison et restera le témoin de sa présence jusqu'a la fin des temps (ne protège pas des radiations).", "937dfe65a4522ed19262e70e3b179549.webp"),
(DEFAULT, "Porte PVC pour jardin", "Porte", 249.23, "Porte légère et résistant à l'usure, le plastique dans toute sa splendeur. Redécouvrez à l'heure de l'écologie la porte de jardin PVC verte, conçu pour résister au changement climatique (sécheresse, tornade, tsunami, ...) cette porte conçue à partir du pétrole de Total vous suivra long moment.", "e1d777ab7e3eede2e184122b004fba64.webp"),
(DEFAULT, "Porte en bois massif", "Porte", 479.87, "Porte imposante faite de bois massif s'intègre parfaitement dans le style rustique de votre maison. Fini le whisky au goût fade, avec cette porte, vos boissons alcooliser prendront une autre dimension. Avec cette porte votre maison gagnera en profondeur, sera plus imposante, et vos feux de cheminer deviendront plus lumineux. Nous précisons que cette porte n'a pas pour objectif de servir de combustible pour votre feu, et qu’elle peut bruler.", "ee1cea3113416700cf49597102afe43a.webp"),
(DEFAULT, "Porte vitrée", "Porte", 549.01, "Cette porte d'exception s'intègre parfaitement dans tout type d'intérieur, apportant une touche d'élégance et de modernité. Fini les soirées sans rigoler. Idéale pour les rigolos qui veulent voir leur ami se manger un mur invisible, votre espace de vie sera transformé. Cet objet de confort s'adresse à tous ceux et celle qui souhaitent pouvoir entrer dans une pièce, ainsi qu'en ressortir, tout en bloquant ses invités.", "19c9a011fbb5af034227ddc7382c31c3.webp"),
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
(DEFAULT, "Verre", 2.30, 2300, "Verre"),
(DEFAULT, "Eau", 1.00, 1000, "Liquide"),
(DEFAULT, "Air", 1.00, 1.20, "Gaz"),
(DEFAULT, "PVC", 1.38, 1380, "Plastique");

INSERT INTO Composer (idProduit, idMateriau) VALUES
(5, 12), (5, 13), (5, 6),
(4, 12), (4, 14),
(3, 1), (3, 2), (3, 11),
(2, 15), (2, 14), (2, 13), (2, 6),
(1, 9), (1, 11), (1, 6), (1, 7), (1, 13);

-- Ajout de vieille option plus dispinible
INSERT INTO OptionAchat (id, libele, cout, typeProduit, active) VALUES
(DEFAULT, "Avec cadre", 685, "Porte", 0),
(DEFAULT, "Avec cadre", 68, "Porte", 0),
(DEFAULT, "Avec poignée", 22, "Porte", 0),
(DEFAULT, "Avec porte", 999, "Porte", 0);


INSERT INTO OptionAchat (id, libele, cout, typeProduit) VALUES
(DEFAULT, "Avec cadre", 250, "Porte"),
(DEFAULT, "Avec poignée", 50, "Porte"),
(DEFAULT, "Avec porte", 0, "Porte"),
(DEFAULT, "Avec installation", 79.99, "Porte");

INSERT INTO Client (id, genre, nom, prenom, rue, CP, ville, pays, mail, telephone, mdp, naissance) VALUES
-- MDP pour Louis : Live before your head fall
(DEFAULT, "Homme", "Le Grand", "Louis", "7 Rue du Chateau", 78000, "Versaille", "France", "louis.le-grand@whitout-head.fr", "06 666 666 66", "$2y$10$zHid668AuTyWDCsSIyh.I.AezPjR7zCPSRrGdIiB8nIMlMCjdcvAK", "1754-08-23"),
-- MDP Marie : I'm radioactive
(DEFAULT, "Femme", "Curie", "Marie", "21 rue de l'école de médecine", 75006, "Paris", "France", "marie.curie@radio-gaga.com", "02 235 66 239", "$2y$10$AfLrBllEiCcqeBNwnJEp5O5Lom8PMy8LoBcOcSLrqHKImdrFoN0Ia", "1867-11-07")
;