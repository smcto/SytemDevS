CREATE TABLE `equipement_bornes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipement_id` int(11) NOT NULL,
  `borne_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_equipement_bornes_lft` (`borne_id`),
  KEY `FK_equipement_bornes_rgth` (`equipement_id`),
  CONSTRAINT `FK_equipement_bornes_lft` FOREIGN KEY (`borne_id`) REFERENCES `bornes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_equipement_bornes_rgth` FOREIGN KEY (`equipement_id`) REFERENCES `equipements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8
