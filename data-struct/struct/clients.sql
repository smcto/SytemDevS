ALTER TABLE `clients` DROP COLUMN `date_de_naissance`,    ADD COLUMN `adresse_2` TEXT NULL AFTER `modified`,     ADD COLUMN `siren` VARCHAR(255) NULL AFTER `adresse_2`,     ADD COLUMN `siret` VARCHAR(255) NULL AFTER `siren`,     ADD COLUMN `sellsy_id` INT NULL AFTER `siret`,     ADD COLUMN `sellsy_user_id` BOOL DEFAULT '0' NULL AFTER `sellsy_id`,     ADD COLUMN `mobile` VARCHAR(255) NULL AFTER `sellsy_user_id`,     ADD COLUMN `country` VARCHAR(255) NULL AFTER `mobile`;
/*[22:46:38][2512 ms]*/ ALTER TABLE `selfizee_crm`.`client_contacts` ADD CONSTRAINT `FK_client_contacts` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);
/*[23:04:49][1794 ms]*/ ALTER TABLE `selfizee_crm`.`clients` DROP COLUMN `sellsy_user_id`;
/*[23:18:45][ 203 ms]*/ ALTER TABLE `selfizee_crm`.`clients`     CHANGE `sellsy_id` `id_in_sellsy` INT(11) NULL ;
/*[23:21:18][1295 ms]*/ ALTER TABLE `selfizee_crm`.`clients`     CHANGE `adresse` `adresse` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,     CHANGE `telephone` `telephone` INT(11) NULL ;
/*[23:23:48][ 343 ms]*/ ALTER TABLE `selfizee_crm`.`client_contacts`     CHANGE `contaid` `id` INT(11) NOT NULL AUTO_INCREMENT;
/*[23:24:19][1045 ms]*/ ALTER TABLE `selfizee_crm`.`client_contacts`     ADD COLUMN `created` DATETIME NULL AFTER `deleted_in_sellsy`,     ADD COLUMN `modified` DATETIME NULL AFTER `created`;

/*[23:28:53][ 250 ms]*/ ALTER TABLE `selfizee_crm`.`client_contacts` DROP FOREIGN KEY `FK_client_contacts`;
/*[23:28:57][2449 ms]*/ ALTER TABLE `selfizee_crm`.`client_contacts` ADD CONSTRAINT `FK_client_contacts` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE  ON UPDATE CASCADE ;
