<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BonsPreparationsProduit Entity
 *
 * @property int $id
 * @property int $bons_preparation_id
 * @property int $catalog_produits_id
 * @property string|null $reference
 * @property string|null $nom
 * @property string|null $description_commercial
 * @property float $quantite
 * @property float|null $quantite_livree
 * @property float|null $rest
 * @property string|null $observation
 * @property string|null $statut
 *
 * @property \App\Model\Entity\BonsPreparation $bons_preparation
 * @property \App\Model\Entity\CatalogProduit $catalog_produit
 */
class BonsPreparationsProduit extends Entity
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
        '*' => true,
    ];
}
