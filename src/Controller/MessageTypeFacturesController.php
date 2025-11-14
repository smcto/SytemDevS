<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MessageTypeFactures Controller
 *
 * @property \App\Model\Table\MessageTypeFacturesTable $MessageTypeFactures
 *
 * @method \App\Model\Entity\MessageTypeFacture[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MessageTypeFacturesController extends AppController
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
        $this->paginate = [
            'contain' => ['EtatFactures']
        ];
        $messageTypeFactures = $this->paginate($this->MessageTypeFactures);

        $this->set(compact('messageTypeFactures'));
    }

    /**
     * View method
     *
     * @param string|null $id Message Type Facture id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $messageTypeFacture = $this->MessageTypeFactures->get($id, [
            'contain' => ['EtatFactures', 'Factures']
        ]);

        $this->set('messageTypeFacture', $messageTypeFacture);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $messageTypeFacture = $this->MessageTypeFactures->newEntity();
        if ($this->request->is('post')) {
            $messageTypeFacture = $this->MessageTypeFactures->patchEntity($messageTypeFacture, $this->request->getData());
            if ($this->MessageTypeFactures->save($messageTypeFacture)) {
                $this->Flash->success(__('The message type facture has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message type facture could not be saved. Please, try again.'));
        }
        $etatFactures = $this->MessageTypeFactures->EtatFactures->find('list', ['valueField' => 'nom']);
        $this->set(compact('messageTypeFacture', 'etatFactures'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Message Type Facture id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $messageTypeFacture = $this->MessageTypeFactures->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $messageTypeFacture = $this->MessageTypeFactures->patchEntity($messageTypeFacture, $this->request->getData());
            if ($this->MessageTypeFactures->save($messageTypeFacture)) {
                $this->Flash->success(__('The message type facture has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message type facture could not be saved. Please, try again.'));
        }
        $etatFactures = $this->MessageTypeFactures->EtatFactures->find('list', ['valueField' => 'nom']);
        $this->set(compact('messageTypeFacture', 'etatFactures'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Message Type Facture id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $messageTypeFacture = $this->MessageTypeFactures->get($id);
        if ($this->MessageTypeFactures->delete($messageTypeFacture)) {
            $this->Flash->success(__('The message type facture has been deleted.'));
        } else {
            $this->Flash->error(__('The message type facture could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
