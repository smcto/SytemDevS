<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EtatBornes Controller
 *
 * @property \App\Model\Table\EtatBornesTable $EtatBornes
 *
 * @method \App\Model\Entity\EtatBorne[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EtatBornesController extends AppController
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
        $etatBornes = $this->paginate($this->EtatBornes);

        $this->set(compact('etatBornes'));
    }

    /**
     * View method
     *
     * @param string|null $id Etat Borne id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $etatBorne = $this->EtatBornes->get($id, [
            'contain' => ['Bornes']
        ]);

        $this->set('etatBorne', $etatBorne);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $etatBorne = $this->EtatBornes->newEntity();
        if ($this->request->is('post')) {
            $etatBorne = $this->EtatBornes->patchEntity($etatBorne, $this->request->getData());
            if ($this->EtatBornes->save($etatBorne)) {
                $this->Flash->success(__('The etat borne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The etat borne could not be saved. Please, try again.'));
        }
        $this->set(compact('etatBorne'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Etat Borne id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $etatBorne = $this->EtatBornes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $etatBorne = $this->EtatBornes->patchEntity($etatBorne, $this->request->getData());
            if ($this->EtatBornes->save($etatBorne)) {
                $this->Flash->success(__('The etat borne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The etat borne could not be saved. Please, try again.'));
        }
        $this->set(compact('etatBorne'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Etat Borne id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $etatBorne = $this->EtatBornes->get($id);
        if ($this->EtatBornes->delete($etatBorne)) {
            $this->Flash->success(__('The etat borne has been deleted.'));
        } else {
            $this->Flash->error(__('The etat borne could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
