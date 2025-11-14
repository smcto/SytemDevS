ALTER TABLE `contacts` ADD `vehicule` VARCHAR(255) NULL AFTER `modified`, ADD `capacite_chargement_borne` VARCHAR(255) NULL AFTER `vehicule`, ADD `creneaux_disponibilite` VARCHAR(255) NULL AFTER `capacite_chargement_borne`, ADD `zone_intervention` VARCHAR(255) NULL AFTER `creneaux_disponibilite`, ADD `fonction` VARCHAR(255) NULL AFTER `zone_intervention`, ADD `adresse` VARCHAR(255) NULL AFTER `fonction`, ADD `cp` VARCHAR(255) NULL AFTER `adresse`, ADD `ville` VARCHAR(255) NULL AFTER `cp`, ADD `pays` VARCHAR(255) NULL AFTER `ville`, ADD `commentaire_interne` VARCHAR(255) NULL AFTER `pays`;
ALTER TABLE `contacts` ADD `client_id` INT NULL AFTER `commentaire_interne`;
ALTER TABLE `contacts` ADD `fournisseur_id` INT NULL AFTER `client_id`;
ALTER TABLE `contacts` ADD `user_id` INT NULL AFTER `fournisseur_id`;
ALTER TABLE `contacts` CHANGE `antenne_id` `antenne_id` INT(11) NULL, CHANGE `situation_id` `situation_id` INT(11) NULL;
ALTER TABLE `contacts` CHANGE `commentaire_interne` `commentaire_interne` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `users` ADD `password_visible` VARCHAR(255) NULL AFTER `password`;

ALTER TABLE `contacts` ADD `civilite` TINYINT(1) NOT NULL DEFAULT '0' AFTER `prenom`;

INSERT INTO `type_profils` (`id`, `nom`, `created`, `modified`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Konitys projet', NULL, NULL),
(3, 'Konitys finance', NULL, NULL),
(4, 'Antenne', NULL, NULL),
(5, 'Installateur', NULL, NULL),
(6, 'Livreur', NULL, NULL),
(7, 'Animateur', NULL, NULL),
(8, 'Fournisseur', NULL, NULL),
(9, 'Clients', NULL, NULL);
