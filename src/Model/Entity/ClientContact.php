<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClientContact Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $position
 * @property string $email
 * @property string $tel
 * @property int $client_id
 * @property int $id_in_sellsy
 * @property bool $deleted_in_sellsy
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Client $client
 */
class ClientContact extends Entity
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
        '*' => true
    ];

    protected $_virtual = ['full_name'];

    protected function _getFullName()
    {
        return trim($this->prenom . " ".$this->nom);
    }

    protected function _getIsInfosEmpty()
    {
        $checkArray = [
            'nom' => (bool) trim($this->nom),
            'prenom' => (bool) trim($this->prenom),
            'position' => (bool) trim($this->position),
            'email' => (bool) trim($this->email),
            'tel' => (bool) trim($this->tel)
        ];
        return empty(array_filter($checkArray));
    }
}
