DROP DATABASE IF EXISTS DW; -- Crée table si elle n'existe pas
CREATE DATABASE DW;
USE DW;

SHOW ENGINES;
SELECT 
    *
FROM
    INFORMATION_SCHEMA.ENGINES;
set global default_storage_engine=INNODB;
-- ALTER USER 'cytech'@'localhost' IDENTIFIED BY '';
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

SELECT * FROM client;
SELECT user,host,password FROM mysql.user;