ALTER TABLE `catalog_produits_files` ADD `titre` INT NULL AFTER `modified`, ADD `description` INT NULL AFTER `titre`, ADD `is_document` TINYINT(1) NOT NULL DEFAULT '0' AFTER `description`; 
ALTER TABLE `catalog_produits_files` CHANGE `titre` `titre` VARCHAR(255) NULL DEFAULT NULL, CHANGE `description` `description` TEXT NULL DEFAULT NULL; 
