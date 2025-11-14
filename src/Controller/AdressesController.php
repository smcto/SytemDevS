<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;

class AdressesController extends AppController
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
        $adresses = $this->Adresses->find()->contain([]);
        $adresses = $this->paginate($adresses);
        $this->set(compact('adresses'));
    }

    public function view($id = null)
    {
        $adressEntity = $this->Adresses->find()->findById($id)->contain([])->first();
        $this->set(compact('adressEntity'));
    }

    public function add($id = null)
    {
        $adressEntity = $this->Adresses->newEntity();

        if ($id) {
            $adressEntity = $this->Adresses->findById($id)->contain([])->first();
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $adressEntity = $this->Adresses->patchEntity($adressEntity, $data, ['validate' => false]);
            if ($this->Adresses->save($adressEntity)) {
                $this->Flash->success(__('The adress has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The adress could not be saved. Please, try again.'));
        }
        $this->set(@compact('adress', 'id', 'adressEntity'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $adressEntity = $this->Adresses->get($id);
        if ($this->Adresses->delete($adressEntity)) {
            $this->Flash->success(__('The adress has been deleted.'));
        } else {
            $this->Flash->error(__('The adress could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
