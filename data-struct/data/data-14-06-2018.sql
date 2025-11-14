/*
SQLyog Ultimate v8.71 
MySQL - 5.7.9 : Database - selfizee_crm
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `selfizee_crm`;

/*Table structure for table `actu_bornes` */

DROP TABLE IF EXISTS `actu_bornes`;

CREATE TABLE `actu_bornes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `contenu` text,
  `borne_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_actu_bornes_bornes1_idx` (`borne_id`),
  CONSTRAINT `fk_actu_bornes_bornes1` FOREIGN KEY (`borne_id`) REFERENCES `bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `actu_bornes` */

/*Table structure for table `actu_bornes_has_medias` */

DROP TABLE IF EXISTS `actu_bornes_has_medias`;

CREATE TABLE `actu_bornes_has_medias` (
  `actu_borne_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`actu_borne_id`,`media_id`),
  KEY `fk_actu_bornes_has_medias_medias1_idx` (`media_id`),
  KEY `fk_actu_bornes_has_medias_actu_bornes1_idx` (`actu_borne_id`),
  CONSTRAINT `fk_actu_bornes_has_medias_actu_bornes1` FOREIGN KEY (`actu_borne_id`) REFERENCES `actu_bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_actu_bornes_has_medias_medias1` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `actu_bornes_has_medias` */

/*Table structure for table `antennes` */

DROP TABLE IF EXISTS `antennes`;

CREATE TABLE `antennes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lieu_type_id` int(11) NOT NULL,
  `ville_principale` varchar(45) DEFAULT NULL,
  `ville_excate` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `cp` int(11) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `precision_lieu` text,
  `commentaire` varchar(255) DEFAULT NULL,
  `etat_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_antennes_etats1_idx` (`etat_id`),
  KEY `fk_antennes_lieu_types1_idx` (`lieu_type_id`),
  CONSTRAINT `fk_antennes_etats1` FOREIGN KEY (`etat_id`) REFERENCES `etats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_antennes_lieu_types1` FOREIGN KEY (`lieu_type_id`) REFERENCES `lieu_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `antennes` */

/*Table structure for table `borne_logiciels` */

DROP TABLE IF EXISTS `borne_logiciels`;

CREATE TABLE `borne_logiciels` (
  `borne_id` int(11) NOT NULL,
  `logiciel_id` int(11) NOT NULL,
  PRIMARY KEY (`borne_id`,`logiciel_id`),
  KEY `fk_bornes_has_logiciels_logiciels1_idx` (`logiciel_id`),
  KEY `fk_bornes_has_logiciels_bornes1_idx` (`borne_id`),
  CONSTRAINT `fk_bornes_has_logiciels_bornes1` FOREIGN KEY (`borne_id`) REFERENCES `bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bornes_has_logiciels_logiciels1` FOREIGN KEY (`logiciel_id`) REFERENCES `logiciels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `borne_logiciels` */

/*Table structure for table `bornes` */

DROP TABLE IF EXISTS `bornes`;

CREATE TABLE `bornes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `couleur` varchar(255) DEFAULT NULL,
  `expiration_sb` datetime DEFAULT NULL,
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
  CONSTRAINT `fk_bornes_antennes1` FOREIGN KEY (`antenne_id`) REFERENCES `antennes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bornes_clients1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bornes_model_bornes1` FOREIGN KEY (`model_borne_id`) REFERENCES `model_bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bornes_parcs1` FOREIGN KEY (`parc_id`) REFERENCES `parcs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `bornes` */

/*Table structure for table `bornes_has_medias` */

DROP TABLE IF EXISTS `bornes_has_medias`;

CREATE TABLE `bornes_has_medias` (
  `borne_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`borne_id`,`media_id`),
  KEY `fk_bornes_has_medias_medias1_idx` (`media_id`),
  KEY `fk_bornes_has_medias_bornes1_idx` (`borne_id`),
  CONSTRAINT `fk_bornes_has_medias_bornes1` FOREIGN KEY (`borne_id`) REFERENCES `bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bornes_has_medias_medias1` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `bornes_has_medias` */

/*Table structure for table `clients` */

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `clients` */

/*Table structure for table `contacts` */

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `situation_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contacts_antennes1_idx` (`antenne_id`),
  KEY `fk_contacts_situations1_idx` (`situation_id`),
  CONSTRAINT `fk_contacts_antennes1` FOREIGN KEY (`antenne_id`) REFERENCES `antennes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contacts_situations1` FOREIGN KEY (`situation_id`) REFERENCES `situations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `contacts` */

/*Table structure for table `couleur_possibles` */

DROP TABLE IF EXISTS `couleur_possibles`;

CREATE TABLE `couleur_possibles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `couleur` varchar(45) DEFAULT NULL,
  `type_borne_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_couleur_possibles_type_bornes1_idx` (`type_borne_id`),
  CONSTRAINT `fk_couleur_possibles_type_bornes1` FOREIGN KEY (`type_borne_id`) REFERENCES `model_bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `couleur_possibles` */

/*Table structure for table `dimension_parties` */

DROP TABLE IF EXISTS `dimension_parties`;

CREATE TABLE `dimension_parties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partie` varchar(250) NOT NULL,
  `dimension` varchar(250) DEFAULT NULL,
  `poids` varchar(250) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `type_borne_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dimension_parties_type_bornes1_idx` (`type_borne_id`),
  CONSTRAINT `fk_dimension_parties_type_bornes1` FOREIGN KEY (`type_borne_id`) REFERENCES `model_bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `dimension_parties` */

/*Table structure for table `documents` */

DROP TABLE IF EXISTS `documents`;

CREATE TABLE `documents` (
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
  KEY `fk_documents_clients1_idx` (`client_id`),
  CONSTRAINT `fk_documents_clients1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `documents` */

/*Table structure for table `etats` */

DROP TABLE IF EXISTS `etats`;

CREATE TABLE `etats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valeur` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `etats` */

/*Table structure for table `fournisseurs` */

DROP TABLE IF EXISTS `fournisseurs`;

CREATE TABLE `fournisseurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `antenne_id` int(11) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  `descirption` text,
  PRIMARY KEY (`id`),
  KEY `fk_fournisseurs_antennes1_idx` (`antenne_id`),
  CONSTRAINT `fk_fournisseurs_antennes1` FOREIGN KEY (`antenne_id`) REFERENCES `antennes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `fournisseurs` */

/*Table structure for table `lieu_types` */

DROP TABLE IF EXISTS `lieu_types`;

CREATE TABLE `lieu_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `lieu_types` */

insert  into `lieu_types`(`id`,`nom`,`created`,`modified`) values (1,'Bureau','2018-06-12 20:03:56','2018-06-12 20:03:56');

/*Table structure for table `logiciels` */

DROP TABLE IF EXISTS `logiciels`;

CREATE TABLE `logiciels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `created` varchar(255) DEFAULT NULL,
  `modified` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `logiciels` */

/*Table structure for table `materiels` */

DROP TABLE IF EXISTS `materiels`;

CREATE TABLE `materiels` (
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

/*Data for the table `materiels` */

/*Table structure for table `medias` */

DROP TABLE IF EXISTS `medias`;

CREATE TABLE `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `extension` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `medias` */

/*Table structure for table `model_bornes` */

DROP TABLE IF EXISTS `model_bornes`;

CREATE TABLE `model_bornes` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `model_bornes` */

insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (1,'qsdfqsdfq','sdfqsdf','2018-06-20','qsdfqsdfqsdf','qdfqsdf','qsdfqsdfqsdf','qsdfqsdf','qsdfqsdfqsdfdf');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (2,'Modèle 02','Version 4.6','2018-06-26','C\'est un model de top qualité','1024 x 114','Imprimante 3d','top','Quelques remarque');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (3,'sqdfqsdf','qsdfqsdf','2018-06-12','qsdfqsdf','sdfqsdf','qsdfqsdf','qsdfsqdf','qsdfqsdfqsdf');

/*Table structure for table `model_bornes_has_medias` */

DROP TABLE IF EXISTS `model_bornes_has_medias`;

CREATE TABLE `model_bornes_has_medias` (
  `model_borne_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`model_borne_id`,`media_id`),
  KEY `fk_model_bornes_has_medias_medias1_idx` (`media_id`),
  KEY `fk_model_bornes_has_medias_model_bornes1_idx` (`model_borne_id`),
  CONSTRAINT `fk_model_bornes_has_medias_medias1` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_model_bornes_has_medias_model_bornes1` FOREIGN KEY (`model_borne_id`) REFERENCES `model_bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `model_bornes_has_medias` */

/*Table structure for table `parcs` */

DROP TABLE IF EXISTS `parcs`;

CREATE TABLE `parcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `parcs` */

insert  into `parcs`(`id`,`nom`,`created`,`modified`) values (1,'Vente','2018-06-13 15:22:24','2018-06-13 15:22:24');
insert  into `parcs`(`id`,`nom`,`created`,`modified`) values (2,'Location','2018-06-13 15:22:41','2018-06-13 15:22:41');

/*Table structure for table `situations` */

DROP TABLE IF EXISTS `situations`;

CREATE TABLE `situations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `situations` */

insert  into `situations`(`id`,`titre`,`created`,`modified`) values (1,'Etudiant','2018-06-12 18:44:09','2018-06-12 18:44:09');
insert  into `situations`(`id`,`titre`,`created`,`modified`) values (2,'Retraité','2018-06-12 19:26:43','2018-06-12 19:26:43');
insert  into `situations`(`id`,`titre`,`created`,`modified`) values (3,'Retraité','2018-06-12 19:27:02','2018-06-12 19:27:02');

/*Table structure for table `type_profils` */

DROP TABLE IF EXISTS `type_profils`;

CREATE TABLE `type_profils` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `type_profils` */

/*Table structure for table `user_type_profils` */

DROP TABLE IF EXISTS `user_type_profils`;

CREATE TABLE `user_type_profils` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type_profil_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_has_type_profils_type_profils1_idx` (`type_profil_id`),
  KEY `fk_users_has_type_profils_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_has_type_profils_type_profils1` FOREIGN KEY (`type_profil_id`) REFERENCES `type_profils` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_type_profils_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_type_profils` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
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
  KEY `fk_users_fournisseurs1_idx` (`fournisseur_id`),
  CONSTRAINT `fk_users_antennes1` FOREIGN KEY (`antenne_id`) REFERENCES `antennes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_clients1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_fournisseurs1` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`email`,`password`,`client_id`,`antenne_id`,`fournisseur_id`,`created`,`modified`) values (1,'admin@konitys.fr','$2y$10$02tKk30wTHJIGTx9iXIckeiWesJ34820VwdkXsK0CbyLOpR7Pa2Jq',NULL,NULL,NULL,'2018-06-13 09:27:06','2018-06-13 09:27:06');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
