
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `documents_antennes` (
  `id` int(11) NOT NULL,
  `nom_fichier` varchar(255) DEFAULT NULL,
  `nom_origine` varchar(255) DEFAULT NULL,
  `chemin` varchar(255) DEFAULT NULL,
  `antenne_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `documents_antennes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `documents_antennes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
