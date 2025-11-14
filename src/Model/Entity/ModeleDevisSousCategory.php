<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ModeleDevisSousCategory Entity
 *
 * @property int $id
 * @property int $modele_devis_categories_id
 * @property string $name
 *
 * @property \App\Model\Entity\ModeleDevisCategory $modele_devis_category
 */
class ModeleDevisSousCategory extends Entity
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
        'modele_devis_categories_id' => true,
        'name' => true,
        'modele_devis_category' => true
    ];
}
