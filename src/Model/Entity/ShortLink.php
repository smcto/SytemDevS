<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShortLink Entity
 *
 * @property int $id
 * @property string $short_link
 * @property string $link
 * @property int|null $devi_id
 * @property \Cake\I18n\FrozenDate|null $created
 * @property \Cake\I18n\FrozenDate|null $modified
 *
 * @property \App\Model\Entity\Devi $devi
 */
class ShortLink extends Entity
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
