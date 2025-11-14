-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 15 sep. 2020 à 12:52
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
-- Structure de la table `sms_autos`
--

CREATE TABLE `sms_autos` (
  `id` int(11) NOT NULL,
  `lien_pdf_classik` varchar(255) NOT NULL,
  `lien_pdf_spherik` varchar(255) NOT NULL,
  `contenu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `sms_autos`
--

INSERT INTO `sms_autos` (`id`, `lien_pdf_classik`, `lien_pdf_spherik`, `contenu`) VALUES
(1, 'https://selfizee.fr/docs/brochure-selfizee-classik.pdf', 'https://selfizee.fr/docs/brochure-selfizee-spherik.pdf', 'IMPORTANT : Le jour J est proche ! Pour une expérience Selfizee sereine, conservez notre UNIQUE numéro d\'assistance technique : 0638199606 . Le guide d\'utilisation de la borne est à retrouver sur ce lien : #MANUEL_BORNE# \r\n(Numéro et Guide à transmettre à votre référent montage de la borne)');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `sms_autos`
--
ALTER TABLE `sms_autos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `sms_autos`
--
ALTER TABLE `sms_autos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
