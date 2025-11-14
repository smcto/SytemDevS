<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VillesCodePostal Entity
 *
 * @property int $ville_cp_id
 * @property string|null $ville_cp_fk_code_postal
 * @property int|null $ville_cp_fk_ville_id
 *
 * @property \App\Model\Entity\VilleCpFkVille $ville_cp_fk_ville
 */
class VillesCodePostal extends Entity
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
        'ville_cp_fk_code_postal' => true,
        'ville_cp_fk_ville_id' => true,
        'ville_cp_fk_ville' => true
    ];
}
