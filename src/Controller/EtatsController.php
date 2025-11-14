<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Etats Controller
 *
 * @property \App\Model\Table\EtatsTable $Etats
 *
 * @method \App\Model\Entity\Etat[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EtatsController extends AppController
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
        $etats = $this->paginate($this->Etats);

        $this->set(compact('etats'));
    }

    /**
     * View method
     *
     * @param string|null $id Etat id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $etat = $this->Etats->get($id, [
            'contain' => ['Antennes']
        ]);

        $this->set('etat', $etat);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $etat = $this->Etats->newEntity();
        if ($this->request->is('post')) {
            $etat = $this->Etats->patchEntity($etat, $this->request->getData());
            if ($this->Etats->save($etat)) {
                $this->Flash->success(__('The etat has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The etat could not be saved. Please, try again.'));
        }
        $this->set(compact('etat'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Etat id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $etat = $this->Etats->get($id, [
            'contain' => ['Antennes']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $etat = $this->Etats->patchEntity($etat, $this->request->getData());
            if ($this->Etats->save($etat)) {
                $this->Flash->success(__('The etat has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The etat could not be saved. Please, try again.'));
        }
        $this->set(compact('etat'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Etat id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $etat = $this->Etats->get($id);
        if ($this->Etats->delete($etat)) {
            $this->Flash->success(__('The etat has been deleted.'));
        } else {
            $this->Flash->error(__('The etat could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
