<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Equipement Entity
 *
 * @property int $id
 * @property int $type_equipement_id
 * @property string $valeur
 * @property string $commentaire
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $is_filtrable
 *
 * @property \App\Model\Entity\TypeEquipement $type_equipement
 */
class Equipement extends Entity
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
        'type_equipement_id' => true,
        'valeur' => true,
        'commentaire' => true,
        'created' => true,
        'modified' => true,
        'type_equipement' => true,
        'marque_equipement' => true,
        'marque_equipement_id' => true
    ];
}
