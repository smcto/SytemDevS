<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Statuts Controller
 *
 * @property \App\Model\Table\StatutsTable $Statuts
 *
 * @method \App\Model\Entity\Statut[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StatutsController extends AppController
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
        $statuts = $this->paginate($this->Statuts);

        $this->set(compact('statuts'));
    }

    /**
     * View method
     *
     * @param string|null $id Statut id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $statut = $this->Statuts->get($id, [
            'contain' => ['Contacts']
        ]);

        $this->set('statut', $statut);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $statut = $this->Statuts->newEntity();
        if ($this->request->is('post')) {
            $statut = $this->Statuts->patchEntity($statut, $this->request->getData());
            if ($this->Statuts->save($statut)) {
                $this->Flash->success(__('The statut has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The statut could not be saved. Please, try again.'));
        }
        $this->set(compact('statut'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Statut id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $statut = $this->Statuts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $statut = $this->Statuts->patchEntity($statut, $this->request->getData());
            if ($this->Statuts->save($statut)) {
                $this->Flash->success(__('The statut has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The statut could not be saved. Please, try again.'));
        }
        $this->set(compact('statut'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Statut id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $statut = $this->Statuts->get($id);
        if ($this->Statuts->delete($statut)) {
            $this->Flash->success(__('The statut has been deleted.'));
        } else {
            $this->Flash->error(__('The statut could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
