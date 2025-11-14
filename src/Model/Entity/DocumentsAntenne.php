<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * DocumentsAntenne Entity
 *
 * @property int $id
 * @property string $nom_fichier
 * @property string $nom_origine
 * @property string $chemin
 * @property int $antenne_id
 *
 * @property \App\Model\Entity\Antenne $antenne
 */
class DocumentsAntenne extends Entity
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
        'nom_origine' => true,
        'chemin' => true,
        'antenne_id' => true,
        'antenne' => true
    ];


    protected $_virtual = ['url','url_viewer'];

    protected function _getUrl(){
        $filename = $this->_properties['nom_fichier'];
        $url = "";
        if(!empty($filename)){
            if(!empty($this->_properties['antenne_id'])){
                $url = Router::url('/',true)."uploads/antenne/".$filename;
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
                $urlViewer = Router::url('/',true)."fr/fichiers/viewFile/".$this->_properties['id']."/0";
            }else{
                $url = "";
                if(!empty($this->_properties['antenne_id'])){
                    $url = Router::url('/',true)."uploads/antenne/".$filename;
                }
                $urlViewer = 'https://docs.google.com/viewer?embedded=true&url='.$url;
            }
        }

        return $urlViewer;
    }

}
