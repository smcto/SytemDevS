/*[17:16:06][1154 ms]*/ CREATE TABLE `selfizee_crm`.`parties`(     `id` INT NOT NULL AUTO_INCREMENT ,     `nom` VARCHAR(255) ,     `created` DATETIME ,     `modified` DATETIME ,     PRIMARY KEY (`id`)  );
/*[17:17:53][1248 ms]*/ ALTER TABLE `selfizee_crm`.`parties`  ENGINE=INNODB AUTO_INCREMENT=1 COMMENT='' ROW_FORMAT=DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;
/*[17:18:15][2121 ms]*/ ALTER TABLE `selfizee_crm`.`dimension_parties` ADD CONSTRAINT `FK_dimension_parties` FOREIGN KEY (`partie_id`) REFERENCES `parties` (`id`);
/*[17:23:50][ 327 ms]*/ ALTER TABLE `selfizee_crm`.`dimension_parties`     CHANGE `type_borne_id` `model_borne_id` INT(11) NOT NULL;
RENAME TABLE `selfizee_crm`.`dimension_parties` TO `selfizee_crm`.`dimensions`;