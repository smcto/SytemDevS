<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * Facture Entity
 *
 * @property int $id
 * @property string $titre
 * @property float $montant
 * @property int $antenne_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Antenne $antenne
 * @property \App\Model\Entity\User $user
 */
class Facture extends Entity
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
        /*'titre' => true,
        'montant' => true,
        'antenne_id' => true,
        'antenne' => true,*/
        'id' => false,
        '*' => true
    ];

    protected $_virtual = ['url', 'url_viewer'];

    protected function _getUrl(){
        $filename = @$this->_properties['nom_fichier'];
        $url = "";
        if(!empty($filename)){
            $url = Router::url('/',true)."uploads/factures/".$filename;
        }
        return $url;
    }

    protected function _getUrlViewer(){
        $filename = @$this->_properties['nom_fichier'];
        $urlViewer = "";
        if(!empty($filename)){
            $ext = explode(".", $this->_properties['nom_fichier'])[1];
            $ext = strtolower($ext);
            if(in_array($ext, ['jpg','jpeg','gif','png'])){
                //$urlViewer = Router::url('/',true)."uploads/fichiers/".$filename;
                $urlViewer = Router::url('/',true)."fr/fichiers/viewFile/".$this->_properties['id']."/0";
            }else{
                $url = Router::url('/',true)."uploads/factures/".$filename;
                $urlViewer = 'https://docs.google.com/viewer?embedded=true&url='.$url;
            }
        }
        return $urlViewer;
    }
}
