<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Borne Entity
 *
 * @property int $id
 * @property int $numero
 * @property string $couleur
 * @property \Cake\I18n\FrozenTime $expiration_sb
 * @property string $commentaire
 * @property bool $is_prette
 * @property int $parc_id
 * @property int $model_borne_id
 * @property \Cake\I18n\FrozenTime $date_arrive_estime
 * @property int $antenne_id
 * @property int $client_id
 * @property string $ville
 * @property string $long
 * @property string $lat
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Parc $parc
 * @property \App\Model\Entity\ModelBorne $model_borne
 * @property \App\Model\Entity\Antenne $antenne
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\ActuBorne[] $actu_bornes
 * @property \App\Model\Entity\VenteBornes[] $vente_bornes
 * @property \App\Model\Entity\BorneLogiciel[] $borne_logiciels
 * @property \App\Model\Entity\BornesHasMedia[] $bornes_has_medias
 */
class Borne extends Entity
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
        '*' => true,
    ];

    public function _getSiLouee()
    {
        return $this->is_sous_louee == 1 ? 'Oui' : 'Non';
    }
    
    public function _getFormatNumero() 
    {
        if(isset($this->model_borne->gammes_borne->notation)) {
            return $this->model_borne->gammes_borne->notation . $this->numero;
        }
        return $this->numero;
    }

    public function _getDateResiliation()
    {
        return $this->contrat_fin ? $this->contrat_fin->subMonth(6) : '';
    }
    
    public function _getGarantieDureeMois()
    {
        return $this->garantie_duree ? str_replace('_mois', '', $this->garantie_duree). ' mois' : '';
    }
}
