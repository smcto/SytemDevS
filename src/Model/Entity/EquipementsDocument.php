<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * EquipementsDocument Entity
 *
 * @property int $id
 * @property int $equipement_id
 * @property string $nom_fichier
 * @property string $chemin
 * @property string|null $nom_origine
 * @property string|null $titre
 * @property string|null $description
 * @property \Cake\I18n\FrozenDate $created
 * @property \Cake\I18n\FrozenDate $modified
 *
 * @property \App\Model\Entity\Equipement $equipement
 */
class EquipementsDocument extends Entity
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
        'equipement_id' => true,
        'nom_fichier' => true,
        'chemin' => true,
        'nom_origine' => true,
        'titre' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'equipement' => true
    ];
    
    
    protected $_virtual = ['url'];

    protected function _getUrl(){
        
        $filename = $this->nom_fichier;
        $url = "";
        if(!empty($filename)){
            $url = Router::url('/',true)."uploads/doc_equipements/".$filename;
        }
        return $url;
    }
    
}
