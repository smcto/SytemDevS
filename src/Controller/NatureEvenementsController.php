<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NatureEvenements Controller
 *
 * @property \App\Model\Table\NatureEvenementsTable $NatureEvenements
 *
 * @method \App\Model\Entity\NatureEvenement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NatureEvenementsController extends AppController
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
        $natureEvenements = $this->paginate($this->NatureEvenements);

        $this->set(compact('natureEvenements'));
    }

    /**
     * View method
     *
     * @param string|null $id Nature Evenement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $natureEvenement = $this->NatureEvenements->get($id, [
            'contain' => []
        ]);

        $this->set('natureEvenement', $natureEvenement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $natureEvenement = $this->NatureEvenements->newEntity();
        if ($this->request->is('post')) {
            $natureEvenement = $this->NatureEvenements->patchEntity($natureEvenement, $this->request->getData());
            if ($this->NatureEvenements->save($natureEvenement)) {
                $this->Flash->success(__('The nature evenement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The nature evenement could not be saved. Please, try again.'));
        }
        $this->set(compact('natureEvenement'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Nature Evenement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $natureEvenement = $this->NatureEvenements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $natureEvenement = $this->NatureEvenements->patchEntity($natureEvenement, $this->request->getData());
            if ($this->NatureEvenements->save($natureEvenement)) {
                $this->Flash->success(__('The nature evenement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The nature evenement could not be saved. Please, try again.'));
        }
        $this->set(compact('natureEvenement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Nature Evenement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $natureEvenement = $this->NatureEvenements->get($id);
        if ($this->NatureEvenements->delete($natureEvenement)) {
            $this->Flash->success(__('The nature evenement has been deleted.'));
        } else {
            $this->Flash->error(__('The nature evenement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
