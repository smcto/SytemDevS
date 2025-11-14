<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Chronos\Chronos;

class ClientsShell extends Shell
{
    
    /**
     * Start the shell and interactive console.
     *
     * @return int|null
     */
    public function main()
    {
        $this->out('Choisir la methode à lancer');
    }

    public function updateClients() {
        
        $this->loadModel('Clients');
        $this->out('Lancement...');
        $clients = $this->Clients->find('all')->contain(['DevisFactures', 'DevisFactures2']);
        foreach ($clients as $client) {
            if(count($client->factures)) {
                $editClient = $this->Clients->patchEntity($client, ['type_commercial' => 'client'], ['validate' => false]);
                $this->Clients->save($editClient);
                $this->out($client->id . ' client');
            } else {
                $editClient = $this->Clients->patchEntity($client, ['type_commercial' => 'prospect'], ['validate' => false]);
                $this->Clients->save($editClient);
                $this->out($client->id . ' prospect');
            }
        }
    }
    
    
    public function updateClientsLocaEvent() {
        
        $this->loadModel('Clients');
        $this->out('Lancement...');
        $clients = $this->Clients->find('all')->contain(['Devis', 'Bornes']);
        foreach ($clients as $client) {

            $data = [
                'is_location_event' => 0,
                'is_location_financiere' => 0,
                'is_vente' => 0,
                'is_selfizee_part' => 0,
                'is_digitea' => 0,
                'is_brandeet' => 0,
            ];

            if(count($client->devis)) {

                foreach ($client->devis as $devis) {
                    if( ! $devis->is_model) {

                        switch ($devis->type_doc_id) {
                            case 1 : { $data['is_selfizee_part'] = 1; break;}
                            case 2 : { $data['is_digitea'] = 1; break;}
                            case 3 : { $data['is_brandeet'] = 1; break;}
                            case 4 : { $data['is_location_event'] = 1; break;}
                            case 5 : { $data['is_vente'] = 1; break;}
                            case 6 : { $data['is_location_financiere'] = 1;break;}
                            default : break;
                        }
                    }
                }
            }

            if(count($client->bornes)) {

                foreach ($client->bornes as $borne) {

                    switch ($borne->parc_id) {
                        case 1 : { $data['is_vente'] = 1; break;}
                        case 4 : { $data['is_location_financiere'] = 1; break;}
                        default : break;
                    }
                }
            }

            $editClient = $this->Clients->patchEntity($client, $data, ['validate' => false]);
            $this->Clients->save($editClient);
            $this->out($client->id . ' saved');
        }
    }
    
    
    public function updateTypeClients() {
        
        $this->loadModel('Clients');
        $this->out('Lancement...');
        $clients = $this->Clients->find('all')->where(['is_location_financiere' => 1]);
        foreach ($clients as $client) {
            $editClient = $this->Clients->patchEntity($client, ['client_type' => 'corporation'], ['validate' => false]);
            $this->Clients->save($editClient);
            $this->out($client->id . ' saved');
        }
    }
    
    public function updateSecteursActivites() {
        
        $this->loadModel('Clients');
        $this->out('Lancement...');
        $clients = $this->Clients->find('all')->where(['secteurs_activite_id is not null']);
        foreach ($clients as $client) {
            $editClient = $this->Clients->patchEntity($client, ['secteurs_activites' => ['_ids' => [$client->secteurs_activite_id]]], ['validate' => false]);
            $this->Clients->save($editClient);
            $this->out($client->id . ' saved');
        }
    }
    
    
    public function updateTelephone() {
        
        $this->loadModel('Clients');
        $this->out('Lancement...');
        $clients = $this->Clients->find('all')->where(['telephone LIKE' => '% %']);
        foreach ($clients as $client) {
            
            $telephone = str_replace(" ", "", $client->telephone);
            $editClient = $this->Clients->patchEntity($client, ['telephone' => $telephone], ['validate' => false]);
            $this->Clients->save($editClient);
            $this->out($client->id . ' saved');
        }
    }
    
    
    public function updateTelephoneContacts() {
        
        $this->loadModel('ClientContacts');
        $this->out('Lancement...');
        $clients = $this->ClientContacts->find('all')->where(['OR' => 
            [
                'tel LIKE' => '% %',
                'tel LIKE ' => '%.%',
                'telephone_2 LIKE' => '% %',
                'telephone_2 LIKE ' => '%.%',
            ]
        ]);
        foreach ($clients as $client) {
            
            $telephone = str_replace([" ", "."],["", ""], $client->tel);
            $telephone2 = str_replace([" ", "."],["", ""], $client->telephone_2);
            $editClient = $this->ClientContacts->patchEntity($client, ['tel' => $telephone, 'telephone_2' => $telephone2], ['validate' => false]);
            $this->ClientContacts->save($editClient);
            $this->out($client->id . ' saved');
        }
    }
    
}
