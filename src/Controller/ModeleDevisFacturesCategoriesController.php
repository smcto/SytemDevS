<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ModeleDevisFacturesCategories Controller
 *
 * @property \App\Model\Table\ModeleDevisFacturesCategoriesTable $ModeleDevisFacturesCategories
 *
 * @method \App\Model\Entity\ModeleDevisFacturesCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ModeleDevisFacturesCategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $modeleDevisFacturesCategories = $this->paginate($this->ModeleDevisFacturesCategories);

        $this->set(compact('modeleDevisFacturesCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Modele DevisFactures Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $modeleDevisFacturesCategory = $this->ModeleDevisFacturesCategories->get($id, [
            'contain' => ['DevisFactures', 'ModeleDevisFacturesSousCategories']
        ]);

        $this->set('modeleDevisFacturesCategory', $modeleDevisFacturesCategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $modeleDevisFacturesCategory = $this->ModeleDevisFacturesCategories->newEntity();
        if ($this->request->is('post')) {
            $modeleDevisFacturesCategory = $this->ModeleDevisFacturesCategories->patchEntity($modeleDevisFacturesCategory, $this->request->getData());
            if ($this->ModeleDevisFacturesCategories->save($modeleDevisFacturesCategory)) {
                $this->Flash->success(__('The modele devis factures category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The modele devis factures category could not be saved. Please, try again.'));
        }
        $this->set(compact('modeleDevisFacturesCategory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Modele DevisFactures Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $modeleDevisFacturesCategory = $this->ModeleDevisFacturesCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $modeleDevisFacturesCategory = $this->ModeleDevisFacturesCategories->patchEntity($modeleDevisFacturesCategory, $this->request->getData());
            if ($this->ModeleDevisFacturesCategories->save($modeleDevisFacturesCategory)) {
                $this->Flash->success(__('The modele devis factures category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The modele devis factures category could not be saved. Please, try again.'));
        }
        $this->set(compact('modeleDevisFacturesCategory'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Modele DevisFactures Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $modeleDevisFacturesCategory = $this->ModeleDevisFacturesCategories->get($id);
        if ($this->ModeleDevisFacturesCategories->delete($modeleDevisFacturesCategory)) {
            $this->Flash->success(__('The modele devis factures category has been deleted.'));
        } else {
            $this->Flash->error(__('The modele devis factures category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
