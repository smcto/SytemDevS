-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 10 août 2020 à 20:21
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.6

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
-- Structure de la table `avoirs_produits`
--

CREATE TABLE `avoirs_produits` (
  `id` int(11) NOT NULL,
  `titre` int(11) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `quantite_usuelle` decimal(10,2) DEFAULT NULL,
  `prix_reference_ht` decimal(10,2) DEFAULT NULL,
  `catalog_unites_id` int(11) DEFAULT NULL,
  `remise_value` decimal(10,2) DEFAULT NULL,
  `remise_unity` enum('%','€') DEFAULT NULL,
  `nom_interne` varchar(255) DEFAULT NULL,
  `nom_commercial` varchar(11) DEFAULT NULL,
  `description_commercial` text DEFAULT NULL,
  `commentaire_ligne` text DEFAULT NULL,
  `titre_ligne` varchar(255) DEFAULT NULL,
  `sous_total` decimal(10,2) DEFAULT NULL,
  `avoir_id` int(11) DEFAULT NULL,
  `catalog_produit_id` int(11) DEFAULT NULL,
  `type_ligne` enum('produit','titre','commentaire','saut_ligne','saut_page','sous_total') NOT NULL DEFAULT 'produit',
  `i_position` int(11) NOT NULL DEFAULT 0,
  `line_option` tinyint(2) DEFAULT NULL,
  `tva` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avoirs_produits`
--
ALTER TABLE `avoirs_produits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avoirs_produits`
--
ALTER TABLE `avoirs_produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
