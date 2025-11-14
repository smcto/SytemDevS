<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VentesHasSousAccessoire Entity
 *
 * @property int $id
 * @property int $ventes_consommable_id
 * @property int|null $accessoire_id
 * @property int|null $sous_accessoire_id
 * @property int|null $qty
 *
 * @property \App\Model\Entity\VentesConsommable $ventes_consommable
 * @property \App\Model\Entity\Accessoire $accessoire
 * @property \App\Model\Entity\SousAccessoire $sous_accessoire
 */
class VentesHasSousAccessoire extends Entity
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
        '*' => true
    ];

    public function _getRemainingDeliverableQty()
    {
        if (isset($this->livraisons_ventes_sous_accessoires) && !empty($this->livraisons_ventes_sous_accessoires)) {
            return (int) ($this->qty - collection($this->livraisons_ventes_sous_accessoires)->sumOf('qty'));
        }

        return $this->qty;
    }   

    public function _getSentQty()
    {
        if (isset($this->livraisons_ventes_sous_accessoires) && !empty($this->livraisons_ventes_sous_accessoires)) {
            return (int) collection($this->livraisons_ventes_sous_accessoires)->sumOf('qty');
        }

        return 0;
    }   
}
