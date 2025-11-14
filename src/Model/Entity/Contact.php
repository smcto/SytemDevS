<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * Contact Entity
 *
 * @property int $id
 * @property int $statut_id
 * @property string $nom
 * @property string $prenom
 * @property string $telephone_portable
 * @property string $telephone_fixe
 * @property string $email
 * @property \Cake\I18n\FrozenDate $date_naissance
 * @property string $info_a_savoir
 * @property string $mode_renumeration
 * @property bool $is_vehicule
 * @property string $modele_vehicule
 * @property int $nbr_borne_transportable_vehicule
 * @property string $commentaire_vehicule
 * @property int $antenne_id
 * @property string $photo_nom
 * @property int $situation_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Antenne $antenne
 * @property \App\Model\Entity\Situation $situation
 * @property \App\Model\Entity\Statut $statut
 */
class Contact extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *s
     * @var array
     */
    protected $_accessible = [
        /*'statut_id' => true,
        'nom' => true,
        'prenom' => true,
        'telephone' => true,
        'email' => true,
        'date_naissance' => true,
        'info_a_savoir' => true,
        'mode_renumeration' => true,
        'is_vehicule' => true,
        'modele_vehicule' => true,
        'nbr_borne_transportable_vehicule' => true,
        'commentaire_vehicule' => true,
        'antenne_id' => true,
        'photo_nom' => true,
        'situation_id' => true,
        'created' => true,
        'modified' => true,
        'antenne' => true,
        'situation' => true,
        'statut' => true*/
        'id' => false,
        '*' => true,
    ];

    protected $_virtual = ['full_name', 'url_photo'];

    protected function _getFullName()
    {
        return $this->_properties['prenom']." ".$this->_properties['nom'];
    }

    protected function _getUrlPhoto(){
        $url = Router::url('/',true)."img/users/default_photo_user.jpg";
        $filename = $this->_properties['photo_nom'];

        if(!empty($filename) && file_exists(PATH_CONTACTS . $filename)){
            $url = Router::url('/',true)."uploads/contacts/".$filename;
        }
        return $url;
    }
}
