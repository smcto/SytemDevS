<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Fournisseur Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $adresse
 * @property int $cp
 * @property string $ville
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $description
 * @property int $antenne_id
 * @property string $commentaire
 * @property int $type_fournisseur_id
 *
 * @property \App\Model\Entity\Antenne $antenne
 * @property \App\Model\Entity\TypeFournisseur $type_fournisseur
 * @property \App\Model\Entity\User[] $users
 */
class Fournisseur extends Entity
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
        'nom' => true,
        'adresse' => true,
        'cp' => true,
        'ville' => true,
        'created' => true,
        'modified' => true,
        'description' => true,
        'antenne_id' => true,
        'commentaire' => true,
        'type_fournisseur_id' => true,
        'antenne' => true,
        'type_fournisseur' => true,
        'users' => true,
        'contact' => true
    ];
}
