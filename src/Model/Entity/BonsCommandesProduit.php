<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BonsCommandesProduit Entity
 *
 * @property int $id
 * @property int $bons_commande_id
 * @property int|null $catalog_produits_id
 * @property string|null $reference
 * @property string|null $nom
 * @property float|null $quantite
 *
 * @property \App\Model\Entity\BonsCommande $bons_commande
 * @property \App\Model\Entity\Produit $produit
 */
class BonsCommandesProduit extends Entity
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
