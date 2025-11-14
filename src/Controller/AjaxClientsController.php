<?php
namespace App\Controller;

use App\Controller\AppController;

class AjaxClientsController extends AppController
{
    public function initialize(array $config = [])
    {
        $this->loadModel('Clients');
        parent::initialize($config);
    }

    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * concernent page vente/recap, cf. form .popup modifier contacts
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteContact($id = null)
    {
        $result = ['status' => 'empty'];
        if ($id) {
            $this->loadModel('Clients');
            $entity = $this->Clients->ClientContacts->get($id);
            $result = $this->Clients->ClientContacts->delete($entity);

            if ($result) {
                $result = ['status' => 'success'];
            }
        }

        $body = $result;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }
    
    
    public function searchClient($type = null){
        
        $this->loadModel('Clients');
        $this->viewBuilder()->setLayout('ajax');
        $key = $this->request->getData('nom');

        $clients = $this->Clients
                ->find('NomEnseigne')
                ->where(['Clients.deleted <>' => 1])
                ->contain(['ClientContact']);
        
        if ($type) {
            $clients->where(['Clients.client_type LIKE' => $type]);
        }
        
        if(!empty($key)){
                
            $ipos = stripos($key, '"');
            $rpos = strrpos($key, '"');
            $pos = strpos($key, '"');

            if ($pos !== false) {
                
                $key = str_replace('"', '', $key);
                if($pos == 0 && $ipos == $pos && $rpos == $pos) {

                    $clients->where([
                        'OR' => [
                            ['Clients.nom LIKE' => "$key%"],
                            ['Clients.enseigne LIKE' => "$key%"],
                        ],
                    ]);
                } elseif ($pos > 0 && $ipos == $pos && $rpos == $pos) {

                    $clients->where([
                        'OR' => [
                            ['Clients.nom LIKE' => "%$key"],
                            ['Clients.enseigne LIKE' => "%$key"],
                        ],
                    ]);
                } else {
                    
                    $clients->where([
                        'OR' => [
                            ['Clients.nom LIKE' => $key],
                            ['Clients.enseigne LIKE' => $key],
                        ]
                    ]);
                }
                
            } else {
                $clients->where([
                    'OR' => [
                        ['Clients.nom LIKE' => "%$key%"],
                        ['Clients.enseigne LIKE' => "%$key%"]
                    ],
                ]);
            }
        }
        
        $clients->group('Clients.id')->order(['Clients.nom' => 'asc']);
        
        $body = [];
        if($clients){
            foreach ($clients as $id => $name) {
                $body[] = ['id' => $id, 'text' => $name];
            }
        }
        
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }
    
    public function updateAdressClient($client_id = null) {
        $return = ['status' => 0];
        $client = $this->Clients->findById($client_id)->first();
        if($client) {
            $data = $this->request->getData();
            $client = $this->Clients->patchEntity($client, $data);
            if($this->Clients->save($client)) {
                $return = ['status' => 1, 'client' => $client];
            }
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($return));
    }
    
    public function addContact($client_id = null) {
        
        $return = ['status' => 0];
        $contacts = $this->Clients->ClientContacts->find('list', ['valueField'=>'full_name'])->where(['client_id' => $client_id]);
        $client = $this->Clients->findById($client_id)->first();
        if($client) {
            $data = $this->request->getData();
            if($data['client_contact'] == 1) {
                $contact = $this->Clients->ClientContacts->findById($data['contact_id'])->first();
                if($contact) {
                    $return = ['status' => 1, 'contact' => $contact, 'contacts' => $contacts];
                }
            } elseif ($data['client_contact'] == 2) {
                $data['client_id'] = $client_id;
                $contact = $this->Clients->ClientContacts->newEntity($data);
                if($this->Clients->ClientContacts->save($contact)) {
                    $return = ['status' => 1, 'contact' => $contact, 'contacts' => $contacts];
                }
            }
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($return));
    }
    
    public function getContact($id) {
        
        $return = ['status' => 0];
        $contact = $this->Clients->ClientContacts->findById($id)->find('NotEmpty')->first();
        if($contact) {
            $return['contact'] = $contact;
            $return['status'] = 1;
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($return));
    }

    function getContactList($client_id)
    {
        $contacts = $this->Clients->ClientContacts->findByClientId($client_id)->find('NotEmpty')->find('list');
        return $this->response->withType('application/json')->withStringBody(json_encode($contacts));
    }
    
    public function getClientById($client_id) {
        $return = ['status' => 0];
        $client = $this->Clients->findById($client_id)->contain(['SecteursActivites'])->first();
        if($client) {
            $arraySecteursActivites = collection($client->secteurs_activites)->extract('id')->toArray();;
            $client->secteurs_activites_ids = $arraySecteursActivites;
            $contacts = $this->Clients->ClientContacts->find('list', ['valueField'=>'full_name'])->where(['client_id' => $client_id]);
            $return = ['status' => 1, 'client' => $client, 'contacts' => $contacts];
        }

        
        return $this->response->withType('application/json')->withStringBody(json_encode($return, JSON_PRETTY_PRINT));
    }
}