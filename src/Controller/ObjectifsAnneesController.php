<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;

class ObjectifsAnneesController extends AppController
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
        $objectifsAnnees = $this->ObjectifsAnnees->find()->contain(['Users', 'ObjectifsCommerciaux']);
        $objectifsAnnees = $this->paginate($objectifsAnnees);
        $this->set(compact('objectifsAnnees'));
    }

    public function view($id = null)
    {
        $objectifsAnneeEntity = $this->ObjectifsAnnees->find()->findById($id)->contain(['Users', 'ObjectifsCommerciaux'])->first();
        $this->set(compact('objectifsAnneeEntity'));
    }

    public function add($id = null)
    {
        $objectifsAnneeEntity = $this->ObjectifsAnnees->newEntity();

        if ($id) {
            $objectifsAnneeEntity = $this->ObjectifsAnnees->findById($id)->contain(['Users', 'ObjectifsCommerciaux'])->first();
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $objectifsAnneeEntity = $this->ObjectifsAnnees->patchEntity($objectifsAnneeEntity, $data, ['validate' => false]);
            if ($this->ObjectifsAnnees->save($objectifsAnneeEntity)) {
                $this->Flash->success(__('The objectifs annee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The objectifs annee could not be saved. Please, try again.'));
        }
        $users = $this->ObjectifsAnnees->Users->find('list', ['limit' => 200]);
        $this->set(@compact('objectifsAnnee', 'users', 'id', 'objectifsAnneeEntity'));
    }

    public function delete($id = null, $commercial_id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $objectifsAnneeEntity = $this->ObjectifsAnnees->get($id);
        if ($this->ObjectifsAnnees->delete($objectifsAnneeEntity)) {
            $this->Flash->success(__('The objectifs annee has been deleted.'));
        } else {
            $this->Flash->error(__('The objectifs annee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Objectifs', 'action' => 'view', $commercial_id]);
    }
}
