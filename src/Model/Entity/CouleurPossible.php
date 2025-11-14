<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CouleurPossible Entity
 *
 * @property int $id
 * @property string $couleur
 * @property int $model_borne_id
 *
 * @property \App\Model\Entity\ModelBorne $model_borne
 */
class CouleurPossible extends Entity
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
        'couleur' => true,
        'model_borne_id' => true,
        'model_borne' => true
    ];
}
