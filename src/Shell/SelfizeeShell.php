<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Shell;

use Cake\Console\Shell;


/**
 * Simple console wrapper around Psy\Shell.
 */
class SelfizeeShell extends Shell
{
    /**
     * Post event to BO selfizee
     * */
    public function main(){
        
        $this->loadModel('Evenements');
        $evenements = $this->Evenements->find('all')
                                ->contain(['DateEvenements','Clients'])
                                ->where(['is_posted_on_event' => false,'type_animation_id' => 1]);
        //var_dump($evenements->toArray());
        
        foreach($evenements as $evenement){
            //debug($evenement);
            //die;
            $data = array(); 
                $data['nom'] = $evenement->nom_event;
                $data['id_client_in_sellsy'] = $evenement->client->id_in_sellsy;
                $data['lieu'] = $evenement->lieu_exact;
                $dates = array();
                if(!empty($evenement->date_evenements)) {
                    foreach($evenement->date_evenements as $dateEvnt){
                        array_push($dates, $dateEvnt->date_debut->format('Y-m-d H:i'));
                        array_push($dates, $dateEvnt->date_fin->format('Y-m-d H:i'));
                    }
                    asort($dates);
                    $data['date_debut'] = current($dates);
                    $data['date_fin'] = end($dates);;
                } 
            
            //debug($data); die;
                 
                                                                               
            $data_string = json_encode($data);  
            //debug($data_string); die;                                                                                 
                                                                                                                                 
            $ch = curl_init('https://manager.selfizee.fr/evenements/send');                                                                      
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                'Content-Type: application/json',                                                                                
                'Content-Length: ' . strlen($data_string))                                                                       
            );                                                                                                                   
                                                                                                                                 
            $result = curl_exec($ch);
            $res = json_decode($result);
            var_dump($result);
            if(!empty($res)){
                if($res->success){
                    $evenement->is_posted_on_event = true;
                    if($this->Evenements->save($evenement)){
                        $this->out('Evenement posted '.$evenement->id);
                    }
                }
            }
        }
    }

     //======= SEND UPDATE DATA TO EVENT
    //======================================

    public function sendClientToEvent($IdClient = null) {

        $this->loadModel('Clients');
        $clients = $this->Clients->find('all',['contain'=>['ClientContacts']])
                        ->where([/*'is_by_webhooks' => true, */ 'is_posted_on_event' => false])
                        ->limit(150);

        if(!empty($IdClient)){
            $clients = $clients->where(['id'=>$IdClient]);
        }
        $clients = $clients->toArray();
        
        //debug($clients);die;
        //debug(json_encode($clients));die;
        foreach ($clients as $key => $client) {
            # code...
            $data = [];
            $data ['client'] = $client->toArray();
            unset($data['client']['id']);
            //debug(json_encode($data));die;
            //debug($data);die;

            $url = 'https://manager.selfizee.fr/evenements/saveClientFromCrm';
            //$url = 'http://localhost/event-selfizee-v2/evenements/saveClientFromCrm';
            $datas = json_encode($data);
            $headers = array(
                'Content-Type: application/json',                                                                                
                'Content-Length: ' . strlen($datas) 
            );

            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $url);
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $datas );
                                                                                                               
            $result = curl_exec($ch);
            $res = json_decode($result);
            if(!empty($res)){
                if($res->success){
                    $client->is_posted_on_event = true;
                    if($this->Clients->save($client)){
                        $this->out('Client posted '.$client->id.' ===> ID in event '.$res->id_in_event);
                    }
                }
            }
        }
    }

    public function sendContactToEvent() {

        $this->loadModel('ClientContacts');
        $contacts = $this->ClientContacts->find('all')->where([/*'is_by_webhooks' => true, */'is_posted_on_event' => false]);
        
        foreach ($contacts as $key => $contact) {
            # code...
            $data = [];
            $data ['contact'] = $contact->toArray();
            unset($data['contact']['id']);
            unset($data['contact']['client_id']);//== effacer client_id
            //debug(json_encode($data));die;
            //debug($data);die;

            $url = 'https://manager.selfizee.fr/evenements/saveContactFromCrm';
            $datas = json_encode($data);
            $headers = array(
                'Content-Type: application/json',                                                                                
                'Content-Length: ' . strlen($datas)
            );

            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $url);
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $datas );
                                                                                                               
            $result = curl_exec($ch);
            $res = json_decode($result);
            //debug($res);
            if(!empty($res)){
                if($res->success){
                    $contact->is_posted_on_event = true;
                    if($this->Contacts->save($contact)){
                        $this->out('Contact posted '.$contact->id.' ===> ID in event '.$res->id_in_event);
                    }
                }
            }
        }
    }

}
