<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Dimension Entity
 *
 * @property int $id
 * @property string $dimension
 * @property string $poids
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $model_borne_id
 * @property int $partie_id
 *
 * @property \App\Model\Entity\ModelBorne $model_borne
 * @property \App\Model\Entity\Party $party
 */
class Dimension extends Entity
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
        'dimension' => true,
        'poids' => true,
        'created' => true,
        'modified' => true,
        'model_borne_id' => true,
        'partie_id' => true,
        'model_borne' => true,
        'party' => true
    ];
}
