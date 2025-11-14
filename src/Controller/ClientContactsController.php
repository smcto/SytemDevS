<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * ClientContacts Controller
 *
 * @property \App\Model\Table\ClientContactsTable $ClientContacts
 *
 * @method \App\Model\Entity\ClientContact[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientContactsController extends AppController
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
    public function index($type = null)
    {
        $this->loadModel('Clients');
        $key = $this->request->getQuery('key');
        $contact_key = $this->request->getQuery('contact_key');
        $groupe_client_id = $this->request->getQuery('groupe_client_id');
        $type_contrats = $this->request->getQuery('type_contrats');
        $genres = Configure::read('genres');
        $type_commercials = Configure::read('type_commercials');
        $connaissance_selfizee = Configure::read('connaissance_selfizee');
        $filtres_contrats = Configure::read('filtres_contrats');
        $civilite = Configure::read('civilite');
        

        $customFinderOptions = $this->request->getQuery();
        $customFinderOptions['type'] = $type;
        
        $clients = $this->Clients->find('filtre', $customFinderOptions)->contain(['GroupeClients', 'ClientContacts', 'Devis', 'DevisFactures', 'Avoirs', 'Bornes' => ['ModelBornes' => 'GammesBornes']]);
        $clients = $this->paginate($clients, ['order' => ['Clients.created' => 'DESC']]);
        $secteursActivites = $this->Clients->SecteursActivites->find('list')->order(['name' => 'asc']);
        
        $groupeClients = $this->Clients->GroupeClients->find('list',['valueField' => 'nom']);
        $newContact = $this->ClientContacts->newEntity();
        $this->set(compact('newContact', 'type_contrats', 'filtres_contrats', 'clients','key','contact_key' ,'type', 'genres', 'type_commercials', 'groupeClients', 'groupe_client_id', 'secteursActivites', 'connaissance_selfizee', 'civilite'));
    }

    /**
     * View method
     *
     * @param string|null $id Client Contact id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientContact = $this->ClientContacts->get($id, [
            'contain' => ['Clients']
        ]);

        $this->set('clientContact', $clientContact);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientContact = $this->ClientContacts->newEntity();
        if ($this->request->is('post')) {
            $clientContact = $this->ClientContacts->patchEntity($clientContact, $this->request->getData());
            if ($this->ClientContacts->save($clientContact)) {
                $this->Flash->success(__('The client contact has been saved.'));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The client contact could not be saved. Please, try again.'));
        }
        $clients = $this->ClientContacts->Clients->find('list', ['limit' => 200]);
        $this->set(compact('clientContact', 'clients'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Contact id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientContact = $this->ClientContacts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientContact = $this->ClientContacts->patchEntity($clientContact, $this->request->getData());
            if ($this->ClientContacts->save($clientContact)) {
                $this->Flash->success(__('The client contact has been saved.'));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The client contact could not be saved. Please, try again.'));
        }
        $clients = $this->ClientContacts->Clients->find('list', ['limit' => 200]);
        $this->set(compact('clientContact', 'clients'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Contact id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $clientContact = $this->ClientContacts->get($id);
        if ($this->ClientContacts->delete($clientContact)) {
            $this->Flash->success(__('The client contact has been deleted.'));
        } else {
            $this->Flash->error(__('The client contact could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    
}
