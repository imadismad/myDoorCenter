DROP DATABASE IF EXISTS DW; -- Crée table si elle n'existe pas
CREATE DATABASE DW;
USE DW;

CREATE TABLE Produit (
    id INT PRIMARY KEY,
    nom VARCHAR(255),
    type VARCHAR(100),
    prixUnitaire DECIMAL(10, 2),
    lienPage VARCHAR(255),
    description TEXT,
    nomImage VARCHAR(255)
);

CREATE TABLE Client (
    id INT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    rue VARCHAR(255),
    CP VARCHAR(10),
    ville VARCHAR(100),
    pays VARCHAR(100),
    mail VARCHAR(255),
    telephone VARCHAR(20),
    mdp VARCHAR(255)
);

CREATE TABLE Commande (
    id INT PRIMARY KEY,
    date DATE,
    modePaiement VARCHAR(100),
    numFacture VARCHAR(50),
    idClient INT,
    FOREIGN KEY (idClient) REFERENCES Client(id)
);

CREATE TABLE Materiau (
    id INT PRIMARY KEY,
    nom VARCHAR(100),
    densite DECIMAL(10, 2),
    masseVolumique DECIMAL(10, 2),
    type VARCHAR(100)
);

CREATE TABLE Entrepot (
    id INT PRIMARY KEY,
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
    id INT PRIMARY KEY,
    idProduit INT,
    idEntrepot INT,
    FOREIGN KEY (idProduit) REFERENCES Produit(id),
    FOREIGN KEY (idEntrepot) REFERENCES Entrepot(id)
);

CREATE TABLE Livraison (
    id INT PRIMARY KEY,
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
    idProduit INT,
    idCommande INT,
    quantite INT,
    PRIMARY KEY (idProduit, idCommande),
    FOREIGN KEY (idProduit) REFERENCES Produit(id),
    FOREIGN KEY (idCommande) REFERENCES Commande(id)
);
