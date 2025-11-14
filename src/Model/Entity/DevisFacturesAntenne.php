<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DevisFacturesAntenne Entity
 *
 * @property int $id
 * @property int $devis_facture_id
 * @property int $antenne_id
 *
 * @property \App\Model\Entity\DevisFacture $devis_facture
 * @property \App\Model\Entity\Antenne $antenne
 */
class DevisFacturesAntenne extends Entity
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
        'devis_facture_id' => true,
        'antenne_id' => true,
        'devis_facture' => true,
        'antenne' => true
    ];
}
