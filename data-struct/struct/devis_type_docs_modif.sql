-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 08 juil. 2020 à 16:27
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
-- Structure de la table `devis_type_docs`
--

DROP TABLE IF EXISTS `devis_type_docs`;
CREATE TABLE `devis_type_docs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `header` text DEFAULT NULL,
  `footer` text DEFAULT NULL,
  `prefix_num` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `devis_type_docs`
--

INSERT INTO `devis_type_docs` (`id`, `nom`, `image`, `header`, `footer`, `prefix_num`, `created`, `modified`) VALUES
(1, 'selfizee', 'devis-selfizee-fond.jpg', '<p>LOCATION ET VENTE DE BORNE PHOTO EN FRANCE ET INTERNATIONAL.&nbsp;</p>', '<p>SelfizeeTM est une marque de la SAS Konitys au capital de 100 000 SIREN 812 138 936 - APE : 4531Z - Num TVA : FR 02812138931</p>', 'Devis selfizee', '2020-07-08', '2020-07-08'),
(2, 'digitea', 'devis-digitea-fond.jpg', NULL, NULL, 'Devis digitea', '2020-07-08', '2020-07-08'),
(3, 'brandeet', 'devis-brandeet-fond.jpg', NULL, NULL, 'Devis brandeet', '2020-07-08', '0000-00-00');

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
