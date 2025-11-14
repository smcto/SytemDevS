<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ModeleDevisFacturesSousCategory Entity
 *
 * @property int $id
 * @property int $modele_devis_factures_category_id
 * @property string $name
 *
 * @property \App\Model\Entity\ModeleDevisFacturesCategory $modele_devis_factures_category
 * @property \App\Model\Entity\Invoice[] $devis_factures
 */
class ModeleDevisFacturesSousCategory extends Entity
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
        'modele_devis_factures_category_id' => true,
        'name' => true,
        'modele_devis_factures_category' => true,
        'devis_factures' => true
    ];
}
