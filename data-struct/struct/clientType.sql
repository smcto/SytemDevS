ALTER TABLE `clients`     ADD COLUMN `clientType` VARCHAR(255) NULL AFTER `country`;
ALTER TABLE `clients`     CHANGE `clientType` `client_type` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ;

