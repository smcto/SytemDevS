<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NumeroSeries Controller
 *
 * @property \App\Model\Table\NumeroSeriesTable $NumeroSeries
 *
 * @method \App\Model\Entity\NumeroSeries[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NumeroSeriesController extends AppController
{

    public function isAuthorized($user)
    {
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
            'contain' => ['LotProduits', 'Bornes']
        ];
        $numeroSeries = $this->paginate($this->NumeroSeries);

        $this->set(compact('numeroSeries'));
    }

    /**
     * View method
     *
     * @param string|null $id Numero Series id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $numeroSeries = $this->NumeroSeries->get($id, [
            'contain' => ['LotProduits', 'Bornes']
        ]);

        $this->set('numeroSeries', $numeroSeries);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $numeroSeries = $this->NumeroSeries->newEntity();
        if ($this->request->is('post')) {
            $numeroSeries = $this->NumeroSeries->patchEntity($numeroSeries, $this->request->getData());
            if ($this->NumeroSeries->save($numeroSeries)) {
                $this->Flash->success(__('The numero series has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The numero series could not be saved. Please, try again.'));
        }
        $lotProduits = $this->NumeroSeries->LotProduits->find('list', ['limit' => 200]);
        $bornes = $this->NumeroSeries->Bornes->find('list', ['limit' => 200]);
        $this->set(compact('numeroSeries', 'lotProduits', 'bornes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Numero Series id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $numeroSeries = $this->NumeroSeries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $numeroSeries = $this->NumeroSeries->patchEntity($numeroSeries, $this->request->getData());
            if ($this->NumeroSeries->save($numeroSeries)) {
                $this->Flash->success(__('The numero series has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The numero series could not be saved. Please, try again.'));
        }
        $lotProduits = $this->NumeroSeries->LotProduits->find('list', ['limit' => 200]);
        $bornes = $this->NumeroSeries->Bornes->find('list', ['limit' => 200]);
        $this->set(compact('numeroSeries', 'lotProduits', 'bornes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Numero Series id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $numeroSeries = $this->NumeroSeries->get($id);
        if ($this->NumeroSeries->delete($numeroSeries)) {
            $this->Flash->success(__('The numero series has been deleted.'));
        } else {
            $this->Flash->error(__('The numero series could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
