<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EmailsHasUsers Controller
 *
 * @property \App\Model\Table\EmailsHasUsersTable $EmailsHasUsers
 *
 * @method \App\Model\Entity\EmailsHasUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailsHasUsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Emails', 'Users']
        ];
        $emailsHasUsers = $this->paginate($this->EmailsHasUsers);

        $this->set(compact('emailsHasUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Emails Has User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emailsHasUser = $this->EmailsHasUsers->get($id, [
            'contain' => ['Emails', 'Users']
        ]);

        $this->set('emailsHasUser', $emailsHasUser);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $emailsHasUser = $this->EmailsHasUsers->newEntity();
        if ($this->request->is('post')) {
            $emailsHasUser = $this->EmailsHasUsers->patchEntity($emailsHasUser, $this->request->getData());
            if ($this->EmailsHasUsers->save($emailsHasUser)) {
                $this->Flash->success(__('The emails has user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The emails has user could not be saved. Please, try again.'));
        }
        $emails = $this->EmailsHasUsers->Emails->find('list', ['limit' => 200]);
        $users = $this->EmailsHasUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('emailsHasUser', 'emails', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Emails Has User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $emailsHasUser = $this->EmailsHasUsers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailsHasUser = $this->EmailsHasUsers->patchEntity($emailsHasUser, $this->request->getData());
            if ($this->EmailsHasUsers->save($emailsHasUser)) {
                $this->Flash->success(__('The emails has user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The emails has user could not be saved. Please, try again.'));
        }
        $emails = $this->EmailsHasUsers->Emails->find('list', ['limit' => 200]);
        $users = $this->EmailsHasUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('emailsHasUser', 'emails', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Emails Has User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $emailsHasUser = $this->EmailsHasUsers->get($id);
        if ($this->EmailsHasUsers->delete($emailsHasUser)) {
            $this->Flash->success(__('The emails has user has been deleted.'));
        } else {
            $this->Flash->error(__('The emails has user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
