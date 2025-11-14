ALTER TABLE `devis` ADD `date_total_paiement` DATE NULL AFTER `id_in_wp`;
ALTER TABLE `devis` ADD `montant_total_paid` DECIMAL(10,2) NULL DEFAULT NULL AFTER `date_total_paiement`;