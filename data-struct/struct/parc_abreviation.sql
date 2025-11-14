ALTER TABLE `parcs` ADD `abreviation` VARCHAR(30) NULL DEFAULT NULL AFTER `nom2`;
UPDATE `parcs` SET `abreviation` = 'Vente' WHERE `parcs`.`id` = 1;
UPDATE `parcs` SET `abreviation` = 'Loca' WHERE `parcs`.`id` = 2;
UPDATE `parcs` SET `abreviation` = 'Stock tampon' WHERE `parcs`.`id` = 3;
UPDATE `parcs` SET `abreviation` = 'Loc fi' WHERE `parcs`.`id` = 4;
UPDATE `parcs` SET `abreviation` = 'Remplacement matériel' WHERE `parcs`.`id` = 8;
UPDATE `parcs` SET `abreviation` = 'Loca longue durée' WHERE `parcs`.`id` = 9;
UPDATE `parcs` SET `abreviation` = 'Occasion' WHERE `parcs`.`id` = 10;
UPDATE `parcs` SET `abreviation` = 'SAV' WHERE `parcs`.`id` = 11;