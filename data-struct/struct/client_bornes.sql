/*[23:27:31][ 764 ms]*/ ALTER TABLE `selfizee_crm`.`bornes` DROP FOREIGN KEY `fk_bornes_clients1`;
/*[23:27:41][8830 ms]*/ ALTER TABLE `selfizee_crm`.`bornes` ADD CONSTRAINT `fk_bornes_clients1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL  ON UPDATE SET NULL ;
