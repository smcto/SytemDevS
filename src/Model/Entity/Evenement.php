<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Evenement Entity
 *
 * @property int $id
 * @property string $nom_event
 * @property string $lieu_exact
 * @property \Cake\I18n\FrozenDate $date_debut_immobilisation
 * @property \Cake\I18n\FrozenDate $date_fin_immobilisation
 * @property string $type_installation
 * @property int $client_id
 * @property int $type_evenement_id
 * @property int $antenne_id
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\TypeEvenement $type_evenement
 * @property \App\Model\Entity\Antenne $antenne
 * @property \App\Model\Entity\Borne $borne
 * @property \App\Model\Entity\DateEvenement[] $date_evenements
 */
class Evenement extends Entity
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
        /*'nom_event' => true,
        'lieu_exact' => true,
        'date_debut_immobilisation' => true,
        'date_fin_immobilisation' => true,
        'type_installation' => true,
        'client_id' => true,
        'type_evenement_id' => true,
        'antenne_id' => true,
        'client' => true,
        'type_evenement' => true,
        'antenne' => true,
        'date_evenements' => true,
        'user_id' => true*/
        'id' => false,
        '*' => true
    ];
}
