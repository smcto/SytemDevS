<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CatalogProduit Entity
 *
 * @property int $id
 * @property int $catalog_sous_categories_id
 * @property string $nom_commercial
 * @property string $nom_interne
 * @property string $description_commercial
 * @property string $prix_reference_ht
 * @property string $code_comptable
 * @property string $reference
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\CatalogSousCategory $catalog_sous_category
 */
class CatalogProduit extends Entity
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
        '*' => true,
    ];

    protected function _getCategoryList()
    {
        if (isset($this->catalog_produits_has_categories)) {
            $catalog_produits_has_categories = $this->catalog_produits_has_categories;
            $catagories = collection($this->catalog_produits_has_categories)->extract('catalog_category.nom')->toArray();
            return $catagories;
        }
    }

    protected function _getSousCategoryList()
    {
        if (isset($this->catalog_produits_has_categories)) {
            $catalog_produits_has_categories = $this->catalog_produits_has_categories;
            $catagories = collection($this->catalog_produits_has_categories)->extract('catalog_sous_category.nom')->toArray();
            return $catagories;
        }
    }
    protected function _getSousSousCategoryList()
    {
        if (isset($this->catalog_produits_has_categories)) {
            $catalog_produits_has_categories = $this->catalog_produits_has_categories;
            $catagories = collection($this->catalog_produits_has_categories)->extract('catalog_sous_sous_category.nom')->toArray();
            return $catagories;
        }
    }

    protected function _getAllCategoriesList()
    {
        if (isset($this->catalog_produits_has_categories)) {
            $catalog_produits_has_categories = $this->catalog_produits_has_categories;
            $cats = [];
            foreach ($catalog_produits_has_categories as $key => $cat) {
                $c = $cat->catalog_category->nom.' > '.$cat->catalog_sous_category->nom;
                $c .= $cat->catalog_sous_sous_category ? " > " . $cat->catalog_sous_sous_category->nom : "";
                $cats[] = $c;
            }

            return $cats;
        }
    }
}
