ALTER TABLE `documents` ADD `url_sellsy` VARCHAR(255) NOT NULL AFTER `montant_ttc`; 
ALTER TABLE `documents` ADD `objet` VARCHAR(255) NOT NULL AFTER `statut`; 
ALTER TABLE `documents` ADD `date` DATETIME NOT NULL AFTER `url_sellsy`; 
ALTER TABLE `documents` ADD `id_in_sellsy` INT NOT NULL AFTER `date`; 
ALTER TABLE `documents` ADD `deleted_in_sellsy` BOOLEAN NOT NULL DEFAULT FALSE AFTER `id_in_sellsy`; 
ALTER TABLE `documents` CHANGE `types` `type_document` ENUM('factures','devis') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL; 
ALTER TABLE `documents` CHANGE `type_document` `type_document` ENUM('invoice','estimate') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL; 
ALTER TABLE `documents` CHANGE `url_sellsy` `url_sellsy` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL; 
ALTER TABLE `documents` CHANGE `date` `date` DATE NOT NULL; 