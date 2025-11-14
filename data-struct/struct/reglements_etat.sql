ALTER TABLE `reglements` CHANGE `etat` `etat` ENUM('confirmed','draft','validate','') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '';
