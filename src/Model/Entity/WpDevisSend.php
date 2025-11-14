<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WpDevisSend Entity
 *
 * @property int $id
 * @property int $id_post_wp
 * @property bool $is_send
 * @property \Cake\I18n\FrozenTime|null $created
 */
class WpDevisSend extends Entity
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
        'id_post_wp' => true,
        'is_send' => true,
        'created' => true
    ];
}
