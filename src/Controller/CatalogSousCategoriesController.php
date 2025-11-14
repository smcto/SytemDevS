<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CatalogSousCategories Controller
 *
 * @property \App\Model\Table\CatalogSousCategoriesTable $CatalogSousCategories
 *
 * @method \App\Model\Entity\CatalogSousCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CatalogSousCategoriesController extends AppController
{


        public function isAuthorized($user)
        {
            $typeprofils = $user['typeprofils'];
            if(array_intersect(['admin', 'konitys'], $typeprofils)) {
                return true;
            }
            return parent::isAuthorized($user);
        }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $categorie = $this->request->getQuery('catalog_categories_id');
        
        $customFinderOptions = [
            'catalog_categories_id' => $categorie
        ];
        $this->paginate = [
            'contain' => ['CatalogCategories'],
            'finder' => ['filtre' => $customFinderOptions,]
        ];
        $catalogSousCategories = $this->paginate($this->CatalogSousCategories);
        $catalogCategories = $this->CatalogSousCategories->CatalogCategories->find('list', ['valueField'=>'nom'])->orderAsc('nom');
        $this->set(compact('catalogSousCategories', 'catalogCategories', 'categorie'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $catalogSousCategory = $this->CatalogSousCategories->newEntity();
        if($id != null) {
            $catalogSousCategory = $this->CatalogSousCategories->get($id, [
                'contain' => ['CatalogCategories']
            ]);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $catalogSousCategory = $this->CatalogSousCategories->patchEntity($catalogSousCategory, $this->request->getData());
            if ($this->CatalogSousCategories->save($catalogSousCategory)) {
                $this->Flash->success(__('The catalog sous category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The catalog sous category could not be saved. Please, try again.'));
        }
        $catalogCategories = $this->CatalogSousCategories->CatalogCategories->find('list', ['valueField'=>'nom']);
        $this->set(compact('catalogSousCategory', 'catalogCategories', 'id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Catalog Sous Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $catalogSousCategory = $this->CatalogSousCategories->get($id);
        if ($this->CatalogSousCategories->delete($catalogSousCategory)) {
            $this->Flash->success(__('The catalog sous category has been deleted.'));
        } else {
            $this->Flash->error(__('The catalog sous category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
