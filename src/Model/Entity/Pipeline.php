<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pipeline Entity
 *
 * @property int $id
 * @property string $nom
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $description
 * @property int|null $id_in_sellsy
 *
 * @property \App\Model\Entity\Opportunite[] $opportunites
 * @property \App\Model\Entity\PipelineEtape[] $pipeline_etapes
 */
class Pipeline extends Entity
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
        'created' => true,
        'modified' => true,
        'description' => true,
        'id_in_sellsy' => true,
        'opportunites' => true,
        'pipeline_etapes' => true
    ];
}
