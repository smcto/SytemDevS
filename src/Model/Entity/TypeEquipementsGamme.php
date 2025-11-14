<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TypeEquipementsGamme Entity
 *
 * @property int $id
 * @property int $type_equipement_id
 * @property int $gamme_borne_id
 *
 * @property \App\Model\Entity\TypeEquipement $type_equipement
 * @property \App\Model\Entity\GammeBorne $gamme_borne
 */
class TypeEquipementsGamme extends Entity
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
        'type_equipement_id' => true,
        'gamme_borne_id' => true,
        'type_equipement' => true,
        'gamme_borne' => true
    ];
}
