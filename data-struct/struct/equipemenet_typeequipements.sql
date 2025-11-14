ALTER TABLE `equipements`
  DROP `is_filtrable`;
  ALTER TABLE `type_equipements` ADD `is_filtrable` BOOLEAN NOT NULL AFTER `nom`; 