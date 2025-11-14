

DROP TABLE IF EXISTS `evenement_pipe_etapes`;

CREATE TABLE `evenement_pipe_etapes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pipe_etape_id` int(11) NOT NULL,
  `evenement_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_evenement_pipe_etapes` (`pipe_etape_id`),
  KEY `FK_evenement_pipe_etapes_1` (`evenement_id`),
  CONSTRAINT `FK_evenement_pipe_etapes` FOREIGN KEY (`pipe_etape_id`) REFERENCES `pipe_etapes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_evenement_pipe_etapes_1` FOREIGN KEY (`evenement_id`) REFERENCES `evenements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `evenement_pipe_etapes` */

insert  into `evenement_pipe_etapes`(`id`,`pipe_etape_id`,`evenement_id`) values (2,1,2);
insert  into `evenement_pipe_etapes`(`id`,`pipe_etape_id`,`evenement_id`) values (7,4,7);
insert  into `evenement_pipe_etapes`(`id`,`pipe_etape_id`,`evenement_id`) values (8,1,9);
insert  into `evenement_pipe_etapes`(`id`,`pipe_etape_id`,`evenement_id`) values (9,4,8);
insert  into `evenement_pipe_etapes`(`id`,`pipe_etape_id`,`evenement_id`) values (10,3,1);
insert  into `evenement_pipe_etapes`(`id`,`pipe_etape_id`,`evenement_id`) values (11,2,3);
insert  into `evenement_pipe_etapes`(`id`,`pipe_etape_id`,`evenement_id`) values (12,3,5);
insert  into `evenement_pipe_etapes`(`id`,`pipe_etape_id`,`evenement_id`) values (13,4,4);
insert  into `evenement_pipe_etapes`(`id`,`pipe_etape_id`,`evenement_id`) values (14,5,2);

/*Table structure for table `pipe_etapes` */

DROP TABLE IF EXISTS `pipe_etapes`;

CREATE TABLE `pipe_etapes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) NOT NULL,
  `ordre` int(11) NOT NULL,
  `pipe_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pipe_etapes` (`pipe_id`),
  CONSTRAINT `FK_pipe_etapes` FOREIGN KEY (`pipe_id`) REFERENCES `pipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `pipe_etapes` */

insert  into `pipe_etapes`(`id`,`nom`,`ordre`,`pipe_id`,`created`,`modified`) values (1,'création en cours',1,1,'2018-10-04 12:31:09','2018-10-04 14:04:30');
insert  into `pipe_etapes`(`id`,`nom`,`ordre`,`pipe_id`,`created`,`modified`) values (2,'envoi clients',1,1,'2018-10-04 12:32:17','2018-10-04 13:57:36');
insert  into `pipe_etapes`(`id`,`nom`,`ordre`,`pipe_id`,`created`,`modified`) values (3,'modification suite retour client',3,1,'2018-10-04 12:32:41','2018-10-04 14:03:00');
insert  into `pipe_etapes`(`id`,`nom`,`ordre`,`pipe_id`,`created`,`modified`) values (4,'Validé par le client ',4,1,'2018-10-04 12:33:12','2018-10-04 14:04:47');
insert  into `pipe_etapes`(`id`,`nom`,`ordre`,`pipe_id`,`created`,`modified`) values (5,'Etape 1',1,2,'2018-10-08 11:39:32','2018-10-08 11:39:32');
insert  into `pipe_etapes`(`id`,`nom`,`ordre`,`pipe_id`,`created`,`modified`) values (6,'Etape 2',2,2,'2018-10-08 11:39:59','2018-10-08 11:39:59');

/*Table structure for table `pipes` */

DROP TABLE IF EXISTS `pipes`;

CREATE TABLE `pipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `pipes` */

insert  into `pipes`(`id`,`nom`,`created`,`modified`) values (1,'Graphique','2018-10-04 12:23:58','2018-10-04 12:23:58');
insert  into `pipes`(`id`,`nom`,`created`,`modified`) values (2,'Configuration','2018-10-04 12:24:25','2018-10-04 12:24:25');
insert  into `pipes`(`id`,`nom`,`created`,`modified`) values (3,'Post Evenement','2018-10-04 12:27:52','2018-10-04 12:27:52');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
