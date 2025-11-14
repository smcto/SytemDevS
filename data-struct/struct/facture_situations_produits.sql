-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 26 oct. 2020 à 08:32
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
-- Structure de la table `facture_situations_produits`
--

DROP TABLE IF EXISTS `facture_situations_produits`;
CREATE TABLE `facture_situations_produits` (
  `id` int(11) NOT NULL,
  `titre` int(11) DEFAULT NULL,
  `reference` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `quantite_usuelle` decimal(10,2) DEFAULT NULL,
  `prix_reference_ht` decimal(10,2) DEFAULT NULL,
  `catalog_unites_id` int(11) DEFAULT NULL,
  `remise_value` decimal(10,2) DEFAULT NULL,
  `remise_unity` enum('%','€') CHARACTER SET latin1 DEFAULT NULL,
  `nom_interne` text DEFAULT NULL,
  `nom_commercial` varchar(11) CHARACTER SET latin1 DEFAULT NULL,
  `description_commercial` text DEFAULT NULL,
  `commentaire_ligne` text DEFAULT NULL,
  `titre_ligne` text DEFAULT NULL,
  `sous_total` decimal(10,2) DEFAULT NULL,
  `facture_situation_id` int(11) DEFAULT NULL,
  `catalog_produits_id` int(11) DEFAULT NULL,
  `type_ligne` enum('produit','titre','commentaire','saut_ligne','saut_page','sous_total','abonnement') CHARACTER SET latin1 NOT NULL DEFAULT 'produit',
  `i_position` int(11) NOT NULL DEFAULT 0,
  `line_option` tinyint(2) DEFAULT NULL,
  `tva` decimal(10,2) DEFAULT NULL,
  `facture_pourcentage` decimal(10,2) DEFAULT NULL,
  `facture_euro` decimal(10,2) DEFAULT NULL,
  `avancement_pourcentage` decimal(10,2) DEFAULT NULL,
  `avancement_euro` decimal(10,2) DEFAULT NULL,
  `avancement_quantite` decimal(10,2) DEFAULT NULL,
  `montant_ht` decimal(10,2) DEFAULT 0.00,
  `montant_ttc` decimal(10,2) DEFAULT 0.00
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `facture_situations_produits`
--
ALTER TABLE `facture_situations_produits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `facture_situations_produits`
--
ALTER TABLE `facture_situations_produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
