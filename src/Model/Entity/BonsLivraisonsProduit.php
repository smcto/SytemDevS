<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BonsLivraisonsProduit Entity
 *
 * @property int $id
 * @property int $bons_livraison_id
 * @property int $catalog_produits_id
 * @property string|null $reference
 * @property string|null $nom
 * @property string|null $description_commercial
 * @property float|null $quantite_livree
 *
 * @property \App\Model\Entity\BonsLivraison $bons_livraison
 * @property \App\Model\Entity\CatalogProduit $catalog_produit
 */
class BonsLivraisonsProduit extends Entity
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
        '*' => true
    ];
}
