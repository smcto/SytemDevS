CREATE TABLE `facture_deductions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ca_ht_deduire` decimal(10,2) DEFAULT '0.00',
  `avoir_ht_deduire` decimal(10,2) DEFAULT '0.00',
  `pca_part` decimal(10,2) DEFAULT '0.00',
  `pca_pro` decimal(10,2) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8