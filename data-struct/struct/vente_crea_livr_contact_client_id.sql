ALTER TABLE `ventes` ADD `vente_contact_client_id` INT NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `ventes` ADD `contact_crea_lastname` VARCHAR(255) NULL DEFAULT NULL AFTER `vente_livraison_contact_client_id`;
ALTER TABLE `ventes` CHANGE `vente_contact_client_id` `vente_crea_contact_client_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `ventes` ADD `vente_livraison_contact_client_id` INT NULL DEFAULT NULL AFTER `vente_crea_contact_client_id`;
ALTER TABLE `ventes` ADD `livraison_crea_lastname` VARCHAR(255) NULL DEFAULT NULL AFTER `contact_crea_lastname`;