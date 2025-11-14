<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ModelesMailsPj Entity
 *
 * @property int $id
 * @property int $modeles_mails_id
 * @property string $nom_fichier
 * @property string $chemin
 * @property string|null $nom_origine
 * @property \Cake\I18n\FrozenDate $created
 * @property \Cake\I18n\FrozenDate $modified
 *
 * @property \App\Model\Entity\ModelsMail $models_mail
 */
class ModelesMailsPj extends Entity
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
        'modeles_mails_id' => true,
        'nom_fichier' => true,
        'chemin' => true,
        'nom_origine' => true,
        'created' => true,
        'modified' => true,
        'models_mail' => true
    ];
}
