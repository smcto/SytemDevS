ALTER TABLE `licences` ADD `nombre_utilisateur` INT NULL AFTER `numero_serie`; 
ALTER TABLE `licences` ADD `dispo` TINYINT(1) NULL AFTER `nombre_utilisateur`; 
ALTER TABLE `licences` CHANGE `dispo` `dispo` TINYINT(1) NULL DEFAULT '1'; 