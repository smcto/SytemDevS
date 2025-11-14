-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 25 sep. 2018 à 07:46
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
-- Structure de la table `nature_evenements`
--

DROP TABLE IF EXISTS `nature_evenements`;
CREATE TABLE IF NOT EXISTS `nature_evenements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `options` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `nature_evenements`
--

INSERT INTO `nature_evenements` (`id`, `type`, `options`) VALUES
(1, 'Particulier', 'Mariage'),
(2, 'Particulier', 'Anniversaire'),
(3, 'Particulier', 'Bar Mitzvah'),
(4, 'Particulier', 'Soirée privée'),
(5, 'Particulier', 'Autre'),
(6, 'Professionnel', 'Cocktail / réception'),
(7, 'Professionnel', 'Inauguration'),
(8, 'Professionnel', 'Anniversaire'),
(9, 'Professionnel', 'Séminaire / AC'),
(10, 'Professionnel', 'Salon / foire'),
(11, 'Professionnel', 'Animation commerciale'),
(12, 'Professionnel', 'Soirée / évenement d\'entreprise'),
(13, 'Professionnel', 'Evenement sportif'),
(14, 'Professionnel', 'Autre');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
