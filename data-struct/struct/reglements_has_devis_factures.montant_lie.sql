ALTER TABLE `reglements_has_devis_factures`     ADD COLUMN `montant_lie` DECIMAL(10.2) NULL AFTER `devis_factures_id`;
ALTER TABLE `reglements_has_devis_factures`     CHANGE `montant_lie` `montant_lie` DECIMAL(10,2) NULL ;
