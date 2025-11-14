ALTER TABLE `reglements` ADD `sellsy_moyen_reglement` VARCHAR(100) NULL DEFAULT NULL AFTER `sellsy_client_id`;
ALTER TABLE `reglements` ADD `full_data` LONGTEXT NULL DEFAULT NULL COMMENT 'ouz seb: récupérer tout on sait jms' AFTER `sellsy_moyen_reglement`;
ALTER TABLE `reglements` ADD `sellsy_proprietaire` VARCHAR(255) NULL DEFAULT NULL AFTER `full_data`;
ALTER TABLE `reglements` ADD `montant_restant` DECIMAL(10,2) NULL DEFAULT NULL AFTER `sellsy_proprietaire`;