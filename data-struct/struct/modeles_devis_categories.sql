-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 22 mai 2020 à 10:31
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `crm_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `modele_devis_categories`
--

CREATE TABLE `modele_devis_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modele_devis_categories`
--

-- --------------------------------------------------------

--
-- Structure de la table `modele_devis_sous_categories`
--

CREATE TABLE `modele_devis_sous_categories` (
  `id` int(11) NOT NULL,
  `modele_devis_categories_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modele_devis_sous_categories`
--

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `modele_devis_categories`
--
ALTER TABLE `modele_devis_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modele_devis_sous_categories`
--
ALTER TABLE `modele_devis_sous_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modele_devis_categories_id` (`modele_devis_categories_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `modele_devis_categories`
--
ALTER TABLE `modele_devis_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `modele_devis_sous_categories`
--
ALTER TABLE `modele_devis_sous_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
