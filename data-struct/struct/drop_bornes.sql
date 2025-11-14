ALTER TABLE `actu_bornes` DROP FOREIGN KEY `fk_actu_bornes_bornes1`;
ALTER TABLE `actu_bornes` ADD CONSTRAINT `fk_actu_bornes_bornes1` FOREIGN KEY (`borne_id`) REFERENCES `bornes` (`id`) ON DELETE CASCADE  ON UPDATE CASCADE ;
ALTER TABLE `borne_logiciels` DROP FOREIGN KEY `fk_bornes_has_logiciels_bornes1`;
ALTER TABLE `borne_logiciels` ADD CONSTRAINT `fk_bornes_has_logiciels_bornes1` FOREIGN KEY (`borne_id`) REFERENCES `bornes` (`id`) ON DELETE CASCADE  ON UPDATE CASCADE ;