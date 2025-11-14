<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FactureDeduction Entity
 *
 * @property int $id
 * @property float|null $ca_ht_deduire
 * @property float|null $avoir_ht_deduire
 * @property float|null $pca_part
 * @property float|null $pca_pro
 * @property int|null $annee
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class FactureDeduction extends Entity
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
        'ca_ht_deduire' => true,
        'avoir_ht_deduire' => true,
        'pca_part' => true,
        'pca_pro' => true,
        'annee' => true,
        'created' => true,
        'modified' => true
    ];
}
