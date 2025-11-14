<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DevisAntenne Entity
 *
 * @property int $id
 * @property int $devis_id
 * @property int $antennes_id
 *
 * @property \App\Model\Entity\Devi $devi
 * @property \App\Model\Entity\Antenne $antenne
 */
class DevisAntenne extends Entity
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
        'devis_id' => true,
        'antennes_id' => true,
        'devi' => true,
        'antenne' => true
    ];
}
