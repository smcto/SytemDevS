ALTER TABLE `devis_factures` ADD `date_total_paiement` DATE NULL AFTER `status`;
ALTER TABLE `devis_factures` ADD `montant_total_paid` DECIMAL(10,2) NULL DEFAULT NULL AFTER `date_total_paiement`;