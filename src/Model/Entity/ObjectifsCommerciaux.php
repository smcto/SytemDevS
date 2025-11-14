<?php 
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * ObjectifsCommerciaux Entity
 *
 * @property int $id
 * @property array|null $montants
 * @property int|null $devis_type_doc_id
 * @property int|null $objectif_annee_id
 *
 * @property \App\Model\Entity\DevisTypeDoc $devis_type_doc
 */
class ObjectifsCommerciaux extends Entity
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
