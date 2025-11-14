-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 21 sep. 2018 à 16:02
-- Version du serveur :  10.1.33-MariaDB
-- Version de PHP :  7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `selfizee_crm_04092018`
--

-- --------------------------------------------------------

--
-- Structure de la table `stripe_csvs`
--

CREATE TABLE `stripe_csvs` (
  `id` int(11) NOT NULL,
  `id_stripe` varchar(255) DEFAULT NULL,
  `stripe_csv_file_id` int(11) DEFAULT NULL,
  `date_import` datetime DEFAULT NULL,
  `filename_origin` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `seller_message` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `amount_refunded` double DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `converted_amount` double DEFAULT NULL,
  `converted_amount_refunded` double DEFAULT NULL,
  `fee` int(11) DEFAULT NULL,
  `tax` int(11) DEFAULT NULL,
  `converted_currency` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `statement_descriptor` varchar(255) DEFAULT NULL,
  `customerId` int(11) DEFAULT NULL,
  `customer_description` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `captured` varchar(255) DEFAULT NULL,
  `cardId` varchar(255) DEFAULT NULL,
  `invoiceId` varchar(255) DEFAULT NULL,
  `transfert` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `stripe_csvs`
--
ALTER TABLE `stripe_csvs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `stripe_csvs`
--
ALTER TABLE `stripe_csvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=352;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
