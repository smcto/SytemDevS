CREATE TABLE `opportunite_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) NOT NULL,
  `opportunite_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_opportunite_tags` (`opportunite_id`),
  CONSTRAINT `FK_opportunite_tags` FOREIGN KEY (`opportunite_id`) REFERENCES `opportunites` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4
