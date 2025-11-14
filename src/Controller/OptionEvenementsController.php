<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OptionEvenements Controller
 *
 * @property \App\Model\Table\OptionEvenementsTable $OptionEvenements
 *
 * @method \App\Model\Entity\OptionEvenement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OptionEvenementsController extends AppController
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
        $optionEvenements = $this->paginate($this->OptionEvenements);

        $this->set(compact('optionEvenements'));
    }

    /**
     * View method
     *
     * @param string|null $id Option Evenement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $optionEvenement = $this->OptionEvenements->get($id, [
            'contain' => []
        ]);

        $this->set('optionEvenement', $optionEvenement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $optionEvenement = $this->OptionEvenements->newEntity();
        if ($this->request->is('post')) {
            $optionEvenement = $this->OptionEvenements->patchEntity($optionEvenement, $this->request->getData());
            if ($this->OptionEvenements->save($optionEvenement)) {
                $this->Flash->success(__('The option evenement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The option evenement could not be saved. Please, try again.'));
        }
        $this->set(compact('optionEvenement'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Option Evenement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $optionEvenement = $this->OptionEvenements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $optionEvenement = $this->OptionEvenements->patchEntity($optionEvenement, $this->request->getData());
            if ($this->OptionEvenements->save($optionEvenement)) {
                $this->Flash->success(__('The option evenement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The option evenement could not be saved. Please, try again.'));
        }
        $this->set(compact('optionEvenement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Option Evenement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $optionEvenement = $this->OptionEvenements->get($id);
        if ($this->OptionEvenements->delete($optionEvenement)) {
            $this->Flash->success(__('The option evenement has been deleted.'));
        } else {
            $this->Flash->error(__('The option evenement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
