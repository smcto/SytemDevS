<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EvenementBrief Entity
 *
 * @property int $id
 * @property int $evenement_id
 * @property string $adresse_exact
 * @property string $batiment
 * @property string $num_voie
 * @property string $code_postal
 * @property string $rue
 * @property int $acces
 * @property int $acces_modalite
 * @property string $contact_sp
 * @property string $nom_sp
 * @property int $prenom_sp
 * @property int $nb_personnes
 * @property string $horaire_debut
 * @property int $horaire_fin
 * @property \Cake\I18n\FrozenTime $date_installation
 * @property \Cake\I18n\FrozenTime $date_desinstallation
 * @property string $disposition_borne
 * @property int $distance_borne_prise
 * @property \Cake\I18n\FrozenTime $date_retrait_ant_locale
 * @property \Cake\I18n\FrozenTime $date_retour_antenne_locale
 * @property string $mail_nom_wifi
 * @property string $mail_code_wifi
 * @property string $mail_expediteur
 * @property string $mail_objet
 * @property string $mail_message
 * @property int $form_check
 * @property string $form_text
 * @property string $fb_nom_page
 * @property string $fb_titre_album
 * @property string $fb_description_album
 * @property string $fb_admin
 * @property string $animation_horaire
 * @property string $animation_tenue_souhaite
 * @property string $animation_objectifs
 * @property int $derniere_etape
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Evenement $evenement
 */
class EvenementBrief extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'evenement_id' => true,
        'adresse_exact' => true,
        'batiment' => true,
        'num_voie' => true,
        'code_postal' => true,
        'rue' => true,
        'acces' => true,
        'acces_modalite' => true,
        'contact_sp' => true,
        'nom_sp' => true,
        'prenom_sp' => true,
        'nb_personnes' => true,
        'horaire_debut' => true,
        'horaire_fin' => true,
        'date_installation' => true,
        'date_desinstallation' => true,
        'disposition_borne' => true,
        'distance_borne_prise' => true,
        'date_retrait_ant_locale' => true,
        'date_retour_antenne_locale' => true,
        'mail_nom_wifi' => true,
        'mail_code_wifi' => true,
        'mail_expediteur' => true,
        'mail_objet' => true,
        'mail_message' => true,
        'form_check' => true,
        'form_text' => true,
        'fb_nom_page' => true,
        'fb_titre_album' => true,
        'fb_description_album' => true,
        'fb_admin' => true,
        'animation_horaire' => true,
        'animation_tenue_souhaite' => true,
        'animation_objectifs' => true,
        'derniere_etape' => true,
        'created' => true,
        'modified' => true,
        'evenement' => true
    ];
}
