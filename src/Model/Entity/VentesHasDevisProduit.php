<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VentesHasDevisProduit Entity
 *
 * @property int $id
 * @property int $devis_produit_id
 * @property int|null $ventes_consommable_id
 *
 * @property \App\Model\Entity\DevisProduit $devis_produit
 * @property \App\Model\Entity\VentesConsommable $ventes_consommable
 */
class VentesHasDevisProduit extends Entity
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
        'id' => false,
        '*' => true
    ];

    public function _getRemainingQty()
    {
        return $this->qty - $this->qty_sent;
    }
}
