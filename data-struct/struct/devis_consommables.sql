ALTER TABLE `devis` ADD `is_consommable` TINYINT(1) NOT NULL DEFAULT '0' AFTER `message_id_in_mailjet`; 
ALTER TABLE `devis_produits` ADD `is_consommable` TINYINT(1) NOT NULL DEFAULT '0' AFTER `tva`; 
ALTER TABLE `catalog_produits` ADD `is_consommable` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'pour faciliter la détection dans la création devis' AFTER `is_particulier`; 
