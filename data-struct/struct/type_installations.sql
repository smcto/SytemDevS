
ALTER TABLE `evenements` ADD `desinstallation_user_id` INT NULL COMMENT 'Id de celui qui est affecté à la désinstallation' AFTER `user_id`;








ALTER TABLE `evenements` CHANGE `type_installation` `type_installation` INT(2) NULL DEFAULT NULL;
ALTER TABLE `evenements` ADD `desinstallation_id` INT(4) NOT NULL AFTER `type_installation`;

CREATE TABLE `type_installations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `type` smallint(1) NOT NULL DEFAULT '1' COMMENT '0: desinstallation, 1: installation',
  `commentaire` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

INSERT INTO `type_installations` (`id`, `nom`, `type`, `created`, `modified`) VALUES
(1, 'Nos soins', 1, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(2, 'Retrait', 1, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(3, 'Envoi transporteur', 1, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(5, 'Pick-up', 0, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(6, 'Désinstallation &amp; livraison', 0, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(7, 'Désinstallation seulement', 0, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(8, 'Livraison seulement', 0, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(9, 'Autre', 0, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(10, 'Non défini', 0, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(11, 'Pick-up', 1, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(12, 'Livraison &amp; installation', 1, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(13, 'Livraison seulement', 1, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(14, 'Installation seulement', 1, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(15, 'Autre', 1, '2019-01-21 18:04:07', '2019-01-21 18:04:07'),
(16, 'Non défini', 1, '2019-01-21 18:04:07', '2019-01-21 18:04:07');