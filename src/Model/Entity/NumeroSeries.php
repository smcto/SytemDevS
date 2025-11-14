<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NumeroSeries Entity
 *
 * @property int $id
 * @property string $serial_nb
 * @property int $lot_produit_id
 * @property int $borne_id
 *
 * @property \App\Model\Entity\LotProduit $lot_produit
 * @property \App\Model\Entity\Borne $borne
 */
class NumeroSeries extends Entity
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
