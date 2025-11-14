ALTER TABLE `antennes` ADD `id_wp` INT NULL AFTER `id`, ADD UNIQUE (`id_wp`);
ALTER TABLE antennes DROP INDEX id_wp