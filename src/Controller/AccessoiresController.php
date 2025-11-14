<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Accessoires Controller
 *
 * @property \App\Model\Table\AccessoiresTable $Accessoires
 *
 * @method \App\Model\Entity\Accessoire[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccessoiresController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $gamme_borne_id = $this->request->getQuery('gamme_borne_id');
        $accessoires = $this->Accessoires->find()->contain(['SousAccessoires' => 'GammesBornes']);

        if ($gamme_borne_id) {
            $accessoires = $accessoires
                ->contain(['SousAccessoires' => 'SousAccessoiresGammes'])
                ->matching('SousAccessoires.SousAccessoiresGammes')
                ->where(['SousAccessoiresGammes.gamme_borne_id' => $gamme_borne_id])
            ;
        }
        
        $accessoires = $this->paginate($accessoires);

        $gammesBornes = $this->Accessoires->SousAccessoires->GammesBornes->find('list');

        $this->set(compact('accessoires','gammesBornes','gamme_borne_id'));
    }

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
     * View method
     *
     * @param string|null $id Accessoire id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accessoire = $this->Accessoires->get($id, [
            'contain' => ['AccessoiresGammes']
        ]);

        $this->set('accessoire', $accessoire);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $accessoire = $this->Accessoires->newEntity();
        if ($this->request->is('post')) {
            $accessoire = $this->Accessoires->patchEntity($accessoire, $this->request->getData());
            if ($this->Accessoires->save($accessoire)) {
                $this->Flash->success(__('The accessoire has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accessoire could not be saved. Please, try again.'));
        }
        $this->set(compact('accessoire','gammesBornes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Accessoire id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $accessoire = $this->Accessoires->get($id, [
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accessoire = $this->Accessoires->patchEntity($accessoire, $this->request->getData());
            if ($this->Accessoires->save($accessoire)) {
                $this->Flash->success(__('The accessoire has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accessoire could not be saved. Please, try again.'));
        }
        
        $this->set(compact('accessoire','gammesBornes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Accessoire id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accessoire = $this->Accessoires->get($id);
        if ($this->Accessoires->delete($accessoire)) {
            $this->Flash->success(__('The accessoire has been deleted.'));
        } else {
            $this->Flash->error(__('The accessoire could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
