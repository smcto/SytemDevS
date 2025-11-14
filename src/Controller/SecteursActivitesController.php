<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;

class SecteursActivitesController extends AppController
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
        $secteursActivites = $this->SecteursActivites->find()->contain([]);
        $secteursActivites = $this->paginate($secteursActivites);
        $this->set(compact('secteursActivites'));
    }

    public function view($id = null)
    {
        $secteursActiviteEntity = $this->SecteursActivites->find()->findById($id)->contain([])->first();
        $this->set(compact('secteursActiviteEntity'));
    }

    public function add($id = null)
    {
        $secteursActiviteEntity = $this->SecteursActivites->newEntity();

        if ($id) {
            $secteursActiviteEntity = $this->SecteursActivites->findById($id)->contain([])->first();
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $secteursActiviteEntity = $this->SecteursActivites->patchEntity($secteursActiviteEntity, $data, ['validate' => false]);
            if ($this->SecteursActivites->save($secteursActiviteEntity)) {
                $this->Flash->success(__('The secteurs activite has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The secteurs activite could not be saved. Please, try again.'));
        }
        $this->set(@compact('secteursActivite', 'id', 'secteursActiviteEntity'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $secteursActiviteEntity = $this->SecteursActivites->get($id);
        if ($this->SecteursActivites->delete($secteursActiviteEntity)) {
            $this->Flash->success(__('The secteurs activite has been deleted.'));
        } else {
            $this->Flash->error(__('The secteurs activite could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
