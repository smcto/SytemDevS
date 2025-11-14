SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
CREATE TABLE `factures` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `antenne_id` int(11) DEFAULT NULL,
  `installateur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `factures`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `factures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
ALTER TABLE `factures` CHANGE `installateur_id` `user_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `factures` ADD `nom_fichier` VARCHAR(255) NULL AFTER `montant`, ADD `nom_origine` VARCHAR(255) NULL AFTER `nom_fichier`;
ALTER TABLE `factures` ADD `etat` ENUM('attente_de_traitement','accepte','refuse','mise_en_attente') NULL AFTER `nom_origine`;
ALTER TABLE `factures` CHANGE `etat` `etat` ENUM('attente_de_traitement','accepte','refuse','mise_en_attente') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'attente_de_traitement';



