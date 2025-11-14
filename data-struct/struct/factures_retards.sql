ALTER TABLE `devis_factures` ADD `progression` ENUM('en_retard','relance1','relance2','relance3','lr','injonction','') NULL DEFAULT NULL AFTER `status`; 
ALTER TABLE `devis_factures` ADD `description_retard` TEXT NULL DEFAULT NULL AFTER `langue_id`; 
