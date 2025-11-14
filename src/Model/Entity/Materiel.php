<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Materiel Entity
 *
 * @property int $id
 * @property string $materiel
 * @property string $descriptif
 * @property string $photos
 * @property string $notice_tuto
 * @property float $dimension
 * @property float $poids
 * @property string $consignes
 * @property int $variation_stok
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Materiel extends Entity
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
        'materiel' => true,
        'descriptif' => true,
        'photos' => true,
        'notice_tuto' => true,
        'dimension' => true,
        'poids' => true,
        'consignes' => true,
        'variation_stok' => true,
        'created' => true,
        'modified' => true
    ];
}
