<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StockAntenne Entity
 *
 * @property int $id
 * @property float $bobine_dnp
 * @property float $bobine_mitsu
 * @property float $imprimante_dnp
 * @property float $imprimante_mitsu
 * @property \Cake\I18n\FrozenDate $date_recensement
 * @property int $antenne_id
 *
 * @property \App\Model\Entity\Antenne $antenne
 */
class StockAntenne extends Entity
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
        'bobine_dnp' => true,
        'bobine_mitsu' => true,
        'imprimante_dnp' => true,
        'imprimante_mitsu' => true,
        'date_recensement' => true,
        'antenne_id' => true,
        'antenne' => true
    ];
}
