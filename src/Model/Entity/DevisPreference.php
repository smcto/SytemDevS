<?php 
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * DevisPreference Entity
 *
 * @property int $id
 * @property string|null $moyen_reglements
 * @property string|null $delai_reglements
 * @property int|null $info_bancaire_id
 * @property float|null $accompte_value
 * @property string|null $accompte_unity
 *
 * @property \App\Model\Entity\InfoBancaire $info_bancaire
 */
class DevisPreference extends Entity
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
