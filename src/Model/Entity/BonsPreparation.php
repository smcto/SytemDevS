<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BonsPreparation Entity
 *
 * @property int $id
 * @property int $devi_id
 * @property int $bons_commande_id
 * @property int $client_id
 * @property string $indent
 * @property int $user_id
 * @property \Cake\I18n\FrozenDate $created
 * @property \Cake\I18n\FrozenDate $modified
 * @property int $type_date
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $statut
 *
 * @property \App\Model\Entity\Devi $devi
 * @property \App\Model\Entity\BonsCommande $bons_commande
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\BonsPreparationsProduit[] $bons_preparations_produits
 */
class BonsPreparation extends Entity
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
