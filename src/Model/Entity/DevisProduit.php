<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DevisProduit Entity
 *
 * @property int $id
 * @property int|null $titre
 * @property string|null $reference
 * @property int|null $quantite_usuelle
 * @property float|null $prix_reference_ht
 * @property string|null $nom_interne
 * @property string|null $nom_commercial
 * @property string|null $description_commercial
 * @property string|null $commentaire_ligne
 * @property string|null $titre_ligne
 * @property bool|null $saut_ligne
 * @property float|null $sous_total
 * @property bool $saut_page
 */
class DevisProduit extends Entity
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
