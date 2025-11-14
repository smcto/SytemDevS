ALTER TABLE `devis` ADD `is_text_loi_displayed` TINYINT(1) NOT NULL DEFAULT '0' AFTER `text_loi`;
ALTER TABLE `devis_preferences` ADD `text_loi` TEXT NULL DEFAULT NULL AFTER `accompte_unity`;
ALTER TABLE `devis_preferences` ADD `is_text_loi_displayed` TINYINT(1) NOT NULL DEFAULT '0' AFTER `accompte_unity`;