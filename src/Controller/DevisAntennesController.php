<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DevisAntennes Controller
 *
 * @property \App\Model\Table\DevisAntennesTable $DevisAntennes
 *
 * @method \App\Model\Entity\DevisAntenne[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevisAntennesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Devis', 'Antennes']
        ];
        $devisAntennes = $this->paginate($this->DevisAntennes);

        $this->set(compact('devisAntennes'));
    }

    /**
     * View method
     *
     * @param string|null $id Devis Antenne id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $devisAntenne = $this->DevisAntennes->get($id, [
            'contain' => ['Devis', 'Antennes']
        ]);

        $this->set('devisAntenne', $devisAntenne);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $devisAntenne = $this->DevisAntennes->newEntity();
        if ($this->request->is('post')) {
            $devisAntenne = $this->DevisAntennes->patchEntity($devisAntenne, $this->request->getData());
            if ($this->DevisAntennes->save($devisAntenne)) {
                $this->Flash->success(__('The devis antenne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The devis antenne could not be saved. Please, try again.'));
        }
        $devis = $this->DevisAntennes->Devis->find('list', ['limit' => 200]);
        $antennes = $this->DevisAntennes->Antennes->find('list', ['limit' => 200]);
        $this->set(compact('devisAntenne', 'devis', 'antennes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Devis Antenne id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $devisAntenne = $this->DevisAntennes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $devisAntenne = $this->DevisAntennes->patchEntity($devisAntenne, $this->request->getData());
            if ($this->DevisAntennes->save($devisAntenne)) {
                $this->Flash->success(__('The devis antenne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The devis antenne could not be saved. Please, try again.'));
        }
        $devis = $this->DevisAntennes->Devis->find('list', ['limit' => 200]);
        $antennes = $this->DevisAntennes->Antennes->find('list', ['limit' => 200]);
        $this->set(compact('devisAntenne', 'devis', 'antennes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Devis Antenne id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $devisAntenne = $this->DevisAntennes->get($id);
        if ($this->DevisAntennes->delete($devisAntenne)) {
            $this->Flash->success(__('The devis antenne has been deleted.'));
        } else {
            $this->Flash->error(__('The devis antenne could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
