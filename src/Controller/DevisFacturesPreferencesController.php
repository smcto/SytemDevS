<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DevisFacturesPreferences Controller
 *
 * @property \App\Model\Table\DevisFacturesPreferencesTable $DevisFacturesPreferences
 *
 * @method \App\Model\Entity\DevisFacturesPreference[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevisFacturesPreferencesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['InfoBancaires', 'Adresses']
        ];
        $devisFacturesPreferences = $this->paginate($this->DevisFacturesPreferences);

        $this->set(compact('devisFacturesPreferences'));
    }

    /**
     * View method
     *
     * @param string|null $id DevisFactures Preference id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $devisFacturesPreference = $this->DevisFacturesPreferences->get($id, [
            'contain' => ['InfoBancaires', 'Adresses']
        ]);

        $this->set('devisFacturesPreference', $devisFacturesPreference);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $devisFacturesPreference = $this->DevisFacturesPreferences->newEntity();
        if ($this->request->is('post')) {
            $devisFacturesPreference = $this->DevisFacturesPreferences->patchEntity($devisFacturesPreference, $this->request->getData());
            if ($this->DevisFacturesPreferences->save($devisFacturesPreference)) {
                $this->Flash->success(__('The devisFactures preference has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The devisFactures preference could not be saved. Please, try again.'));
        }
        $infoBancaires = $this->DevisFacturesPreferences->InfoBancaires->find('list', ['limit' => 200]);
        $adresses = $this->DevisFacturesPreferences->Adresses->find('list', ['limit' => 200]);
        $this->set(compact('devisFacturesPreference', 'infoBancaires', 'adresses'));
    }

    /**
     * Edit method
     *
     * @param string|null $id DevisFactures Preference id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $devisFacturesPreference = $this->DevisFacturesPreferences->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $devisFacturesPreference = $this->DevisFacturesPreferences->patchEntity($devisFacturesPreference, $this->request->getData());
            if ($this->DevisFacturesPreferences->save($devisFacturesPreference)) {
                $this->Flash->success(__('The devisFactures preference has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The devisFactures preference could not be saved. Please, try again.'));
        }
        $infoBancaires = $this->DevisFacturesPreferences->InfoBancaires->find('list', ['limit' => 200]);
        $adresses = $this->DevisFacturesPreferences->Adresses->find('list', ['limit' => 200]);
        $this->set(compact('devisFacturesPreference', 'infoBancaires', 'adresses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id DevisFactures Preference id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $devisFacturesPreference = $this->DevisFacturesPreferences->get($id);
        if ($this->DevisFacturesPreferences->delete($devisFacturesPreference)) {
            $this->Flash->success(__('The devisFactures preference has been deleted.'));
        } else {
            $this->Flash->error(__('The devisFactures preference could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
