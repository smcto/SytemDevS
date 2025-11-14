<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Dimensions Controller
 *
 * @property \App\Model\Table\DimensionsTable $Dimensions
 *
 * @method \App\Model\Entity\Dimension[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DimensionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ModelBornes', 'Parties']
        ];
        $dimensions = $this->paginate($this->Dimensions);

        $this->set(compact('dimensions'));
    }

    /**
     * View method
     *
     * @param string|null $id Dimension id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dimension = $this->Dimensions->get($id, [
            'contain' => ['ModelBornes', 'Parties']
        ]);

        $this->set('dimension', $dimension);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dimension = $this->Dimensions->newEntity();
        if ($this->request->is('post')) {
            $dimension = $this->Dimensions->patchEntity($dimension, $this->request->getData());
            if ($this->Dimensions->save($dimension)) {
                $this->Flash->success(__('The dimension has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dimension could not be saved. Please, try again.'));
        }
        $modelBornes = $this->Dimensions->ModelBornes->find('list', ['limit' => 200]);
        $parties = $this->Dimensions->Parties->find('list', ['limit' => 200]);
        $this->set(compact('dimension', 'modelBornes', 'parties'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Dimension id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dimension = $this->Dimensions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dimension = $this->Dimensions->patchEntity($dimension, $this->request->getData());
            if ($this->Dimensions->save($dimension)) {
                $this->Flash->success(__('The dimension has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dimension could not be saved. Please, try again.'));
        }
        $modelBornes = $this->Dimensions->ModelBornes->find('list', ['limit' => 200]);
        $parties = $this->Dimensions->Parties->find('list', ['limit' => 200]);
        $this->set(compact('dimension', 'modelBornes', 'parties'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dimension id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dimension = $this->Dimensions->get($id);
        if ($this->Dimensions->delete($dimension)) {
            $this->Flash->success(__('The dimension has been deleted.'));
        } else {
            $this->Flash->error(__('The dimension could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
