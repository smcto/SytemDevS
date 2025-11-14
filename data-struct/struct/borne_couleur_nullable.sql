ALTER TABLE `bornes` CHANGE `couleur_id` `couleur_id` INT(11) NULL DEFAULT '0';
ALTER TABLE `equipement_bornes` ADD `aucun` TINYINT(1) NOT NULL DEFAULT '0' AFTER `modified`;
ALTER TABLE `commentaires_factures` CHANGE `created` `created` DATE NULL DEFAULT NULL, CHANGE `modified` `modified` DATE NULL DEFAULT NULL;