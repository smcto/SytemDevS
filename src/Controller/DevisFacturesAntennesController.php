<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DevisFacturesAntennes Controller
 *
 * @property \App\Model\Table\DevisFacturesAntennesTable $DevisFacturesAntennes
 *
 * @method \App\Model\Entity\DevisFacturesAntenne[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevisFacturesAntennesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['DevisFactures', 'Antennes']
        ];
        $devisFacturesAntennes = $this->paginate($this->DevisFacturesAntennes);

        $this->set(compact('devisFacturesAntennes'));
    }

    /**
     * View method
     *
     * @param string|null $id DevisFactures Antenne id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $devisFacturesAntenne = $this->DevisFacturesAntennes->get($id, [
            'contain' => ['DevisFactures', 'Antennes']
        ]);

        $this->set('devisFacturesAntenne', $devisFacturesAntenne);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $devisFacturesAntenne = $this->DevisFacturesAntennes->newEntity();
        if ($this->request->is('post')) {
            $devisFacturesAntenne = $this->DevisFacturesAntennes->patchEntity($devisFacturesAntenne, $this->request->getData());
            if ($this->DevisFacturesAntennes->save($devisFacturesAntenne)) {
                $this->Flash->success(__('The devisFactures antenne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The devisFactures antenne could not be saved. Please, try again.'));
        }
        $devisFactures = $this->DevisFacturesAntennes->DevisFactures->find('list', ['limit' => 200]);
        $antennes = $this->DevisFacturesAntennes->Antennes->find('list', ['limit' => 200]);
        $this->set(compact('devisFacturesAntenne', 'devisFactures', 'antennes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id DevisFactures Antenne id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $devisFacturesAntenne = $this->DevisFacturesAntennes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $devisFacturesAntenne = $this->DevisFacturesAntennes->patchEntity($devisFacturesAntenne, $this->request->getData());
            if ($this->DevisFacturesAntennes->save($devisFacturesAntenne)) {
                $this->Flash->success(__('The devisFactures antenne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The devisFactures antenne could not be saved. Please, try again.'));
        }
        $devisFactures = $this->DevisFacturesAntennes->DevisFactures->find('list', ['limit' => 200]);
        $antennes = $this->DevisFacturesAntennes->Antennes->find('list', ['limit' => 200]);
        $this->set(compact('devisFacturesAntenne', 'devisFactures', 'antennes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id DevisFactures Antenne id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $devisFacturesAntenne = $this->DevisFacturesAntennes->get($id);
        if ($this->DevisFacturesAntennes->delete($devisFacturesAntenne)) {
            $this->Flash->success(__('The devisFactures antenne has been deleted.'));
        } else {
            $this->Flash->error(__('The devisFactures antenne could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
