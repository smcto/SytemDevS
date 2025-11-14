<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ModeleDevisSousCategories Controller
 *
 * @property \App\Model\Table\ModeleDevisSousCategoriesTable $ModeleDevisSousCategories
 *
 * @method \App\Model\Entity\ModeleDevisSousCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ModeleDevisSousCategoriesController extends AppController
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
        $categorie = $this->request->getQuery('modele_devis_categories_id');
        
        $customFinderOptions = [
            'modele_devis_categories_id' => $categorie
        ];
        $this->paginate = [
            'contain' => ['ModeleDevisCategories'],
            'finder' => ['filtre' => $customFinderOptions,]
        ];
        $modeleDevisSousCategories = $this->paginate($this->ModeleDevisSousCategories);
        $modeleDevisCategories = $this->ModeleDevisSousCategories->ModeleDevisCategories->find('list', ['limit' => 200]);
        $this->set(compact('modeleDevisSousCategories','modeleDevisCategories','categorie'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $modeleDevisSousCategory = $this->ModeleDevisSousCategories->newEntity();
        
        if($id) {
            $modeleDevisSousCategory = $this->ModeleDevisSousCategories->get($id, [
                'contain' => []
            ]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $modeleDevisSousCategory = $this->ModeleDevisSousCategories->patchEntity($modeleDevisSousCategory, $this->request->getData());
            if ($this->ModeleDevisSousCategories->save($modeleDevisSousCategory)) {
                $this->Flash->success(__('The modele devis sous category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The modele devis sous category could not be saved. Please, try again.'));
        }
        $modeleDevisCategories = $this->ModeleDevisSousCategories->ModeleDevisCategories->find('list', ['limit' => 200]);
        $this->set(compact('modeleDevisSousCategory', 'modeleDevisCategories', 'id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Modele Devis Sous Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $modeleDevisSousCategory = $this->ModeleDevisSousCategories->get($id);
        if ($this->ModeleDevisSousCategories->delete($modeleDevisSousCategory)) {
            $this->Flash->success(__('The modele devis sous category has been deleted.'));
        } else {
            $this->Flash->error(__('The modele devis sous category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
