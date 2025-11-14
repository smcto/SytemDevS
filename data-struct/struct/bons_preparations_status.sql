ALTER TABLE `bons_preparations` CHANGE `statut` `statut` ENUM('en_attente','en_prepa','pret_exp','expedie','') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'en_attente'; 
