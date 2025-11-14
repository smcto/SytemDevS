<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FactureDeductions Controller
 *
 * @property \App\Model\Table\FactureDeductionsTable $FactureDeductions
 *
 * @method \App\Model\Entity\FactureDeduction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FactureDeductionsController extends AppController
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
        $factureDeductions = $this->paginate($this->FactureDeductions);

        $this->set(compact('factureDeductions'));
    }

    /**
     * View method
     *
     * @param string|null $id Facture Deduction id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $factureDeduction = $this->FactureDeductions->get($id, [
            'contain' => []
        ]);

        $this->set('factureDeduction', $factureDeduction);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $factureDeduction = $this->FactureDeductions->newEntity();
        if ($this->request->is('post')) {
            $factureDeduction = $this->FactureDeductions->patchEntity($factureDeduction, $this->request->getData());
            if ($this->FactureDeductions->save($factureDeduction)) {
                $this->Flash->success(__('Enregistrement effectué.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Une erreur est survenue. Veuillez réessayer plus tard.'));
        }
        $this->set(compact('factureDeduction'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Facture Deduction id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $factureDeduction = $this->FactureDeductions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $factureDeduction = $this->FactureDeductions->patchEntity($factureDeduction, $this->request->getData());
            if ($this->FactureDeductions->save($factureDeduction)) {
                $this->Flash->success(__('Enregistrement effectué.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Une erreur est survenue. Veuillez réessayer plus tard.'));
        }
        $this->set(compact('factureDeduction'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Facture Deduction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $factureDeduction = $this->FactureDeductions->get($id);
        if ($this->FactureDeductions->delete($factureDeduction)) {
            $this->Flash->success(__('The facture deduction has been deleted.'));
        } else {
            $this->Flash->error(__('Une erreur est survenue. Veuillez réessayer plus tard.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
