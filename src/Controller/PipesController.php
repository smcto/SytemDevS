<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Pipes Controller
 *
 * @property \App\Model\Table\PipesTable $Pipes
 *
 * @method \App\Model\Entity\Pipe[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PipesController extends AppController
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
        $pipes = $this->paginate($this->Pipes);

        $this->set(compact('pipes'));
    }

    /**
     * View method
     *
     * @param string|null $id Pipe id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pipe = $this->Pipes->get($id, [
            'contain' => ['PipeEtapes']
        ]);

        $this->set('pipe', $pipe);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pipe = $this->Pipes->newEntity();
        if ($this->request->is('post')) {
            $pipe = $this->Pipes->patchEntity($pipe, $this->request->getData());
            if ($this->Pipes->save($pipe)) {
                $this->Flash->success(__('The pipe has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pipe could not be saved. Please, try again.'));
        }
        $this->set(compact('pipe'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pipe id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pipe = $this->Pipes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pipe = $this->Pipes->patchEntity($pipe, $this->request->getData());
            if ($this->Pipes->save($pipe)) {
                $this->Flash->success(__('The pipe has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pipe could not be saved. Please, try again.'));
        }
        $this->set(compact('pipe'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pipe id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pipe = $this->Pipes->get($id);
        if ($this->Pipes->delete($pipe)) {
            $this->Flash->success(__('The pipe has been deleted.'));
        } else {
            $this->Flash->error(__('The pipe could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
