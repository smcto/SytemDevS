ALTER TABLE `licences` 
CHANGE `date_achat` `date_achat` DATE NULL, 
CHANGE `date_renouvellement` `date_renouvellement` DATE NULL, 
CHANGE `version` `version` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
