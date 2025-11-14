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
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `antennes` */

insert  into `antennes`(`id`,`lieu_type_id`,`ville_principale`,`ville_excate`,`adresse`,`cp`,`longitude`,`latitude`,`precision_lieu`,`commentaire`,`etat_id`,`created`,`modified`) values (2,1,'Paris','Paris - 3ème','',NULL,'','','','',1,'2018-06-14 18:18:06','2018-06-14 18:18:06');

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

insert  into `borne_logiciels`(`borne_id`,`logiciel_id`) values (2,1);
insert  into `borne_logiciels`(`borne_id`,`logiciel_id`) values (2,2);

/*Table structure for table `bornes` */

DROP TABLE IF EXISTS `bornes`;

CREATE TABLE `bornes` (
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
  KEY `FK_bornes` (`couleur_possible_id`),
  CONSTRAINT `FK_bornes` FOREIGN KEY (`couleur_possible_id`) REFERENCES `couleur_possibles` (`id`),
  CONSTRAINT `fk_bornes_antennes1` FOREIGN KEY (`antenne_id`) REFERENCES `antennes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bornes_clients1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bornes_model_bornes1` FOREIGN KEY (`model_borne_id`) REFERENCES `model_bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bornes_parcs1` FOREIGN KEY (`parc_id`) REFERENCES `parcs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `bornes` */

insert  into `bornes`(`id`,`numero`,`couleur_possible_id`,`expiration_sb`,`commentaire`,`is_prette`,`parc_id`,`model_borne_id`,`date_arrive_estime`,`antenne_id`,`client_id`,`ville`,`long`,`lat`,`created`,`modified`) values (1,1,10,'2018-06-12','qsdfqsdf qsdf qdsfqsdf<br>',0,1,3,NULL,NULL,1,'Ville test',NULL,NULL,'2018-06-14 18:36:14','2018-06-14 18:36:14');
insert  into `bornes`(`id`,`numero`,`couleur_possible_id`,`expiration_sb`,`commentaire`,`is_prette`,`parc_id`,`model_borne_id`,`date_arrive_estime`,`antenne_id`,`client_id`,`ville`,`long`,`lat`,`created`,`modified`) values (2,78,10,'2018-06-12','qsdfqsdfqsdfqsdfqsdf',0,2,2,NULL,2,NULL,'',NULL,NULL,'2018-06-14 18:48:53','2018-06-14 18:48:53');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `clients` */

insert  into `clients`(`id`,`nom`,`prenom`,`date_de_naissance`,`adresse`,`ville`,`cp`,`telephone`,`email`,`created`,`modified`) values (1,'Test','',NULL,'Adresse test','',NULL,0,'','2018-06-14 18:18:56','2018-06-14 18:18:56');

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
  `model_borne_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_couleur_possibles_type_bornes1_idx` (`model_borne_id`),
  CONSTRAINT `fk_couleur_possibles_type_bornes1` FOREIGN KEY (`model_borne_id`) REFERENCES `model_bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `couleur_possibles` */

insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (1,'sqdfqsdf',7);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (2,'sqdfqsdfqsdf',7);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (3,'sqdfqsdf',8);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (4,'qsdfqsdf',8);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (5,'sdqdf',9);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (6,'qsdfqsdfqsdf',9);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (7,'sqfqsdf',10);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (8,'qsdfqsdf',10);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (9,'sdfqsdf',11);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (10,'sdfqsdf',12);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (11,'sqdfqsdfqsdf',12);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (12,'bleu',12);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (13,'rouge',12);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (14,'sdfqsdf',12);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (15,'sqdfqsdfqsdf',12);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (16,'bleu',12);
insert  into `couleur_possibles`(`id`,`couleur`,`model_borne_id`) values (17,'rouge',12);

/*Table structure for table `dimensions` */

DROP TABLE IF EXISTS `dimensions`;

CREATE TABLE `dimensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dimension` varchar(250) DEFAULT NULL,
  `poids` varchar(250) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `model_borne_id` int(11) NOT NULL,
  `partie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dimension_parties_type_bornes1_idx` (`model_borne_id`),
  KEY `FK_dimension_parties` (`partie_id`),
  CONSTRAINT `FK_dimension_parties` FOREIGN KEY (`partie_id`) REFERENCES `parties` (`id`),
  CONSTRAINT `fk_dimension_parties_type_bornes1` FOREIGN KEY (`model_borne_id`) REFERENCES `model_bornes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `dimensions` */

insert  into `dimensions`(`id`,`dimension`,`poids`,`created`,`modified`,`model_borne_id`,`partie_id`) values (1,'sqdfqsd','fqsdfqsdf','2018-06-14 15:06:44','2018-06-14 15:06:44',1,1);
insert  into `dimensions`(`id`,`dimension`,`poids`,`created`,`modified`,`model_borne_id`,`partie_id`) values (2,'qsdfqs','qsdfqsdf','2018-06-14 15:08:19','2018-06-14 15:08:19',11,1);
insert  into `dimensions`(`id`,`dimension`,`poids`,`created`,`modified`,`model_borne_id`,`partie_id`) values (3,'dfqsdfqsdf','qsdfqsdf','2018-06-14 15:08:19','2018-06-14 15:08:19',11,2);
insert  into `dimensions`(`id`,`dimension`,`poids`,`created`,`modified`,`model_borne_id`,`partie_id`) values (4,'12','13','2018-06-14 15:50:23','2018-06-14 16:07:23',12,1);
insert  into `dimensions`(`id`,`dimension`,`poids`,`created`,`modified`,`model_borne_id`,`partie_id`) values (5,'14','15','2018-06-14 15:50:23','2018-06-14 16:07:23',12,2);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `etats` */

insert  into `etats`(`id`,`valeur`,`created`,`modified`) values (1,'ouvert ','2018-06-14 18:17:05','2018-06-14 18:17:05');
insert  into `etats`(`id`,`valeur`,`created`,`modified`) values (2,'à venir ','2018-06-14 18:17:21','2018-06-14 18:17:21');
insert  into `etats`(`id`,`valeur`,`created`,`modified`) values (3,'ancienne ','2018-06-14 18:17:40','2018-06-14 18:17:40');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `logiciels` */

insert  into `logiciels`(`id`,`nom`,`created`,`modified`) values (1,'Logiciel 1','14/06/2018 16:53','14/06/2018 16:54');
insert  into `logiciels`(`id`,`nom`,`created`,`modified`) values (2,'Logiciel 02','14/06/2018 16:54','14/06/2018 16:54');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `model_bornes` */

insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (1,'qsdfqsdfq','sdfqsdf','2018-06-20','qsdfqsdfqsdf','qdfqsdf','qsdfqsdfqsdf','qsdfqsdf','qsdfqsdfqsdfdf');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (2,'Modèle 02','Version 4.6','2018-06-26','C\'est un model de top qualité','1024 x 114','Imprimante 3d','top','Quelques remarque');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (3,'sqdfqsdf','qsdfqsdf','2018-06-12','qsdfqsdf','sdfqsdf','qsdfqsdf','qsdfsqdf','qsdfqsdfqsdf');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (4,'sdfqsdf','qdsfqsdf','2018-06-21','sqdfqsdf','qsdfqsdf','qdfqsdfqsdf','sdfqsdfq','sqdfqsdfqsdf');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (5,'Nom mod','fff','2018-06-12','ffffqsdfsdf','fqsdfqs','fqsdfqsdf','qsdfqsdf','qsdfqsdfqsdf');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (6,'sdQSDqsd','QSDqsd','2018-06-20','qsdfsqdf','qsdfqsdf','qsdfqsdf','sqdfqsdfqsdf','qsdfqsdfqsdfqsdf');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (7,'sqdfqsdfqsdf','qsdfqsdf','2018-06-19','sqdfqsdfqsdf','qsdfqsdf','qsdfqsdf','qsdfqsdf','qsdfqsdfqsdfqsdf');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (8,'fffsqdfqsd','fqsdfsdqf','2018-06-28','sdfqsdfqsdf','qsdfqsdfqsdf','qsdfqsdf','qsdfqsdf','qsdfqsdfqsdf');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (9,'sqdfqsdfsd','fqsdfqsdf','2018-06-15','qsdfqsdfqsdf','sqdfqsdf','qsdfqsdf','qsdfqsdf','qsdfqsdfqsdf');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (10,'qsdfqsdfqsd','fqsdfqsdf','2018-06-12','qsdfqsdf','qsdfqsdf','qsdfqsdf','qsdfqsdfqsd','qsdfqsdfqsdfqsdf');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (11,'qsdfqsdf','sqdfqsdf','2018-06-26','sqdfqsdfqsdf','qsdfqsdf','qsdfqsdf','qsdfqsdf','qsdfqsdfqdsf');
insert  into `model_bornes`(`id`,`nom`,`version`,`date_sortie`,`description`,`taille_ecran`,`modele_imprimante`,`model_appareil_photo`,`note_complementaire`) values (12,'sdfqsdfqsdfq','fqsdfqsdf','2018-06-01','qsdfqdfqsdf','sqdfqsdf','sdfqsdf','qsdfqsdf','qsdfqsdfqsdfqsdfqsdf');

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

/*Table structure for table `parties` */

DROP TABLE IF EXISTS `parties`;

CREATE TABLE `parties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `parties` */

insert  into `parties`(`id`,`nom`,`created`,`modified`) values (1,'Pieds','2018-06-14 14:19:59','2018-06-14 14:19:59');
insert  into `parties`(`id`,`nom`,`created`,`modified`) values (2,'Corps','2018-06-14 14:20:35','2018-06-14 14:20:35');

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
