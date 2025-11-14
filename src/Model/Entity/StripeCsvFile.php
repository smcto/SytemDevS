<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Route\Route;
use Cake\Routing\Router;

/**
 * StripeCsvFile Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $date_import
 * @property string $filename
 * @property string $filename_origin
 * @property boolean $is_export_excel
 *
 * @property \App\Model\Entity\StripeCsv[] $stripe_csvs
 */
class StripeCsvFile extends Entity
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
        'date_import' => true,
        'filename' => true,
        'filename_origin' => true,
        'is_export_excel' => true,
        'stripe_csvs' => true
    ];

    protected $_virtual = ['url', 'url_viewer'];

    protected function _getUrlViewer(){
        $filename = $this->_properties['filename'];
        $urlViewer = "";
        if(!empty($filename)){
            $url = Router::url('/',true)."uploads/stripes_csv/".$filename;
            $urlViewer = 'https://docs.google.com/viewer?embedded=true&url='.$url;
        }
        return $urlViewer;
    }
}
