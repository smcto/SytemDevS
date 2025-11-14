ALTER TABLE `devis_factures` ADD `display_virement` TINYINT(1) NOT NULL DEFAULT '0' AFTER `sellsy_estimate_id`, ADD `display_cheque` TINYINT(1) NOT NULL DEFAULT '0' AFTER `display_virement`; 
