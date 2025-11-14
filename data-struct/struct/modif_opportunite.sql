ALTER TABLE `opportunite_clients` DROP FOREIGN KEY `FK_opportunite_clients`;
DROP TABLE `opportunite_clients`;
ALTER TABLE `opportunites`     ADD COLUMN `client_id` INT NULL AFTER `modified`;
