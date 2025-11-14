<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CatalogProduitsHasCategory Entity
 *
 * @property int $id
 * @property int $catalog_produit_id
 * @property int $catalog_category_id
 * @property int $catalog_sous_category_id
 *
 * @property \App\Model\Entity\CatalogProduit $catalog_produit
 * @property \App\Model\Entity\CatalogCategory $catalog_category
 * @property \App\Model\Entity\CatalogSousCategory $catalog_sous_category
 */
class CatalogProduitsHasCategory extends Entity
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
