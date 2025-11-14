<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DevisObjet Entity
 *
 * @property int $id
 * @property string|null $name
 * @property int $devis_id
 *
 * @property \App\Model\Entity\Devi $devi
 */
class DevisObjet extends Entity
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
        'name' => true,
        'devis_id' => true,
        'devi' => true
    ];
}
