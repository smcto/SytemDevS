<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\AppEntity;
/**
 * VentesConsommable Entity
 *
 * @property int $id
 * @property int $client_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenDate $livraison_date
 * @property int|null $parc_id
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\VentesBelongsConsommable[] $ventes_belongs_consommables
 */
class VentesConsommable extends Entity
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

    public function _getListConsommables()
    {
        if (isset($this->ventes_has_sous_consommables)) {
            return collection($this->ventes_has_sous_consommables)->combine('sous_types_consommable.name', 'qty')->toArray();
        }
    }

    public function _getListAccessoires()
    {
        if (isset($this->ventes_has_sous_consommables)) {
            return collection($this->ventes_has_sous_accessoires)->combine('sous_accessoire.name', 'qty')->toArray();
        }
    }

    public function _getCheckedAccessories($field)
    {
        return $field ?? [];
    }

    public function _getCheckedConsommables($field)
    {
        return $field ?? [];
    }


}
