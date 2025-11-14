-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 14 mai 2020 à 08:34
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
-- Structure de la table `modeles_mails`
--

CREATE TABLE `modeles_mails` (
  `id` int(11) NOT NULL,
  `nom_interne` varchar(255) NOT NULL,
  `objet` varchar(255) NOT NULL,
  `contenu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modeles_mails`
--

INSERT INTO `modeles_mails` (`id`, `nom_interne`, `objet`, `contenu`) VALUES
(1, 'test modèle', 'Test Models devis', 'Mbola tsy wysig ity fa atao test eto fotsiny aloh\r\nfa le gras zan zao no mbola tsy mande'),
(2, 'test modèle', 'Test Models devis', 'Mbola tsy wysig ity fa atao test eto fotsiny al<u>oh\r\nfa le gras zan zao no mbola</u> tsy mande');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `modeles_mails`
--
ALTER TABLE `modeles_mails`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `modeles_mails`
--
ALTER TABLE `modeles_mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
