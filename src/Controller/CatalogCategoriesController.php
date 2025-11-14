<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CatalogCategories Controller
 *
 * @property \App\Model\Table\CatalogCategoriesTable $CatalogCategories
 *
 * @method \App\Model\Entity\CatalogCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CatalogCategoriesController extends AppController
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
        $catalogCategories = $this->paginate($this->CatalogCategories);

        $this->set(compact('catalogCategories'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $catalogCategory = $this->CatalogCategories->newEntity();
        
        if($id != null) {
            $catalogCategory = $this->CatalogCategories->get($id, [
                'contain' => []
            ]);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $catalogCategory = $this->CatalogCategories->patchEntity($catalogCategory, $this->request->getData());
            if ($this->CatalogCategories->save($catalogCategory)) {
                $this->Flash->success(__('The catalog category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The catalog category could not be saved. Please, try again.'));
        }
        $this->set(compact('catalogCategory','id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Catalog Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $catalogCategory = $this->CatalogCategories->get($id);
        if ($this->CatalogCategories->delete($catalogCategory)) {
            $this->Flash->success(__('The catalog category has been deleted.'));
        } else {
            $this->Flash->error(__('The catalog category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
