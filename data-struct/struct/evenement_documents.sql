CREATE TABLE `evenement_documents`(     `id` INT NOT NULL AUTO_INCREMENT ,     `evenement_id` INT NOT NULL ,     `document_id` INT NOT NULL ,     PRIMARY KEY (`id`)  );
ALTER TABLE `evenement_documents` ADD CONSTRAINT `FK_evenement_documents` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE  ON UPDATE CASCADE ;
ALTER TABLE `evenement_documents` ADD CONSTRAINT `FK_evenement_documents_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE  ON UPDATE CASCADE ;
