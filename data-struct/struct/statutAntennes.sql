ALTER TABLE `antennes` ADD `statut` TINYINT NOT NULL AFTER `fond_vert`;

ALTER TABLE `antennes` CHANGE `statut` `statut` TINYINT(1) NULL;