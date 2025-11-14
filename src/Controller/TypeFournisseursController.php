<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TypeFournisseurs Controller
 *
 * @property \App\Model\Table\TypeFournisseursTable $TypeFournisseurs
 *
 * @method \App\Model\Entity\TypeFournisseur[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypeFournisseursController extends AppController
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
        $this->paginate =  [
            'contain' => ['Fournisseurs']
        ];
        $typeFournisseurs = $this->paginate($this->TypeFournisseurs);

        $this->set(compact('typeFournisseurs'));
    }

    /**
     * View method
     *
     * @param string|null $id Type Fournisseur id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $typeFournisseur = $this->TypeFournisseurs->get($id, [
            'contain' => ['Fournisseurs']
        ]);

        $this->set('typeFournisseur', $typeFournisseur);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $typeFournisseur = $this->TypeFournisseurs->newEntity();
        if ($this->request->is('post')) {
            $typeFournisseur = $this->TypeFournisseurs->patchEntity($typeFournisseur, $this->request->getData());
            if ($this->TypeFournisseurs->save($typeFournisseur)) {
                $this->Flash->success(__('The type fournisseur has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type fournisseur could not be saved. Please, try again.'));
        }
        $this->set(compact('typeFournisseur'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Type Fournisseur id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $typeFournisseur = $this->TypeFournisseurs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $typeFournisseur = $this->TypeFournisseurs->patchEntity($typeFournisseur, $this->request->getData());
            if ($this->TypeFournisseurs->save($typeFournisseur)) {
                $this->Flash->success(__('The type fournisseur has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type fournisseur could not be saved. Please, try again.'));
        }
        $this->set(compact('typeFournisseur'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Type Fournisseur id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $typeFournisseur = $this->TypeFournisseurs->get($id, ['contain'=>'Fournisseurs']);
        //debug($typeFournisseur);die;
        if(!empty($typeFournisseur->fournisseurs)){
            $this->Flash->error(__('Ce type est deja liée à de(s) fournisseur(s)'));
        } else {
            if ($this->TypeFournisseurs->delete($typeFournisseur)) {
                $this->Flash->success(__('The type fournisseur has been deleted.'));
            } else {
                $this->Flash->error(__('The type fournisseur could not be deleted. Please, try again.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }
}
