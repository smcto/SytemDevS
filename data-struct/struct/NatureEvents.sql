ALTER TABLE `evenements` ADD `nature_evenement_id` INT NOT NULL AFTER `type_evenement_id`;
ALTER TABLE `evenements` CHANGE `nature_evenement_id` `nature_evenement_id` INT(11) NULL;
ALTER TABLE `evenements` ADD `animation_hotesse` TINYINT NULL AFTER `location_week`;
