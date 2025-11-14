<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Logiciels Controller
 *
 * @property \App\Model\Table\LogicielsTable $Logiciels
 *
 * @method \App\Model\Entity\Logiciel[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LogicielsController extends AppController
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
        $logiciels = $this->paginate($this->Logiciels);

        $this->set(compact('logiciels'));
    }

    /**
     * View method
     *
     * @param string|null $id Logiciel id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $logiciel = $this->Logiciels->get($id, [
            'contain' => ['BorneLogiciels']
        ]);

        $this->set('logiciel', $logiciel);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $logiciel = $this->Logiciels->newEntity();
        if ($this->request->is('post')) {
            $logiciel = $this->Logiciels->patchEntity($logiciel, $this->request->getData());
            if ($this->Logiciels->save($logiciel)) {
                $this->Flash->success(__('The logiciel has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The logiciel could not be saved. Please, try again.'));
        }
        $this->set(compact('logiciel'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Logiciel id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $logiciel = $this->Logiciels->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $logiciel = $this->Logiciels->patchEntity($logiciel, $this->request->getData());
            if ($this->Logiciels->save($logiciel)) {
                $this->Flash->success(__('The logiciel has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The logiciel could not be saved. Please, try again.'));
        }
        $this->set(compact('logiciel'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Logiciel id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $logiciel = $this->Logiciels->get($id);
        if ($this->Logiciels->delete($logiciel)) {
            $this->Flash->success(__('The logiciel has been deleted.'));
        } else {
            $this->Flash->error(__('The logiciel could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
