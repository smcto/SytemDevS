<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MarqueEquipements Controller
 *
 * @property \App\Model\Table\MarqueEquipementsTable $Couleurs
 *
 * @method \App\Model\Entity\MarqueEquipement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MarqueEquipementsController extends AppController
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
            'contain' =>['Equipements']
        ];
        $marqueEquipements = $this->paginate($this->MarqueEquipements);

        $this->set(compact('marqueEquipements'));
    }

    /**
     * View method
     *
     * @param string|null $id Couleur id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $marqueEquipement = $this->MarqueEquipements->get($id, [
            'contain' => ['Equipements']
        ]);

        $this->set('marqueEquipement', $marqueEquipement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $marqueEquipement = $this->MarqueEquipements->newEntity();
        if ($this->request->is('post')) {
            $marqueEquipement = $this->MarqueEquipements->patchEntity($marqueEquipement, $this->request->getData());
            if ($this->MarqueEquipements->save($marqueEquipement)) {
                $this->Flash->success(__('The mark equipement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mark equipement could not be saved. Please, try again.'));
        }
        $this->set(compact('marqueEquipement'));
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Couleur id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $marqueEquipement = $this->MarqueEquipements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $marqueEquipement = $this->MarqueEquipements->patchEntity($marqueEquipement, $this->request->getData());
            if ($this->MarqueEquipements->save($marqueEquipement)) {
                $this->Flash->success(__('The mark equipement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mark equipement could not be saved. Please, try again.'));
        }
        $this->set(compact('marqueEquipement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Couleur id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $marqueEquipement = $this->MarqueEquipements->get($id);
        if ($this->MarqueEquipements->delete($marqueEquipement)) {
            $this->Flash->success(__('The mark equipement has been deleted.'));
        } else {
            $this->Flash->error(__('The mark equipement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
