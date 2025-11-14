ALTER TABLE `type_profils` ADD `alias` VARCHAR(100) NULL DEFAULT NULL AFTER `modified`;
UPDATE `type_profils` SET `alias` = 'admin' WHERE `type_profils`.`id` = 1;
UPDATE `type_profils` SET `alias` = 'finance' WHERE `type_profils`.`id` = 3;
UPDATE `type_profils` SET `alias` = 'animateur' WHERE `type_profils`.`id` = 7;
UPDATE `type_profils` SET `alias` = 'fournisseur' WHERE `type_profils`.`id` = 8;
UPDATE `type_profils` SET `alias` = 'commercial' WHERE `type_profils`.`id` = 11;
UPDATE `type_profils` SET `alias` = 'compta' WHERE `type_profils`.`id` = 12;