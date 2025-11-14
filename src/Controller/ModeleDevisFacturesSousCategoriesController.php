<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ModeleDevisFacturesSousCategories Controller
 *
 * @property \App\Model\Table\ModeleDevisFacturesSousCategoriesTable $ModeleDevisFacturesSousCategories
 *
 * @method \App\Model\Entity\ModeleDevisFacturesSousCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ModeleDevisFacturesSousCategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ModeleDevisFacturesCategories']
        ];
        $modeleDevisFacturesSousCategories = $this->paginate($this->ModeleDevisFacturesSousCategories);

        $this->set(compact('modeleDevisFacturesSousCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Modele DevisFactures Sous Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $modeleDevisFacturesSousCategory = $this->ModeleDevisFacturesSousCategories->get($id, [
            'contain' => ['ModeleDevisFacturesCategories', 'DevisFactures']
        ]);

        $this->set('modeleDevisFacturesSousCategory', $modeleDevisFacturesSousCategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $modeleDevisFacturesSousCategory = $this->ModeleDevisFacturesSousCategories->newEntity();
        if ($this->request->is('post')) {
            $modeleDevisFacturesSousCategory = $this->ModeleDevisFacturesSousCategories->patchEntity($modeleDevisFacturesSousCategory, $this->request->getData());
            if ($this->ModeleDevisFacturesSousCategories->save($modeleDevisFacturesSousCategory)) {
                $this->Flash->success(__('The modele devis factures sous category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The modele devis factures sous category could not be saved. Please, try again.'));
        }
        $modeleDevisFacturesCategories = $this->ModeleDevisFacturesSousCategories->ModeleDevisFacturesCategories->find('list', ['limit' => 200]);
        $this->set(compact('modeleDevisFacturesSousCategory', 'modeleDevisFacturesCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Modele DevisFactures Sous Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $modeleDevisFacturesSousCategory = $this->ModeleDevisFacturesSousCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $modeleDevisFacturesSousCategory = $this->ModeleDevisFacturesSousCategories->patchEntity($modeleDevisFacturesSousCategory, $this->request->getData());
            if ($this->ModeleDevisFacturesSousCategories->save($modeleDevisFacturesSousCategory)) {
                $this->Flash->success(__('The modele devis factures sous category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The modele devis factures sous category could not be saved. Please, try again.'));
        }
        $modeleDevisFacturesCategories = $this->ModeleDevisFacturesSousCategories->ModeleDevisFacturesCategories->find('list', ['limit' => 200]);
        $this->set(compact('modeleDevisFacturesSousCategory', 'modeleDevisFacturesCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Modele DevisFactures Sous Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $modeleDevisFacturesSousCategory = $this->ModeleDevisFacturesSousCategories->get($id);
        if ($this->ModeleDevisFacturesSousCategories->delete($modeleDevisFacturesSousCategory)) {
            $this->Flash->success(__('The modele devis factures sous category has been deleted.'));
        } else {
            $this->Flash->error(__('The modele devis factures sous category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
