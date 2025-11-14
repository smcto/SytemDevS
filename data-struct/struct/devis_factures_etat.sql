ALTER TABLE `devis_factures` CHANGE `status` `status` ENUM('fix','partial-payment','paid','delay','canceled') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL; 

