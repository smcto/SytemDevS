<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * StripeExcels Controller
 *
 * @property \App\Model\Table\StripeExcelsTable $StripeExcels
 *
 * @method \App\Model\Entity\StripeExcel[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StripeExcelsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['StripeCsvs']
        ];
        $stripeExcels = $this->paginate($this->StripeExcels);

        $this->set(compact('stripeExcels'));
    }

    /**
     * View method
     *
     * @param string|null $id Stripe Excel id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stripeExcel = $this->StripeExcels->get($id, [
            'contain' => ['StripeCsvs']
        ]);

        $this->set('stripeExcel', $stripeExcel);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $stripeExcel = $this->StripeExcels->newEntity();
        if ($this->request->is('post')) {
            $stripeExcel = $this->StripeExcels->patchEntity($stripeExcel, $this->request->getData());
            if ($this->StripeExcels->save($stripeExcel)) {
                $this->Flash->success(__('The stripe excel has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stripe excel could not be saved. Please, try again.'));
        }
        $stripeCsvs = $this->StripeExcels->StripeCsvs->find('list', ['limit' => 200]);
        $this->set(compact('stripeExcel', 'stripeCsvs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Stripe Excel id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stripeExcel = $this->StripeExcels->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stripeExcel = $this->StripeExcels->patchEntity($stripeExcel, $this->request->getData());
            if ($this->StripeExcels->save($stripeExcel)) {
                $this->Flash->success(__('The stripe excel has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stripe excel could not be saved. Please, try again.'));
        }
        $stripeCsvs = $this->StripeExcels->StripeCsvs->find('list', ['limit' => 200]);
        $this->set(compact('stripeExcel', 'stripeCsvs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stripe Excel id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stripeExcel = $this->StripeExcels->get($id);
        if ($this->StripeExcels->delete($stripeExcel)) {
            $this->Flash->success(__('The stripe excel has been deleted.'));
        } else {
            $this->Flash->error(__('The stripe excel could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
