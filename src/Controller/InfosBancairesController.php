<?php
namespace App\Controller;

use App\Controller\AppController;

class InfosBancairesController extends AppController
{

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if(in_array('konitys', $typeprofils) || in_array('admin', $typeprofils)) {
            return true;
        }

        return parent::isAuthorized($user);
    }
    
    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->loadComponent('Utilities');
        $this->Utilities->loadModels([]);
    }

    public function index()
    {
        $infosBancaires = $this->paginate($this->InfosBancaires);
        $this->set(compact('infosBancaires'));
    }

    public function view($id = null)
    {
        $infosBancaire = $this->InfosBancaires->find()->findById($id)->contain([])->first();
        $this->set(compact('infosBancaire'));
    }

    public function add($id = null)
    {
        $infosBancaire = $this->InfosBancaires->newEntity();

        if ($id) {
            $infosBancaire = $this->InfosBancaires->findById($id)->contain([])->first();
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $infosBancaire = $this->InfosBancaires->patchEntity($infosBancaire, $this->request->getData());
            if ($this->InfosBancaires->save($infosBancaire)) {
                $this->Flash->success(__('The infos bancaire has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The infos bancaire could not be saved. Please, try again.'));
        }

        $this->set(compact('infosBancaire', 'id'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $infosBancaire = $this->InfosBancaires->get($id);
        if ($this->InfosBancaires->delete($infosBancaire)) {
            $this->Flash->success(__('The infos bancaire has been deleted.'));
        } else {
            $this->Flash->error(__('The infos bancaire could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
