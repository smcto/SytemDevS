<?php 
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * ReglementsHasDevi Entity
 *
 * @property int $id
 * @property int $reglements_id
 * @property int $devis_id
 *
 * @property \App\Model\Entity\Reglement $reglement
 * @property \App\Model\Entity\Devi $devi
 * @property \App\Model\Entity\Facture[] $factures
 */
class ReglementsHasDevi extends Entity
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
