<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * CatalogProduitsFile Entity
 *
 * @property int $id
 * @property int $catalog_produits_id
 * @property string $nom_fichier
 * @property string $chemin
 * @property string $nom_origine
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\CatalogProduit $catalog_produit
 */
class CatalogProduitsFile extends Entity
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
    
    protected $_virtual = ['url'];

    protected function _getUrl(){
        $filename = $this->nom_fichier;
        $url = "";
        if(!empty($filename)){
            $url = Router::url('/',true)."uploads/catalogue_produits/".$filename;
        }
        return $url;
    }
}
