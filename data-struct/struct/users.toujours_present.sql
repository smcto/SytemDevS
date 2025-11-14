ALTER TABLE `users` ADD `toujours_present` BOOLEAN NULL DEFAULT FALSE AFTER `poste`;
ALTER TABLE `users` CHANGE `toujours_present` `toujours_present` TINYINT(1) NULL DEFAULT '1';
