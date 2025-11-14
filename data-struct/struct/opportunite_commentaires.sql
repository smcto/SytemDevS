
CREATE TABLE `opportunite_commentaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `opportunite_id` int(11) NOT NULL,
  `commentaire_id_in_sellsy` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `date_format` varchar(250) DEFAULT NULL,
  `titre` text,
  `commentaire` text,
  PRIMARY KEY (`id`),
  KEY `FK_opportunite_commentaires` (`opportunite_id`),
  CONSTRAINT `FK_opportunite_commentaires` FOREIGN KEY (`opportunite_id`) REFERENCES `opportunites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `opportunite_commentaires`     CHANGE `timestamp` `timestamp` INT NULL ;
