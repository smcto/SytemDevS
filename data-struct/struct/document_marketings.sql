DROP TABLE IF EXISTS `document_marketings`;
CREATE TABLE IF NOT EXISTS `document_marketings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catalogue_spherik` varchar(500) DEFAULT NULL,
  `catalogue_classik` varchar(500) DEFAULT NULL,
  `cgl_classik_part` varchar(500) DEFAULT NULL,
  `cgl_spherik_part` varchar(500) DEFAULT NULL,
  `cgl_pro` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*[17:01:41][3884 ms]*/ ALTER TABLE `document_marketings`     CHANGE `cgl_classik_part` `cgl_classik_part` TEXT(500) NULL ,     CHANGE `cgl_spherik_part` `cgl_spherik_part` TEXT(500) NULL ,     CHANGE `cgl_pro` `cgl_pro` TEXT(500) NULL ;
