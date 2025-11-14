ALTER TABLE `statut_historiques` ADD `reglement_id` INT NULL DEFAULT NULL COMMENT 'si ajout reglement' AFTER `user_id`, ADD `commentaires_facture_id` INT NULL DEFAULT NULL COMMENT 'si ajout commentaire' AFTER `reglement_id`;

