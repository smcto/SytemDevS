<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EquipementsVente Entity
 *
 * @property int $id
 * @property int $vente_id
 * @property int $equipement_id
 * @property int $qty
 *
 * @property \App\Model\Entity\Vente $vente
 * @property \App\Model\Entity\Equipement $equipement
 */
class EquipementVente extends Entity
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
        'id' => false,
        '*' => true
    ];

    protected $_virtual = ['is_rien_rempli'];

    public function _getIsRienRempli()
    {
        return $this->valeur_definir == false && $this->materiel_occasion == false && !$this->equipement_id;
    }
}
