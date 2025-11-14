-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 03 déc. 2020 à 18:52
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `crm_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `bons_livraisons`
--

DROP TABLE IF EXISTS `bons_livraisons`;
CREATE TABLE `bons_livraisons` (
  `id` int(11) NOT NULL,
  `devi_id` int(11) NOT NULL,
  `indent` varchar(255) DEFAULT NULL,
  `bons_commande_id` int(11) NOT NULL,
  `original_bp_id` int(11) DEFAULT NULL COMMENT 'bp parentes. si null original_bp_id = bons_preparation_id',
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_depart_atelier` date DEFAULT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `nombre_palettes` decimal(10,2) DEFAULT NULL,
  `nombre_cartons` decimal(10,2) DEFAULT NULL,
  `poids` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `bons_livraisons_produits`
--

DROP TABLE IF EXISTS `bons_livraisons_produits`;
CREATE TABLE `bons_livraisons_produits` (
  `id` int(11) NOT NULL,
  `bons_livraison_id` int(11) NOT NULL,
  `catalog_produits_id` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `description_commercial` text DEFAULT NULL,
  `quantite_livree` decimal(10,2) DEFAULT NULL,
  `quantite` decimal(10,2) DEFAULT NULL,
  `rest` decimal(10,2) DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `i_position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bons_livraisons`
--
ALTER TABLE `bons_livraisons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devi_id` (`devi_id`),
  ADD KEY `bons_preparation_id` (`bons_commande_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `bons_livraisons_produits`
--
ALTER TABLE `bons_livraisons_produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bons_livraison_id` (`bons_livraison_id`),
  ADD KEY `catalog_produits_id` (`catalog_produits_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bons_livraisons`
--
ALTER TABLE `bons_livraisons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bons_livraisons_produits`
--
ALTER TABLE `bons_livraisons_produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
