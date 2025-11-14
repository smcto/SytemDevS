ALTER TABLE `evenements` ADD `publication_fb` TINYINT(1) NOT NULL COMMENT 'Autorisation d\'une publication facebook' AFTER `location_week`;
ALTER TABLE `evenements` ADD `nom_fb` VARCHAR(120) NULL COMMENT 'Nom de la fb qui partage les photos dans une page liée au client' AFTER `publication_fb`;
ALTER TABLE `evenements` ADD `mail_expediteur` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'Mail de celui qui envoye un mail récap au client' AFTER `is_envoye_recap`;


CREATE TABLE `evenement_briefs` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`evenement_id` int(11) NOT NULL,
	`adresse_exact` varchar(100) NULL,
	`batiment` varchar(50) NULL,
	`num_voie` varchar(8) NULL,
	`code_postal` varchar(15) NULL,
	`rue` varchar(100) NULL,
	`acces` smallint(2) NULL,
	`acces_modalite` smallint(2) NULL,
	
	`contact_sp` varchar(20) NULL COMMENT 'Contact sur place',
	`nom_sp` varchar(100) NULL COMMENT 'Nom du contact sur place',
	`prenom_sp` varchar(100) NULL,
	`nb_personnes` int(3) NULL COMMENT 'Nombre de personnes évènements',
	`horaire_debut` varchar(8) NULL COMMENT 'Début de l''évènement',
	`horaire_fin` varchar(8) NULL COMMENT 'Fin de l''évènement',
	`date_installation` datetime NULL,
	`date_desinstallation` datetime NULL,
	`disposition_borne` varchar(120) NULL,
	`distance_borne_prise` int(3) NULL,
	`date_retrait_ant_locale` datetime NULL,
	`date_retour_antenne_locale` datetime NULL,
	
	`mail_nom_wifi` varchar(120) NULL,
	`mail_code_wifi` varchar(120) NULL,
	`mail_expediteur` varchar(120) NULL,
	`mail_destinataire` varchar(120) NULL COMMENT 'Mail de celui où on envoye les photos de l\'evenement',
	`mail_objet` varchar(120) NULL,
	`mail_message` longtext NULL,
	
	`form_check` tinyint(4) DEFAULT NULL COMMENT 'Si le client souhaite obtenir les coordonnées',
	`form_text` longtext NULL COMMENT 'Formulaire de saisie pour le client',
	
	`fb_nom_page` varchar(120) NULL,
	`fb_titre_album` varchar(120) NULL,
	`fb_description_album` longtext NULL,
	`fb_admin` varchar(120) NULL,
	
	`animation_horaire` varchar(8) NULL,
	`animation_tenue_souhaite` varchar(200) NULL,
	`animation_objectifs` longtext NULL,
	
	`derniere_etape` smallint(2) NULL COMMENT 'dérnière etape faite par l''utilisateur',
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;