-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 27 nov. 2020 à 12:01
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
-- Structure de la table `bons_preparations`
--

DROP TABLE IF EXISTS `bons_preparations`;
CREATE TABLE `bons_preparations` (
  `id` int(11) NOT NULL,
  `devi_id` int(11) NOT NULL,
  `bons_commande_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `indent` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `type_date` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `statut` enum('en_attente','en_prepa','pret_exp','expedie','') DEFAULT 'en_attente',
  `date_depart_atelier` date DEFAULT NULL,
  `nombre_palettes` decimal(10,2) DEFAULT NULL,
  `nombre_cartons` decimal(10,2) DEFAULT NULL,
  `poids` decimal(10,2) DEFAULT NULL,
  `bons_preparation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `bons_preparations_produits`
--

DROP TABLE IF EXISTS `bons_preparations_produits`;
CREATE TABLE `bons_preparations_produits` (
  `id` int(11) NOT NULL,
  `bons_preparation_id` int(11) NOT NULL,
  `catalog_produits_id` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `description_commercial` text DEFAULT NULL,
  `quantite` decimal(10,2) NOT NULL,
  `quantite_livree` decimal(10,2) DEFAULT NULL,
  `rest_a_livrer` decimal(10,2) DEFAULT NULL,
  `rest` decimal(10,2) DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `statut` enum('complet','incomplet','attente_traitement','') DEFAULT 'attente_traitement'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bons_preparations`
--
ALTER TABLE `bons_preparations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bons_preparations_produits`
--
ALTER TABLE `bons_preparations_produits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bons_preparations`
--
ALTER TABLE `bons_preparations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bons_preparations_produits`
--
ALTER TABLE `bons_preparations_produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
