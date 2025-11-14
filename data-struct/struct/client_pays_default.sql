ALTER TABLE `clients` CHANGE `pays_id` `pays_id` INT(11) NULL DEFAULT '5';
UPDATE `clients` SET `pays_id` = 5 WHERE `pays_id` IS NULL;