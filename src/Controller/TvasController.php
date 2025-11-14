<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;

class TvasController extends AppController
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
        $tvas = $this->Tvas->find()->contain([]);
        $tvas = $this->paginate($tvas);
        $this->set(compact('tvas'));
    }

    public function view($id = null)
    {
        $tvaEntity = $this->Tvas->find()->findById($id)->contain([])->first();
        $this->set(compact('tvaEntity'));
    }

    public function add($id = null)
    {
        $tvaEntity = $this->Tvas->newEntity();

        if ($id) {
            $tvaEntity = $this->Tvas->findById($id)->contain([])->first();
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            if ($data['is_default'] == 1) {
                $this->Tvas->updateAll(['is_default' => 0], []);
            }
            
            $tvaEntity = $this->Tvas->patchEntity($tvaEntity, $data, ['validate' => false]);

            if ($this->Tvas->save($tvaEntity)) {
                $this->Flash->success(__('The tva has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tva could not be saved. Please, try again.'));
        }
        $this->set(@compact('tva', 'id', 'tvaEntity'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tvaEntity = $this->Tvas->get($id);
        if ($this->Tvas->delete($tvaEntity)) {
            $this->Flash->success(__('The tva has been deleted.'));
        } else {
            $this->Flash->error(__('The tva could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
