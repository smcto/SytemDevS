ALTER TABLE `opportunite_statuts` ADD `indent` VARCHAR(250) NOT NULL AFTER `nom`;
/*[11:43:36][  94 ms]*/ UPDATE `opportunite_statuts` SET `indent`='ouvert' WHERE `id`='1' AND `nom`='Ouverte' AND `indent`='' AND `created` IS NULL AND `modified` IS NULL;
/*[11:43:42][  93 ms]*/ UPDATE `opportunite_statuts` SET `indent`='perdue' WHERE `id`='3' AND `nom`='Perdue' AND `indent`='' AND `created` IS NULL AND `modified` IS NULL;
/*[11:43:45][  78 ms]*/ UPDATE `opportunite_statuts` SET `indent`='retard' WHERE `id`='4' AND `nom`='En retard' AND `indent`='' AND `created` IS NULL AND `modified` IS NULL;
/*[11:43:50][ 109 ms]*/ UPDATE `opportunite_statuts` SET `indent`='annulle' WHERE `id`='5' AND `nom`='Annulée' AND `indent`='' AND `created` IS NULL AND `modified` IS NULL;
/*[11:43:54][  94 ms]*/ UPDATE `opportunite_statuts` SET `indent`='ferme' WHERE `id`='6' AND `nom`='Fermée' AND `indent`='' AND `created` IS NULL AND `modified` IS NULL;
/*[11:43:56][  78 ms]*/ UPDATE `opportunite_statuts` SET `indent`='hot' WHERE `id`='7' AND `nom`='Hot' AND `indent`='' AND `created`='2020-08-11 00:00:00' AND `modified` IS NULL;
