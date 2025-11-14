ALTER TABLE `devis` ADD `categorie_tarifaire` ENUM('ht','ttc') NOT NULL DEFAULT 'ht' AFTER `modele_devis_sous_categories_id`; 
ALTER TABLE `devis` CHANGE `categorie_tarifaire` `categorie_tarifaire` ENUM('ht','ttc') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'ht'; 
