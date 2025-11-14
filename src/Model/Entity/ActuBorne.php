<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ActuBorne Entity
 *
 * @property int $id
 * @property string $titre
 * @property string $contenu
 * @property string $photos
 * @property int $borne_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Borne $borne
 * @property \App\Model\Entity\ActuBornesHasMedia[] $actu_bornes_has_medias
 */
class ActuBorne extends Entity
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
        'contenu' => true,
        'photos' => true,
        'borne_id' => true,
        'categorie_actus_id' => true,
        'created' => true,
        'modified' => true,
        'borne' => true,
        'actu_bornes_has_medias' => true
    ];
}
