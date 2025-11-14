<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LotProduit Entity
 *
 * @property int $id
 * @property int $type_equipement_id
 * @property int $equipement_id
 * @property int $fournisseur_id
 * @property string $etat
 * @property \Cake\I18n\FrozenDate $date_facture
 * @property string $numero_facture
 * @property int $quantité
 *
 * @property \App\Model\Entity\TypeEquipement $type_equipement
 * @property \App\Model\Entity\Equipement $equipement
 * @property \App\Model\Entity\Fournisseur $fournisseur
 */
class LotProduit extends Entity
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
        'id' => true,
        '*' => true,
    ];
    
    
    public function _getListeUnivers()
    {
        
        if (isset($this->type_docs)) {
            return join('<br> ', collection($this->type_docs)->extract('nom')->toArray());
        }
    }
}
