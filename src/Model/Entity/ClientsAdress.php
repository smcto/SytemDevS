<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClientsAdress Entity
 *
 * @property int $id
 * @property string|null $nom
 * @property string|null $cp
 * @property string|null $ville
 * @property string|null $adresse
 * @property string|null $adresse_2
 * @property string|null $adresse_3
 * @property string|null $adresse_4
 * @property int|null $client_id
 * @property int|null $pays_id
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Pay $pay
 */
class ClientsAdress extends Entity
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

    public function _getIsEmpty()
    {
        $data = [
            'adresse' => trim($this->adresse),
            'cp' => trim($this->cp),
            'ville' => trim($this->ville),
            'adresse_2' => trim($this->adresse_2),
            'adresse_3' => trim($this->adresse_3),
            'adresse_' => trim($this->adresse_4)
        ];

        return (bool) @empty(array_filter($data));
    }
}
