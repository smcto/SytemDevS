<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TypeEvenements Controller
 *
 * @property \App\Model\Table\TypeEvenementsTable $TypeEvenements
 *
 * @method \App\Model\Entity\TypeEvenement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypeEvenementsController extends AppController
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
        $typeEvenements = $this->paginate($this->TypeEvenements);

        $this->set(compact('typeEvenements'));
    }

    /**
     * View method
     *
     * @param string|null $id Type Evenement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $typeEvenement = $this->TypeEvenements->get($id, [
            'contain' => ['Evenements']
        ]);

        $this->set('typeEvenement', $typeEvenement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $typeEvenement = $this->TypeEvenements->newEntity();
        if ($this->request->is('post')) {
            $typeEvenement = $this->TypeEvenements->patchEntity($typeEvenement, $this->request->getData());
            if ($this->TypeEvenements->save($typeEvenement)) {
                $this->Flash->success(__('The type evenement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type evenement could not be saved. Please, try again.'));
        }
        $this->set(compact('typeEvenement'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Type Evenement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $typeEvenement = $this->TypeEvenements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $typeEvenement = $this->TypeEvenements->patchEntity($typeEvenement, $this->request->getData());
            if ($this->TypeEvenements->save($typeEvenement)) {
                $this->Flash->success(__('The type evenement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type evenement could not be saved. Please, try again.'));
        }
        $this->set(compact('typeEvenement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Type Evenement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $typeEvenement = $this->TypeEvenements->get($id, ['contain'=>'Evenements']);
        //debug($typeEvenement);die;
        if(!empty($typeEvenement->evenements)){
            $this->Flash->error(__('Ce type est deja liée à de(s) événement(s)'));
        } else {

            if ($this->TypeEvenements->delete($typeEvenement)) {
                $this->Flash->success(__('The type evenement has been deleted.'));
            } else {
                $this->Flash->error(__('The type evenement could not be deleted. Please, try again.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }
}
