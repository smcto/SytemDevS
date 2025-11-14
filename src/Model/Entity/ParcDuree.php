<?php 
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * ParcDuree Entity
 *
 * @property int $id
 * @property string|null $valeur
 * @property int $parc_id
 *
 * @property \App\Model\Entity\Parc $parc
 * @property \App\Model\Entity\Borne[] $bornes
 * @property \App\Model\Entity\Vente[] $ventes
 */
class ParcDuree extends Entity
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

    public function _getDuree()
    {
        if (strpos($this->valeur, 'mois') !== false) {
            return str_replace('mois', 'months', $this->valeur);
        } 
        elseif (strpos($this->valeur, 'an') !== false) {
            return str_replace('an', 'years', $this->valeur);
        }
    }

}
