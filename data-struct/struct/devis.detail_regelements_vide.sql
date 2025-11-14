ALTER TABLE `devis` CHANGE `delai_reglements` `delai_reglements` ENUM('commande','30j','15j','reception','echeances','') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
