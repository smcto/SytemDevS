ALTER TABLE `catalog_produits` ADD `is_pro` TINYINT(1) NULL AFTER `quantite_usuelle`, ADD `is_particulier` TINYINT(1) NULL AFTER `is_pro`; 
