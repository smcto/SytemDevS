ALTER TABLE `evenements` ADD `envoyer_recap` TINYINT(1) NULL AFTER `location_week`;
ALTER TABLE `evenements` ADD `is_envoye_recap` TINYINT(1) NULL DEFAULT NULL AFTER `envoyer_recap`;