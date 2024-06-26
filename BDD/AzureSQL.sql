DROP DATABASE IF EXISTS DW; -- Crée table si elle n'existe pas
CREATE DATABASE DW;
USE DW;

CREATE TABLE Produit (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    type VARCHAR(100),
    prixUnitaire DECIMAL(10, 2),
    description VARCHAR(3000),
    nomImage VARCHAR(255),
    estAuCatalogue BIT NOT NULL DEFAULT 1 -- Type qui prends deux valeur : 1 ou 0
);

CREATE TABLE Client (
    id INT PRIMARY KEY AUTO_INCREMENT,
    genre VARCHAR(100),
    nom VARCHAR(100),
    prenom VARCHAR(100),
    rue VARCHAR(255),
    CP VARCHAR(10),
    ville VARCHAR(100),
    pays VARCHAR(100),
    mail VARCHAR(255) UNIQUE,
    telephone VARCHAR(20) UNIQUE,
    mdp VARCHAR(255),
    naissance DATE
);

CREATE TABLE Commande (
    id INT PRIMARY KEY AUTO_INCREMENT,
    date DATE,
    modePaiement VARCHAR(100),
    numFacture VARCHAR(50),
    idClient INT,
    -- Information de facturation
    nom VARCHAR(100),
    prenom VARCHAR(100),
    rue VARCHAR(255),
    CP VARCHAR(10),
    ville VARCHAR(100),
    pays VARCHAR(100),
    telephone VARCHAR(20),
    -- Information de livraison
    nomLivraison VARCHAR(100),
    prenomLivraison VARCHAR(100),
    rueLivraison VARCHAR(255),
    CPLivraison VARCHAR(10),
    villeLivraison VARCHAR(100),
    paysLivraison VARCHAR(100),
    FOREIGN KEY (idClient) REFERENCES Client(id)
);

CREATE TABLE Materiau (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    densite DECIMAL(10, 2),
    masseVolumique DECIMAL(10, 2),
    type VARCHAR(100)
);

CREATE TABLE Entrepot (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    latitude DECIMAL(9, 6),
    longitude DECIMAL(9, 6),
    stockTheorique INT,
    stockActuel INT,
    CONSTRAINT check_stock CHECK (stockActuel <= stockTheorique),
    CONSTRAINT check_latitude CHECK (latitude BETWEEN -90 AND 90),
	CONSTRAINT check_longitude CHECK (longitude BETWEEN -180 AND 180)
);

CREATE TABLE Porte (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idProduit INT,
    idEntrepot INT,
    FOREIGN KEY (idProduit) REFERENCES Produit(id),
    FOREIGN KEY (idEntrepot) REFERENCES Entrepot(id)
);

CREATE TABLE Livraison (
    id INT PRIMARY KEY AUTO_INCREMENT,
    arriveeEstimee DATETIME,
    distance DECIMAL(10, 2),
    nbPointsArrets INT,
    idCommande INT,
    idClient INT,
    idPorte INT,
    FOREIGN KEY (idCommande) REFERENCES Commande(id),
    FOREIGN KEY (idClient) REFERENCES Client(id),
    FOREIGN KEY (idPorte) REFERENCES Porte(id)
);

CREATE TABLE Composer (
    idProduit INT,
    idMateriau INT,
    PRIMARY KEY (idProduit, idMateriau),
    FOREIGN KEY (idProduit) REFERENCES Produit(id),
    FOREIGN KEY (idMateriau) REFERENCES Materiau(id)
);

CREATE TABLE Noter (
    idClient INT,
    idProduit INT,
    titre VARCHAR(255),
    note DECIMAL(2, 1),
    contenu TEXT,
    etat VARCHAR(50),
    date DATE,
    PRIMARY KEY (idClient, idProduit),
    FOREIGN KEY (idClient) REFERENCES Client(id),
    FOREIGN KEY (idProduit) REFERENCES Produit(id)
);

CREATE TABLE Concerner (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idProduit INT,
    idCommande INT,
    quantite INT,
    FOREIGN KEY (idProduit) REFERENCES Produit(id),
    FOREIGN KEY (idCommande) REFERENCES Commande(id)
);

CREATE TABLE OptionAchat (
    id INT PRIMARY KEY AUTO_INCREMENT,
    libele VARCHAR(255),
    cout DECIMAL(10, 2),
    typeProduit VARCHAR(100), -- Même valeur que type dans Produit
    active BIT NOT NULL DEFAULT 1 -- Bool pour savoir si on doit l'afficher à l'utilisateur
);

CREATE TABLE AOption (
    idConcerner INT,
    idOption INT,
    PRIMARY KEY (idConcerner, idOption),
    FOREIGN KEY (idConcerner) REFERENCES Concerner(id),
    FOREIGN KEY (idOption) REFERENCES OptionAchat(id)
);

DELIMITER //

CREATE FUNCTION LEVENSHTEIN(s1 VARCHAR(255), s2 VARCHAR(255))
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE s1_len, s2_len, i, j, c, c_temp INT;
    DECLARE s1_char CHAR;
    DECLARE cv0, cv1 VARBINARY(256);

    SET s1_len = LENGTH(s1), s2_len = LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0;

    IF s1 = s2 THEN
        RETURN 0;
    ELSEIF s1_len = 0 THEN
        RETURN s2_len;
    ELSEIF s2_len = 0 THEN
        RETURN s1_len;
    ELSE
        WHILE j <= s2_len DO
            SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1;
        END WHILE;
        WHILE i <= s1_len DO
            SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1;
            WHILE j <= s2_len DO
                SET c = c + 1;
                SET c_temp = IF(s1_char = SUBSTRING(s2, j, 1), 0, 1);
                SET c = IF(c > LEAST(LEAST(cv1, cv0) + 1, c + 1, c_temp), c_temp, c);
                SET j = j + 1;
                SET cv0 = CONV(CONCAT_WS('', cv1, HEX(c)), 16, 10);
            END WHILE;
            SET i = i + 1;
        END WHILE;
    END IF;

    RETURN c;
END //

DELIMITER ;

INSERT INTO Produit (id, nom, type, prixUnitaire, description, nomImage) VALUES 
(1, "Porte blindée en fer forgé", "Porte", 1999.98, "Porte ferme avec un design élégant, son acier protégé contre la rouille gardera sa splendeur tout au long de sa vie. Ses quelques 748 kilos vous protégeront des intrusions, tire d'armes à feu, bélierss et même explosif posé à proximité. Cette porte survivra à votre maison et restera le témoin de sa présence jusqu'à la fin des temps (ne protège pas des radiations).", "937dfe65a4522ed19262e70e3b179549.webp"),
(2, "Porte PVC pour jardin", "Porte", 137.23, "Porte légère et résistante à l'usure, le plastique dans toute sa splendeur. Redécouvrez, à l'heure de l'écologie, la porte de jardin PVC verte, conçue pour résister aux changements climatiques (sécheresses, tornades, tsunamis, ...) cette porte conçue à partir du pétrole Total vous suivra un long moment.", "e1d777ab7e3eede2e184122b004fba64.webp"),
(3, "Porte en bois massif", "Porte", 479.87, "Porte imposante constituée de bois massif, s'intègre parfaitement dans le style rustique de votre maison. Fini le whisky au goût fade, avec cette porte, vos boissons alcoolisées prendront une autre dimension. Avec cette porte votre maison gagnera en profondeur, sera plus imposante, et vos feux de cheminée deviendront plus lumineux. Nous précisons que cette porte n'a pas pour objectif de servir de combustible pour votre feu, bien qu’elle puisse brûler.", "ee1cea3113416700cf49597102afe43a.webp"),
(4, "Porte vitrée", "Porte", 549.01, "Cette porte d'exception s'intègre parfaitement dans tout type d'intérieur, apportant une touche d'élégance et de modernité. Fini les soirées sans rigoler. Idéal pour les rigolos qui veulent voir leurs amis se manger un mur invisible, votre espace de vie sera transformé. Cet objet de confort s'adresse à tous ceux et celles qui souhaitent pouvoir entrer dans une pièce, ainsi qu'en ressortir, tout en bloquant ses invités.", "19c9a011fbb5af034227ddc7382c31c3.webp"),
(5, "Porte coulissante en aluminium", "Porte", 499.01, "Cette porte d'exception s'intègre parfaitement dans tout type d'intérieur, apportant une touche d'élégance et de modernité. Fini les pièces sans ouverture pour y pénétrer. Idéale pour les amateurs de design, elle saura mettre en valeur votre espace de vie. Cet objet de confort s'adresse à tous ceux qui souhaitent pouvoir entrer dans une pièce, ainsi qu'en ressortir.", "4cb65f46159d95e4188b8f384041806b.webp"),

-- /!\\ Pas d'image
(8, 'Porte intérieur en pin', 'Porte', 199.99, "Porte intérieure en pin massif avec panneaux moulés. Vous retrouverez l'odeur des forêts dans votre intérieur, vous permettant de vous détendre au travail, au lit, et même aux toilettes. Attention il peut rester de la résine sur la porte à sa réception.", 'pin.webp'),
(9, 'Porte coupe-feu certifiée', 'Porte', 875.67, 'Porte coupe-feu résistante aux flammes avec isolation thermique', 'porte-coupe-feu.jpg'),
(10, 'Porte de garage sectionnelle', 'Porte', 899.99, 'Porte de garage automatique à panneaux sectionnels en acier. Vous pourrez enfin ranger votre voiture dans un garage, et ne plus la laisser dehors. Attention, la porte ne protège pas des voleurs, ni des intempéries.', "porte-de-garage-sectionnelle-manuelle-a-cassette.webp"),
(12, 'Porte-fenêtre en PVC', 'Porte', 349.99, "Porte-fenêtre en PVC blanc avec double vitrage isolant. Le classique, l'indémodable qui vous accompagne de déménagement en déménagement. Avec son traitement anti-jaunissement, vous pourrez la garder un bon moment.", 'porte-fenetre.webp'),
(22, 'Porte pliante en bambou', 'Porte', 320.99, 'Porte pliante légère en bambou, parfaite pour les petits espaces ou comme séparateur de pièce. Offre une touche naturelle et écologique.', 'bambou.webp'),
(23, 'Porte en chêne massif', 'Porte', 850.00, 'Porte en chêne massif avec finition vernie. Robuste et élégante, elle ajoute une note de luxe et de durabilité à votre intérieur.', 'massif.webp'),
(24, 'Porte vitrée à motifs', 'Porte', 415.50, 'Porte vitrée avec motifs gravés pour plus d’intimité tout en laissant passer la lumière. Parfaite pour les entrées ou les salles de bains.', 'motif.jpg'),
(13, 'Porte coulissante en verre trempé', 'Porte', 499.99, 'Porte coulissante en verre trempé, idéale pour les séparations de pièces tout en conservant une sensation d’espace ouvert. Élégante et moderne, elle permet une utilisation fluide et silencieuse.', 'porte-verre-coulissante.jpg'),
(14, 'Porte acoustique en bois composite', 'Porte', 755.00, 'Porte acoustique spécialement conçue pour réduire les bruits extérieurs, fabriquée en bois composite. Parfaite pour les bureaux ou les studios d’enregistrement cherchant à isoler le son.', 'compo.webp'),
(15, 'Porte blindée de sécurité', 'Porte', 1200.00, 'Porte blindée haute sécurité avec serrure multipoints. Assurez la sécurité de votre domicile contre les intrusions avec une résistance maximale.', 'blindax.webp'),
(31, "Porte de soirée bois", "Porte", 8651.00, "Porte semblant classique, mais ayant survécu à de nombreuses épreuves intenses. Pour des raisons de confidentialité, nous ne pouvons en dire plus, mais son histoire est inquiétante.", "tortue.jpg"),

-- Poignée
-- /!\\ Pas d'image
(6, 'Poignée de porte en acier inoxydable', 'Poignée', 29.99, 'Poignée de porte en acier inoxydable brossé, design moderne. Enfin une poignée qui ne rougira pas face au temps, elle restera impassible face à la rouille.', 'q50ZBgrnrRFlZ1mtBxnI7z5IpuKlM5QQ.webp'),
(7, 'Poignée de porte classique en laiton', 'Poignée', 19.99, 'Poignée de porte traditionnelle en laiton poli. Vous pourrez enfin vous regarder ailleurs que dans votre salle de bain.', '8Dc7O6Mypjxa37Bqze6MaZSkIB6QKMmp.webp'),
(11, 'Poignée de porte design en acrylique', 'Poignée', 49.99, "Poignée de porte moderne en acrylique transparent. Avec cette poignée, voir vos doigts de l'autre coté de la poignée sera un jeu d'enfant", 'yHgCYNB28evigmAw1BN34DAFRaBLNsTu.jpg'),
(16, 'Poignée tactile biométrique', 'Poignée', 199.99, 'Poignée de porte avec scanner biométrique intégré. Offre un accès sécurisé et personnalisable, parfaite pour les bureaux ou les maisons modernes.', 'ruoGoSOruM2esNIFKBz0uhqeCljbWpKv.jpg'),
(17, 'Poignée de porte en céramique', 'Poignée', 34.99, 'Poignée de porte en céramique avec motif floral, apportant une touche d’élégance classique à votre intérieur.', 'PNSrTZWmct69r7blFOqtM8CutUcAqsex.webp'),
(18, 'Poignée de porte rustique en fer forgé', 'Poignée', 45.99, 'Poignée de porte en fer forgé, finition rustique. Idéale pour ajouter un caractère ancien et robuste à vos portes.', 'todrKWeT5nZmvbxmMGyeR3MmBLUZ0jMb.jpg'),
(25, 'Poignée en bronze vieilli', 'Poignée', 39.99, 'Poignée de porte en bronze vieilli, idéale pour les aménagements vintages ou classiques. Apporte un cachet indéniable à toute porte.', 'z3kh2NpCIb51qm6N2Xhmv4SOBf7yoN03.webp'),
(26, 'Poignée pivotante minimaliste', 'Poignée', 29.99, 'Poignée pivotante au design minimaliste en acier inoxydable. Parfait pour un intérieur moderne et épuré.', 'JGrwlpsJ5XjWlknOA5KAk0hykyWxwd7l.png'),
(27, 'Poignée coquille pour tiroir', 'Poignée', 12.99, 'Poignée coquille classique pour tiroir, en métal avec finition matte. Facile à installer et polyvalente pour tous types de meubles.', 'aflUrWS1JkoSTgbgwScBDYIIoDR2CR9U.jpeg'),

-- Accessoire
-- /!\\ Pas d'image
(19, 'Seuil de porte en aluminium', 'Accessoire', 25.99, 'Seuil de porte en aluminium, aide à maintenir l’étanchéité et l’isolation des portes extérieures. Résistant et durable, il supporte bien les variations climatiques.', '51Mwzm41tSL._AC_SL1500.jpg'),
(20, 'Judas numérique écran LCD', 'Accessoire', 75.00, 'Judas de porte avec écran LCD pour une sécurité accrue. Permet de visualiser les visiteurs sans ouvrir la porte, idéal pour les personnes souhaitant une sécurité supplémentaire.', '51Q7lT0WxEL._AC_SL1500_.jpg'),
(21, 'Ferme-porte automatique', 'Accessoire', 59.99, 'Ferme-porte automatique, assure une fermeture douce et silencieuse de la porte. Convient aux environnements nécessitant de maintenir les portes fermées, comme les hôpitaux et les écoles.', '51RJV3xt+4L._AC_SL1000_.jpg'),
(28, 'Charnières invisibles', 'Accessoire', 18.99, 'Charnières invisibles pour une finition de porte sans interruption visuelle. Idéales pour les designs modernes et minimalistes.', '81VrN+Cyq6L._AC_SL1500_.jpg'),
(29, 'Butoir de porte magnétique', 'Accessoire', 16.99, 'Butoir de porte magnétique qui maintient votre porte ouverte sans la bloquer. Installation facile et efficace.', '61lnjHEzolL._AC_SL1100_.jpg'),
(30, 'Kit d’isolation pour porte', 'Accessoire', 34.99, 'Kit d’isolation acoustique et thermique pour portes. Comprend des joints d’étanchéité et des bandes isolantes pour réduire les courants d’air et le bruit.', '51y99-NXsnL._AC_SL1000_.jpg'),
(32, "Chati pour kitty", "Accessoire", 45.00, "Permet à votre Hello Kitty de rentrer et sortir de sa maison (et non pas la vôtre). Avec son option de vérouillage de la trape, vous pourrez redevenir maître de céans.", "51C72P3QcYL._AC_.jpg")
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
(DEFAULT, "Homme", "Le Grand", "Louis", "7 Rue du Chateau", '78000', "Versailles", "France", "louis.le-grand@whitout-head.fr", "0666666666", "$2y$10$zHid668AuTyWDCsSIyh.I.AezPjR7zCPSRrGdIiB8nIMlMCjdcvAK", "1754-08-23"),
-- MDP Marie : I'm radioactive
(DEFAULT, "Femme", "Curie", "Marie", "21 rue de l'école de médecine", '75006', "Paris", "France", "marie.curie@radio-gaga.com", "0223566239", "$2y$10$AfLrBllEiCcqeBNwnJEp5O5Lom8PMy8LoBcOcSLrqHKImdrFoN0Ia", "1867-11-07")
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
(17, "Pin", 0.50, 500, "Bois"),
(18, "MDF", 0.60, 600, "Bois"),
(19, "Ceramique", 0.60, 600, "Ceramique"),
(20, "LED", 0.05, 50, "Electronique"),
(21, "Mini-Moteur", 1.7, 1700, "Electronique"),
(22, "Bambou", 1.15, 1150, "Bois"),
(23, "Bronze", 8.73, 8730, "Metal"),
(24, "Polypropylène", 0.89, 890, "Plastique"),
(25, "Pastis", 0.51, 510, "Alcool")
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
(12, 12),(12, 14),(12, 15),
(13, 12),(13, 13),(13,16),(13,14),
(14, 18),
(15, 9),(15, 6),(15, 8),(15, 14),
(16, 9),(16, 12),(16, 14),
(17, 19),(17, 8),
(18, 9),(18, 13),
(19, 10),
(20, 7), (20, 20),
(21, 9), (21, 7), (21, 21),
(22, 22), (22, 14),
(23,  1), (23, 14), (23, 13),
(24, 12), (24, 11), (24, 14),
(25, 23),
(26, 8),
(27, 9),
(28, 14), (28, 10),
(29, 9), (29, 15),
(30, 24),
(31, 18), (31, 25),
(32, 18), (32, 14)
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
(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),(12, 10),

-- Produit 13
(13, 1),(13, 1),(13, 1),(13, 1),(13, 1),(13, 1),(13, 1),(13, 1),(13, 1),(13, 1),(13, 1),(13, 1),(13, 1),
(13, 10),(13, 10),(13, 10),(13, 10),

-- Produit 14
(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),(14, 6),
(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),(14, 8),

-- Produit 15
(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),(15, 9),
(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),(15, 7),

-- Produit 16
(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),
(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),(16, 5),
(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),(16, 2),

-- Product 17
(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),(17, 3),
(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),(17, 10),

-- Produit 18
(18, 4),(18, 4),(18, 4),(18, 4),(18, 4),(18, 4),(18, 4),(18, 4),(18, 4),(18, 4),(18, 4),
(18, 6),(18, 6),(18, 6),(18, 6),(18, 6),(18, 6),(18, 6),
(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),(18, 10),

-- Produit 19
(19, 1),(19, 1),(19, 1),(19, 1),(19, 1),(19, 1),(19, 1),(19, 1),(19, 1),(19, 1),(19, 1),(19, 1),(19, 1),
(19, 10),(19, 10),(19, 10),(19, 10),

-- Produit 20
(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),(20, 6),
(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),(20, 8),

-- Produit 21
(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),(21, 9),
(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),(21, 7),

-- Produit 22
(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),
(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),(22, 5),
(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),(22, 2),

-- Product 23
(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),(23, 3),
(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),(23, 10),

-- Produit 24
(24, 4),(24, 4),(24, 4),(24, 4),(24, 4),(24, 4),(24, 4),(24, 4),(24, 4),(24, 4),(24, 4),
(24, 6),(24, 6),(24, 6),(24, 6),(24, 6),(24, 6),(24, 6),
(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),(24, 10),

-- Produit 25
(25, 1),(25, 1),(25, 1),(25, 1),(25, 1),(25, 1),(25, 1),(25, 1),(25, 1),(25, 1),(25, 1),(25, 1),(25, 1),
(25, 10),(25, 10),(25, 10),(25, 10),

-- Produit 26
(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),(26, 6),
(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),(26, 8),

-- Produit 27
(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),(27, 9),
(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),(27, 7),

-- Produit 28
(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),
(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),(28, 5),
(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),(28, 2),

-- Product 29
(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),(29, 3),
(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),(29, 10),

-- Produit 30
(30, 1),(30, 1),(30, 1),(30, 1),(30, 1),(30, 1),(30, 1),(30, 1),(30, 1),(30, 1),(30, 1),(30, 1),(30, 1),
(30, 10),(30, 10),(30, 10),(30, 10),

-- Produit 31
(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),(31, 6),
(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),(31, 8),

-- Produit 32
(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),(32, 9),
(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7),(32, 7)
;