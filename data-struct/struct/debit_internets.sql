-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 08 août 2018 à 11:10
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
-- Structure de la table `debit_internets`
--

DROP TABLE IF EXISTS `debit_internets`;
CREATE TABLE IF NOT EXISTS `debit_internets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valeur` varchar(25) NOT NULL,
  `information` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `debit_internets`
--

INSERT INTO `debit_internets` (`id`, `valeur`, `information`, `created`, `modified`) VALUES
(1, 'Très bon', 'Excellent avec vitesse très haut...', '2018-08-08 11:05:22', '2018-08-08 11:05:22'),
(2, 'Bon', 'Débit bon', '2018-08-08 11:05:45', '2018-08-08 11:05:45'),
(3, 'Faible', 'Débit pas bon', '2018-08-08 11:06:03', '2018-08-08 11:06:03'),
(4, 'Très médiocre', 'Débit pourie', '2018-08-08 11:06:26', '2018-08-08 11:06:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
