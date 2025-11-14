<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DevisTypeDoc Entity
 *
 * @property int $id
 * @property string $nom
 * @property string|null $image
 * @property string|null $header
 * @property string|null $footer
 * @property string $prefix_num
 * @property \Cake\I18n\FrozenDate $created
 * @property \Cake\I18n\FrozenDate $modified
 */
class DevisTypeDoc extends Entity
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
        'nom' => true,
        'image' => true,
        'header' => true,
        'footer' => true,
        'prefix_num' => true,
        'created' => true,
        'modified' => true
    ];
}
