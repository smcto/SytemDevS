-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost:3306
-- Généré le :  Dim 19 Mai 2019 à 08:16
-- Version du serveur :  5.7.26-0ubuntu0.16.04.1
-- Version de PHP :  7.3.5-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `selfizee_crm_09052019`
--

-- --------------------------------------------------------

--
-- Structure de la table `secteur_geographiques`
--

CREATE TABLE `secteur_geographiques` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `secteur_geographiques`
--

INSERT INTO `secteur_geographiques` (`id`, `nom`, `description`) VALUES
(1, 'Grand Ouest', NULL),
(2, 'Ile de France', NULL),
(3, 'Est', NULL),
(4, 'Sud-Ouest', NULL),
(5, 'Sud-Est', NULL),
(6, 'Nord', NULL),
(7, 'Centre', NULL),
(8, 'Suisse', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `secteur_geographiques`
--
ALTER TABLE `secteur_geographiques`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `secteur_geographiques`
--
ALTER TABLE `secteur_geographiques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
