ALTER TABLE `devis` ADD `tva_id` INT NULL DEFAULT NULL COMMENT 'prend le tva par default' AFTER `uuid`;
# UPDATE `devis` SET `tva_id` = 2;