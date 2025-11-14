<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Parcs Controller
 *
 * @property \App\Model\Table\ParcsTable $Parcs
 *
 * @method \App\Model\Entity\Parc[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ParcsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $parcs = $this->paginate($this->Parcs);

        $this->set(compact('parcs'));
    }

    /**
     * View method
     *
     * @param string|null $id Parc id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $parc = $this->Parcs->get($id, [
            'contain' => ['Bornes']
        ]);

        $this->set('parc', $parc);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $parc = $this->Parcs->newEntity();
        if ($this->request->is('post')) {
            $parc = $this->Parcs->patchEntity($parc, $this->request->getData());
            if ($this->Parcs->save($parc)) {
                $this->Flash->success(__('The parc has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The parc could not be saved. Please, try again.'));
        }
        $this->set(compact('parc'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Parc id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $parc = $this->Parcs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $parc = $this->Parcs->patchEntity($parc, $this->request->getData());
            if ($this->Parcs->save($parc)) {
                $this->Flash->success(__('The parc has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The parc could not be saved. Please, try again.'));
        }
        $this->set(compact('parc'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Parc id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $parc = $this->Parcs->get($id);
        if ($this->Parcs->delete($parc)) {
            $this->Flash->success(__('The parc has been deleted.'));
        } else {
            $this->Flash->error(__('The parc could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
