<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TypeEquipement Entity
 *
 * @property int $id
 * @property string $nom
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Equipement[] $equipements 
 */
class TypeEquipement extends Entity
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

    public function _getGammesBornesList()
    {
        if (isset($this->gammes_bornes)) {
            return collection($this->gammes_bornes)->extract('name')->toArray();
        }
    }
    
    
    public function _getTypeList()
    {
        
        $types = [];
        if ($this->is_structurel) {
            $types['is_structurel'] = "équipement structurel";
        }
        if ($this->is_accessoire) {
            $types['is_accessoire'] = "équipement accessoire";
        }
        if ($this->is_protection) {
            $types['is_protection'] = "équipement protection";
        }
        
        return $types;
    }
}
