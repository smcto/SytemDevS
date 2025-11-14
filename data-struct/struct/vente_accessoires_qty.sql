ALTER TABLE `ventes_accessoires` ADD `sous_accessoire_id` INT  NULL AFTER `accessoire_id`;
ALTER TABLE `ventes_accessoires` ADD `qty` INT  NULL AFTER `sous_accessoire_id`;