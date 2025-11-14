-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 02 sep. 2020 à 11:27
-- Version du serveur :  10.4.13-MariaDB
-- Version de PHP : 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `crm`
--

-- --------------------------------------------------------

--
-- Structure de la table `opportunite_actions`
--

CREATE TABLE `opportunite_actions` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `phrase` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `opportunite_actions`
--

INSERT INTO `opportunite_actions` (`id`, `name`, `phrase`) VALUES
(1, 'Créer', 'a créé l\'opprotunité à'),
(2, 'Ajouter des tags', 'a ajouté des tags à l\'opportunité'),
(3, 'Déplacer dans l\'étape', 'a déplacé cette oppotunité à '),
(4, 'Ajout commentaire', 'a ajouté un commentaire'),
(5, 'modifer l\'info de l\'événement', 'a modifié l\'info de l\'événement'),
(6, 'modifier l\'info du client', 'a modifié l\'info du client'),
(7, 'Ajouter un contact au client', 'ajouter un contact au client'),
(8, 'modifier opportunité', 'a modifié l\'info de l\'opportunité '),
(9, 'changer le statut', 'a changé le statut à'),
(10, 'supprimer tag', 'a supprimé des tags');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `opportunite_actions`
--
ALTER TABLE `opportunite_actions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `opportunite_actions`
--
ALTER TABLE `opportunite_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



UPDATE `opportunite_actions` SET `phrase` = 'a ajouté des tags à l\'opportunité' WHERE `opportunite_actions`.`id` = 2;
INSERT INTO `opportunite_actions` (`id`, `name`, `phrase`) VALUES (NULL, 'supprimer tag', 'a supprimé des tags');
UPDATE `opportunite_actions` SET `name` = 'Ajouter un contact au client' WHERE `opportunite_actions`.`id` = 7;
