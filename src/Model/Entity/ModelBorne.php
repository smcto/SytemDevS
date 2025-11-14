<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ModelBorne Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $version
 * @property \Cake\I18n\FrozenDate $date_sortie
 * @property string $description
 * @property string $taille_ecran
 * @property string $modele_imprimante
 * @property string $model_appareil_photo
 * @property string $note_complementaire
 *
 * @property \App\Model\Entity\Borne[] $bornes
 * @property \App\Model\Entity\ModelBornesHasMedia[] $model_bornes_has_medias
 */
class ModelBorne extends Entity
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
        '*' => true
    ];
}
