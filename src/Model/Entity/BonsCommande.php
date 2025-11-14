<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BonsCommande Entity
 *
 * @property int $id
 * @property int $devi_id
 * @property string $indent
 * @property int $type_date
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $commentaire
 * @property int $user_id
 * @property \Cake\I18n\FrozenDate $created
 * @property \Cake\I18n\FrozenDate $modified
 *
 * @property \App\Model\Entity\Devi $devi
 * @property \App\Model\Entity\User $user
 */
class BonsCommande extends Entity
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
    
    
    public function _getDocUrl()
    {
        $path = 'uploads/bc/'.$this->indent.'.pdf';
        if (file_exists(WWW_ROOT.$path)) {
            return '/'.$path;
        }
        return '#';
    }
}
