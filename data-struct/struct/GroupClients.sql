CREATE TABLE `crm_app`.`groupe_clients` ( `id` INT NOT NULL AUTO_INCREMENT , `nom` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , INDEX (`id`)) ENGINE = InnoDB;
ALTER TABLE `groupe_clients` ADD PRIMARY KEY(`id`);
ALTER TABLE `clients` ADD `groupe_client_id` INT NULL AFTER `is_posted_on_event`;
