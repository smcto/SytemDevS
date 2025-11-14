-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mer. 08 juil. 2020 à 08:55
-- Version du serveur :  10.3.23-MariaDB-1:10.3.23+maria~stretch-log
-- Version de PHP :  7.3.19-1+0~20200612.60+debian9~1.gbp6c8fe1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `crm_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `devis_type_docs`
--

DROP TABLE IF EXISTS `devis_type_docs`;
CREATE TABLE `devis_type_docs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `devis_type_docs`
--

INSERT INTO `devis_type_docs` (`id`, `nom`, `image`) VALUES
(1, 'selfizee', 'devis-selfizee-fond.jpg'),
(2, 'digitea', 'devis-digitea-fond.jpg'),
(3, 'brandeet', 'devis-brandeet-fond.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `devis_type_docs`
--
ALTER TABLE `devis_type_docs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `devis_type_docs`
--
ALTER TABLE `devis_type_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

ALTER TABLE `devis` ADD `devis_type_doc_id` INT NULL AFTER `lieu_retrait`; 

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
