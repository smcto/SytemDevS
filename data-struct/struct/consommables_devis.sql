ALTER TABLE `ventes_consommables` ADD `devis_id` INT NULL DEFAULT NULL AFTER `date_reception_client`;
ALTER TABLE `ventes_consommables` ADD `lieu_livraison` VARCHAR(255) NULL DEFAULT NULL AFTER `devis_id`;
ALTER TABLE `ventes_consommables` ADD `commentaire` TEXT NULL DEFAULT NULL AFTER `lieu_livraison`;