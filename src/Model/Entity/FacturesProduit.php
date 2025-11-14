<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FacturesProduit Entity
 *
 * @property int $id
 * @property int|null $type_equipement_id
 * @property int|null $equipement_id
 * @property int|null $qty
 * @property int|null $facture_id
 *
 * @property \App\Model\Entity\TypeEquipement $type_equipement
 * @property \App\Model\Entity\Equipement $equipement
 * @property \App\Model\Entity\Facture $facture
 */
class FacturesProduit extends Entity
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
}
