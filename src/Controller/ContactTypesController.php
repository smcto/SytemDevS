<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;

class ContactTypesController extends AppController
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
        $contactTypes = $this->ContactTypes->find()->contain([]);
        $contactTypes = $this->paginate($contactTypes);
        $this->set(compact('contactTypes'));
    }

    public function view($id = null)
    {
        $contactTypeEntity = $this->ContactTypes->find()->findById($id)->contain([])->first();
        $this->set(compact('contactTypeEntity'));
    }

    public function add($id = null)
    {
        $contactTypeEntity = $this->ContactTypes->newEntity();

        if ($id) {
            $contactTypeEntity = $this->ContactTypes->findById($id)->contain([])->first();
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $contactTypeEntity = $this->ContactTypes->patchEntity($contactTypeEntity, $data, ['validate' => false]);
            if ($this->ContactTypes->save($contactTypeEntity)) {
                $this->Flash->success(__('The contact type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contact type could not be saved. Please, try again.'));
        }
        $this->set(@compact('contactType', 'id', 'contactTypeEntity'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contactTypeEntity = $this->ContactTypes->get($id);
        if ($this->ContactTypes->delete($contactTypeEntity)) {
            $this->Flash->success(__('The contact type has been deleted.'));
        } else {
            $this->Flash->error(__('The contact type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
