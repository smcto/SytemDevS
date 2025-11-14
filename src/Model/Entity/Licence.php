<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Licence Entity
 *
 * @property int $id
 * @property int $type_licence_id
 * @property \Cake\I18n\FrozenDate $date_achat
 * @property \Cake\I18n\FrozenDate $date_renouvellement
 * @property string $numero_serie
 * @property string $email
 * @property string $version
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\TypeLicence $type_licence
 * @property \App\Model\Entity\Borne $borne
 */
class Licence extends Entity
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
