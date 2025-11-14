
--
-- Base de données :  `selfizee_crm`
--

-- --------------------------------------------------------

--
-- Structure de la table `equipements`
--

DROP TABLE IF EXISTS `equipements`;
CREATE TABLE IF NOT EXISTS `equipements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_equipement_id` int(11) NOT NULL,
  `valeur` varchar(250) NOT NULL,
  `commentaire` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `is_filtrable` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_equipements` (`type_equipement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `type_equipements`
--

DROP TABLE IF EXISTS `type_equipements`;
CREATE TABLE IF NOT EXISTS `type_equipements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


--
ALTER TABLE `equipements`
  ADD CONSTRAINT `FK_equipements` FOREIGN KEY (`type_equipement_id`) REFERENCES `type_equipements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

