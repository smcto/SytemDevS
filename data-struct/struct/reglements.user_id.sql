ALTER TABLE `reglements`     ADD COLUMN `user_id` INT NULL AFTER `sellsy_client_id`;
ALTER TABLE `reglements` ADD CONSTRAINT `FK_reglements` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
