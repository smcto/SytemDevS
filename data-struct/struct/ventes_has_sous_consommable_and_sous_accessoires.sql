-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 27 fév. 2020 à 06:50
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `crm_app_selfizee`
--

-- --------------------------------------------------------

--
-- Structure de la table `ventes_has_sous_consommables`
--
DROP TABLE IF EXISTS `ventes_belongs_consommables`;
DROP TABLE IF EXISTS `ventes_has_sous_consommables`;
CREATE TABLE IF NOT EXISTS `ventes_has_sous_consommables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ventes_consommable_id` int(11) NOT NULL,
  `sous_types_consommable_id` int(11) NOT NULL,
  `type_consommable_id` int(11) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

DROP TABLE IF EXISTS `ventes_has_sous_accessoires`;
CREATE TABLE IF NOT EXISTS `ventes_has_sous_accessoires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ventes_consommable_id` int(11) NOT NULL,
  `accessoire_id` int(11) DEFAULT NULL,
  `sous_accessoire_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;
