SET GLOBAL validate_password.policy = 0;
SET GLOBAL validate_password.number_count = 0;
SET GLOBAL validate_password.special_char_count = 0;
SET GLOBAL validate_password.mixed_case_count = 0;
SET GLOBAL validate_password.length = 0;
DROP USER IF EXISTS 'TestBDD'@'localhost';
CREATE USER 'TestBDD'@'localhost' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON DW.* TO 'TestBDD'@'localhost';
FLUSH PRIVILEGES;

DROP DATABASE IF EXISTS DW; -- Crée table si elle n'existe pas
CREATE DATABASE DW;
USE DW;

CREATE TABLE Produit (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    type VARCHAR(100),
    prixUnitaire DECIMAL(10, 2),
    description TEXT,
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
