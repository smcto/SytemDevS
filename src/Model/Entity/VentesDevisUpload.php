<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VentesDevisUpload Entity
 *
 * @property int $id
 * @property string|null $filename
 * @property int|null $vente_id
 *
 * @property \App\Model\Entity\Vente $vente
 */
class VentesDevisUpload extends Entity
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
        'id' => true,
        'filename' => true,
        'vente_id' => true,
        'vente' => true
    ];

    public function _getFilePath()
    {
        return 'uploads/ventes/devis/'.$this->filename;
    }
}
