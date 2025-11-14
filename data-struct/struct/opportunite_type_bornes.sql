-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 25 août 2020 à 08:49
-- Version du serveur :  10.4.13-MariaDB
-- Version de PHP : 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `crm`
--

-- --------------------------------------------------------

--
-- Structure de la table `opportunite_type_bornes`
--

CREATE TABLE `opportunite_type_bornes` (
  `id` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `opportunite_type_bornes`
--

INSERT INTO `opportunite_type_bornes` (`id`, `nom`) VALUES
(1, 'CLASSIK & SPHERIK'),
(2, 'CLASSIK'),
(3, 'SPHERIK');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `opportunite_type_bornes`
--
ALTER TABLE `opportunite_type_bornes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `opportunite_type_bornes`
--
ALTER TABLE `opportunite_type_bornes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


ALTER TABLE `opportunites` CHANGE `type_borne` `opportunite_type_borne_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `opportunites` CHANGE `impression` `impression` INT(11) NULL;
ALTER TABLE `opportunites` CHANGE `option_fond_vert` `option_fond_vert` TINYINT(1) NULL;
ALTER TABLE `opportunites` ADD `lieu_evenement` VARCHAR(250) NULL AFTER `impression`;
