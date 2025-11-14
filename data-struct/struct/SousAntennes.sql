ALTER TABLE `antennes` ADD `sous_antenne` BOOLEAN NULL DEFAULT FALSE AFTER `is_deleted`, 
ADD `antenne_id` INT NULL AFTER `sous_antenne`;
