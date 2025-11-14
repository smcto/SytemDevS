<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * GroupeClients Controller
 *
 * @property \App\Model\Table\GroupeClientsTable $GroupeClients
 *
 * @method \App\Model\Entity\GroupeClient[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupeClientsController extends AppController
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
        $groupeClients = $this->paginate($this->GroupeClients);

        $this->set(compact('groupeClients'));
    }

    /**
     * View method
     *
     * @param string|null $id Groupe Client id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $groupeClient = $this->GroupeClients->get($id, [
            'contain' => []
        ]);

        $this->set('groupeClient', $groupeClient);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $groupeClient = $this->GroupeClients->newEntity();
        if($id){
                $groupeClient = $this->GroupeClients->get($id, [
                    'contain' => []
                ]);
        }
        
        if ($this->request->is(['post', 'put'])) {
            $groupeClient = $this->GroupeClients->patchEntity($groupeClient, $this->request->getData());
            if ($this->GroupeClients->save($groupeClient)) {
                $this->Flash->success(__('The groupe client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupe client could not be saved. Please, try again.'));
        }
        $this->set(compact('groupeClient','id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Groupe Client id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $groupeClient = $this->GroupeClients->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $groupeClient = $this->GroupeClients->patchEntity($groupeClient, $this->request->getData());
            if ($this->GroupeClients->save($groupeClient)) {
                $this->Flash->success(__('The groupe client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groupe client could not be saved. Please, try again.'));
        }
        $this->set(compact('groupeClient'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Groupe Client id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $groupeClient = $this->GroupeClients->get($id);
        if ($this->GroupeClients->delete($groupeClient)) {
            $this->Flash->success(__('The groupe client has been deleted.'));
        } else {
            $this->Flash->error(__('The groupe client could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
