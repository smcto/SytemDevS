<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Parties Controller
 *
 * @property \App\Model\Table\PartiesTable $Parties
 *
 * @method \App\Model\Entity\Party[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PartiesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $parties = $this->paginate($this->Parties);

        $this->set(compact('parties'));
    }

    /**
     * View method
     *
     * @param string|null $id Party id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $party = $this->Parties->get($id, [
            'contain' => []
        ]);

        $this->set('party', $party);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $party = $this->Parties->newEntity();
        if ($this->request->is('post')) {
            $party = $this->Parties->patchEntity($party, $this->request->getData());
            if ($this->Parties->save($party)) {
                $this->Flash->success(__('The party has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The party could not be saved. Please, try again.'));
        }
        $this->set(compact('party'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Party id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $party = $this->Parties->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $party = $this->Parties->patchEntity($party, $this->request->getData());
            if ($this->Parties->save($party)) {
                $this->Flash->success(__('The party has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The party could not be saved. Please, try again.'));
        }
        $this->set(compact('party'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Party id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $party = $this->Parties->get($id);
        if ($this->Parties->delete($party)) {
            $this->Flash->success(__('The party has been deleted.'));
        } else {
            $this->Flash->error(__('The party could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
