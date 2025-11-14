<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LotProduitsHasUniver Entity
 *
 * @property int $id
 * @property int $lot_produit_id
 * @property int $type_doc_id
 *
 * @property \App\Model\Entity\LotProduit $lot_produit
 * @property \App\Model\Entity\TypeDoc $type_doc
 */
class LotProduitsHasUniver extends Entity
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
    ];
}
