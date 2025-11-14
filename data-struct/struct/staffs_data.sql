/*
SQLyog Ultimate v8.71 
MySQL - 5.7.9 : Database - crm_app_2
*********************************************************************
*/
ALTER TABLE `staffs`     ADD COLUMN `nom` VARCHAR(250) NULL AFTER `email`,     ADD COLUMN `prenom` VARCHAR(250) NULL AFTER `nom`;


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Data for the table `staffs` */

insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (1,127636,'Alan VERET','a.veret@konitys.fr','VERET','Alan',17012278);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (2,119267,'Alexandre Moro','a.moro@konitys.fr','Moro','Alexandre',15335474);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (3,84896,'Amandine Dreano','a.dreano@konitys.fr','Dreano','Amandine',9930798);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (4,84899,'Benjamin Guyon','b.guyon@konitys.fr','Guyon','Benjamin',9930811);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (5,84901,'Bertrand Lecollinet','b.lecollinet@konitys.fr','Lecollinet','Bertrand',9930820);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (6,155467,'compta konitys','comptabilitekonitys@gmail.com','konitys','compta',22671298);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (7,84924,'Corentin Henrio','c.henrio@konitys.fr','Henrio','Corentin',9932755);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (8,119905,'Elise Dooley','e.dooley@konitys.fr','Dooley','Elise',15493749);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (9,122320,'Emilie Cholet','e.cholet@konitys.fr','Cholet','Emilie',16329205);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (10,89558,'Eugénie Richeux','e.richeux@konitys.fr','Richeux','Eugénie',10550005);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (11,114503,'Grégory Lelièvre','g.lelievre@konitys.fr','Lelièvre','Grégory',14515484);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (12,157618,'Jean Yves dev','zanakolonajym@gmail.com','dev','Jean Yves',23063186);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (13,122316,'La Team Selfizee','commercial@konitys.fr','Selfizee','La Team',16329062);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (14,95327,'Laura Kerzil','l.kerzil@konitys.fr','Kerzil','Laura',11477915);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (15,119781,'Lucie L\'Hôtelier','l.lhotelier@konitys.fr','L\'Hôtelier','Lucie',15421589);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (16,119914,'Marie Constantin','m.constantin@konitys.fr','Constantin','Marie',15495534);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (17,81644,'Sebastien Mahé','s.mahe@konitys.fr','Mahé','Sebastien',9191132);
insert  into `staffs`(`id`,`id_in_sellsy`,`full_name`,`email`,`nom`,`prenom`,`people_id_in_sellsy`) values (18,133896,'William Michel','logistique@konitys.fr','Michel','William',18600744);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
