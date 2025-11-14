ALTER TABLE `selfizee_crm`.`bornes` DROP FOREIGN KEY `fk_bornes_antennes1`;
ALTER TABLE `selfizee_crm`.`bornes` ADD CONSTRAINT `fk_bornes_antennes1` FOREIGN KEY (`antenne_id`) REFERENCES `antennes` (`id`) ON DELETE SET NULL  ON UPDATE SET NULL ;
