<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CatalogSousCategory Entity
 *
 * @property int $id
 * @property int $catalog_categories_id
 * @property string $nom
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\CatalogSousCategory $catalog_sous_category
 */
class CatalogSousCategory extends Entity
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
        'catalog_categories_id' => true,
        'nom' => true,
        'catalog_sous_category' => true,
        'created' => true,
        'modified' => true
    ];
}
