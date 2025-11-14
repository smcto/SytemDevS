<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VentesBelongsConsommable Entity
 *
 * @property int $id
 * @property int $ventes_consomable_id
 * @property int $type_consommable_id
 * @property int $qty
 *
 * @property \App\Model\Entity\VentesConsomable $ventes_consomable
 * @property \App\Model\Entity\TypeConsommable $type_consommable
 */
class VentesHasSousConsommable extends Entity
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
        '*'=> true,
        'id' => false
    ];

    public function _getRemainingDeliverableQty()
    {
        if (isset($this->livraisons_ventes_sous_consommables) && !empty($this->livraisons_ventes_sous_consommables)) {
            return (int) ($this->qty - collection($this->livraisons_ventes_sous_consommables)->sumOf('qty'));
        }

        return $this->qty;
    }   

    public function _getSentQty()
    {
        if (isset($this->livraisons_ventes_sous_consommables) && !empty($this->livraisons_ventes_sous_consommables)) {
            return (int) collection($this->livraisons_ventes_sous_consommables)->sumOf('qty');
        }

        return 0;
    }   
}
