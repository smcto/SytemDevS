ALTER TABLE `payss` CHANGE `name_fr` `name_fr` VARCHAR(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `payss` CHANGE `phonecode` `phonecode` INT(5) NULL DEFAULT NULL;
ALTER TABLE `clients` ADD `pays_id` INT NULL DEFAULT NULL AFTER `user_id`;
UPDATE `clients` SET `pays_id` = 5;