<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * Fichier Entity
 *
 * @property int $id
 * @property string $nom_fichier
 * @property string $chemin
 * @property string $nom_origine
 * @property int $antenne_id
 * @property int $post_id
 * @property int $actu_borne_id
 * @property int $model_borne_id
 *
 * @property \App\Model\Entity\Antenne $antenne
 * @property \App\Model\Entity\Post $post
 * @property \App\Model\Entity\ActuBorne $actu_borne
 * @property \App\Model\Entity\ModelBorne $model_borne
 */
class Fichier extends Entity
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
        'chemin' => true,
        'nom_origine' => true,
        'antenne_id' => true,
        'post_id' => true,
        'actu_borne_id' => true,
        'model_borne_id' => true,
        'antenne' => true,
        'post' => true,
        'actu_borne' => true,
        'model_borne' => true
    ];


    protected $_virtual = ['url','url_viewer'];

    protected function _getUrl(){
        $filename = $this->_properties['nom_fichier'];
        $url = "";
        if(!empty($filename)){
            if(!empty($this->_properties['post_id'])){
                $url = Router::url('/',true)."uploads/documentations/".$filename;
            } else if(!empty($this->_properties['model_borne_id'])) {
                    $url = Router::url('/', true) . "uploads/model_bornes/" . $filename;
             }
        }
        return $url;
    }

    protected function _getUrlViewer(){
        $filename = $this->_properties['nom_fichier'];
        $urlViewer = "";
        if(!empty($filename)){
            $ext = pathinfo($this->_properties['chemin'], PATHINFO_EXTENSION);
            $ext = strtolower($ext);
            if(in_array($ext, ['jpg','jpeg','gif','png'])){
                //$urlViewer = Router::url('/',true)."uploads/fichiers/".$filename;
                $urlViewer = Router::url('/',true)."fr/fichiers/viewFile/".$this->_properties['id']."/0";
            }else{
                $url = "";
                if(!empty($this->_properties['post_id'])){
                    $url = Router::url('/',true)."uploads/documentations/".$filename;
                } else
                if(!empty($this->_properties['actu_borne_id'])){
                    $url = Router::url('/',true)."uploads/actubornes/".$filename;
                } else
                if(!empty($this->_properties['model_borne_id'])){
                    $url = Router::url('/',true)."uploads/model_bornes/".$filename;
                }
                $urlViewer = 'https://docs.google.com/viewer?embedded=true&url='.$url;
            }
        }
        return $urlViewer;
    }
}
