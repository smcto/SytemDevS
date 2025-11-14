ALTER TABLE `devis` DROP `moyen_reglement`;
ALTER TABLE `devis` ADD `moyen_reglements` TEXT NULL DEFAULT NULL AFTER `date_validite`;