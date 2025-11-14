ALTER TABLE `devis_factures` ADD `type_doc_id` INT NULL AFTER `sellsy_echeances`; 
ALTER TABLE `avoirs` ADD `type_doc_id` INT NULL AFTER `sellsy_echeances`; 
ALTER TABLE `devis` CHANGE `devis_type_doc_id` `type_doc_id` INT(11) NULL DEFAULT NULL; 