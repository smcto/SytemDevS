<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Messagery Entity
 *
 * @property int $id
 * @property string $destinateur
 * @property string $message
 * @property bool $is_test
 * @property \Cake\I18n\FrozenTime $created
 */
class Messagery extends Entity
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
        'destinateur' => true,
        'message' => true,
        'users' => true,
        'clients' => true,
        'is_test' => true,
        'created' => true
    ];
}
