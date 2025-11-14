ALTER TABLE `devis_factures` ADD `langue_id` INT NULL AFTER `is_situation`, ADD INDEX (`langue_id`); 
ALTER TABLE `avoirs` ADD `langue_id` INT NULL AFTER `total_tva_client`; 
