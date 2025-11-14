ALTER TABLE `devis` ADD `langue_id` INT NULL AFTER `total_tva_client`, ADD INDEX `langues` (`langue_id`); 
