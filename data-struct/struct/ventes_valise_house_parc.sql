ALTER TABLE `ventes` ADD `is_without_app_photos` TINYINT(1) NOT NULL DEFAULT '0' AFTER `livraison_date`;
ALTER TABLE `ventes` ADD `parc_id` INT NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `ventes` ADD `parc_duree_id` INT NULL DEFAULT NULL AFTER `is_without_app_photos`;
ALTER TABLE `ventes` ADD `is_valise_with_tete` TINYINT(1) NOT NULL DEFAULT '0' AFTER `parc_duree_id`;
ALTER TABLE `ventes` ADD `is_valise_with_pied` TINYINT(1) NOT NULL DEFAULT '0' AFTER `parc_duree_id`;
ALTER TABLE `ventes` ADD `is_valise_with_socle` TINYINT(1) NOT NULL DEFAULT '0' AFTER `parc_duree_id`;
ALTER TABLE `ventes` ADD `is_house_with_tete` TINYINT(1) NOT NULL DEFAULT '0' AFTER `parc_duree_id`;
ALTER TABLE `ventes` ADD `is_house_with_pied` TINYINT(1) NOT NULL DEFAULT '0' AFTER `parc_duree_id`;
ALTER TABLE `ventes` ADD `is_house_with_socle` TINYINT(1) NOT NULL DEFAULT '0' AFTER `parc_duree_id`;