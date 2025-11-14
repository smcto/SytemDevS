ALTER TABLE `clients` ADD `is_posted_on_event` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_by_webhooks`;
ALTER TABLE `client_contacts` ADD `is_by_webhooks` TINYINT(1) NOT NULL DEFAULT '0' AFTER `modified`;
ALTER TABLE `client_contacts` ADD `is_posted_on_event` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_by_webhooks`;
ALTER TABLE `documents` ADD `is_posted_on_event` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_by_webhooks`;

ALTER TABLE `clients` ADD `deleted_by_webhooks` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_by_webhooks`;
ALTER TABLE `documents` ADD `deleted_by_webhooks` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_by_webhooks`;
ALTER TABLE `client_contacts` ADD `deleted_by_webhooks` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_by_webhooks`;