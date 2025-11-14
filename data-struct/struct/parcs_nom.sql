ALTER TABLE `parcs` ADD `nom2` VARCHAR(255) NULL DEFAULT NULL AFTER `nom`;
UPDATE `parcs` SET `nom2` = 'Achat directe' WHERE `parcs`.`id` = 1;
UPDATE `parcs` SET `nom2` = 'Location' WHERE `parcs`.`id` = 2;
UPDATE `parcs` SET `nom2` = 'Stock tampon' WHERE `parcs`.`id` = 3;
UPDATE `parcs` SET `nom2` = 'Location financière' WHERE `parcs`.`id` = 4;
UPDATE `parcs` SET `nom2` = 'Remplacement matériel' WHERE `parcs`.`id` = 8;
UPDATE `parcs` SET `nom2` = 'Location longue durée' WHERE `parcs`.`id` = 9;
UPDATE `parcs` SET `nom2` = 'Borne d\'occasion' WHERE `parcs`.`id` = 10;