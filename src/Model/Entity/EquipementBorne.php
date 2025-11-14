<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EquipementBorne Entity
 *
 * @property int $id
 * @property int|null $equipement_id
 * @property int $borne_id
 * @property int|null $type_equipement_id
 * @property int|null $numero_serie_id
 * @property string|null $precisions
 * @property \Cake\I18n\FrozenDate $created
 * @property \Cake\I18n\FrozenDate $modified
 *
 * @property \App\Model\Entity\Equipement $equipement
 * @property \App\Model\Entity\Borne $borne
 * @property \App\Model\Entity\TypeEquipement $type_equipement
 * @property \App\Model\Entity\NumeroSeries $numero_series
 */
class EquipementBorne extends Entity
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
        '*' => true,
    ];
}
