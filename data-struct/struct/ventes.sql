-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 08 jan. 2020 à 06:25
-- Version du serveur :  5.7.21
-- Version de PHP :  7.0.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `crm_app_selfizee`
--

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

DROP TABLE IF EXISTS `ventes`;
CREATE TABLE IF NOT EXISTS `ventes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facturation_accord_signature_path` varchar(255) DEFAULT NULL,
  `contact_crea_telfixe` varchar(255) DEFAULT NULL,
  `contact_crea_email` varchar(255) DEFAULT NULL,
  `client_adresse` varchar(255) DEFAULT NULL,
  `client_email` varchar(255) DEFAULT NULL,
  `client_prenom` varchar(255) DEFAULT NULL,
  `client_nom` varchar(255) DEFAULT NULL,
  `is_livraison_adresse_diff_than_client_addr` tinyint(1) DEFAULT NULL,
  `facturation_other_email` varchar(255) DEFAULT NULL,
  `facturation_other_tel` varchar(255) DEFAULT NULL,
  `facturation_other_ville` varchar(255) DEFAULT NULL,
  `facturation_other_cp` varchar(255) DEFAULT NULL,
  `facturation_other_adress` varchar(255) DEFAULT NULL,
  `facturation_other_society_name` varchar(255) DEFAULT NULL,
  `livraison_crea_telfixe` varchar(255) DEFAULT NULL,
  `livraison_crea_telmobile` varchar(255) DEFAULT NULL,
  `livraison_crea_email` varchar(255) DEFAULT NULL,
  `livraison_crea_fonction` varchar(255) DEFAULT NULL,
  `livraison_crea_fullname` varchar(255) DEFAULT NULL,
  `logiciel` varchar(255) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `proprietaire` text,
  `project_is_same_contact_as_client` tinyint(1) DEFAULT '0',
  `livraison_infos_sup` text,
  `is_agence` enum('0','1') DEFAULT NULL,
  `project_crea_note` text,
  `entites_sellsy` int(11) DEFAULT NULL,
  `nb_mois` enum('','36','24') DEFAULT NULL,
  `type_vente` enum('achat_direct','loca_fi','') DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT 'qui ont profil commercial',
  `livraison_service` text,
  `livraison_date_first_usage` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_custom_gravure` tinyint(1) DEFAULT NULL,
  `gravure_note` text,
  `materiel_note` text,
  `is_carton_bobine` enum('0','1','') DEFAULT NULL,
  `is_fond_vert` enum('0','1','') DEFAULT NULL,
  `is_photocall` enum('0','1','') DEFAULT NULL,
  `is_magnet` enum('0','1','') DEFAULT NULL,
  `carton_bobine_note` text,
  `fond_vert_note` text,
  `photocall_note` text,
  `magnet_note` text,
  `contact_crea_note` text,
  `is_contact_crea_different_than_contact_client` tinyint(1) DEFAULT NULL,
  `is_without_imprimante` tinyint(1) DEFAULT NULL,
  `materiel_other_note` text,
  `config_crea_note` text,
  `facturation_entity_jurid` enum('client','grenke','leasecom','autre') DEFAULT NULL,
  `facturation_society_name` varchar(255) DEFAULT NULL,
  `facturation_adress` varchar(255) DEFAULT NULL,
  `facturation_email` varchar(255) DEFAULT NULL,
  `facturation_tel` varchar(255) DEFAULT NULL,
  `facturation_cp` varchar(150) DEFAULT NULL,
  `facturation_ville` varchar(255) DEFAULT NULL,
  `facturation_date_signature` datetime DEFAULT NULL,
  `facturation_accord_signature` varchar(255) DEFAULT NULL,
  `livraison_is_client_direct` tinyint(1) DEFAULT NULL,
  `livraison_is_client_livr_adress` tinyint(4) DEFAULT NULL,
  `project_crea_telfixe` varchar(100) DEFAULT NULL,
  `project_crea_telmobile` varchar(100) DEFAULT NULL,
  `project_crea_fonction` varchar(100) DEFAULT NULL,
  `project_crea_fullname` varchar(255) DEFAULT NULL,
  `livraison_horaire` varchar(150) DEFAULT NULL,
  `livraison_adress` varchar(255) DEFAULT NULL,
  `livraison_client_indirect_name` varchar(150) DEFAULT NULL,
  `contact_crea_telmobile` varchar(250) DEFAULT NULL,
  `contact_crea_fonction` varchar(250) DEFAULT NULL,
  `contact_crea_fullname` varchar(250) DEFAULT NULL,
  `is_allow_to_communicate_achat` tinyint(1) DEFAULT NULL,
  `is_livraison_different_than_contact_client` tinyint(1) DEFAULT NULL,
  `equipement_imp_id` int(11) DEFAULT NULL,
  `equipement_apn_id` int(11) DEFAULT NULL,
  `is_marque_blanche` tinyint(1) DEFAULT NULL,
  `is_housse_protection` tinyint(1) DEFAULT NULL,
  `is_valise_transport` tinyint(4) DEFAULT NULL,
  `couleur_borne_id` int(11) DEFAULT NULL,
  `model_borne_id` int(11) DEFAULT NULL,
  `gamme_borne_id` int(11) DEFAULT NULL,
  `project_client_id` int(11) DEFAULT NULL,
  `livraison_client_id` int(11) DEFAULT NULL,
  `contact_crea_client_id` int(11) DEFAULT NULL,
  `project_note` text,
  `is_client_in_sellsy` tinyint(1) NOT NULL DEFAULT '0',
  `client_name` varchar(255) DEFAULT NULL,
  `commercial_telfixe` varchar(255) DEFAULT NULL,
  `commercial_telmobile` varchar(255) DEFAULT NULL,
  `commercial_email` varchar(255) DEFAULT NULL,
  `commercial_fullname` varchar(255) DEFAULT NULL,
  `contact_client_id` int(11) DEFAULT NULL,
  `client_addr_lat` decimal(10,8) DEFAULT NULL,
  `client_addr_lng` decimal(10,8) DEFAULT NULL,
  `facturation_achat_type` tinyint(1) DEFAULT '0',
  `facturation_montant_ht` decimal(10,2) DEFAULT NULL,
  `type_equipement_id` int(11) DEFAULT NULL,
  `livraison_client_adresse` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
