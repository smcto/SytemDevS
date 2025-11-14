<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CouleurPossibles Controller
 *
 * @property \App\Model\Table\CouleurPossiblesTable $CouleurPossibles
 *
 * @method \App\Model\Entity\CouleurPossible[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CouleurPossiblesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ModelBornes']
        ];
        $couleurPossibles = $this->paginate($this->CouleurPossibles);

        $this->set(compact('couleurPossibles'));
    }

    /**
     * View method
     *
     * @param string|null $id Couleur Possible id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $couleurPossible = $this->CouleurPossibles->get($id, [
            'contain' => ['ModelBornes']
        ]);

        $this->set('couleurPossible', $couleurPossible);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $couleurPossible = $this->CouleurPossibles->newEntity();
        if ($this->request->is('post')) {
            $couleurPossible = $this->CouleurPossibles->patchEntity($couleurPossible, $this->request->getData());
            if ($this->CouleurPossibles->save($couleurPossible)) {
                $this->Flash->success(__('The couleur possible has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The couleur possible could not be saved. Please, try again.'));
        }
        $modelBornes = $this->CouleurPossibles->ModelBornes->find('list', ['limit' => 200]);
        $this->set(compact('couleurPossible', 'modelBornes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Couleur Possible id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $couleurPossible = $this->CouleurPossibles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $couleurPossible = $this->CouleurPossibles->patchEntity($couleurPossible, $this->request->getData());
            if ($this->CouleurPossibles->save($couleurPossible)) {
                $this->Flash->success(__('The couleur possible has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The couleur possible could not be saved. Please, try again.'));
        }
        $modelBornes = $this->CouleurPossibles->ModelBornes->find('list', ['limit' => 200]);
        $this->set(compact('couleurPossible', 'modelBornes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Couleur Possible id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $couleurPossible = $this->CouleurPossibles->get($id);
        if ($this->CouleurPossibles->delete($couleurPossible)) {
            $this->Flash->success(__('The couleur possible has been deleted.'));
        } else {
            $this->Flash->error(__('The couleur possible could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
