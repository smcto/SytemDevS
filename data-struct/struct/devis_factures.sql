-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 25 juin 2020 à 09:57
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
-- Structure de la table `devis_factures`
--

CREATE TABLE `devis_factures` (
  `id` int(11) NOT NULL,
  `indent` varchar(100) DEFAULT NULL,
  `objet` text NOT NULL,
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
  `status` enum('draft','expedie','lu','done','refused','paid','accepted','acompte','canceled','sent','expired','billed','partially-billed') NOT NULL DEFAULT 'draft',
  `position_type` enum('pro','particulier','') DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `total_ttc` decimal(10,2) DEFAULT NULL,
  `total_ht` decimal(10,2) DEFAULT NULL,
  `total_reduction` decimal(10,2) DEFAULT NULL,
  `total_remise` decimal(10,2) DEFAULT NULL,
  `total_tva` decimal(10,2) DEFAULT NULL,
  `is_model` tinyint(1) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `modele_devis_factures_category_id` int(11) DEFAULT NULL,
  `modele_devis_factures_sous_category_id` int(11) DEFAULT NULL,
  `categorie_tarifaire` enum('ht','ttc') DEFAULT 'ht',
  `client_nom` varchar(255) DEFAULT NULL,
  `client_cp` varchar(255) DEFAULT NULL,
  `client_ville` varchar(255) DEFAULT NULL,
  `client_adresse` varchar(255) DEFAULT NULL,
  `client_country` varchar(255) DEFAULT NULL,
  `display_tva` tinyint(2) DEFAULT 0,
  `uuid` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `devis_factures_antennes`
--

CREATE TABLE `devis_factures_antennes` (
  `id` int(11) NOT NULL,
  `devis_facture_id` int(11) NOT NULL,
  `antenne_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `devis_factures_preferences`
--

CREATE TABLE `devis_factures_preferences` (
  `id` int(11) NOT NULL,
  `moyen_reglements` text DEFAULT NULL COMMENT 'type json',
  `delai_reglements` enum('commande','30j','15j','reception','') DEFAULT NULL,
  `info_bancaire_id` int(11) DEFAULT NULL,
  `accompte_value` decimal(10,2) DEFAULT NULL,
  `accompte_unity` enum('%','€') DEFAULT NULL,
  `is_text_loi_displayed` tinyint(1) NOT NULL DEFAULT 0,
  `text_loi` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `adress_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `devis_factures_preferences`
--

INSERT INTO `devis_factures_preferences` (`id`, `moyen_reglements`, `delai_reglements`, `info_bancaire_id`, `accompte_value`, `accompte_unity`, `is_text_loi_displayed`, `text_loi`, `note`, `adress_id`) VALUES
(1, '{\"cheque\":\"1\",\"virement\":\"1\",\"prelevement\":\"0\",\"carte\":\"1\",\"especes\":\"0\",\"billet\":\"0\"}', '30j', 2, '30.00', '%', 1, 'En cas de retard de paiement, une pénalité égale à 3 fois le taux d’intérêt légal sera exigible (loi du 31/12/93) et une indemnité forfaitaire pour frais derecouvrement de 40 euros sera appliquée (article L.441-6)', 'Un acompte de 30% est à régler à signature du devis pour validation', 1);

-- --------------------------------------------------------

--
-- Structure de la table `devis_factures_produits`
--

CREATE TABLE `devis_factures_produits` (
  `id` int(11) NOT NULL,
  `titre` int(11) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `quantite_usuelle` int(11) DEFAULT NULL,
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
  `devis_facture_id` int(11) DEFAULT NULL,
  `catalog_produit_id` int(11) DEFAULT NULL,
  `type_ligne` enum('produit','titre','commentaire','saut_ligne','saut_page','sous_total') NOT NULL DEFAULT 'produit',
  `i_position` int(11) NOT NULL DEFAULT 0,
  `line_option` tinyint(2) DEFAULT NULL,
  `tva` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `modele_devis_factures_categories`
--

CREATE TABLE `modele_devis_factures_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `modele_devis_factures_sous_categories`
--

CREATE TABLE `modele_devis_factures_sous_categories` (
  `id` int(11) NOT NULL,
  `modele_devis_factures_category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `devis_factures`
--
ALTER TABLE `devis_factures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Index pour la table `devis_factures_antennes`
--
ALTER TABLE `devis_factures_antennes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `devis_factures_preferences`
--
ALTER TABLE `devis_factures_preferences`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `devis_factures_produits`
--
ALTER TABLE `devis_factures_produits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modele_devis_factures_categories`
--
ALTER TABLE `modele_devis_factures_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modele_devis_factures_sous_categories`
--
ALTER TABLE `modele_devis_factures_sous_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modele_devis_factures_category_id` (`modele_devis_factures_category_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `devis_factures`
--
ALTER TABLE `devis_factures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `devis_factures_antennes`
--
ALTER TABLE `devis_factures_antennes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `devis_factures_preferences`
--
ALTER TABLE `devis_factures_preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `devis_factures_produits`
--
ALTER TABLE `devis_factures_produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `modele_devis_factures_categories`
--
ALTER TABLE `modele_devis_factures_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `modele_devis_factures_sous_categories`
--
ALTER TABLE `modele_devis_factures_sous_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
