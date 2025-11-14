<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;

/**
 * Emails Controller
 *
 * @property \App\Model\Table\EmailsTable $Emails
 *
 * @method \App\Model\Entity\Email[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailsController extends AppController
{

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        //debug($user);die;
        $typeprofils = $user['typeprofils'];
        return true;
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $emails = $this->paginate($this->Emails);

        $this->set(compact('emails'));
    }

    /**
     * View method
     *
     * @param string|null $id Email id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $email = $this->Emails->get($id, [
            'contain' => ['EmailsHasUsers']
        ]);

        $this->set('email', $email);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $email = $this->Emails->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            //debug($data);die;
            $email = $this->Emails->patchEntity($email, $data, [
            'associated' => ['Destinateurs', 'Expediteurs']
            ]);
            //debug($email);die;

            $confirmation_email = "";
            if ($this->Emails->save($email)) {
                //==== Envoy email
                $email_msg = new Email('default');
                $email_msg->setFrom([$email->email_expediteur => 'Konitys'])
                          ->setSubject($email->objet)
                          ->setTo($email->email_destinateur);
                if ($email_msg->send($email->contenu)) {
                    $email->is_sent = true;
                    $this->Emails->save($email);
                    $confirmation_email = "Email envoyé.";
                }
                $this->Flash->success(__('The email has been saved.'.$confirmation_email));
                //return $this->redirect(['action' => 'index']);
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The email could not be saved. Please, try again.'));
        }
        $this->set(compact('email'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Email id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $email = $this->Emails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $email = $this->Emails->patchEntity($email, $this->request->getData());
            if ($this->Emails->save($email)) {
                $this->Flash->success(__('The email has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The email could not be saved. Please, try again.'));
        }
        $this->set(compact('email'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Email id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $email = $this->Emails->get($id);
        if ($this->Emails->delete($email)) {
            $this->Flash->success(__('The email has been deleted.'));
        } else {
            $this->Flash->error(__('The email could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
