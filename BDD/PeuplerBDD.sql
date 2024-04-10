USE DW;

INSERT INTO Produit (id, nom, type, prixUnitaire, description, nomImage) VALUES 
(DEFAULT, "Porte blindée en fer forgé", "Porte", 349.56, "Porte ferme avec un design élégant, sont acier protégé contre la rouille garderas sa splendeur tout au lond de sa vie. Ses quelques 748 kilos vous protégerons des intrusions, tire d'arme à feu, bélier et même explosif posé à proximité. Cette porte survivra à votre maison et restera le témoin de sa présence jusqu'a la fin des temps (ne protège pas des radiations).", "937dfe65a4522ed19262e70e3b179549.webp"),
(DEFAULT, "Porte PVC pour jardin", "Porte", 249.23, "Porte légger et résistant à l'usure, le plastique dans toute sa splendeur. Redécouvrez a l'heure de l'écologie de porte de jardin PVC verte, conçu pour résister au changement climatique (sécheresse, tornade, tsunamie, ...) cette porte conçu à partir du pétrole de Total vous suivras long moment.", "e1d777ab7e3eede2e184122b004fba64.webp"),
(DEFAULT, "Porte en bois massif", "Porte", 479.87, "Porte imposante faite de bois massif s'intègre parfaitement dans le style rustique de votre maison. Fini le whisky au goût fade, avec cette porte, vos boissons alcooliser prendrons une autre dimension, même les premiers prix. Avec cette porte votre maison prendra une autre dimension, et vos feux de cheminé deviendront plus lumineux. Nous précisons que cette porte n'as pas pour objectif de servir de combustible pour votre feu.", "ee1cea3113416700cf49597102afe43a.webp"),
(DEFAULT, "Porte vitrée", "Porte", 549.01, "Cette porte d'exception s'intègre parfaitement dans tout type d'intérieur, apportant une touche d'élégance et de modernité. Fini les soirées sans rigoler. Idéale pour les rigolos qui veulent voir leur ami se manger un mur invisible, votre espace de vie seras transformé. Cet objet de confort s'adresse à tous ceux qui souhaitent pouvoir entrer dans une pièce, ainsi qu'en ressortir, tout en bloquant vos invités.", "19c9a011fbb5af034227ddc7382c31c3.webp"),
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