ALTER TABLE `clients` CHANGE `addr_lng` `addr_lng` FLOAT NULL DEFAULT NULL;
ALTER TABLE `clients` CHANGE `addr_lat` `addr_lat` FLOAT NULL DEFAULT NULL;
ALTER TABLE `ventes` CHANGE `client_addr_lng` `client_addr_lng` FLOAT NULL DEFAULT NULL;
ALTER TABLE `ventes` CHANGE `client_addr_lat` `client_addr_lat` FLOAT NULL DEFAULT NULL;