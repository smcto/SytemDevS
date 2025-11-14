<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LieuTypes Controller
 *
 * @property \App\Model\Table\LieuTypesTable $LieuTypes
 *
 * @method \App\Model\Entity\LieuType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LieuTypesController extends AppController
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
        $lieuTypes = $this->paginate($this->LieuTypes);

        $this->set(compact('lieuTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Lieu Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lieuType = $this->LieuTypes->get($id, [
            'contain' => ['Antennes']
        ]);

        $this->set('lieuType', $lieuType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lieuType = $this->LieuTypes->newEntity();
        if ($this->request->is('post')) {
            $lieuType = $this->LieuTypes->patchEntity($lieuType, $this->request->getData());
            if ($this->LieuTypes->save($lieuType)) {
                $this->Flash->success(__('The lieu type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lieu type could not be saved. Please, try again.'));
        }
        $this->set(compact('lieuType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lieu Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lieuType = $this->LieuTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lieuType = $this->LieuTypes->patchEntity($lieuType, $this->request->getData());
            if ($this->LieuTypes->save($lieuType)) {
                $this->Flash->success(__('The lieu type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lieu type could not be saved. Please, try again.'));
        }
        $this->set(compact('lieuType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lieu Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lieuType = $this->LieuTypes->get($id);
        if ($this->LieuTypes->delete($lieuType)) {
            $this->Flash->success(__('The lieu type has been deleted.'));
        } else {
            $this->Flash->error(__('The lieu type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
