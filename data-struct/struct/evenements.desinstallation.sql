ALTER TABLE `evenements` CHANGE `desinstallation_id` `desinstallation_id` INT(4) NULL;
ALTER TABLE `evenements` CHANGE `is_posted_on_event` `is_posted_on_event` TINYINT(1) NULL DEFAULT '0';
ALTER TABLE `evenements` CHANGE `is_fond_vert` `option_fond_vert_id` INT(1) NULL DEFAULT NULL;
ALTER TABLE `evenements` ADD `besion_borne_id` INT NULL AFTER `option_fond_vert_id`;
