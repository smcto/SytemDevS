<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AvoirsProduit Entity
 *
 * @property int $id
 * @property int|null $titre
 * @property string|null $reference
 * @property float|null $quantite_usuelle
 * @property float|null $prix_reference_ht
 * @property int|null $catalog_unites_id
 * @property float|null $remise_value
 * @property string|null $remise_unity
 * @property string|null $nom_interne
 * @property string|null $nom_commercial
 * @property string|null $description_commercial
 * @property string|null $commentaire_ligne
 * @property string|null $titre_ligne
 * @property float|null $sous_total
 * @property int|null $avoir_id
 * @property int|null $catalog_produit_id
 * @property string $type_ligne
 * @property int $i_position
 * @property int|null $line_option
 * @property float|null $tva
 *
 * @property \App\Model\Entity\CatalogUnite $catalog_unite
 * @property \App\Model\Entity\Avoir $avoir
 * @property \App\Model\Entity\CatalogProduit $catalog_produit
 */
class AvoirsProduit extends Entity
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
