<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;


/**
 * DocumentMarketing Entity
 *
 * @property int $id
 * @property string|null $catalogue_spherik
 * @property string|null $catalogue_classik
 * @property string|null $cgl_classik_part
 * @property string|null $cgl_spherik_part
 * @property string|null $cgl_pro
 */
class DocumentMarketing extends Entity
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

    protected $pathDoc = WWW_ROOT.'uploads'.DS.'document_marketings'.DS;


    protected $_accessible = [
        'catalogue_spherik' => true,
        'catalogue_classik' => true,
        'cgl_classik_part' => true,
        'cgl_spherik_part' => true,
        'cgl_pro' => true,
        'catalogue_spherik_2020' => true
    ];

    //url_catalogue_classik_2020

    protected function _getUrlCatalogueSpherik2020(){
        $url = null;
        if(!empty($this->catalogue_spherik_2020)){
            $url = Router::url('/',true)."uploads/document_marketings/".$this->catalogue_spherik_2020;
        }
        return $url;
    }

    protected function _getUrlCatalogueSpherik(){
        $url = null;
        if(!empty($this->catalogue_spherik)){
            $url = Router::url('/',true)."uploads/document_marketings/".$this->catalogue_spherik;
        }
        return $url;
    }

    protected function _getPathCatalogueSpherik(){
        $path = null;
        if(!empty($this->catalogue_spherik)){
            $path = $this->pathDoc.$this->catalogue_spherik;
        }
        return $path;
    }

    protected function _getPathCatalogueSpherik2020(){
        $path = null;
        if(!empty($this->catalogue_spherik_2020)){
            $path = $this->pathDoc.$this->catalogue_spherik_2020;
        }
        return $path;
    }

    protected function _getUrlCatalogueClassik(){
        $url = null;
        if(!empty($this->catalogue_classik)){
            $url = Router::url('/',true)."uploads/document_marketings/".$this->catalogue_classik;
        }
        return $url;
    }

    protected function _getPathCatalogueClassik(){
        $path = null;
        if(!empty($this->catalogue_classik)){
            $path = $this->pathDoc.$this->catalogue_classik;
        }
        return $path;
    }



}
