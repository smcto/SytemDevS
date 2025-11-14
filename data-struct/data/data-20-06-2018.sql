-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 21 juin 2018 à 12:59
-- Version du serveur :  5.7.19
-- Version de PHP :  7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `selfizee_crm`
--

-- --------------------------------------------------------

--
-- Structure de la table `actu_bornes`
--

DROP TABLE IF EXISTS `actu_bornes`;
CREATE TABLE IF NOT EXISTS `actu_bornes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `contenu` text,
  `borne_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_actu_bornes_bornes1_idx` (`borne_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `actu_bornes_has_medias`
--

DROP TABLE IF EXISTS `actu_bornes_has_medias`;
CREATE TABLE IF NOT EXISTS `actu_bornes_has_medias` (
  `actu_borne_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`actu_borne_id`,`media_id`),
  KEY `fk_actu_bornes_has_medias_medias1_idx` (`media_id`),
  KEY `fk_actu_bornes_has_medias_actu_bornes1_idx` (`actu_borne_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `antennes`
--

DROP TABLE IF EXISTS `antennes`;
CREATE TABLE IF NOT EXISTS `antennes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lieu_type_id` int(11) NOT NULL,
  `ville_principale` varchar(45) DEFAULT NULL,
  `ville_excate` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `cp` int(11) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `precision_lieu` text,
  `commentaire` varchar(255) DEFAULT NULL,
  `etat_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_antennes_etats1_idx` (`etat_id`),
  KEY `fk_antennes_lieu_types1_idx` (`lieu_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `antennes`
--

INSERT INTO `antennes` (`id`, `lieu_type_id`, `ville_principale`, `ville_excate`, `adresse`, `cp`, `longitude`, `latitude`, `precision_lieu`, `commentaire`, `etat_id`, `created`, `modified`) VALUES
(2, 1, 'Paris', 'Paris - 3ème', '', NULL, '', '', '', '', 1, '2018-06-14 18:18:06', '2018-06-14 18:18:06');

-- --------------------------------------------------------

--
-- Structure de la table `bornes`
--

DROP TABLE IF EXISTS `bornes`;
CREATE TABLE IF NOT EXISTS `bornes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `couleur_possible_id` int(255) NOT NULL,
  `expiration_sb` date DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  `is_prette` tinyint(1) NOT NULL,
  `parc_id` int(11) NOT NULL,
  `model_borne_id` int(11) NOT NULL,
  `date_arrive_estime` datetime DEFAULT NULL,
  `antenne_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `long` varchar(45) DEFAULT NULL,
  `lat` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_bornes_parcs1_idx` (`parc_id`),
  KEY `fk_bornes_model_bornes1_idx` (`model_borne_id`),
  KEY `fk_bornes_antennes1_idx` (`antenne_id`),
  KEY `fk_bornes_clients1_idx` (`client_id`),
  KEY `FK_bornes` (`couleur_possible_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bornes`
--

INSERT INTO `bornes` (`id`, `numero`, `couleur_possible_id`, `expiration_sb`, `commentaire`, `is_prette`, `parc_id`, `model_borne_id`, `date_arrive_estime`, `antenne_id`, `client_id`, `ville`, `long`, `lat`, `created`, `modified`) VALUES
(1, 1, 10, '2018-06-12', 'qsdfqsdf qsdf qdsfqsdf<br>', 0, 1, 3, NULL, NULL, 1, 'Ville test', NULL, NULL, '2018-06-14 18:36:14', '2018-06-14 18:36:14'),
(2, 78, 10, '2018-06-12', 'qsdfqsdfqsdfqsdfqsdf', 0, 2, 2, NULL, 2, NULL, '', NULL, NULL, '2018-06-14 18:48:53', '2018-06-14 18:48:53');

-- --------------------------------------------------------

--
-- Structure de la table `bornes_has_medias`
--

DROP TABLE IF EXISTS `bornes_has_medias`;
CREATE TABLE IF NOT EXISTS `bornes_has_medias` (
  `borne_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`borne_id`,`media_id`),
  KEY `fk_bornes_has_medias_medias1_idx` (`media_id`),
  KEY `fk_bornes_has_medias_bornes1_idx` (`borne_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `borne_logiciels`
--

DROP TABLE IF EXISTS `borne_logiciels`;
CREATE TABLE IF NOT EXISTS `borne_logiciels` (
  `borne_id` int(11) NOT NULL,
  `logiciel_id` int(11) NOT NULL,
  PRIMARY KEY (`borne_id`,`logiciel_id`),
  KEY `fk_bornes_has_logiciels_logiciels1_idx` (`logiciel_id`),
  KEY `fk_bornes_has_logiciels_bornes1_idx` (`borne_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `borne_logiciels`
--

INSERT INTO `borne_logiciels` (`borne_id`, `logiciel_id`) VALUES
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `date_de_naissance` date DEFAULT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `cp` int(11) DEFAULT NULL,
  `telephone` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `date_de_naissance`, `adresse`, `ville`, `cp`, `telephone`, `email`, `created`, `modified`) VALUES
(1, 'Test', '', NULL, 'Adresse test', '', NULL, 0, '', '2018-06-14 18:18:56', '2018-06-14 18:18:56');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statut_id` int(11) NOT NULL,
  `situation_id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `info_a_savoir` text,
  `mode_renumeration` text,
  `is_vehicule` tinyint(1) DEFAULT NULL,
  `modele_vehicule` varchar(255) DEFAULT NULL,
  `nbr_borne_transportable_vehicule` int(11) DEFAULT NULL,
  `commentaire_vehicule` text,
  `antenne_id` int(11) NOT NULL,
  `photo_nom` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contacts_antennes1_idx` (`antenne_id`),
  KEY `fk_contacts_statuts1_idx` (`statut_id`),
  KEY `fk_contacts_situations1_idx` (`situation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `couleur_possibles`
--

DROP TABLE IF EXISTS `couleur_possibles`;
CREATE TABLE IF NOT EXISTS `couleur_possibles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `couleur` varchar(45) DEFAULT NULL,
  `model_borne_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_couleur_possibles_type_bornes1_idx` (`model_borne_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `couleur_possibles`
--

INSERT INTO `couleur_possibles` (`id`, `couleur`, `model_borne_id`) VALUES
(1, 'Gris', 7),
(2, 'Rouge', 7),
(3, 'Verte', 8),
(4, 'Blanche', 8),
(5, 'Noir', 9),
(6, 'Noir', 9),
(7, 'Noir', 10),
(8, 'Noir', 10),
(9, 'Noir', 11),
(10, 'Noir', 12),
(11, 'Noir', 12),
(12, 'Noir', 12),
(13, 'Noir', 12),
(14, 'Noir', 12),
(15, 'Noir', 12),
(16, 'Noir', 12),
(17, 'Noir', 12);

-- --------------------------------------------------------

--
-- Structure de la table `dimensions`
--

DROP TABLE IF EXISTS `dimensions`;
CREATE TABLE IF NOT EXISTS `dimensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dimension` varchar(250) DEFAULT NULL,
  `poids` varchar(250) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `model_borne_id` int(11) NOT NULL,
  `partie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dimension_parties_type_bornes1_idx` (`model_borne_id`),
  KEY `FK_dimension_parties` (`partie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `dimensions`
--

INSERT INTO `dimensions` (`id`, `dimension`, `poids`, `created`, `modified`, `model_borne_id`, `partie_id`) VALUES
(1, 'sqdfqsd', 'fqsdfqsdf', '2018-06-14 15:06:44', '2018-06-14 15:06:44', 1, 1),
(2, 'qsdfqs', 'qsdfqsdf', '2018-06-14 15:08:19', '2018-06-14 15:08:19', 11, 1),
(3, 'dfqsdfqsdf', 'qsdfqsdf', '2018-06-14 15:08:19', '2018-06-14 15:08:19', 11, 2),
(4, '12', '13', '2018-06-14 15:50:23', '2018-06-14 16:07:23', 12, 1),
(5, '14', '15', '2018-06-14 15:50:23', '2018-06-14 16:07:23', 12, 2);

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `types` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `statut` varchar(45) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `montant_ht` varchar(255) DEFAULT NULL,
  `montant_ttc` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_documents_clients1_idx` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `etats`
--

DROP TABLE IF EXISTS `etats`;
CREATE TABLE IF NOT EXISTS `etats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valeur` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etats`
--

INSERT INTO `etats` (`id`, `valeur`, `created`, `modified`) VALUES
(1, 'ouvert ', '2018-06-14 18:17:05', '2018-06-14 18:17:05'),
(2, 'à venir ', '2018-06-14 18:17:21', '2018-06-14 18:17:21'),
(3, 'ancienne ', '2018-06-14 18:17:40', '2018-06-14 18:17:40');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

DROP TABLE IF EXISTS `fournisseurs`;
CREATE TABLE IF NOT EXISTS `fournisseurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `cp` int(11) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `description` text,
  `antenne_id` int(11) DEFAULT NULL,
  `commentaire` text,
  `type_fournisseur_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fournisseurs_antennes1_idx` (`antenne_id`),
  KEY `FK_fournisseurs_type` (`type_fournisseur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `nom`, `adresse`, `cp`, `ville`, `created`, `modified`, `description`, `antenne_id`, `commentaire`, `type_fournisseur_id`) VALUES
(2, 'Test', 's', 1500, 's', '2018-06-21 12:21:51', '2018-06-21 12:21:51', 'ss', 90, 's', 1);

-- --------------------------------------------------------

--
-- Structure de la table `lieu_types`
--

DROP TABLE IF EXISTS `lieu_types`;
CREATE TABLE IF NOT EXISTS `lieu_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lieu_types`
--

INSERT INTO `lieu_types` (`id`, `nom`, `created`, `modified`) VALUES
(1, 'Maison', '2018-06-12 20:03:56', '2018-06-12 20:03:56'),
(2, 'Appartement', NULL, NULL),
(3, 'Local', NULL, NULL),
(4, 'Appartement', NULL, NULL),
(5, 'Professionel', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `logiciels`
--

DROP TABLE IF EXISTS `logiciels`;
CREATE TABLE IF NOT EXISTS `logiciels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `created` varchar(255) DEFAULT NULL,
  `modified` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `logiciels`
--

INSERT INTO `logiciels` (`id`, `nom`, `created`, `modified`) VALUES
(1, 'Logiciel 1', '14/06/2018 16:53', '14/06/2018 16:54'),
(2, 'Logiciel 02', '14/06/2018 16:54', '14/06/2018 16:54');

-- --------------------------------------------------------

--
-- Structure de la table `materiels`
--

DROP TABLE IF EXISTS `materiels`;
CREATE TABLE IF NOT EXISTS `materiels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `materiel` varchar(255) DEFAULT NULL,
  `descriptif` varchar(255) DEFAULT NULL,
  `photos` varchar(255) DEFAULT NULL,
  `notice_tuto` varchar(255) DEFAULT NULL,
  `dimension` float DEFAULT NULL,
  `poids` float DEFAULT NULL,
  `consignes` varchar(255) DEFAULT NULL,
  `variation_stok` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

DROP TABLE IF EXISTS `medias`;
CREATE TABLE IF NOT EXISTS `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `extension` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `model_bornes`
--

DROP TABLE IF EXISTS `model_bornes`;
CREATE TABLE IF NOT EXISTS `model_bornes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `date_sortie` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `taille_ecran` varchar(255) NOT NULL,
  `modele_imprimante` varchar(255) NOT NULL,
  `model_appareil_photo` varchar(255) NOT NULL,
  `note_complementaire` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `model_bornes`
--

INSERT INTO `model_bornes` (`id`, `nom`, `version`, `date_sortie`, `description`, `taille_ecran`, `modele_imprimante`, `model_appareil_photo`, `note_complementaire`) VALUES
(1, 'qsdfqsdfq', 'sdfqsdf', '2018-06-20', 'qsdfqsdfqsdf', 'qdfqsdf', 'qsdfqsdfqsdf', 'qsdfqsdf', 'qsdfqsdfqsdfdf'),
(2, 'Modèle 02', 'Version 4.6', '2018-06-26', 'C\'est un model de top qualité', '1024 x 114', 'Imprimante 3d', 'top', 'Quelques remarque'),
(3, 'sqdfqsdf', 'qsdfqsdf', '2018-06-12', 'qsdfqsdf', 'sdfqsdf', 'qsdfqsdf', 'qsdfsqdf', 'qsdfqsdfqsdf'),
(4, 'sdfqsdf', 'qdsfqsdf', '2018-06-21', 'sqdfqsdf', 'qsdfqsdf', 'qdfqsdfqsdf', 'sdfqsdfq', 'sqdfqsdfqsdf'),
(5, 'Nom mod', 'fff', '2018-06-12', 'ffffqsdfsdf', 'fqsdfqs', 'fqsdfqsdf', 'qsdfqsdf', 'qsdfqsdfqsdf'),
(6, 'sdQSDqsd', 'QSDqsd', '2018-06-20', 'qsdfsqdf', 'qsdfqsdf', 'qsdfqsdf', 'sqdfqsdfqsdf', 'qsdfqsdfqsdfqsdf'),
(7, 'sqdfqsdfqsdf', 'qsdfqsdf', '2018-06-19', 'sqdfqsdfqsdf', 'qsdfqsdf', 'qsdfqsdf', 'qsdfqsdf', 'qsdfqsdfqsdfqsdf'),
(8, 'fffsqdfqsd', 'fqsdfsdqf', '2018-06-28', 'sdfqsdfqsdf', 'qsdfqsdfqsdf', 'qsdfqsdf', 'qsdfqsdf', 'qsdfqsdfqsdf'),
(9, 'sqdfqsdfsd', 'fqsdfqsdf', '2018-06-15', 'qsdfqsdfqsdf', 'sqdfqsdf', 'qsdfqsdf', 'qsdfqsdf', 'qsdfqsdfqsdf'),
(10, 'qsdfqsdfqsd', 'fqsdfqsdf', '2018-06-12', 'qsdfqsdf', 'qsdfqsdf', 'qsdfqsdf', 'qsdfqsdfqsd', 'qsdfqsdfqsdfqsdf'),
(11, 'qsdfqsdf', 'sqdfqsdf', '2018-06-26', 'sqdfqsdfqsdf', 'qsdfqsdf', 'qsdfqsdf', 'qsdfqsdf', 'qsdfqsdfqdsf'),
(12, 'sdfqsdfqsdfq', 'fqsdfqsdf', '2018-06-01', 'qsdfqdfqsdf', 'sqdfqsdf', 'sdfqsdf', 'qsdfqsdf', 'qsdfqsdfqsdfqsdfqsdf');

-- --------------------------------------------------------

--
-- Structure de la table `model_bornes_has_medias`
--

DROP TABLE IF EXISTS `model_bornes_has_medias`;
CREATE TABLE IF NOT EXISTS `model_bornes_has_medias` (
  `model_borne_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`model_borne_id`,`media_id`),
  KEY `fk_model_bornes_has_medias_medias1_idx` (`media_id`),
  KEY `fk_model_bornes_has_medias_model_bornes1_idx` (`model_borne_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `parcs`
--

DROP TABLE IF EXISTS `parcs`;
CREATE TABLE IF NOT EXISTS `parcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `parcs`
--

INSERT INTO `parcs` (`id`, `nom`, `created`, `modified`) VALUES
(1, 'Vente', '2018-06-13 15:22:24', '2018-06-13 15:22:24'),
(2, 'Location', '2018-06-13 15:22:41', '2018-06-13 15:22:41');

-- --------------------------------------------------------

--
-- Structure de la table `parties`
--

DROP TABLE IF EXISTS `parties`;
CREATE TABLE IF NOT EXISTS `parties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `parties`
--

INSERT INTO `parties` (`id`, `nom`, `created`, `modified`) VALUES
(1, 'Pieds', '2018-06-14 14:19:59', '2018-06-14 14:19:59'),
(2, 'Corps', '2018-06-14 14:20:35', '2018-06-14 14:20:35');

-- --------------------------------------------------------

--
-- Structure de la table `situations`
--

DROP TABLE IF EXISTS `situations`;
CREATE TABLE IF NOT EXISTS `situations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(225) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `situations`
--

INSERT INTO `situations` (`id`, `titre`, `created`, `modified`) VALUES
(1, 'Etudiant', '2018-06-21 06:29:31', '2018-06-21 06:29:31'),
(2, 'Professionnel', '2018-06-21 06:29:55', '2018-06-21 06:29:55'),
(3, 'Retraité', '2018-06-21 06:30:04', '2018-06-21 06:30:04');

-- --------------------------------------------------------

--
-- Structure de la table `statuts`
--

DROP TABLE IF EXISTS `statuts`;
CREATE TABLE IF NOT EXISTS `statuts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(225) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `statuts`
--

INSERT INTO `statuts` (`id`, `titre`, `created`, `modified`) VALUES
(1, 'Responsable antenne ', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Installateur ', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Contacts antennes', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Autres', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `type_fournisseurs`
--

DROP TABLE IF EXISTS `type_fournisseurs`;
CREATE TABLE IF NOT EXISTS `type_fournisseurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `type_fournisseurs`
--

INSERT INTO `type_fournisseurs` (`id`, `nom`, `description`, `created`, `modified`) VALUES
(1, 'Imprimeurs', 'Imprimeurs', '2018-06-21 10:57:07', '2018-06-21 10:57:07'),
(2, 'Agence hotesse', 'Agence hotesses', '2018-06-21 10:57:30', '2018-06-21 10:57:30'),
(3, 'Intérim', 'Interim', '2018-06-21 10:57:48', '2018-06-21 10:57:48');

-- --------------------------------------------------------

--
-- Structure de la table `type_profils`
--

DROP TABLE IF EXISTS `type_profils`;
CREATE TABLE IF NOT EXISTS `type_profils` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `antenne_id` int(11) DEFAULT NULL,
  `fournisseur_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_clients1_idx` (`client_id`),
  KEY `fk_users_antennes1_idx` (`antenne_id`),
  KEY `fk_users_fournisseurs1_idx` (`fournisseur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `client_id`, `antenne_id`, `fournisseur_id`, `created`, `modified`) VALUES
(1, 'admin@konitys.fr', '$2y$10$02tKk30wTHJIGTx9iXIckeiWesJ34820VwdkXsK0CbyLOpR7Pa2Jq', NULL, NULL, NULL, '2018-06-13 09:27:06', '2018-06-13 09:27:06');

-- --------------------------------------------------------

--
-- Structure de la table `user_type_profils`
--

DROP TABLE IF EXISTS `user_type_profils`;
CREATE TABLE IF NOT EXISTS `user_type_profils` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type_profil_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_has_type_profils_type_profils1_idx` (`type_profil_id`),
  KEY `fk_users_has_type_profils_users1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `actu_bornes`
--
ALTER TABLE `actu_bornes`
  ADD CONSTRAINT `fk_actu_bornes_bornes1` FOREIGN KEY (`borne_id`) REFERENCES `bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `actu_bornes_has_medias`
--
ALTER TABLE `actu_bornes_has_medias`
  ADD CONSTRAINT `fk_actu_bornes_has_medias_actu_bornes1` FOREIGN KEY (`actu_borne_id`) REFERENCES `actu_bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_actu_bornes_has_medias_medias1` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `antennes`
--
ALTER TABLE `antennes`
  ADD CONSTRAINT `fk_antennes_etats1` FOREIGN KEY (`etat_id`) REFERENCES `etats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_antennes_lieu_types1` FOREIGN KEY (`lieu_type_id`) REFERENCES `lieu_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `bornes`
--
ALTER TABLE `bornes`
  ADD CONSTRAINT `FK_bornes` FOREIGN KEY (`couleur_possible_id`) REFERENCES `couleur_possibles` (`id`),
  ADD CONSTRAINT `fk_bornes_antennes1` FOREIGN KEY (`antenne_id`) REFERENCES `antennes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bornes_clients1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bornes_model_bornes1` FOREIGN KEY (`model_borne_id`) REFERENCES `model_bornes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bornes_parcs1` FOREIGN KEY (`parc_id`) REFERENCES `parcs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `bornes_has_medias`
--
ALTER TABLE `bornes_has_medias`
  ADD CONSTRAINT `fk_bornes_has_medias_bornes1` FOREIGN KEY (`borne_id`) REFERENCES `bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bornes_has_medias_medias1` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `borne_logiciels`
--
ALTER TABLE `borne_logiciels`
  ADD CONSTRAINT `fk_bornes_has_logiciels_bornes1` FOREIGN KEY (`borne_id`) REFERENCES `bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bornes_has_logiciels_logiciels1` FOREIGN KEY (`logiciel_id`) REFERENCES `logiciels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `couleur_possibles`
--
ALTER TABLE `couleur_possibles`
  ADD CONSTRAINT `fk_couleur_possibles_type_bornes1` FOREIGN KEY (`model_borne_id`) REFERENCES `model_bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
