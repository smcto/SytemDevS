<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PipelineEtape Entity
 *
 * @property int $id
 * @property string $nom
 * @property int $pipeline_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $id_in_sellsy
 * @property int|null $rank
 *
 * @property \App\Model\Entity\Pipeline $pipeline
 * @property \App\Model\Entity\Opportunite[] $opportunites
 */
class PipelineEtape extends Entity
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
        /*'id' => true,
        'nom' => true,
        'pipeline_id' => true,
        'created' => true,
        'modified' => true,
        'id_in_sellsy' => true,
        'rank' => true,
        'pipeline' => true,
        'opportunites' => true*/
        '*' => true
    ];
}
