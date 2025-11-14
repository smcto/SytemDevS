<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VentesCommercialContact Entity
 *
 * @property int $id
 * @property string|null $full_name
 * @property string|null $telfixe
 * @property string|null $telportable
 * @property int $vente_id
 *
 * @property \App\Model\Entity\Vente $vente
 */
class VentesCommercialContact extends Entity
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
