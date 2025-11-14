CREATE TABLE `couleurs`(     `id` INT NOT NULL AUTO_INCREMENT ,     `couleur` VARCHAR(250) NOT NULL ,     `created` DATETIME ,     `modified` DATETIME ,     PRIMARY KEY (`id`)  );

CREATE TABLE `model_bornes_has_couleurs`(     `model_borne_id` INT NOT NULL ,     `couleur_id` INT NOT NULL   );

ALTER TABLE `bornes` DROP COLUMN `couleur_possible_id`;
ALTER TABLE `bornes` ADD `couleur_id` INT NOT NULL AFTER `is_prette`; 

ALTER TABLE `bornes` ADD CONSTRAINT `FK_bornes` FOREIGN KEY (`couleur_id`) REFERENCES `couleurs` (`id`) ON DELETE SET NULL  ON UPDATE SET NULL ;

DROP TABLE `couleur_possibles`;

ALTER TABLE `model_bornes_has_couleurs`     CHANGE `model_borne_id` `model_borne_id` INT(11) NOT NULL,     CHANGE `couleur_id` `couleur_id` INT(11) NOT NULL,    ADD PRIMARY KEY(`model_borne_id`, `couleur_id`);

