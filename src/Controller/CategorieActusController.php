<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CategorieActus Controller
 *
 * @property \App\Model\Table\CategorieActusTable $CategorieActus
 *
 * @method \App\Model\Entity\CategorieActus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategorieActusController extends AppController
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
        $categorieActus = $this->paginate($this->CategorieActus);

        $this->set(compact('categorieActus'));
    }

    /**
     * View method
     *
     * @param string|null $id Categorie Actus id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $categorieActus = $this->CategorieActus->get($id, [
            'contain' => []
        ]);

        $this->set('categorieActus', $categorieActus);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categorieActus = $this->CategorieActus->newEntity();
        if ($this->request->is('post')) {
            $categorieActus = $this->CategorieActus->patchEntity($categorieActus, $this->request->getData());
            if ($this->CategorieActus->save($categorieActus)) {
                $this->Flash->success(__('The categorie actus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The categorie actus could not be saved. Please, try again.'));
        }
        $this->set(compact('categorieActus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Categorie Actus id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categorieActus = $this->CategorieActus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categorieActus = $this->CategorieActus->patchEntity($categorieActus, $this->request->getData());
            if ($this->CategorieActus->save($categorieActus)) {
                $this->Flash->success(__('The categorie actus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The categorie actus could not be saved. Please, try again.'));
        }
        $this->set(compact('categorieActus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Categorie Actus id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categorieActus = $this->CategorieActus->get($id);
        if ($this->CategorieActus->delete($categorieActus)) {
            $this->Flash->success(__('The categorie actus has been deleted.'));
        } else {
            $this->Flash->error(__('The categorie actus could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
