<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MessageTypeFacture Entity
 *
 * @property int $id
 * @property string $titre
 * @property string $message
 * @property int $etat_facture_id
 *
 * @property \App\Model\Entity\EtatFacture $etat_facture
 * @property \App\Model\Entity\Facture[] $factures
 */
class MessageTypeFacture extends Entity
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
        'titre' => true,
        'message' => true,
        'etat_facture_id' => true,
        'etat_facture' => true,
        'factures' => true
    ];
}
