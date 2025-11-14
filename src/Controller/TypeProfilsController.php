<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TypeProfils Controller
 *
 * @property \App\Model\Table\TypeProfilsTable $TypeProfils
 *
 * @method \App\Model\Entity\TypeProfil[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypeProfilsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $typeProfils = $this->paginate($this->TypeProfils);

        $this->set(compact('typeProfils'));
    }

    /**
     * View method
     *
     * @param string|null $id Type Profil id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $typeProfil = $this->TypeProfils->get($id, [
            'contain' => ['UserTypeProfils']
        ]);

        $this->set('typeProfil', $typeProfil);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $typeProfil = $this->TypeProfils->newEntity();
        if ($this->request->is('post')) {
            $typeProfil = $this->TypeProfils->patchEntity($typeProfil, $this->request->getData());
            if ($this->TypeProfils->save($typeProfil)) {
                $this->Flash->success(__('The type profil has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type profil could not be saved. Please, try again.'));
        }
        $this->set(compact('typeProfil'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Type Profil id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $typeProfil = $this->TypeProfils->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $typeProfil = $this->TypeProfils->patchEntity($typeProfil, $this->request->getData());
            if ($this->TypeProfils->save($typeProfil)) {
                $this->Flash->success(__('The type profil has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type profil could not be saved. Please, try again.'));
        }
        $this->set(compact('typeProfil'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Type Profil id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $typeProfil = $this->TypeProfils->get($id);
        if ($this->TypeProfils->delete($typeProfil)) {
            $this->Flash->success(__('The type profil has been deleted.'));
        } else {
            $this->Flash->error(__('The type profil could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
