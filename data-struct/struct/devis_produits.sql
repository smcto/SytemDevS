-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 04 mai 2020 à 08:15
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
-- Structure de la table `devis_produits`
--

DROP TABLE IF EXISTS `devis_produits`;
CREATE TABLE IF NOT EXISTS `devis_produits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` int(11) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `quantite_usuelle` int(11) DEFAULT NULL,
  `prix_reference_ht` decimal(10,2) DEFAULT NULL,
  `nom_interne` varchar(255) DEFAULT NULL,
  `nom_commercial` varchar(11) DEFAULT NULL,
  `description_commercial` text,
  `commentaire_ligne` text,
  `titre_ligne` varchar(255) DEFAULT NULL,
  `sous_total` decimal(10,2) DEFAULT NULL,
  `devis_id` int(11) DEFAULT NULL,
  `type_ligne` enum('produit','titre','commentaire','saut_ligne','saut_page') NOT NULL DEFAULT 'produit',
  `i_position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
