<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SousAccessoire Entity
 *
 * @property int $id
 * @property string|null $name
 * @property int $accessoire_id
 *
 * @property \App\Model\Entity\GammesBorne[] $gammes_bornes
 * @property \App\Model\Entity\AccessoiresGamme[] $accessoires_gammes
 * @property \App\Model\Entity\Accessoire $accessoire
 */
class SousAccessoire extends Entity
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

    public function _getGammesBornesList()
    {
        if (isset($this->gammes_bornes)) {
            return collection($this->gammes_bornes)->extract('name')->toArray();
        }
    }
}
