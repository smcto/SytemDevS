<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * DocumentsModelBorne Entity
 *
 * @property int $id
 * @property string $nom_fichier
 * @property string $titre
 * @property string $description
 * @property string $chemin
 * @property string $nom_origine
 * @property int $model_borne_id
 *
 * @property \App\Model\Entity\ModelBorne $model_borne
 */
class DocumentsModelBorne extends Entity
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
        'nom_fichier' => true,
        'titre' => true,
        'description' => true,
        'chemin' => true,
        'nom_origine' => true,
        'model_borne_id' => true,
        'model_borne' => true
    ];

    protected $_virtual = ['url'];

    protected function _getUrl(){
        $filename = $this->_properties['nom_fichier'];
        $url = "";
        if(!empty($filename)){
            $url = Router::url('/',true)."uploads/model_bornes/".$filename;
        }
        return $url;
    }
}
