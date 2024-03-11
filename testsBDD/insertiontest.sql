USE DW;

INSERT INTO Produit (id, nom, type, prixUnitaire, lienPage, description, nomImage) VALUES
(1, 'Porte en bois massif', 'Porte', 299.99, 'http://example.com/porte-bois-massif', 'Porte chêne massif avec finition naturelle', 'porte_bois.jpg'),
(2, 'Porte coulissante moderne', 'Porte', 499.99, 'http://example.com/porte-coulissante-moderne', 'Porte coulissante en verre trempé avec cadre en aluminium', 'porte_coulissante.jpg'),
(3, 'Poignée de porte en acier inoxydable', 'Poignée', 29.99, 'http://example.com/poignee-inox', 'Poignée de porte en acier inoxydable brossé, design moderne', 'poignee_inox.jpg'),
(4, 'Poignée de porte classique en laiton', 'Poignée', 19.99, 'http://example.com/poignee-laiton', 'Poignée de porte traditionnelle en laiton poli', 'poignee_laiton.jpg'),
(5, 'Porte intérieur en pin', 'Porte', 199.99, 'http://example.com/porte-interieur-pin', 'Porte intérieure en pin massif avec panneaux moulés', 'porte_pin.jpg'),
(6, 'Porte coupe-feu certifiée', 'Porte', 399.99, 'http://example.com/porte-coupe-feu', 'Porte coupe-feu résistante aux flammes avec isolation thermique', 'porte_coupe_feu.jpg'),
(7, 'Poignée de porte en laiton antique', 'Poignée', 39.99, 'http://example.com/poignee-laiton-antique', 'Poignée de porte vintage en laiton antique avec motifs gravés', 'poignee_laiton_antique.jpg'),
(8, 'Porte de garage sectionnelle', 'Porte', 899.99, 'http://example.com/porte-garage-sectionnelle', 'Porte de garage automatique à panneaux sectionnels en acier', 'porte_garage_sectionnelle.jpg'),
(9, 'Poignée de porte design en acrylique', 'Poignée', 49.99, 'http://example.com/poignee-acrylique-design', 'Poignée de porte moderne en acrylique transparent', 'poignee_acrylique.jpg'),
(10, 'Porte-fenêtre en PVC', 'Porte', 349.99, 'http://example.com/porte-fenetre-pvc', 'Porte-fenêtre en PVC blanc avec double vitrage isolant', 'porte_fenetre_pvc.jpg');

INSERT INTO Client (id, nom, prenom, rue, CP, ville, pays, mail, telephone, mdp) VALUES
(1, 'Dupont', 'Jean', '10 Rue des Lilas', '75001', 'Paris', 'France', 'jean.dupont@example.com', '0123456789', 'mdpclient1'),
(2, 'Martin', 'Sophie', '25 Avenue des Roses', '69001', 'Lyon', 'France', 'sophie.martin@example.com', '0234567891', 'mdpclient2'),
(3, 'Dubois', 'Pierre', '8 Rue des Chênes', '33000', 'Bordeaux', 'France', 'pierre.dubois@example.com', '0345678912', 'mdpclient3'),
(4, 'Lefevre', 'Marie', '15 Rue des Pivoines', '44000', 'Nantes', 'France', 'marie.lefevre@example.com', '0456789123', 'mdpclient4'),
(5, 'Moreau', 'Julie', '20 Rue des Tulipes', '59000', 'Lille', 'France', 'julie.moreau@example.com', '0567891234', 'mdpclient5');

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
(10, '2024-03-10', 'Carte bancaire', 'FACT010', 5);

INSERT INTO Materiau (id, nom, densite, masseVolumique, type) VALUES
(1, 'Bois', 0.6, 700, 'Naturel'),
(2, 'Acier', 7.85, 7850, 'Métal'),
(3, 'Verre', 2.5, 2500, 'Transparent'),
(4, 'Plastique', 1.2, 1200, 'Synthétique'),
(5, 'Aluminium', 2.7, 2700, 'Métal'),
(6, 'Cuivre', 8.96, 8960, 'Métal'),
(7, 'PVC', 1.38, 1380, 'Synthétique'),
(8, 'Fonte', 7.2, 7200, 'Métal'),
(9, 'Granit', 2.7, 2700, 'Naturel'),
(10, 'Marbre', 2.7, 2700, 'Naturel');

INSERT INTO Entrepot (id, nom, latitude, longitude, stockTheorique, stockActuel) VALUES
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

INSERT INTO Porte (id, idProduit, idEntrepot) VALUES
(1, 10, 7),
(2, 4, 1),
(3, 7, 9),
(4, 1, 3),
(5, 6, 5),
(6, 8, 10),
(7, 2, 8),
(8, 3, 6),
(9, 9, 2),
(10, 5, 4);

INSERT INTO Livraison (id, arriveeEstimee, distance, nbPointsArrets, idCommande, idClient, idPorte) VALUES
(1, '2024-03-10 08:00:00', 50.25, 3, 1, 1, 1),
(2, '2024-03-11 09:30:00', 75.50, 4, 2, 2, 10),
(3, '2024-03-12 11:15:00', 100.75, 5, 3, 9, 3),
(4, '2024-03-13 12:45:00', 125.00, 6, 4, 7, 8),
(5, '2024-03-14 14:30:00', 150.25, 7, 5, 4, 5),
(6, '2024-03-15 16:00:00', 175.50, 8, 6, 10, 6),
(7, '2024-03-16 17:45:00', 200.75, 9, 7, 1, 4),
(8, '2024-03-17 19:30:00', 225.00, 10, 8, 3, 2),
(9, '2024-03-18 21:00:00', 250.25, 11, 9, 5, 9),
(10, '2024-03-19 22:45:00', 275.50, 12, 10, 8, 2);

INSERT INTO Composer (idProduit, idMateriau) VALUES
(1, 1), -- Produit 1 composé de Matériau 1
(1, 2), -- Produit 1 composé de Matériau 2
(2, 3), -- Produit 2 composé de Matériau 3
(2, 4), -- Produit 2 composé de Matériau 4
(3, 1), -- Produit 3 composé de Matériau 1
(3, 5), -- Produit 3 composé de Matériau 5
(4, 2), -- Produit 4 composé de Matériau 2
(4, 3), -- Produit 4 composé de Matériau 3
(5, 4), -- Produit 5 composé de Matériau 4
(5, 5); -- Produit 5 composé de Matériau 5

INSERT INTO Noter (idClient, idProduit, titre, note, contenu, etat, date) VALUES
(1, 1, 'Très bon produit', 4.5, 'J''ai vraiment apprécié ce produit, il correspond parfaitement à mes attentes.', 'Validé', '2023-05-15'),
(3, 2, 'Excellent rapport qualité-prix', 5.0, 'Produit de très bonne qualité, surtout pour son prix.', 'Validé', '2023-04-10'),
(1, 4, 'À éviter', 1.5, 'Produit fragile et peu fonctionnel, je suis très déçu de mon achat.', 'Validé', '2023-07-02'),
(4, 5, 'Très satisfait', 4.0, 'Bonne qualité, livraison rapide.', 'En attente', '2023-08-05');

INSERT INTO Concerner (idProduit, idCommande, quantite) VALUES
(1, 1, 2),
(2, 8, 1),
(3, 3, 3),
(4, 7, 1),
(5, 5, 2);
