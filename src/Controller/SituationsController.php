<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Situations Controller
 *
 * @property \App\Model\Table\SituationsTable $Situations
 *
 * @method \App\Model\Entity\Situation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SituationsController extends AppController
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
        $situations = $this->paginate($this->Situations);

        $this->set(compact('situations'));
    }

    /**
     * View method
     *
     * @param string|null $id Situation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $situation = $this->Situations->get($id, [
            'contain' => ['Contacts']
        ]);

        $this->set('situation', $situation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $situation = $this->Situations->newEntity();
        if ($this->request->is('post')) {
            $situation = $this->Situations->patchEntity($situation, $this->request->getData());
            if ($this->Situations->save($situation)) {
                $this->Flash->success(__('The situation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The situation could not be saved. Please, try again.'));
        }
        $this->set(compact('situation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Situation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $situation = $this->Situations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $situation = $this->Situations->patchEntity($situation, $this->request->getData());
            if ($this->Situations->save($situation)) {
                $this->Flash->success(__('The situation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The situation could not be saved. Please, try again.'));
        }
        $this->set(compact('situation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Situation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $situation = $this->Situations->get($id);
        if ($this->Situations->delete($situation)) {
            $this->Flash->success(__('The situation has been deleted.'));
        } else {
            $this->Flash->error(__('The situation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
