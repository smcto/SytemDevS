<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MoyenReglements Controller
 *
 * @property \App\Model\Table\MoyenReglementsTable $MoyenReglements
 *
 * @method \App\Model\Entity\MoyenReglement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MoyenReglementsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $moyenReglements = $this->paginate($this->MoyenReglements);

        $this->set(compact('moyenReglements'));
    }

    /**
     * View method
     *
     * @param string|null $id Moyen Reglement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $moyenReglement = $this->MoyenReglements->get($id, [
            'contain' => ['Reglements']
        ]);

        $this->set('moyenReglement', $moyenReglement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $moyenReglement = $this->MoyenReglements->newEntity();
        if ($this->request->is('post')) {
            $moyenReglement = $this->MoyenReglements->patchEntity($moyenReglement, $this->request->getData());
            if ($this->MoyenReglements->save($moyenReglement)) {
                $this->Flash->success(__('The moyen reglement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The moyen reglement could not be saved. Please, try again.'));
        }
        $this->set(compact('moyenReglement'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Moyen Reglement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $moyenReglement = $this->MoyenReglements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $moyenReglement = $this->MoyenReglements->patchEntity($moyenReglement, $this->request->getData());
            if ($this->MoyenReglements->save($moyenReglement)) {
                $this->Flash->success(__('The moyen reglement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The moyen reglement could not be saved. Please, try again.'));
        }
        $this->set(compact('moyenReglement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Moyen Reglement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $moyenReglement = $this->MoyenReglements->get($id);
        if ($this->MoyenReglements->delete($moyenReglement)) {
            $this->Flash->success(__('The moyen reglement has been deleted.'));
        } else {
            $this->Flash->error(__('The moyen reglement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
