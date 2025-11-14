ALTER TABLE `devis`
  DROP `adresse`,
  DROP `cp`,
  DROP `ville`,
  DROP `pays`;
ALTER TABLE `devis` ADD `sellsy_client_id` INT NULL AFTER `display_cheque`, ADD `sellsy_document_id` INT NULL AFTER `sellsy_client_id`;
ALTER TABLE `devis` ADD `is_in_sellsy` TINYINT(1) NOT NULL DEFAULT '0' AFTER `sellsy_document_id`;