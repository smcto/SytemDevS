<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StatutHistorique Entity
 *
 * @property int $id
 * @property int|null $devi_id
 * @property int|null $devis_facture_id
 * @property string $statut_document
 * @property \Cake\I18n\FrozenTime|null $time
 *
 * @property \App\Model\Entity\Devi $devi
 * @property \App\Model\Entity\DevisFacture $devis_facture
 */
class StatutHistorique extends Entity
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
