<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * GammesBornes Controller
 *
 * @property \App\Model\Table\GammesBornesTable $GammesBornes
 *
 * @method \App\Model\Entity\GammesBorne[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GammesBornesController extends AppController
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
        $gammesBornes = $this->paginate($this->GammesBornes, ['order' => ['id' => 'DESC']]);
        $this->set(compact('gammesBornes'));
    }

    /**
     * View method
     *
     * @param string|null $id Gammes Borne id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gammesBorne = $this->GammesBornes->get($id, [
            'contain' => []
        ]);

        $this->set('gammesBorne', $gammesBorne);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $gammesBorne = $this->GammesBornes->newEntity();
        if ($id) {
            $gammesBorne = $this->GammesBornes->findById($id)->first();
        }
        if ($this->request->is(['post', 'put'])) {
            $gammesBorne = $this->GammesBornes->patchEntity($gammesBorne, $this->request->getData());
            if ($this->GammesBornes->save($gammesBorne)) {
                $this->Flash->success(__('The gammes borne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gammes borne could not be saved. Please, try again.'));
        }
        $this->set(compact('gammesBorne', 'id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Gammes Borne id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gammesBorne = $this->GammesBornes->get($id);
        if ($this->GammesBornes->delete($gammesBorne)) {
            $this->Flash->success(__('The gammes borne has been deleted.'));
        } else {
            $this->Flash->error(__('The gammes borne could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
