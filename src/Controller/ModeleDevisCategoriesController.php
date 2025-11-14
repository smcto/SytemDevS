<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ModeleDevisCategories Controller
 *
 * @property \App\Model\Table\ModeleDevisCategoriesTable $ModeleDevisCategories
 *
 * @method \App\Model\Entity\ModeleDevisCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ModeleDevisCategoriesController extends AppController
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
        $modeleDevisCategories = $this->paginate($this->ModeleDevisCategories);

        $this->set(compact('modeleDevisCategories'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $modeleDevisCategory = $this->ModeleDevisCategories->newEntity();
        
        if($id) {
            $modeleDevisCategory = $this->ModeleDevisCategories->get($id, [
                'contain' => []
            ]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $modeleDevisCategory = $this->ModeleDevisCategories->patchEntity($modeleDevisCategory, $this->request->getData());
            if ($this->ModeleDevisCategories->save($modeleDevisCategory)) {
                $this->Flash->success(__('The modele devis category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The modele devis category could not be saved. Please, try again.'));
        }
        $this->set(compact('modeleDevisCategory', 'id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Modele Devis Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $modeleDevisCategory = $this->ModeleDevisCategories->get($id);
        if ($this->ModeleDevisCategories->delete($modeleDevisCategory)) {
            $this->Flash->success(__('The modele devis category has been deleted.'));
        } else {
            $this->Flash->error(__('The modele devis category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
