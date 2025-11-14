<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CatalogUnites Controller
 *
 * @property \App\Model\Table\CatalogUnitesTable $CatalogUnites
 *
 * @method \App\Model\Entity\CatalogUnites[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CatalogUnitesController extends AppController
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
        $catalogUnites = $this->paginate($this->CatalogUnites);

        $this->set(compact('catalogUnites'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $catalogUnite = $this->CatalogUnites->newEntity();
        if($id) {
            $catalogUnite = $this->CatalogUnites->get($id, [
                'contain' => []
            ]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $catalogUnite = $this->CatalogUnites->patchEntity($catalogUnite, $this->request->getData());
            if ($this->CatalogUnites->save($catalogUnite)) {
                $this->Flash->success(__('The catalog unite has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The catalog unite could not be saved. Please, try again.'));
        }
        $this->set(compact('catalogUnite','id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Catalog Unite id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $catalogUnite = $this->CatalogUnites->get($id);
        if ($this->CatalogUnites->delete($catalogUnite)) {
            $this->Flash->success(__('The catalog unite has been deleted.'));
        } else {
            $this->Flash->error(__('The catalog unite could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
