
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `documents_model_bornes` (
  `id` int(11) NOT NULL,
  `nom_fichier` varchar(255) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `chemin` varchar(255) DEFAULT NULL,
  `nom_origine` varchar(255) DEFAULT NULL,
  `model_borne_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `documents_model_bornes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `documents_model_bornes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
