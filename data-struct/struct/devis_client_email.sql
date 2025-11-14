ALTER TABLE `devis` ADD `client_email` VARCHAR(100) NULL DEFAULT NULL COMMENT 'surtout pour les anciens devis importés' AFTER `is_in_sellsy`;
ALTER TABLE `devis` ADD `client_tel` VARCHAR(100) NULL DEFAULT NULL COMMENT 'surtout pour les anciens devis importés' AFTER `is_in_sellsy`;
ALTER TABLE `devis` ADD `sellsy_public_url` VARCHAR(500) NULL DEFAULT NULL AFTER `client_email`;
ALTER TABLE `devis` ADD `sellsy_doc_id` INT NULL DEFAULT '0' AFTER `sellsy_public_url`;
ALTER TABLE `devis` CHANGE `status` `status` ENUM('accepted', 'acompte', 'canceled', 'draft', 'sent', 'expired', 'lu', 'billed', 'partially_billed', 'refused', 'paid') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'draft';
ALTER TABLE `devis` CHANGE `status` `status` ENUM('accepted','acompte','canceled','draft','sent','expired','lu','billed','refused','paid', 'partially_billed') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'draft';
ALTER TABLE `devis` CHANGE `objet` `objet` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;