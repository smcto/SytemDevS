<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EtatBorne Entity
 *
 * @property int $id
 * @property string $etat_general
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Borne[] $bornes
 */
class EtatBorne extends Entity
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
        'etat_general' => true,
        'created' => true,
        'modified' => true,
        'bornes' => true
    ];
}
