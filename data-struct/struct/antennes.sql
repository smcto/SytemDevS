-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 29 juin 2018 à 19:31
-- Version du serveur :  5.7.19
-- Version de PHP :  7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `selfizee_crm`
--

-- --------------------------------------------------------

--
-- Structure de la table `antennes`
--

DROP TABLE IF EXISTS `antennes`;
CREATE TABLE IF NOT EXISTS `antennes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lieu_type_id` int(11) NOT NULL,
  `ville_principale` varchar(45) DEFAULT NULL,
  `ville_excate` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `cp` int(11) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `photo_lieu` varchar(50) NOT NULL,
  `precision_lieu` text,
  `commentaire` varchar(255) DEFAULT NULL,
  `etat_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_antennes_etats1_idx` (`etat_id`),
  KEY `fk_antennes_lieu_types1_idx` (`lieu_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `antennes`
--


--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `antennes`
--
ALTER TABLE `antennes`
  ADD CONSTRAINT `fk_antennes_etats1` FOREIGN KEY (`etat_id`) REFERENCES `etats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_antennes_lieu_types1` FOREIGN KEY (`lieu_type_id`) REFERENCES `lieu_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
