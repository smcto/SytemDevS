ALTER TABLE `devis_produits` CHANGE `remise_value` `remise_value` DECIMAL(10,2) NULL, CHANGE `remise_unity` `remise_unity` ENUM('%','€') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
