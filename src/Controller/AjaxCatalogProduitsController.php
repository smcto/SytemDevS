<?php
namespace App\Controller;

use App\Controller\AppController;

class AjaxCatalogProduitsController extends AppController
{
    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->loadModel('CatalogProduits');
    }

    public function isAuthorized($user)
    {
        return true;
    }

    public function getCatalogSousCategories($catalog_category_id)
    {
        $catalogSousCategories = $this->CatalogProduits->CatalogProduitsHasCategories->CatalogSousCategories->findByCatalogCategoriesId($catalog_category_id)->find('list');
        return $this->response->withType('application/json')->withStringBody(json_encode($catalogSousCategories));
    }

    public function deleteHasCategories($catalog_produits_has_category_id)
    {
        $entity = $this->CatalogProduits->CatalogProduitsHasCategories->get($catalog_produits_has_category_id);
        $result = $this->CatalogProduits->CatalogProduitsHasCategories->delete($entity);

        $result = ['status' => 'empty'];
        if ($result) {
            $result = ['status' => 'success'];
        }

        $body = $result;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }
    
    
    public function refreshListCatalog(){
        
        $this->loadModel('CatalogProduits');
        $this->viewBuilder()->setLayout('ajax');
        
        $key = $this->request->getQuery('key');
        $categorie = $this->request->getQuery('categorie');
        $sousCat = $this->request->getQuery('sous-categorie');
        $sousSousCat = $this->request->getQuery('sous_sous_category_id');
        
        $customFinderOptions = [
            'key' => $key,
            'catalog_category_id' => $categorie,
            'catalog_sous_category_id' => $sousCat,
            'catalog_sous_sous_category_id' => $sousSousCat
        ];
        
        $catalogProduits = $this->CatalogProduits->find('filtre',$customFinderOptions)->toArray();
        
        $this->set(compact('catalogProduits'));
    }

}
