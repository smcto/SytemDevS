ALTER TABLE `lot_produits` ADD `is_event` TINYINT(1) NOT NULL DEFAULT '0' AFTER `lot`, ADD `antenne_id` INT NULL AFTER `is_event`; 
