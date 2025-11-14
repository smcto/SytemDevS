<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EquipementsAccessoiresVente Entity
 *
 * @property int $id
 * @property int $vente_id
 * @property int $type_equipement_id
 * @property int $equipement_id
 * @property int|null $qty
 *
 * @property \App\Model\Entity\Vente $vente
 * @property \App\Model\Entity\TypeEquipement $type_equipement
 * @property \App\Model\Entity\Equipement $equipement
 */
class EquipementsAccessoiresVente extends Entity
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
        // 'id' => false,
        '*' => true
    ];
}
