<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DebitInternets Controller
 *
 * @property \App\Model\Table\DebitInternetsTable $DebitInternets
 *
 * @method \App\Model\Entity\DebitInternet[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DebitInternetsController extends AppController
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
        $debitInternets = $this->paginate($this->DebitInternets);

        $this->set(compact('debitInternets'));
    }

    /**
     * View method
     *
     * @param string|null $id Debit Internet id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $debitInternet = $this->DebitInternets->get($id, [
            'contain' => []
        ]);

        $this->set('debitInternet', $debitInternet);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $debitInternet = $this->DebitInternets->newEntity();
        if ($this->request->is('post')) {
            $debitInternet = $this->DebitInternets->patchEntity($debitInternet, $this->request->getData());
            if ($this->DebitInternets->save($debitInternet)) {
                $this->Flash->success(__('The debit internet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The debit internet could not be saved. Please, try again.'));
        }
        $this->set(compact('debitInternet'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Debit Internet id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $debitInternet = $this->DebitInternets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $debitInternet = $this->DebitInternets->patchEntity($debitInternet, $this->request->getData());
            if ($this->DebitInternets->save($debitInternet)) {
                $this->Flash->success(__('The debit internet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The debit internet could not be saved. Please, try again.'));
        }
        $this->set(compact('debitInternet'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Debit Internet id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $debitInternet = $this->DebitInternets->get($id);
        if ($this->DebitInternets->delete($debitInternet)) {
            $this->Flash->success(__('The debit internet has been deleted.'));
        } else {
            $this->Flash->error(__('The debit internet could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
