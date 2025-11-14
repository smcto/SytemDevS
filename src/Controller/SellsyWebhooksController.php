<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Date;
use Cake\Mailer\Email;
use Cake\Log\Log;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\SellsyCurlComponent;

/**
 * SellsyWebhooks Controller
 *

 */
class SellsyWebhooksController extends AppController
{
    public function isAuthorized($user)
    {
        //$action = $this->request->getParam('action');
        //s$typeprofils = $user['typeprofils'];
        return true;
    }

    public function getFactureSellsy($doc_id){
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Document.getOne',
            'params' => array(
                'doctype' => 'invoice',
                'docid'     => $doc_id
            )
        );
        $document = $this->sellsyCurlComponent->requestApi($request);
        debug($document);die;
    }

    public function getDevisSellsy($doc_id){
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Document.getOne',
            'params' => array(
                'doctype' => 'estimate',
                'docid'     => $doc_id
            )
        );
        $document = $this->sellsyCurlComponent->requestApi($request);
        debug($document);die;
    }

    public function getEvent0(){

        $datas = $this->request->getData();
        if($this->request->is('post')) {
            //debug($datas);die;
            $email_msg = new Email('default');
            $email_msg->setFrom(['contact@konitys.fr' => 'DEBUG Webhook CRM '])
                ->setSubject('DEBUG Webhook CRM ')
                ->setTo('celest1.pr@gmail.com');
            if ($email_msg->send(json_encode($datas))) {//$datas['notif']
                echo 'sent';die;
            }
        }
        //debug($document);die;
    }

    public function getEvent()
    {
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        
        //json_encode($datas);
        $res = null;
        if ($this->request->is('post')) {
            $datas = $this->request->getData();
            Log::warning('Data postée '.json_encode($datas), ['scope' => ['webhooks_sellsy']]);
            $datas = $datas['notif'];

            $event = $datas['event'];
            $objet = $datas['relatedtype'];
            $objet_id = $datas['relatedid'];

            $res ['success'] = false;
            //=== Documents
            if($objet == "invoice" || $objet == "estimate"){
                $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
                $request = array(
                    'method' => 'Document.getOne',
                    'params' => array(
                        'doctype' => $objet,
                        'docid'     => $objet_id
                    )
                );
                if($objet == "estimate") { $request['params']['search']['steps'] = array('accepted','invoiced'); }

                $doc_in_sellsy = $this->sellsyCurlComponent->requestApi($request)->response;
                //debug($doc_in_sellsy);die;

                if($event == "deleted") {
                    $this->loadModel('Documents');
                    $doc = $this->Documents->find('all')->where(["id_in_sellsy" => intval($objet_id)])->first();
                    if ($doc) {
                        $doc->deleted_in_sellsy = true;
                        $doc->deleted_by_webhooks = true;
                        if($this->Documents->save($doc)){
                            $res ['success'] = true;
                            echo json_encode($res);
                            //return  $this->response->withStatus(200);
                        }
                    }
                }

                if($event == "created" || $event == "updated") {

                    $documentsInsert['objet'] = isset($doc_in_sellsy->subject) ? $doc_in_sellsy->subject : null;
                    $documentsInsert['date'] = isset($doc_in_sellsy->displayedDate) ? $doc_in_sellsy->displayedDate : null;
                    $date = implode("-", explode('/', $documentsInsert['date']));
                    $documentsInsert['date'] = new Date($date);
                    $documentsInsert['montant_ttc'] = isset($doc_in_sellsy->totalAmount) ? floatval($doc_in_sellsy->totalAmount) : null;
                    $documentsInsert['montant_ht'] = $doc_in_sellsy->totalAmountTaxesFree;
                    $documentsInsert['id_in_sellsy'] = $doc_in_sellsy->id;
                    $documentsInsert['deleted_in_sellsy'] = false;
                    $documentsInsert['type_document'] = $doc_in_sellsy->linkedtype;
                    $documentsInsert['step'] = isset($doc_in_sellsy->step) ? $doc_in_sellsy->step : null;
                    $documentsInsert['url_sellsy'] = "https://www.sellsy.fr/";

                    //echo json_encode($documentsInsert);die;

                    $this->loadModel('Clients');
                    $clientFind = $this->Clients->find()->where(["id_in_sellsy" => intval($doc_in_sellsy->thirdid)])->first();
                    //debug($clientFind);die;
                    if ($clientFind) {
                        $clientId = $clientFind->id;
                        $documentsInsert['client_id'] = $clientId;
                        $documentsInsert['is_by_webhooks'] = true;

                        $this->loadModel('Documents');
                        $document = $this->Documents->newEntity();
                        $docFind = $this->Documents->find('all')->where(["id_in_sellsy" => intval($doc_in_sellsy->id)])->first();
                        if ($docFind) {
                            $document = $docFind;
                        }
                        $document = $this->Documents->patchEntity($document, $documentsInsert, ['validate' => false]);
                        if ($this->Documents->save($document)) {
                            $res ['success'] = true;
                            echo json_encode($res);
                            //return  $this->response->withStatus(200);
                        }
                    }
                }
            }

            //=== Client
            if($objet == "third") {

                $this->loadModel('Clients');
                if($event == "deleted") {
                    $clientFind = $this->Clients->find()->where(["id_in_sellsy" => intval($objet_id)])->first();
                    if ($clientFind) {
                        $clientFind->deleted_in_sellsy = true;
                        $clientFind->deleted_by_webhooks = true;
                        if($this->Clients->save($clientFind)){
                            $res ['success'] = true;
                            echo json_encode($res);
                            //return  $this->response->withStatus(200);
                        }
                    }
                }

                $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
                $request = array(
                    'method' => 'Client.getOne',
                    'params' => array(
                        'clientid'  =>  $objet_id
                    )
                );
                $client = $this->sellsyCurlComponent->requestApi($request)->response;
                //debug(json_decode(json_encode($client->contacts), true));die;

                if($event == "created" || $event == "updated") {

                    $clientContacts = isset($client->contacts) ? $client->contacts : null;
                    $clientContacts = $clientContacts != null ? json_decode(json_encode($clientContacts), true) : null;
                    $clientContacts = is_array($clientContacts) ? array_values($clientContacts) : null;
                    $clientContact = $clientContacts != null && isset($clientContacts[0]) ? (object)$clientContacts[0] : null;

                    $clientAdress = isset($client->address[0]) ? $client->address[0] : null;

                    $clientToInsert['nom'] = isset($client->client->name) ? $client->client->name : null;
                    $clientToInsert['prenom'] = isset($clientContact->forename) ? $clientContact->forename : null;
                    $clientToInsert['cp'] = isset($clientAdress->zip) ? intval($clientAdress->zip) : null;
                    $clientToInsert['email'] = isset($clientContact->email) ? $clientContact->email : null;
                    $clientToInsert['ville'] = isset($clientAdress->town) ? $clientAdress->town : null;
                    $clientToInsert['telephone'] = isset($clientContact->tel) ? $clientContact->tel : null;
                    $clientToInsert['mobile'] = isset($clientContact->mobile) ? $clientContact->mobile : null;
                    $clientToInsert['country'] = isset($clientAdress->countryname) ? $clientAdress->countryname : null;
                    $clientToInsert['adresse'] = isset($clientAdress->part1) ? $clientAdress->part1 : null;
                    $clientToInsert['adresse_2'] = isset($clientAdress->part2) ? $clientAdress->part2 : null;
                    $clientToInsert['siren'] = isset($client->corporation->siren) ? $client->corporation->siren : null;
                    $clientToInsert['siret'] = isset($client->corporation->siret) ? $client->corporation->siret : null;
                    $clientToInsert['id_in_sellsy'] =  isset($client->client->id) ? intval($client->client->id) : null;
                    $clientToInsert['delete_in_sellsy'] = false;
                    $clientToInsert['client_type'] = isset($client->client->type) ? $client->client->type : null;
                    $clientToInsert["client_contacts"]  = array();
                    //debug($clientContact);die;
                    //echo json_encode($clientToInsert);die;

                    if(isset($client->contacts)){
                            $listeContact = array();
                           
                            foreach($client->contacts as $key => $contact){
                                $oneContact = array();
                                $oneContact["nom"] = $contact->name;
                                $oneContact["prenom"] = $contact->forename;
                                $oneContact["position"] = $contact->position;
                                $oneContact["email"] = $contact->email;
                                $oneContact["tel"] = $contact->tel;
                                $oneContact["mobile"] = $contact->mobile;
                                $oneContact["civilite"] = $contact->civil;
                                $idInSellsy = $contact->id;
                                $oneContact["id_in_sellsy"] = $contact->id; //$key;
                                $oneContact["deleted_in_sellsy"] = false;
                                $oneContact['is_by_webhooks'] = true;

                                $this->loadModel('ClientContacts');
                                $contactFind = $this->ClientContacts->find('all')->where(["id_in_sellsy" => intval($key)])->first();
                                if($contactFind){
                                    $oneContact["id"] = $contactFind->id;
                                }
                                //debug($oneContact);
                                array_push($listeContact, $oneContact);
                            }
                            $clientToInsert["client_contacts"] = $listeContact;
                    }
                    //debug($clientToInsert);die;

                    $clientToInsert['is_by_webhooks'] = true;

                    $cli = $this->Clients->newEntity();
                    $clientFind = $this->Clients->find()->where(["id_in_sellsy" => intval($client->client->id)])->contain(['ClientContacts'])->first();
                    if ($clientFind) {
                         $clientToInsert['id'] = $clientFind->id;
                        $cli = $clientFind;
                    }

                    $cli = $this->Clients->patchEntity($cli, $clientToInsert, ['validate' => false, ['associated' => ['ClientContacts']]]);
                    if($this->Clients->save($cli)){
                        $res ['success'] = true;
                        echo json_encode($res);
                        //return  $this->response->withStatus(200);
                    }
                }
            }

             //=== Contact
            if($objet == "people"){
                //debug($datas);die;
                $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
                $request = array(
                    'method' => 'Peoples.getOne',
                    'params' => array(
                        //'id' => $contact_id
                        'thirdcontactid'    => $objet_id,
                    ),
                );
                $contact = $this->sellsyCurlComponent->requestApi($request)->response;
                //debug($contact);die;

                $this->loadModel('ClientContacts');
                if($event == "deleted") {
                    $contactFind = $this->ClientContacts->find('all')->where(["id_in_sellsy" => intval($objet_id)])->first();
                    //debug($contactFind);die;
                    if ($contactFind) {
                        $contactFind->deleted_in_sellsy = true;
                        $contactFind->deleted_by_webhooks = true;
                        if($this->ClientContacts->save($contactFind)){
                            $res ['success'] = true;
                            echo json_encode($res);
                            //return  $this->response->withStatus(200);
                        }
                    }
                }

                if($event == "created" || $event == "updated") {

                    $oneContact["nom"] = $contact->name;
                    $oneContact["prenom"] = $contact->forename;
                    $oneContact["position"] = $contact->position;
                    $oneContact["email"] = $contact->email;
                    $oneContact["tel"] = $contact->tel;
                    $oneContact["mobile"] = $contact->mobile;
                    $oneContact["civilite"] = $contact->civil;
                    $idInSellsy = $contact->id;
                    $oneContact["id_in_sellsy"] = $contact->linkedid;
                    $oneContact["deleted_in_sellsy"] = false;
                    $oneContact['is_by_webhooks'] = true;

                    $contact = $this->ClientContacts->newEntity();
                    $contactFind = $this->ClientContacts->find('all')->where(["id_in_sellsy" => intval($contact->linkedid)])->first();
                    if ($contactFind) {
                        $oneContact["id"] = $contactFind->id;
                        $contact = $contactFind;
                    }

                    $contact = $this->ClientContacts->patchEntity($contact, $oneContact, ['validate' => false]);
                    if($this->ClientContacts->save($contact)){
                        $res ['success'] = true;
                        echo json_encode($res);
                        //return  $this->response->withStatus(200);
                    }
                }
            }

            //============ REturn
            if ($res ['success'] === false) {
                Log::warning('Problème de save ', ['scope' => ['webhooks_sellsy']]);
                return  $this->response->withStatus(500);
                //echo json_encode($res);
            }else{
                return  $this->response->withStatus(200);
                //echo json_encode($res);
            }

            /*$email_msg = new Email('default');
            $email_msg->setFrom(['contact@konitys.fr' => 'Test webhook sellsy'])
                ->setSubject('Test Webhook CRM')
                ->setTo('celest1.pr@gmail.com');
            if ($email_msg->send(json_encode($datas['notif']))) {
                echo 'sent';die;
            }*/
        }
        return  $this->response->withStatus(200);
    }

    //======= SEND UPDATE DATA FROM WEBHOOKS
    //======================================
    public function sendDocumentFromWebhooks() {

        $this->loadModel('Documents');
        $docs = $this->Documents->find('all')->where([/*'is_by_webhooks' => true,*/ 'is_posted_on_event' => false]);
        
        foreach ($docs as $key => $doc) {
            # code...
            $data = [];
            $data ['document'] = $doc->toArray();
            unset($data['document']['id']);
            //debug($data);die;

            $url = 'https://manager.selfizee.fr/evenements/saveDocumentFromWebhooks';
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
            debug($res);
            if(!empty($res)){
                if($res->success){
                    $doc->is_posted_on_event = true;
                    if($this->Documents->save($doc)){
                        $this->out('Document posted '.$doc->id);
                    }
                }
            }
        }
    }

    public function sendClientFromWebhooks() {

        $this->loadModel('Clients');
        $clients = $this->Clients->find('all')->where([/*'is_by_webhooks' => true,*/ 'is_posted_on_event' => false]);
        $this->autoRender = false;
        $res = null;
        foreach ($clients as $key => $client) {
            # code...
            $data = [];
            $data ['client'] = $client->toArray();
            unset($data['client']['id']);
            //debug($data);die;

            $url = 'http://localhost/event-selfizee-v2/evenements/saveClientFromWebhooks';
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
            //var_dump($result);
            debug($res);
            if(!empty($res)){
                if($res->success){
                    $client->is_posted_on_event = true;
                    if($this->Clients->save($client)){
                        $this->out('Client posted '.$client->id);
                    }
                }
            }
            //debug($res->success);die;
        }

        echo $res;
    }

    public function sendContactFromWebhooks() {

        $this->loadModel('ClientContacts');
        $contacts = $this->ClientContacts->find('all')->where([/*'is_by_webhooks' => true,*/ 'is_posted_on_event' => false]);
        
        foreach ($contacts as $key => $contact) {
            # code...
            $data = [];
            $data ['contact'] = $contact->toArray();
            unset($data['contact']['id']);
            //debug($data);die;

            $url = 'https://manager.selfizee.fr/evenements/saveContactFromWebhooks';
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
            debug($res);
            if(!empty($res)){
                if($res->success){
                    $contact->is_posted_on_event = true;
                    if($this->Contacts->save($contact)){
                        $this->out('Contact posted '.$contact->id);
                    }
                }
            }
        }
    }

}
