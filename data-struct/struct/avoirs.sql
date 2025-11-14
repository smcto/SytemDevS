-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 10 août 2020 à 20:19
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
-- Structure de la table `avoirs`
--

CREATE TABLE `avoirs` (
  `id` int(11) NOT NULL,
  `indent` varchar(100) DEFAULT NULL,
  `objet` text DEFAULT NULL,
  `adresse` int(11) DEFAULT NULL,
  `cp` int(11) DEFAULT NULL,
  `ville` int(11) DEFAULT NULL,
  `pays` int(11) DEFAULT NULL,
  `nom_societe` varchar(255) DEFAULT NULL,
  `date_crea` date DEFAULT NULL,
  `date_sign_before` date DEFAULT NULL,
  `ref_commercial_id` varchar(200) DEFAULT NULL COMMENT '-	Le référent commercial à afficher',
  `note` text DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `date_validite` date DEFAULT NULL,
  `moyen_reglements` text DEFAULT NULL,
  `delai_reglements` enum('commande','30j','15j','reception','echeances') DEFAULT NULL,
  `echeance_date` longtext DEFAULT NULL,
  `echeance_value` longtext DEFAULT NULL,
  `text_loi` text DEFAULT NULL,
  `is_text_loi_displayed` tinyint(1) NOT NULL DEFAULT 0,
  `remise_hide_line` tinyint(4) DEFAULT NULL,
  `remise_line` tinyint(4) DEFAULT NULL,
  `remise_global_value` decimal(10,2) DEFAULT NULL,
  `remise_global_unity` enum('%','€') DEFAULT NULL,
  `accompte_value` decimal(10,2) DEFAULT NULL,
  `accompte_unity` enum('%','€') DEFAULT NULL,
  `col_visibility_params` varchar(350) DEFAULT NULL COMMENT 'type json',
  `info_bancaire_id` int(11) DEFAULT NULL,
  `status` enum('draft','fix','partial-payment','paid','delay','canceled','') NOT NULL DEFAULT 'draft',
  `position_type` enum('pro','particulier','') DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `total_ttc` decimal(10,2) DEFAULT NULL,
  `total_ht` decimal(10,2) DEFAULT NULL,
  `total_reduction` decimal(10,2) DEFAULT NULL,
  `total_remise` decimal(10,2) DEFAULT NULL,
  `total_tva` decimal(10,2) DEFAULT NULL,
  `categorie_tarifaire` enum('ht','ttc') DEFAULT 'ht',
  `client_nom` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `client_email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `client_ville` varchar(255) DEFAULT NULL,
  `client_adresse` varchar(255) DEFAULT NULL,
  `client_adresse_2` varchar(255) DEFAULT NULL,
  `client_country` varchar(255) DEFAULT NULL,
  `display_tva` tinyint(2) DEFAULT 0,
  `sellsy_echeances` longtext DEFAULT NULL,
  `sellsy_client_id` int(11) DEFAULT 0,
  `is_in_sellsy` tinyint(1) DEFAULT 0,
  `sellsy_public_url` varchar(500) DEFAULT NULL,
  `sellsy_doc_id` int(11) NOT NULL DEFAULT 0,
  `devis_facture_id` int(11) DEFAULT NULL,
  `commentaire_client` text DEFAULT NULL,
  `commentaire_commercial` text DEFAULT NULL,
  `client_tel` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `sellsy_estimate_id` int(11) DEFAULT NULL,
  `display_virement` tinyint(1) NOT NULL DEFAULT 0,
  `display_cheque` tinyint(1) NOT NULL DEFAULT 0,
  `client_contact_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avoirs`
--
ALTER TABLE `avoirs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avoirs`
--
ALTER TABLE `avoirs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
