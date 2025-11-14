ALTER TABLE `reglements` ADD `sellsy_client_id` INT NOT NULL AFTER `modified`, 
ADD `sellsy_status` VARCHAR(30) NULL DEFAULT NULL AFTER `modified`,
ADD `sellsy_note` TEXT NULL DEFAULT NULL AFTER `modified`,
ADD `sellsy_pay_id` INT DEFAULT NULL AFTER `modified`,
ADD `linkedtype` VARCHAR(30) NULL DEFAULT NULL AFTER `modified`;

ALTER TABLE `reglements` ADD `sellsy_client_name` VARCHAR(255) NULL DEFAULT NULL AFTER `linkedtype`;
ALTER TABLE `reglements` CHANGE `sellsy_client_id` `sellsy_client_id` INT(11) NULL;
ALTER TABLE `reglements` ADD `devis_facture_id` INT NULL DEFAULT NULL AFTER `sellsy_client_name`;
ALTER TABLE `reglements` CHANGE `moyen_reglement_id` `moyen_reglement_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `reglements` ADD `is_in_sellsy` TINYINT(1) NOT NULL DEFAULT '0' AFTER `devis_facture_id`;