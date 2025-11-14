<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DevisFacturesProduits Controller
 *
 * @property \App\Model\Table\DevisFacturesProduitsTable $DevisFacturesProduits
 *
 * @method \App\Model\Entity\DevisFacturesProduit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevisFacturesProduitsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CatalogUnites', 'DevisFactures', 'CatalogProduits']
        ];
        $devisFacturesProduits = $this->paginate($this->DevisFacturesProduits);

        $this->set(compact('devisFacturesProduits'));
    }

    /**
     * View method
     *
     * @param string|null $id DevisFactures Produit id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $devisFacturesProduit = $this->DevisFacturesProduits->get($id, [
            'contain' => ['CatalogUnites', 'DevisFactures', 'CatalogProduits']
        ]);

        $this->set('devisFacturesProduit', $devisFacturesProduit);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $devisFacturesProduit = $this->DevisFacturesProduits->newEntity();
        if ($this->request->is('post')) {
            $devisFacturesProduit = $this->DevisFacturesProduits->patchEntity($devisFacturesProduit, $this->request->getData());
            if ($this->DevisFacturesProduits->save($devisFacturesProduit)) {
                $this->Flash->success(__('The devisFactures produit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The devisFactures produit could not be saved. Please, try again.'));
        }
        $catalogUnites = $this->DevisFacturesProduits->CatalogUnites->find('list', ['limit' => 200]);
        $devisFactures = $this->DevisFacturesProduits->DevisFactures->find('list', ['limit' => 200]);
        $catalogProduits = $this->DevisFacturesProduits->CatalogProduits->find('list', ['limit' => 200]);
        $this->set(compact('devisFacturesProduit', 'catalogUnites', 'devisFactures', 'catalogProduits'));
    }

    /**
     * Edit method
     *
     * @param string|null $id DevisFactures Produit id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $devisFacturesProduit = $this->DevisFacturesProduits->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $devisFacturesProduit = $this->DevisFacturesProduits->patchEntity($devisFacturesProduit, $this->request->getData());
            if ($this->DevisFacturesProduits->save($devisFacturesProduit)) {
                $this->Flash->success(__('The devisFactures produit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The devisFactures produit could not be saved. Please, try again.'));
        }
        $catalogUnites = $this->DevisFacturesProduits->CatalogUnites->find('list', ['limit' => 200]);
        $devisFactures = $this->DevisFacturesProduits->DevisFactures->find('list', ['limit' => 200]);
        $catalogProduits = $this->DevisFacturesProduits->CatalogProduits->find('list', ['limit' => 200]);
        $this->set(compact('devisFacturesProduit', 'catalogUnites', 'devisFactures', 'catalogProduits'));
    }

    /**
     * Delete method
     *
     * @param string|null $id DevisFactures Produit id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $devisFacturesProduit = $this->DevisFacturesProduits->get($id);
        if ($this->DevisFacturesProduits->delete($devisFacturesProduit)) {
            $this->Flash->success(__('The devisFactures produit has been deleted.'));
        } else {
            $this->Flash->error(__('The devisFactures produit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
