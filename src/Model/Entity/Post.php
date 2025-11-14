<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * Post Entity
 *
 * @property int $id
 * @property string $titre
 * @property string $contenu
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\PostCategory[] $post_categories
 */
class Post extends Entity
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

    protected $_virtual = ['url_photo_illustration', 'url_viewer'];

    protected function _getUrlPhotoIllustration(){
        $filename = @$this->_properties['photo_illustration_name'];
        $url = "";
        if(!empty($filename)){
            $url = Router::url('/',true)."uploads/documentations/".$filename;
        }
        return $url;
    }


    protected function _getUrlViewer(){
        $filename = @$this->_properties['photo_illustration_name'];
        $urlViewer = "";
        if(!empty($filename)){
            $ext = explode(".", $this->_properties['photo_illustration_name'])[1];
            $ext = strtolower($ext);
            $urlViewer = Router::url('/',true)."fr/posts/viewFile/".$this->_properties['id'];
        }
        return $urlViewer;
    }
}
