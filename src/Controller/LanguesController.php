<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Langues Controller
 *
 * @property \App\Model\Table\LanguesTable $Langues
 *
 * @method \App\Model\Entity\Langue[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LanguesController extends AppController
{

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if(in_array('konitys', $typeprofils) || in_array('admin', $typeprofils)) {
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
        $langues = $this->paginate($this->Langues);

        $this->set(compact('langues'));
    }

    /**
     * View method
     *
     * @param string|null $id Langue id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $langue = $this->Langues->get($id, [
            'contain' => ['Devis']
        ]);

        $this->set('langue', $langue);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        
        $langue = $this->Langues->newEntity();
        if ($id) {
            $langue = $this->Langues->get($id, [
                'contain' => []
            ]);
        }
        if ($this->request->is(['post', 'put'])) {
            $langue = $this->Langues->patchEntity($langue, $this->request->getData());
            if ($this->Langues->save($langue)) {
                $this->Flash->success(__('The langue has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The langue could not be saved. Please, try again.'));
        }
        $this->set(compact('langue'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Langue id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $langue = $this->Langues->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $langue = $this->Langues->patchEntity($langue, $this->request->getData());
            if ($this->Langues->save($langue)) {
                $this->Flash->success(__('The langue has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The langue could not be saved. Please, try again.'));
        }
        $this->set(compact('langue'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Langue id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $langue = $this->Langues->get($id);
        if ($this->Langues->delete($langue)) {
            $this->Flash->success(__('The langue has been deleted.'));
        } else {
            $this->Flash->error(__('The langue could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
