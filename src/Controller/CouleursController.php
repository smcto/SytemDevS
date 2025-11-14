<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Couleurs Controller
 *
 * @property \App\Model\Table\CouleursTable $Couleurs
 *
 * @method \App\Model\Entity\Couleur[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CouleursController extends AppController
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
        $couleurs = $this->paginate($this->Couleurs);

        $this->set(compact('couleurs'));
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
        $couleur = $this->Couleurs->get($id, [
            'contain' => []
        ]);

        $this->set('couleur', $couleur);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $couleur = $this->Couleurs->newEntity();
        if ($this->request->is('post')) {
            $couleur = $this->Couleurs->patchEntity($couleur, $this->request->getData());
            if ($this->Couleurs->save($couleur)) {
                $this->Flash->success(__('The couleur has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The couleur could not be saved. Please, try again.'));
        }
        $this->set(compact('couleur'));
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
        $couleur = $this->Couleurs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $couleur = $this->Couleurs->patchEntity($couleur, $this->request->getData());
            if ($this->Couleurs->save($couleur)) {
                $this->Flash->success(__('The couleur has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The couleur could not be saved. Please, try again.'));
        }
        $this->set(compact('couleur'));
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
        $couleur = $this->Couleurs->get($id);
        if ($this->Couleurs->delete($couleur)) {
            $this->Flash->success(__('The couleur has been deleted.'));
        } else {
            $this->Flash->error(__('The couleur could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
