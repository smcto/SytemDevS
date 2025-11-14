<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Routing\Router;
use Cake\Core\Configure;

/**
 * User Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $email
 * @property string $password
 * @property int $client_id
 * @property int $antenne_id
 * @property int $fournisseur_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $statut_id
 * @property string $telephone_portable
 * @property string $telephone_fixe
 * @property \Cake\I18n\FrozenDate $date_naissance
 * @property string $info_a_savoir
 * @property string $mode_renumeration
 * @property bool $is_vehicule
 * @property string $modele_vehicule
 * @property int $nbr_borne_transportable_vehicule
 * @property string $commentaire_vehicule
 * @property string $photo_nom
 * @property int $situation_id
 * @property string $type_contact
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Antenne $antenne
 * @property \App\Model\Entity\Fournisseur $fournisseur
 * @property \App\Model\Entity\UserTypeProfil[] $user_type_profils
 */
class User extends Entity
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
        /*'email' => true,
        'password' => true,
        'client_id' => true,
        'antenne_id' => true,
        'fournisseur_id' => true,
        'created' => true,
        'modified' => true,
        'client' => true,
        'antenne' => true,
        'fournisseur' => true,
        'user_type_profils' => true*/
        'id' => false,
        '*' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected $_virtual = ['full_name', 'url_photo', 'full_name_short'];

    protected function _setPassword($value)
    {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($value);
        }
    }

    protected function _getFullName()
    {
        return $this->prenom." ".$this->nom;
    }

    protected function _getFullNameShort()
    {
        return $this->prenom." ".($this->nom)[0].'.';
    }

    protected function _getUrlPhoto(){
        $url = Router::url('/',true)."img/users/default_photo_user.jpg";
        $filename = $this->photo_nom;

        if(!empty($filename) && file_exists(PATH_CONTACTS . $filename)){
            $url = Router::url('/',true)."uploads/contacts/".$filename;
        }
        return $url;
    }

    protected function _getUrlViewerPhoto(){
        $url = "";
        $filename = $this->photo_nom;

        if(!empty($filename) && file_exists(PATH_CONTACTS . $filename)){
            $url = Router::url('/',true)."uploads/contacts/".$filename;
        }
        return $url;
    }

    public function _getNumberGroupUser()
    {
        $typeProfilKonitys = Configure::read('typeProfilKonitys');

        if(!empty($user->profils)){
            foreach ($user->profils as $profil){
               if (in_array($user->profils[0]->id, $typeProfilKonitys)){
                   return $user->group_user = 2;
               } else {
                   return $user->group_user = 1;
               }
            }
        }
    }
}
