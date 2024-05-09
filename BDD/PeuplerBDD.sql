USE DW;

INSERT INTO Produit (id, nom, type, prixUnitaire, description, nomImage) VALUES 
(1, "Porte blindée en fer forgé", "Porte", 1999.98, "Porte ferme avec un design élégant, son acier protégé contre la rouille gardera sa splendeur tout au long de sa vie. Ses quelque 748 kilos vous protégeront des intrusions, tire d'arme à feu, bélier et même explosif posé à proximité. Cette porte survivra à votre maison et restera le témoin de sa présence jusqu'a la fin des temps (ne protège pas des radiations).", "937dfe65a4522ed19262e70e3b179549.webp"),
(2, "Porte PVC pour jardin", "Porte", 137.23, "Porte légère et résistant à l'usure, le plastique dans toute sa splendeur. Redécouvrez à l'heure de l'écologie la porte de jardin PVC verte, conçu pour résister au changement climatique (sécheresse, tornade, tsunami, ...) cette porte conçue à partir du pétrole de Total vous suivra long moment.", "e1d777ab7e3eede2e184122b004fba64.webp"),
(3, "Porte en bois massif", "Porte", 479.87, "Porte imposante faite de bois massif s'intègre parfaitement dans le style rustique de votre maison. Fini le whisky au goût fade, avec cette porte, vos boissons alcooliser prendront une autre dimension. Avec cette porte votre maison gagnera en profondeur, sera plus imposante, et vos feux de cheminer deviendront plus lumineux. Nous précisons que cette porte n'a pas pour objectif de servir de combustible pour votre feu, et qu’elle peut bruler.", "ee1cea3113416700cf49597102afe43a.webp"),
(4, "Porte vitrée", "Porte", 549.01, "Cette porte d'exception s'intègre parfaitement dans tout type d'intérieur, apportant une touche d'élégance et de modernité. Fini les soirées sans rigoler. Idéale pour les rigolos qui veulent voir leur ami se manger un mur invisible, votre espace de vie sera transformé. Cet objet de confort s'adresse à tous ceux et celle qui souhaitent pouvoir entrer dans une pièce, ainsi qu'en ressortir, tout en bloquant ses invités.", "19c9a011fbb5af034227ddc7382c31c3.webp"),
(5, "Porte coulissante en aluminium", "Porte", 499.01, "Cette porte d'exception s'intègre parfaitement dans tout type d'intérieur, apportant une touche d'élégance et de modernité. Fini les pièces sans ouverture pour y pénétrer. Idéale pour les amateurs de design, elle saura mettre en valeur votre espace de vie. Cet objet de confort s'adresse à tous ceux qui souhaitent pouvoir entrer dans une pièce, ainsi qu'en ressortir.", "4cb65f46159d95e4188b8f384041806b.webp"),

-- /!\\ Pas d'image
(8, 'Porte intérieur en pin', 'Porte', 199.99, "Porte intérieure en pin massif avec panneaux moulés. Vous retrouverez l'odeur des forets dans votre intérieur, vous permetant de vous détendre au travail, au lit, et même au toilette. Attention il peut rester de la résine sur la porte à sa reception.", ''),
(9, 'Porte coupe-feu certifiée', 'Porte', 875.67, 'Porte coupe-feu résistante aux flammes avec isolation thermique', 'porte_coupe_feu.jpg'),
(10, 'Porte de garage sectionnelle', 'Porte', 899.99, 'Porte de garage automatique à panneaux sectionnels en acier. Vous pourrez enfin ranger votre voiture dans un garage, et ne plus la laisser dehors. Attention, la porte ne protège pas des voleurs, ni des intempéries.', ""),
(12, 'Porte-fenêtre en PVC', 'Porte', 349.99, "Porte-fenêtre en PVC blanc avec double vitrage isolant. Le classique, l'indémodable qui vous acompagne de déménagement en déménagement. Avec son traitement anti jaunissement, vous pourrez la garder un bon moment.", ''),

-- Poignée
-- /!\\ Pas d'image
(6, 'Poignée de porte en acier inoxydable', 'Poignée', 29.99, 'Poignée de porte en acier inoxydable brossé, design moderne. Enfin une poignée qui ne rougira pas face au temps, elle restera impassible face à la rouille.', ''),
(7, 'Poignée de porte classique en laiton', 'Poignée', 19.99, 'Poignée de porte traditionnelle en laiton poli. Vous pourrez enfin vous regardez ailleur que dans votre sale de bain.', ''),
(11, 'Poignée de porte design en acrylique', 'Poignée', 49.99, "Poignée de porte moderne en acrylique transparent. Avec cette poignée, voir vos doigt de l'autre coté de la poigné sera un jeu d'enfant", '')
;

INSERT INTO Client (id, genre, nom, prenom, rue, CP, ville, pays, mail, telephone, mdp, naissance) VALUES
-- MDP pour Jean : mdpclient1
(1, "Homme", 'Dupont', 'Jean', '10 Rue des Lilas', '75001', 'Paris', 'France', 'jean.dupont@example.com', '0123456789', '$2y$10$SGhAFy9Z0Ottxqm5mthUGe14FPxDl0UwJRQZlthrQcBq9N5reuLEW', "1999-01-01"),
-- MDP pour Sophie : mdpclient2
(2, "Femme", 'Martin', 'Sophie', '25 Avenue des Roses', '69001', 'Lyon', 'France', 'sophie.martin@example.com', '0234567891', '$2y$10$NoEKlP1PU/RlMNKl0/sCJe/t5iiiT4IfCYL.feZ5af/m.RZFLdzmS', "1966-07-05"),
-- MDP pour Pierre : mdpclient3
(3, "Homme", 'Dubois', 'Pierre', '8 Rue des Chênes', '33000', 'Bordeaux', 'France', 'pierre.dubois@example.com', '0345678912', '$2y$10$BIJBZT0kyx9BlG1RTdNIWOAOqy4zKbkE69bVe69kMej5BTWnnajdS', "2000-12-24"),
-- MDP pour Marie : mdpclient4
(4, "Femme", 'Lefevre', 'Marie', '15 Rue des Pivoines', '44000', 'Nantes', 'France', 'marie.lefevre@example.com', '0456789123', '$2y$10$jPYD4RC5d.AiA.qqg/Ec3uj9CP0q/M6d0TWgLSgShc2aQhZs57zCq', "1988-03-11"),
-- MDP pour Julie : mdpclient5
(5, "Femme", 'Moreau', 'Julie', '20 Rue des Tulipes', '59000', 'Lille', 'France', 'julie.moreau@example.com', '0567891234', '$2y$10$BrfQ6ts3VmDfNghZ1GcUd.QdpI3HqU1hso05Hxq/7CnfGGAVw.lxO', "1998-05-26"),
-- MDP pour Louis : Live before your head fall
(DEFAULT, "Homme", "Le Grand", "Louis", "7 Rue du Chateau", 78000, "Versaille", "France", "louis.le-grand@whitout-head.fr", "06 666 666 66", "$2y$10$zHid668AuTyWDCsSIyh.I.AezPjR7zCPSRrGdIiB8nIMlMCjdcvAK", "1754-08-23"),
-- MDP Marie : I'm radioactive
(DEFAULT, "Femme", "Curie", "Marie", "21 rue de l'école de médecine", 75006, "Paris", "France", "marie.curie@radio-gaga.com", "02 235 66 239", "$2y$10$AfLrBllEiCcqeBNwnJEp5O5Lom8PMy8LoBcOcSLrqHKImdrFoN0Ia", "1867-11-07")
;

INSERT INTO Commande (id, date, modePaiement, numFacture, idClient) VALUES
(1, '2024-03-06', 'Carte bancaire', 'FACT001', 1),
(2, '2024-03-06', 'PayPal', 'FACT002', 2),
(3, '2024-03-07', 'Virement bancaire', 'FACT003', 3),
(4, '2024-03-07', 'Carte bancaire', 'FACT004', 4),
(5, '2024-03-08', 'PayPal', 'FACT005', 5),
(6, '2024-03-08', 'Carte bancaire', 'FACT006', 1),
(7, '2024-03-09', 'Virement bancaire', 'FACT007', 2),
(8, '2024-03-09', 'Carte bancaire', 'FACT008', 3),
(9, '2024-03-10', 'PayPal', 'FACT009', 4),
(10, '2024-03-10', 'Carte bancaire', 'FACT010', 5)
;

INSERT INTO Materiau (id, nom, densite, masseVolumique, type) VALUES
(1, "Chêne", 0.70, 704, "Bois"),
(2, "Acacia", 0.77, 770, "Bois"),
(3, "Granit", 2.67, 2674, "Roche"),
(4, "Andésite", 2.95, 2950, "Roche"),
(5, "Grès", 3.19, 3186, "Roche"),
(6, "Béton", 2.3, 2300, "Roche"),
(7, "Cuivre", 8.94, 8940, "Métal"),
(8, "Or", 11.5, 11500, "Métal"),
(9, "Acier", 7.5, 7500, "Métal"),
(10, "Aluminium", 2.7, 2700, "Métal"),
(11, "Plomb", 11.4, 11400, "Métal"),
(12, "Verre", 2.30, 2300, "Verre"),
(13, "Eau", 1.00, 1000, "Liquide"),
(14, "Air", 1.00, 1.20, "Gaz"),
(15, "PVC", 1.38, 1380, "Plastique"),
(16, "Laiton", 8.56, 8560, "Métal"),
(17, "Pin", 0.50, 500, "Pin")
;

INSERT INTO Composer (idProduit, idMateriau) VALUES
(1, 9), (1, 11), (1, 6), (1, 7), (1, 13),
(2, 15), (2, 14), (2, 13), (2, 6),
(3, 1), (3, 2), (3, 11),
(4, 12), (4, 14),
(5, 12), (5, 13), (5, 6),
(6, 9),
(7, 16),
(8, 17),
(9, 6),(9, 13),(9, 14),
(10, 10),(10, 12),(10, 15),
(11, 12),
(12, 12),(12, 14),(12, 15)
;

INSERT INTO OptionAchat (id, libele, cout, typeProduit, active) VALUES
-- Ajout de vieille option plus dispinible
(DEFAULT, "Avec cadre", 685, "Porte", 0),
(DEFAULT, "Avec cadre", 68, "Porte", 0),
(DEFAULT, "Avec poignée", 22, "Porte", 0),
(DEFAULT, "Avec porte", 999, "Porte", 0),

-- Ajout d'option disponible
(DEFAULT, "Avec cadre", 250, "Porte", 1),
(DEFAULT, "Avec poignée", 50, "Porte", 1),
(DEFAULT, "Avec porte", 0, "Porte", 1),
(DEFAULT, "Avec installation", 79.99, "Porte", 1);

INSERT INTO Entrepot (id, nom, latitude, longitude, stockTheorique, stockActuel) VALUES
(1000, 'Livraison', 0, 0, 10000, 0),
(1, 'Entrepôt Paris', 48.8566, 2.3522, 1000, 800),
(2, 'Entrepôt Lyon', 45.7578, 4.8320, 800, 700),
(3, 'Entrepôt Marseille', 43.2965, 5.3698, 1200, 1100),
(4, 'Entrepôt Bordeaux', 44.8378, -0.5792, 900, 850),
(5, 'Entrepôt Lille', 50.6292, 3.0573, 600, 550),
(6, 'Entrepôt Nantes', 47.2184, -1.5536, 700, 650),
(7, 'Entrepôt Toulouse', 43.6047, 1.4442, 1000, 950),
(8, 'Entrepôt Strasbourg', 48.5734, 7.7521, 800, 750),
(9, 'Entrepôt Nice', 43.7102, 7.2620, 600, 500),
(10, 'Entrepôt Rennes', 48.1173, -1.6778, 500, 450);

INSERT INTO Porte (idProduit, idEntrepot) VALUES
-- Produit 1
(1, 3),(1, 3),(1, 3),(1, 3),(1, 3),
(1, 9),(1, 9),(1, 9),(1, 9),(1, 9),(1, 9),

-- Produit 2

-- Produit 3
(3, 6),(3, 6),(3, 6),(3, 6),(3, 6),(3, 6),
(3, 7),(3, 7),(3, 7),(3, 7),(3, 7),(3, 7),(3, 7),(3, 7),(3, 7),
(3, 10),(3, 10),(3, 10),(3, 10),(3, 10),(3, 10),(3, 10),(3, 10),(3, 10),
(3, 1),(3, 1),(3, 1),(3, 1),

-- Produit 4
(4, 1),(4, 1),(4, 1),(4, 1),(4, 1),(4, 1),
(4, 10),(4, 10),(4, 10),(4, 10),(4, 10),(4, 10),(4, 10),(4, 10),

-- Produit 5
(5, 4),(5, 4),(5, 4),(5, 4),(5, 4),(5, 4),(5, 4),(5, 4),(5, 4),(5, 4),
(5, 5),(5, 5),(5, 5),(5, 5),(5, 5),(5, 5),(5, 5),(5, 5),(5, 5),(5, 5),(5, 5),
(5, 8),(5, 8),(5, 8),(5, 8),(5, 8),(5, 8),

-- Produit 6
(6, 5),(6, 5),(6, 5),(6, 5),(6, 5),(6, 5),(6, 5),(6, 5),(6, 5),(6, 5),(6, 5),(6, 5),
(6, 3),(6, 3),(6, 3),(6, 3),(6, 3),(6, 3),(6, 3),(6, 3),(6, 3),

-- Produit 7
(7, 9),(7, 9),(7, 9),(7, 9),(7, 9),(7, 9),(7, 9),(7, 9),(7, 9),(7, 9),(7, 9),(7, 9),(7, 9),(7, 9),(7, 9),
(7, 10),(7, 10),(7, 10),(7, 10),(7, 10),(7, 10),(7, 10),(7, 10),(7, 10),(7, 10),(7, 10),
(7, 2),(7, 2),(7, 2),(7, 2),(7, 2),(7, 2),(7, 2),(7, 2),(7, 2),(7, 2),(7, 2),(7, 2),(7, 2),

-- Produit 8
(8, 10),(8, 10),(8, 10),(8, 10),(8, 10),(8, 10),
(8, 9),(8, 9),(8, 9),(8, 9),(8, 9),(8, 9),(8, 9),(8, 9),(8, 9),
(8, 7),(8, 7),(8, 7),(8, 7),(8, 7),(8, 7),(8, 7),(8, 7),(8, 7),(8, 7),(8, 7),(8, 7),(8, 7),(8, 7),

-- Produit 9
(9, 2),(9, 2),(9, 2),(9, 2),(9, 2),(9, 2),(9, 2),(9, 2),(9, 2),(9, 2),
(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),(9, 1),

-- Produit 10
(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),(10, 7),
(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),(10, 6),
(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),(10, 1),

-- Produit 11
(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),
(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),(11, 3),

-- Produit 12
(12, 4),(12, 4),(12, 4),(12, 4),(12, 4),(12, 4),(12, 4),(12, 4),(12, 4),(12, 4),(12, 4),
(12, 6),(12, 6),(12, 6),(12, 6),(12, 6),(12, 6),(12, 6),
(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10)

;