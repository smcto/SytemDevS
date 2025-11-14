ALTER TABLE `type_equipements` ADD `is_vente` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_filtrable`; 
ALTER TABLE `type_equipements` ADD `is_structurel` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_vente`, ADD `is_accessoire` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_structurel`; 
