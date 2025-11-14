<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;

class DevisPreferencesController extends AppController
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
        $this->Utilities->loadModels(['Adresses']);
    }

    public function index()
    {
        $devisPreferences = $this->DevisPreferences->find()->find()->contain(['InfosBancaires']);
        $devisPreferences = $this->paginate($devisPreferences);
        $this->set(compact('devisPreferences'));
    }

    public function view($id = null)
    {
        $devisPreferenceEntity = $this->DevisPreferences->find()->findById($id)->contain(['InfosBancaires'])->first();
        $this->set(compact('devisPreferenceEntity'));
    }

    public function add($id = null)
    {
        $devisPreferenceEntity = $this->DevisPreferences->newEntity();
        $moyen_reglements = Configure::read('moyen_reglements');
        $delai_reglements = Configure::read('delai_reglements');
        $accompte_unities = Configure::read('accompte_unities');
        $adresses = $this->DevisPreferences->Adresses->find('list');

        if ($id) {
            $devisPreferenceEntity = $this->DevisPreferences->findById($id)->contain(['InfosBancaires'])->first();
        }

        if ($devisPreferenceEntity == null) {
            return $this->redirect(['controller' => 'reglages']);
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $devisPreferenceEntity = $this->DevisPreferences->patchEntity($devisPreferenceEntity, $data, ['validate' => false]);

            if ($this->DevisPreferences->save($devisPreferenceEntity)) {
                $this->Flash->success(__('The devis preference has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The devis preference could not be saved. Please, try again.'));
        }
        $infosBancaires = $this->DevisPreferences->InfosBancaires->find('list', ['limit' => 200]);
        $this->set(compact('adresses', 'accompte_unities', 'moyen_reglements', 'delai_reglements', 'infosBancaires', 'id', 'devisPreferenceEntity'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $devisPreferenceEntity = $this->DevisPreferences->get($id);
        if ($this->DevisPreferences->delete($devisPreferenceEntity)) {
            $this->Flash->success(__('The devis preference has been deleted.'));
        } else {
            $this->Flash->error(__('The devis preference could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
