<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EvenementsHasContact Entity
 *
 * @property int $id
 * @property int $evenement_id
 * @property int $user_id
 * @property bool $is_responsable
 *
 * @property \App\Model\Entity\Evenement $evenement
 * @property \App\Model\Entity\User $user
 */
class EvenementsHasContact extends Entity
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
        'evenement_id' => true,
        'user_id' => true,
        'is_responsable' => true,
        'evenement' => true,
        'user' => true
    ];
}
