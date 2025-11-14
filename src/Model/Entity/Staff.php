<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Staff Entity
 *
 * @property int $id
 * @property int|null $id_in_sellsy
 * @property string|null $full_name
 * @property string|null $email
 * @property string|null $nom
 * @property string|null $prenom
 * @property int|null $people_id_in_sellsy
 *
 * @property \App\Model\Entity\OpportuniteStaff[] $opportunite_staffs
 */
class Staff extends Entity
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
        'id_in_sellsy' => true,
        'full_name' => true,
        'email' => true,
        'nom' => true,
        'prenom' => true,
        'people_id_in_sellsy' => true,
        'opportunite_staffs' => true
    ];
}
