DROP DATABASE IF EXISTS shoplocal1; 
CREATE DATABASE shoplocal1; 
USE shoplocal1;


DROP user if EXISTS mina@localhost;
CREATE USER IF NOT EXISTS mina@localhost IDENTIFIED BY 'courage';--On crée un utilisateur qui aura tout les droits
GRANT ALL ON shoplocal1.* TO mina@localhost;

CREATE TABLE IF NOT EXISTS `Users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nom` varchar(50)  NULL,
  `motDePasse` varchar(255) NULL,
  `email` varchar(50)  NULL ,
  `photo` varchar(255)  NULL,
  `créé_à` datetime  NULL
 ) ENGINE=InnoDB; 

 CREATE TABLE IF NOT EXISTS `Password_resets`(
      `email` varchar(50)  NULL ,
      `token` varchar(250)  NULL,
      `créé_à` datetime  NULL
 )

 INSERT INTO Users (nom, email) VALUES ('mina', 'mina@amour.com');