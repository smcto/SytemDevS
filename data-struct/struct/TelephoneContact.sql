ALTER TABLE `contacts` CHANGE `telephone` `telephone_portable` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `contacts` ADD `telephone_fixe` VARCHAR(255) NULL AFTER `telephone_portable`;
ALTER TABLE `contacts` ADD `description_rapide` TEXT NULL AFTER `statut_id`;