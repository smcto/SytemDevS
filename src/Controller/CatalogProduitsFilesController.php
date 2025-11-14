<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CatalogProduitsFiles Controller
 *
 * @property \App\Model\Table\CatalogProduitsFilesTable $CatalogProduitsFiles
 *
 * @method \App\Model\Entity\CatalogProduitsFile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CatalogProduitsFilesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CatalogProduits']
        ];
        $catalogProduitsFiles = $this->paginate($this->CatalogProduitsFiles);

        $this->set(compact('catalogProduitsFiles'));
    }

    /**
     * View method
     *
     * @param string|null $id Catalog Produits File id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $catalogProduitsFile = $this->CatalogProduitsFiles->get($id, [
            'contain' => ['CatalogProduits']
        ]);

        $this->set('catalogProduitsFile', $catalogProduitsFile);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $catalogProduitsFile = $this->CatalogProduitsFiles->newEntity();
        if ($this->request->is('post')) {
            $catalogProduitsFile = $this->CatalogProduitsFiles->patchEntity($catalogProduitsFile, $this->request->getData());
            if ($this->CatalogProduitsFiles->save($catalogProduitsFile)) {
                $this->Flash->success(__('The catalog produits file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The catalog produits file could not be saved. Please, try again.'));
        }
        $catalogProduits = $this->CatalogProduitsFiles->CatalogProduits->find('list', ['limit' => 200]);
        $this->set(compact('catalogProduitsFile', 'catalogProduits'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Catalog Produits File id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $catalogProduitsFile = $this->CatalogProduitsFiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $catalogProduitsFile = $this->CatalogProduitsFiles->patchEntity($catalogProduitsFile, $this->request->getData());
            if ($this->CatalogProduitsFiles->save($catalogProduitsFile)) {
                $this->Flash->success(__('The catalog produits file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The catalog produits file could not be saved. Please, try again.'));
        }
        $catalogProduits = $this->CatalogProduitsFiles->CatalogProduits->find('list', ['limit' => 200]);
        $this->set(compact('catalogProduitsFile', 'catalogProduits'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Catalog Produits File id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $catalogProduitsFile = $this->CatalogProduitsFiles->get($id);
        if ($this->CatalogProduitsFiles->delete($catalogProduitsFile)) {
            $this->Flash->success(__('The catalog produits file has been deleted.'));
        } else {
            $this->Flash->error(__('The catalog produits file could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
