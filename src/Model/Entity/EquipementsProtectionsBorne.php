<?php 
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * EquipementsProtectionsBorne Entity
 *
 * @property int $id
 * @property int $borne_id
 * @property int $type_equipement_id
 * @property int|null $equipement_id
 * @property int|null $qty
 *
 * @property \App\Model\Entity\Borne $borne
 * @property \App\Model\Entity\TypeEquipement $type_equipement
 * @property \App\Model\Entity\Equipement $equipement
 */
class EquipementsProtectionsBorne extends Entity
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
        '*' => true,
        'id' => false
    ];

}
