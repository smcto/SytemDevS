<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SousTypesConsommables Controller
 *
 * @property \App\Model\Table\SousTypesConsommablesTable $SousTypesConsommables
 *
 * @method \App\Model\Entity\SousTypesConsommable[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SousTypesConsommablesController extends AppController
{

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
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
        $this->paginate = [
            'contain' => ['TypeConsommables']
        ];
        $sousTypesConsommables = $this->paginate($this->SousTypesConsommables);

        $this->set(compact('sousTypesConsommables'));
    }

    /**
     * View method
     *
     * @param string|null $id Consumable id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sousTypesConsommable = $this->SousTypesConsommables->get($id, [
            'contain' => ['TypeConsommables']
        ]);

        $this->set('sousTypesConsommable', $sousTypesConsommable);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($type_consommable_id, $sous_types_consommable_id = null)
    {
        $sousTypesConsommable = $this->SousTypesConsommables->newEntity();

        if ($sous_types_consommable_id) {
            $sousTypesConsommable = $this->SousTypesConsommables->get($sous_types_consommable_id);
        }

        if ($this->request->is(['post', 'put'])) {
            $sousTypesConsommable = $this->SousTypesConsommables->patchEntity($sousTypesConsommable, $this->request->getData());
            if ($this->SousTypesConsommables->save($sousTypesConsommable)) {
                $this->Flash->success(__('The consumable has been saved.'));

                return $this->redirect(['controller' => 'TypeConsommables', 'action' => 'index']);
            }
            $this->Flash->error(__('The consumable could not be saved. Please, try again.'));
        }
        $typeConsommables = $this->SousTypesConsommables->TypeConsommables->find('list', ['limit' => 200]);
        $this->set(compact('sousTypesConsommable', 'typeConsommables', 'type_consommable_id', 'sous_types_consommable_id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Consumable id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sousTypesConsommable = $this->SousTypesConsommables->get($id);
        if ($this->SousTypesConsommables->delete($sousTypesConsommable)) {
            $this->Flash->success(__('The consumable has been deleted.'));
        } else {
            $this->Flash->error(__('The consumable could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'TypeConsommables', 'action' => 'index']);
    }
}
