<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AccessoiresGammes Controller
 *
 * @property \App\Model\Table\AccessoiresGammesTable $AccessoiresGammes
 *
 * @method \App\Model\Entity\AccessoiresGamme[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccessoiresGammesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Accessoires', 'GammeBornes']
        ];
        $accessoiresGammes = $this->paginate($this->AccessoiresGammes);

        $this->set(compact('accessoiresGammes'));
    }

    /**
     * View method
     *
     * @param string|null $id Accessoires Gamme id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accessoiresGamme = $this->AccessoiresGammes->get($id, [
            'contain' => ['Accessoires', 'GammeBornes']
        ]);

        $this->set('accessoiresGamme', $accessoiresGamme);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $accessoiresGamme = $this->AccessoiresGammes->newEntity();
        if ($this->request->is('post')) {
            $accessoiresGamme = $this->AccessoiresGammes->patchEntity($accessoiresGamme, $this->request->getData());
            if ($this->AccessoiresGammes->save($accessoiresGamme)) {
                $this->Flash->success(__('The accessoires gamme has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accessoires gamme could not be saved. Please, try again.'));
        }
        $accessoires = $this->AccessoiresGammes->Accessoires->find('list', ['limit' => 200]);
        $gammeBornes = $this->AccessoiresGammes->GammeBornes->find('list', ['limit' => 200]);
        $this->set(compact('accessoiresGamme', 'accessoires', 'gammeBornes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Accessoires Gamme id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $accessoiresGamme = $this->AccessoiresGammes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accessoiresGamme = $this->AccessoiresGammes->patchEntity($accessoiresGamme, $this->request->getData());
            if ($this->AccessoiresGammes->save($accessoiresGamme)) {
                $this->Flash->success(__('The accessoires gamme has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accessoires gamme could not be saved. Please, try again.'));
        }
        $accessoires = $this->AccessoiresGammes->Accessoires->find('list', ['limit' => 200]);
        $gammeBornes = $this->AccessoiresGammes->GammeBornes->find('list', ['limit' => 200]);
        $this->set(compact('accessoiresGamme', 'accessoires', 'gammeBornes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Accessoires Gamme id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accessoiresGamme = $this->AccessoiresGammes->get($id);
        if ($this->AccessoiresGammes->delete($accessoiresGamme)) {
            $this->Flash->success(__('The accessoires gamme has been deleted.'));
        } else {
            $this->Flash->error(__('The accessoires gamme could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
