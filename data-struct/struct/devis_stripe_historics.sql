-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 29 juin 2020 à 14:52
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

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
-- Structure de la table `devis_stripe_historics`
--

DROP TABLE IF EXISTS `devis_stripe_historics`;
CREATE TABLE IF NOT EXISTS `devis_stripe_historics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(30) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `description` text,
  `amount` int(11) DEFAULT NULL,
  `failure_message` text,
  `payment_method` varchar(255) DEFAULT NULL,
  `receipt_email` varchar(150) DEFAULT NULL,
  `receipt_url` varchar(350) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created` bigint(20) DEFAULT NULL,
  `devis_id` int(11) DEFAULT NULL,
  `devis_echeance_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
