<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;

class CatalogSousSousCategoriesController extends AppController
{

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if(in_array('konitys', $typeprofils) || in_array('admin', $typeprofils)) {
            return true;
        }

        return parent::isAuthorized($user);
    }
    
    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->loadComponent('Utilities');
        $this->Utilities->loadModels([]);
    }

    public function index()
    {
        $catalogSousSousCategories = $this->CatalogSousSousCategories->find()->contain(['CatalogSousCategories' => 'CatalogCategories']);
        
        $catalogSousCategories = $this->CatalogSousSousCategories->CatalogSousCategories->find('list', ['limit' => 200]);
        $catalogCategories = $this->CatalogSousSousCategories->CatalogSousCategories->CatalogCategories->find('list', ['limit' => 200]);

        $nom = $this->request->getQuery('nom');
        $catalog_category_id = $this->request->getQuery('catalog_category_id');
        $catalog_sous_category_id = $this->request->getQuery('catalog_sous_category_id');

        $optionsFiltres = [
            'nom' => $nom,
            'catalog_category_id' => $catalog_category_id,
            'catalog_sous_category_id' => $catalog_sous_category_id,
        ];

        $catalogSousSousCategories->find('filtre', $optionsFiltres);
        $catalogSousSousCategories = $this->paginate($catalogSousSousCategories);
        $this->set(compact('nom', 'catalog_category_id', 'catalog_sous_category_id', 'catalogSousSousCategories', 'catalogCategories', 'catalogSousCategories'));
    }

    public function view($id = null)
    {
        $catalogSousSousCategoryEntity = $this->CatalogSousSousCategories->find()->findById($id)->contain(['CatalogSousCategories'])->first();
        $this->set(compact('catalogSousSousCategoryEntity'));
    }

    public function add($id = null)
    {
        $catalogSousSousCategoryEntity = $this->CatalogSousSousCategories->newEntity();

        if ($id) {
            $catalogSousSousCategoryEntity = $this->CatalogSousSousCategories->findById($id)->contain(['CatalogSousCategories'])->first();
            $catalogSousCategories = $this->CatalogSousSousCategories->CatalogSousCategories->find('list', ['limit' => 200]);
            $this->set(compact('catalogSousCategories'));
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $catalogSousSousCategoryEntity = $this->CatalogSousSousCategories->patchEntity($catalogSousSousCategoryEntity, $data, ['validate' => false]);
            if ($this->CatalogSousSousCategories->save($catalogSousSousCategoryEntity)) {
                $this->Flash->success(__('The catalog sous sous category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The catalog sous sous category could not be saved. Please, try again.'));
        }
        $catalogCategories = $this->CatalogSousSousCategories->CatalogSousCategories->CatalogCategories->find('list', ['limit' => 200]);
        $this->set(@compact('catalogCategories', 'catalogSousSousCategory', 'catalogSousCategories', 'id', 'catalogSousSousCategoryEntity'));
    }

    public function getSousCategoryByCategoryId($catalog_category_id)
    {
        $catalogSousCategories = $this->CatalogSousSousCategories->CatalogSousCategories->findByCatalogCategoriesId($catalog_category_id)->find('list');
        $body = $catalogSousCategories;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function getSousSousCategoriesBySousCategoryId($catalog_sous_category_id)
    {
        $catalogSousSousCategories = $this->CatalogSousSousCategories->findByCatalogSousCategoryId($catalog_sous_category_id)->find('list');
        $body = $catalogSousSousCategories;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $catalogSousSousCategoryEntity = $this->CatalogSousSousCategories->get($id);
        if ($this->CatalogSousSousCategories->delete($catalogSousSousCategoryEntity)) {
            $this->Flash->success(__('The catalog sous sous category has been deleted.'));
        } else {
            $this->Flash->error(__('The catalog sous sous category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
