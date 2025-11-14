ALTER TABLE `statut_historiques` ADD `activite` VARCHAR(255) NULL DEFAULT NULL AFTER `user_id`; 
ALTER TABLE `statut_historiques` ADD `entity_id` INT NULL DEFAULT NULL COMMENT 'reglement ou commentaire ...' AFTER `activite`; 
