<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EvenementPipeEtape Entity
 *
 * @property int $id
 * @property int $pipe_etape_id
 * @property int $evenement_id
 *
 * @property \App\Model\Entity\PipeEtape $pipe_etape
 * @property \App\Model\Entity\Evenement $evenement
 */
class EvenementPipeEtape extends Entity
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
        'pipe_etape_id' => true,
        'evenement_id' => true,
        'pipe_etape' => true,
        'evenement' => true
    ];
}
