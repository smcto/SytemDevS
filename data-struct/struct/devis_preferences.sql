-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 20 mai 2020 à 12:00
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
-- Structure de la table `devis_preferences`
--

DROP TABLE IF EXISTS `devis_preferences`;
CREATE TABLE IF NOT EXISTS `devis_preferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moyen_reglements` text COMMENT 'type json',
  `delai_reglements` enum('commande','30j','15j','reception','') DEFAULT NULL,
  `info_bancaire_id` int(11) DEFAULT NULL,
  `accompte_value` decimal(10,2) DEFAULT NULL,
  `accompte_unity` enum('%','€') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `devis_preferences`
--

INSERT INTO `devis_preferences` (`id`, `moyen_reglements`, `delai_reglements`, `info_bancaire_id`, `accompte_value`, `accompte_unity`) VALUES
(1, '{\"cheque\":\"0\",\"virement\":\"0\",\"prelevement\":\"0\",\"carte\":\"1\",\"especes\":\"1\",\"billet\":\"0\"}', '30j', 2, '14.00', '€');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE `devis` DROP `accompte`;