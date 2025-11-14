-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 19 mai 2020 à 14:18
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
-- Structure de la table `modeles_mails_pjs`
--

CREATE TABLE `modeles_mails_pjs` (
  `id` int(11) NOT NULL,
  `modeles_mails_id` int(11) NOT NULL,
  `nom_fichier` varchar(255) NOT NULL,
  `chemin` varchar(255) NOT NULL,
  `nom_origine` varchar(250) DEFAULT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modeles_mails_pjs`
--

INSERT INTO `modeles_mails_pjs` (`id`, `modeles_mails_id`, `nom_fichier`, `chemin`, `nom_origine`, `created`, `modified`) VALUES
(4, 3, '0c024f34-37f1-4a3d-8e47-6bad65ffaaab.jpg', 'C:\\xampp\\htdocs\\crm-selfizee\\webroot\\uploads\\pjs\\0c024f34-37f1-4a3d-8e47-6bad65ffaaab.jpg', NULL, '2020-05-19', '2020-05-19'),
(8, 3, '4a9d9e41-37e7-4389-bc00-d51304ad5ea1.pdf', 'C:\\xampp\\htdocs\\crm-selfizee\\webroot\\uploads\\pjs\\4a9d9e41-37e7-4389-bc00-d51304ad5ea1.pdf', NULL, '2020-05-19', '2020-05-19');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `modeles_mails_pjs`
--
ALTER TABLE `modeles_mails_pjs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `modeles_mails_pjs`
--
ALTER TABLE `modeles_mails_pjs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
