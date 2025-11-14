ALTER TABLE `commentaires_clients` ADD `titre` VARCHAR(255) NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `commentaires_clients` ADD `user_id` INT NOT NULL AFTER `modified`;