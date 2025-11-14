<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FactureSituation Entity
 *
 * @property int $id
 * @property string $indent
 * @property int $numero
 * @property int $devi_id
 * @property string $objet
 * @property \Cake\I18n\FrozenDate $date_crea
 * @property int $ref_commercial_id
 * @property string $note
 * @property int $client_id
 * @property float $total_ht
 * @property float $total_ttc
 *
 * @property \App\Model\Entity\Devi $devi
 * @property \App\Model\Entity\RefCommercial $ref_commercial
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\FactureSituationsProduit[] $facture_situations_produits
 */
class FactureSituation extends Entity
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
