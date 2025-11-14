<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LivraisonsVentesSousAccessoire Entity
 *
 * @property int $id
 * @property int|null $qty
 * @property int $ventes_has_sous_accessoire_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\VentesHasSousAccessoire $ventes_has_sous_accessoire
 */
class LivraisonsVentesSousAccessoire extends Entity
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
        'qty' => true,
        'ventes_has_sous_accessoire_id' => true,
        'created' => true,
        'ventes_has_sous_accessoire' => true
    ];
}
