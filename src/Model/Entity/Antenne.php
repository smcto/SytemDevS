<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Antenne Entity
 *
 * @property int $id
 * @property int $lieu_type_id
 * @property string $ville_principale
 * @property string $ville_excate
 * @property string $adresse
 * @property int $cp
 * @property string $longitude
 * @property string $latitude
 * @property string $precision_lieu
 * @property string $commentaire
 * @property int $etat_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\LieuType $lieu_type
 * @property \App\Model\Entity\Etat $etat
 * @property \App\Model\Entity\Borne[] $bornes
 * @property \App\Model\Entity\Contact[] $contacts
 * @property \App\Model\Entity\Fournisseur[] $fournisseurs
 * @property \App\Model\Entity\User[] $users
 */
class Antenne extends Entity
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
        'id' => false,
        '*' => true,
    ];
}
