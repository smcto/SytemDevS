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
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\SellsyCurlComponent;
use Cake\I18n\Date;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Routing\Router;
use App\Traits\AppTrait;
use DateTime;

/**
 * Simple console wrapper around Psy\Shell.
 */
class SellsyShell extends Shell
{
    use AppTrait;

    public function synchroTable($table)
    {
        $this->loadModel($table);
        $this->loadModel('Clients');
        $devis = $this->{$table}->find()->contain(['Clients'])->notMatching('Clients')->select(['client_id', 'sellsy_client_id', 'id'])->order([$table.'.id' => 'DESC']);
        $validator = @$this->Clients->ClientContacts->validator('default');
        $validator->remove('email');

        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());

        foreach ($devis as $key => $devi) {
            $devis_id = $devi->id;
            $clientToInsert = $this->getClient($devi->sellsy_client_id, 'Client');
            if (!empty($clientToInsert)) {
                $clientEntity = $this->saveClient($clientToInsert, $devis_id, $table);
                $this->out('new client id:'.$clientEntity->id.', nom: '.$clientEntity->get('FullName').', type : client, devis_id: '.$clientEntity->devis_id);
            } else {
                $clientToInsert = $this->getClient($devi->sellsy_client_id, 'Prospects');
                if (!empty($clientToInsert)) {
                    $clientEntity = $this->saveClient($clientToInsert, $devis_id, $table);
                    $this->out('prospect id:'.$clientEntity->id.', nom: '.$clientEntity->get('FullName').', type : prospects, devis_id: '.$clientEntity->devis_id);
                }
                else {
                    $this->out('vide');
                }
            }
        }

        $this->out('fin');
    }


    public function saveClient($clientToInsert, $devis_id, $table)
    {
        $clientEntity = $this->Clients->newEntity($clientToInsert, ['validate' => false]);
        if (!$clientEntity->getErrors()) {
            if ($clientEntity = $this->Clients->save($clientEntity)) {
                $this->{$table}->updateAll(['client_id' => $clientEntity->id], ['id' => $devis_id]);
                $clientEntity->devis_id = $devis_id;
                return $clientEntity;
            } else {
                debug($clientEntity);
                die();
            }

        } else {
            debug($clientEntity->getErrors());
            die;
        }
    }


    /**
     * Rempli les infos dans base paiements non récupératble lors du sellsy document invoice
     * @param  integer $year [description]
     * @return [type]        [description]
     */
    public function synchroReglement($year = 2018)
    {
        $this->out('Lancement...');
        
        $this->loadModel('Clients');
        $this->loadModel('Reglements');


        if ($year == null) {
            $interval = [];
        } else {
            $interval = [
                'periodecreated_start'  => \DateTime::createFromFormat('Y', $year-1)->getTimestamp(),
                'periodecreated_end'  => \DateTime::createFromFormat('Y', $year)->getTimestamp(),
            ];
        }

        $requestClientPagination = array(
            'method' => 'Payments.getList',
            'params' => [
                'search' => $interval
            ]
        );
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $reponseClientPagination = $this->sellsyCurlComponent->requestApi($requestClientPagination);
        debug($reponseClientPagination);
        die();

        $this->out('Connexion api ...');

        $validator = @$this->Clients->ClientContacts->validator('default');
        $validator->remove('email');
        
        if($reponseClientPagination->status == "success"){
            $response = $reponseClientPagination->response;
            $infos = isset($response->infos) ? $response->infos : null;
            $nbrPage = isset($infos->nbpages) ? $infos->nbpages : 0;
            for ($i = 1; $i <= $nbrPage; $i++) {
                $requestClient = array(
                    'method' => 'Payments.getList',
                    'params' => array(
                        'search' => $interval,
                        'pagination' => array(
                            'pagenum' => $i,
                            'nbperpage' => 100
                        ))
                );
                $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
                $reponseClient = $this->sellsyCurlComponent->requestApi($requestClient);
                $theReponse = @$reponseClient->response;

                if ($theReponse) {
                    $reglements = isset($theReponse->result) ? $theReponse->result : null;
                    $sousInfos = $theReponse->infos;
                    // debug($clients);
                    $progress = round($sousInfos->pagenum/$sousInfos->nbpages*100, 2).'%';
                    //debug($_clients_result);
                    
                    if (!empty($reglements)) { 
                        foreach ($reglements as $idSellsy => $reglement) {
                            
                            
                            $reglementToInsert['full_data'] = serialize(get_object_vars($reglement));
                            $reglementToInsert['sellsy_client_id'] = @$reglement->linkedtype == 'third' ? $reglement->linkedid : null;
                            $reglementToInsert['montant'] = $reglement->amount ?? null;
                            $reglementToInsert['montant_restant'] = $reglement->amountRemaining ?? null;
                            $reglementToInsert['sellsy_status'] = $reglement->step ?? null;
                            $clientEntity = $this->Clients->findByIdInSellsy($reglementToInsert['sellsy_client_id'])->first();
                            $reglementToInsert['client_id'] = $clientEntity->step ?? null;
                            $reglementToInsert['date'] = date('Y-m-d', $reglement->date);
                            // debug($reglement);
                            // die();

                            $reglementEntity = $this->Reglements->findBySellsyPayId($reglement->id)->first();             

                            // debug($reglementToInsert);
                            // debug($reglementEntity);
                            // die();
                            if ($reglementEntity) {
                                $docEntity = $this->{$table}->patchEntity($reglementEntity, $reglementToInsert, ['validate' => false]);
                                $docEntity = $this->{$table}->save($docEntity);
                                $this->out($docEntity->indent.'('.$item->ident.'), patch sellsy_id: '.$docEntity->sellsy_doc_id.', progress: '.$progress.', date: '.$docEntity->created->format('d/m/Y').', status: '.$item->step);
                                // $this->out('cat_tarif: '.$item->rateCategoryFormated);
                            } /*else {
                                unset($reglementToInsert['id']);
                                $docEntity = $this->{$table}->newEntity($reglementToInsert, ['validate' => false]);
                                $this->out($docEntity->indent.'('.$item->ident.'), new sellsy_id: '.$docEntity->sellsy_doc_id.', client_nom: '.$item->thirdname.', date_crea: '.$item->created.', created: '.$item->created.', echeance_date: '.$item->payDateCustom.', status: '.$item->step.', status_entity: '.$docEntity->status);
                                // $this->out($docEntity->indent.'('.$item->ident.'), new sellsy_id: '.$docEntity->sellsy_doc_id.', progress: '.$progress.', date: '.$docEntity->created->format('d/m/Y').', status: '.$item->step.', cat_tarif: '.$item->rateCategoryFormated);
                                $docEntity = $this->{$table}->save($docEntity);
                            }*/

                        }

                        die();
                        
                    }
                }

                // sleep(2);
                // return true;
            }
        }
            
    }
    /**
     * Synchro client ou prospect
     * @param  string $type Client|Prospects
     * @return [type]       [description]
     */
    public function client($type = 'Client', $year = null)
    {
        $this->out('Lancement...');
        
        $this->loadModel('Clients');
        $this->loadModel('ClientContacts');

        $type = ucfirst($type);

        if ($year == null) {
            $interval = [];
        } else {
            $interval = [
                'periodecreated_start'  => \DateTime::createFromFormat('Y', $year-1)->getTimestamp(),
                'periodecreated_end'  => \DateTime::createFromFormat('Y', $year)->getTimestamp(),
            ];
        }

        $requestClientPagination = array(
            'method' => $type.'.getList',
            'params' => [
                'search' => $interval
            ]
        );
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $reponseClientPagination = $this->sellsyCurlComponent->requestApi($requestClientPagination);

        $this->out('Connexion api ...');

        $validator = @$this->Clients->ClientContacts->validator('default');
        $validator->remove('email');
 
        if($reponseClientPagination->status == "success"){
            $response = $reponseClientPagination->response;
            $infos = isset($response->infos) ? $response->infos : null;
            $nbrPage = isset($infos->nbpages) ? $infos->nbpages : 0;
            for ($i = 1; $i <= $nbrPage; $i++) {
                $requestClient = array(
                    'method' => $type.'.getList',
                    'params' => array(
                        'search' => $interval,
                        'pagination' => array(
                            'pagenum' => $i,
                            'nbperpage' => 100
                        ))
                );
                $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
                $reponseClient = $this->sellsyCurlComponent->requestApi($requestClient);
                $theReponse = @$reponseClient->response;

                if ($theReponse) {
                    $clients = isset($theReponse->result) ? $theReponse->result : null;
                    $sousInfos = $theReponse->infos;
                    // debug($clients);
                    $progress = round($sousInfos->pagenum/$sousInfos->nbpages*100, 2).'%';
                    //debug($_clients_result);
                    
                    if (!empty($clients)) { 
                        foreach ($clients as $idSellsy => $client) {
                            
                            $clientContacts = isset($client->contacts) ? $client->contacts : null;
                            $clientContacts = $clientContacts != null ? json_decode(json_encode($clientContacts), true) : null;
                            $clientContacts = is_array($clientContacts) ? array_values($clientContacts) : null;
                            $clientContact = $clientContacts != null && isset($clientContacts[0]) ? (object)$clientContacts[0] : null;
                            
                           
                            $clientToInsert['nom'] = isset($client->name) ? $client->name : null;
                            $clientToInsert['prenom'] = isset($clientContact->forename) ? $clientContact->forename : null;
                            //$clientToInsert['url_img_profil'] = isset($clientContact->pic) ? $clientContact->pic : null;
                            $clientToInsert['cp'] = isset($client->addr_zip) ? intval($client->addr_zip) : null;
                            $clientToInsert['email'] = isset($clientContact->email) ? $clientContact->email : null;
                            $clientToInsert['ville'] = isset($client->addr_town) ? $client->addr_town : null;
                            $clientToInsert['telephone'] = isset($clientContact->tel) ? $clientContact->tel : null;
                            $clientToInsert['mobile'] = isset($clientContact->mobile) ? $clientContact->mobile : null;
                            $clientToInsert['country'] = isset($client->addr_countryname) ? $client->addr_countryname : null;
                            $clientToInsert['adresse'] = isset($client->addr_part1) ? $client->addr_part1 : null;
                            $clientToInsert['adresse_2'] = isset($client->addr_part2) ? $client->addr_part2 : null;
                            $clientToInsert['addr_lat'] = isset($client->addr_lat) ? $client->addr_lat : null;
                            $clientToInsert['addr_lng'] = isset($client->addr_lng) ? $client->addr_lng : null;
                            $clientToInsert['siren'] = isset($client->siren) ? $client->siren : null;
                            $clientToInsert['siret'] = isset($client->siret) ? $client->siret : null;
                            $clientToInsert['id_in_sellsy'] = intval($idSellsy);
                            $clientToInsert['delete_in_sellsy'] = false; //si sellsy retourne le client, c'est � dire que cen'est pas encore supprimer depuis sellsy'''
                            $clientToInsert['client_type'] = $client->type;
                            $clientToInsert['type_commercial'] = $client->relationType;
                            $clientToInsert["client_contacts"]  = array();
                            $clientToInsert["created"]  = $client->joindate;
                            
                            // if ($client->relationType == 'prospect') {
                            //     pr($client);
                            //     die();
                            // }
                            // debug($idSellsy);
                            // debug($client);
                            debug($client->contacts);
                            die;
                            //contact user
                            if(isset($client->contacts)){
                                $listeContact = array();
                               
                                foreach($client->contacts as $key => $contact){
                                    // pr($contact);
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
                                    $contactFind = $this->ClientContacts->find('all')->where(["id_in_sellsy" => intval($key)])->first();
                                    if($contactFind){
                                        $oneContact["id"] = $contactFind->id;
                                    }
                                    //debug($oneContact);
                                    array_push($listeContact, $oneContact);
                                }
                                $clientToInsert["client_contacts"] = $listeContact;
                            }

                            // debug($clientToInsert);die;
                            // pr($client);die;
                            
                            $clientEntity= $this->Clients->findByIdInSellsy(intval($idSellsy))->contain(['ClientContacts'])->first();
                            $full_name = trim($clientToInsert['nom']) && trim($clientToInsert['prenom']);
                            if($clientEntity !== null){
                                // $clientToInsert['id'] = $clientEntity->id;
                                // $clientEntity = $this->Clients->patchEntity($clientEntity, $clientToInsert, ['validate' => false], ['associated' => ['ClientContacts']] );
                                $this->out('Patch: '.$clientEntity->id_in_sellsy.', progress: '.$progress.', date: '.$clientEntity->created->format('d/m/Y'));
                            } else {
                                unset($clientToInsert['id']);
                                $clientEntity = $this->Clients->newEntity($clientToInsert, ['validate' => false]);
                                $date = $clientEntity->created->format('d/m/Y');
                                if ($full_name != "") {
                                    $mode = $clientEntity->isNew() ? 'new' : 'patch';
                                    if ($clientEntity = $this->Clients->save($clientEntity)) {
                                        $this->out($type.' id: '.$clientEntity->id.', name: '.$clientEntity->nom.', id_in_sellsy: '.$clientEntity->id_in_sellsy.', mode: '.$mode.', progress: '.$progress.', date: '.$date);
                                    }else{
                                        debug($clientEntity);
                                        pr($clientToInsert); die;
                                        $this->logginto($clientToInsert, 'sellsy_data'); die;
                                    }
                                } else {
                                    $this->out('Empty: '.$clientEntity->id_in_sellsy.', progress: '.$progress.', date: '.$date);
                                }
                            }

                        }
                        
                    }
                }

                // sleep(2);
                // return true;
            }
            
        }
        

        $this->out('fin.');
        return true;
    }

    function logginto($string, $file, $mode = 'erase') {
        $filename = ROOT.DS.'logs'.DS.$file.'.log'; 
        new File($file, true, 0777);
        if ($mode != 'erase') {
            file_put_contents($filename, "");
        }
        $fp = fopen($filename,"a+");  
        fwrite($fp,  date('Y-m-d H:i:s', time()). ' '. print_r($string, true)."\n"); 
        fclose($fp);
    }

    /**
     * Start the shell and interactive console.
     *
     * @return int|null
     */
    
    public function importPdf($type = 'invoice', $year = 2020){ // OR Estimate
    
        $this->loadModel('Documents');
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());

        if ($year == null) {
            $interval = [];
        } else {
            $interval = [
                'periodecreated_start'  => \DateTime::createFromFormat('Y', $year-1)->getTimestamp(),
                'periodecreated_end'  => \DateTime::createFromFormat('Y', $year)->getTimestamp(),
            ];
        }
        $request = array(
            'method' => 'Document.getList',
            'params' => array(
                'search' => $interval,
                'doctype' => $type
            )
        );

        if($type == 'invoice'){
            //$request['params']['search']['steps'] = array('');
        }else{ //estimate
            //$request['params']['search']['steps'] = array('accepted','invoiced');
        }
        
        $documents = $this->sellsyCurlComponent->requestApi($request);
        
        $nbrPageResponses = $documents->response;
        $infos = isset($nbrPageResponses->infos) ? $nbrPageResponses->infos : null;
        $nbrPage = isset($infos->nbpages) ? $infos->nbpages : 0;
        
        //Mettre � jour tous les clients. Marquer suprimer depuis sellsy
        if(!empty($nbrPageResponses)){
            $this->Documents->updateAll(
            ['deleted_in_sellsy' => true],
            ['id >'=>0]);
        }
        
        
        $this->out('Lancement...');
        for ($i = 1; $i <= $nbrPage; $i++) {
            $requestDoc = array(
                'method' => 'Document.getList',
                'params' => array(
                    'doctype' => $type,
                    'pagination' => array(
                        'pagenum' => $i,
                        'nbperpage' => 100
                    )
                )
            );
            if($type == 'invoice'){
                //$requestDoc['params']['search']['steps'] = array('');
            }else{ //estimate
                // $requestDoc['params']['search']['steps'] = array('accepted','invoiced');
            }
        
            $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
            $documents = $this->sellsyCurlComponent->requestApi($requestDoc);
           /* debug($documents);
            die;*/
            if(!empty($documents)){
                 
                $documentsResponses = $documents->response;
                $documentsResult = isset($documentsResponses->result) ? $documentsResponses->result : null;
                
                //debug($documentsResponses); die;
                
                if ($documentsResult != null) {
                    foreach ($documentsResult as $idSellsy => $item) {
                        $documentsInsert['objet'] = isset($item->subject) ? $item->subject : null;
                        $documentsInsert['date'] = isset($item->displayedDate) ? $item->displayedDate : null;
                        $documentsInsert['montant_ttc'] = isset($item->totalAmount) ? floatval($item->totalAmount) : null;
                        $documentsInsert['montant_ht'] = $item->totalAmountTaxesFree;
                        $documentsInsert['id_in_sellsy'] = $idSellsy;
                        $documentsInsert['deleted_in_sellsy'] = false;
                        $documentsInsert['type_document'] = $type;
                        $documentsInsert['step'] = isset($item->step) ? $item->step : null;
                        $documentsInsert['ident'] = $item->ident;

                        

                        //debug($idSellsy ." => ".$item->ident);
                         //get public link
                        $requestLink = array(
                                'method' => 'Document.getPublicLink',
                                'params' => array(
                                    'doctype' => $type,
                                    'docid' => $idSellsy,
                                )
                        );
                        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
                        $link = $this->sellsyCurlComponent->requestApi($requestLink);
                        //debug($link);
                        $linkReponse = "";
                        if($link){
                           $linkReponse = $link->response; 
                        }
                        
                        //debug($linkReponse);
                        $pdfUrl = $documentsInsert['url_sellsy'] = "https://www.sellsy.fr/".$linkReponse;
                        $pdfName = strtok($item->filename, '_').'.pdf';
                        $pdfUploadPath = WWW_ROOT.'uploads/devis/'.$pdfName;

                        if ($type == 'invoice') {
                            $pdfUploadPath = WWW_ROOT.'uploads/factures_vente/'.$pdfName;
                        } 

                        // debug($pdfUploadPath);
                        // die();
                        if (!file_exists($pdfUploadPath)) {
                            $file = new File($pdfUploadPath, true, 0755);
                            $response = $file->write(file_get_contents($pdfUrl));
                            if ($response == true) {
                                $this->out('Fichier importé : '.$pdfName);
                                $this->logginto('Fichier importé : '.$pdfName, 'sellsy_devis');
                            }
                        } else {
                            $this->out('fichier: '.$pdfName.' déjà importé');
                            $this->logginto('fichier: '.$pdfName.' déjà importé', 'sellsy_devis');
                        }
                    }
                    
                }
            }

            
        }
        $this->out('Fin');
    }
    
    /**
     * Le type de document : invoice ou estimate ou proforma ou delivery ou order ou mode
     * @param  string $type [description]
     * @return [type]       [description]
     */
    public function document( $type = 'invoice', $year = null, $mode = 'avec_reglements'){ // OR Estimate
    	$this->out('Lancement...');
        $table = 'Devis';

        if ($year == null) {
            $interval = [];
        } else {
            $interval = [
                'periodecreated_start'  => \DateTime::createFromFormat('Y', $year-1)->getTimestamp(),
                'periodecreated_end'  => \DateTime::createFromFormat('Y', $year)->getTimestamp(),
            ];
        }

        if ($type == 'invoice') {
            $table = 'DevisFactures';
            $this->loadModel('ReglementsHasDevisFactures');
        }
        elseif ($type == 'estimate') {
            $table = 'Devis';
        }

        $this->loadModel($table);
        // debug($type);
        // debug();
        // die();
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());

        $request = array(
            'method' => 'Document.getList',
            'params' => array(
                'search' => $interval,
                'doctype' => $type
            )
        );
        if ($type == 'invoice') {
            // $filter = $request['params']['search']['steps'] = ['payinprogress', 'paid', 'late'];
        }

        $documents = $this->sellsyCurlComponent->requestApi($request);
        
        $nbrPageResponses = $documents->response;
        $infos = isset($nbrPageResponses->infos) ? $nbrPageResponses->infos : null;
        $nbrPage = isset($infos->nbpages) ? $infos->nbpages : 0;
        
        
        $this->out('Connexion api ...');
    	for ($i = 1; $i <= $nbrPage; $i++) {
    		$requestDoc = array(
    			'method' => 'Document.getList',
    			'params' => array(
                    'search' => $interval,
    				'doctype' => $type,
    				'pagination' => array(
    					'pagenum' => $i,
    					'nbperpage' => 100
    				)
    			)
    		);
            if ($type == 'invoice') {
                // $requestDoc['params']['search']['steps'] = $filter;
            }
            // debug($requestDoc);
            // die();
            
    		$this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
    		$documents = $this->sellsyCurlComponent->requestApi($requestDoc);

        
    	   /* debug($documents);
    		die;*/
    		if(!empty($documents)){
	
				$documentsResponses = $documents->response;
				$documentsResult = isset($documentsResponses->result) ? $documentsResponses->result : null;
                $sousInfos = $documentsResponses->infos;
                $progress = round($sousInfos->pagenum/$sousInfos->nbpages*100, 2).'%';
				
				//debug($documentsResponses); die;
				
				if ($documentsResult != null) {
                    $documentsInsert = [];
					foreach ($documentsResult as $idSellsy => $item) {
                        // debug($item);
                        // die();

                        $commercialEntity = $this->findLikeCommercial($item->docspeakerStaffFullName);
                        $clientEntity = $this->Devis->Clients->findByIdInSellsy($item->thirdid ?? null)->first();

                        $documentsInsert['indent'] = $item->ident ?? null;
                        $documentsInsert['objet'] = $item->object ?? null;
                        $documentsInsert['nom_societe'] = 'KONITYS';
                        $documentsInsert['date_crea'] = $item->created ?? null;
                        $documentsInsert['created'] = $item->created ?? null;
                        $documentsInsert['total_ht'] = $item->totalAmountTaxesFree ?? null;
                        $documentsInsert['total_ttc'] = $item->totalAmount ?? null;
                        $documentsInsert['total_remise'] = $item->discountAmount ?? null;
                        $documentsInsert['date_validite'] = $item->expireDate ?? null;
                        $documentsInsert['total_tva'] = $item->taxesAmountSum ?? null;
                        $documentsInsert['ref_commercial_id'] = $commercialEntity->id ?? null;
                        $documentsInsert['client_id'] = $clientEntity->id ?? null;
                        $documentsInsert['sellsy_client_id'] = $item->thirdid ?? null;
                        $documentsInsert['client_nom'] = $item->thirdname ?? null;
                        $documentsInsert['client_email'] = $item->thirdemail ?? null;
                        $documentsInsert['client_tel'] = $item->thirdtel ?? null;
                        $documentsInsert['echeance_date'] = $item->payDateCustom ?? null;
                        $documentsInsert['sellsy_doc_id'] = $item->docid ?? null;
                        $documentsInsert['categorie_tarifaire'] = $this->getCatTarifaire($item->rateCategoryFormated ?? null);
                        $documentsInsert['status'] = $this->buildSellsyStatus($item->step, $type);
                        $documentsInsert['is_in_sellsy'] = true;

                        if ($type == 'invoice') {
                            $documentsInsert['sellsy_estimate_id'] =  $item->parentid;
                            if ($mode == 'avec_reglements') {
                                $documentsInsert['reglements'] = $this->getPaymentsFactures($idSellsy, $clientEntity);
                            }
                        }

                        if (@$item->hasDeadlines == 'Y') {
                            $documentsInsert['sellsy_echeances'] = $item->deadlines_json;
                        }

						//get public link
						$requestLink = array(
								'method' => 'Document.getPublicLink',
								'params' => array(
									'doctype' => $type,
									'docid' => $idSellsy,
								)
						);
						$this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
						$link = $this->sellsyCurlComponent->requestApi($requestLink);
                        $linkReponse = "";
                        if($link){
                           $linkReponse = $link->response; 
                        }

                        $documentsInsert['sellsy_public_url'] = "https://www.sellsy.fr/".$linkReponse;
                        // debug($item);
                        // debug($documentsInsert);
                        // die();

                        $document = $this->{$table}->findBySellsyDocId($item->docid);
                        if ($type == 'invoice') {
                            $document->contain(['Reglements']);
                        }
                        $document = $document->first();       

                        if ($document) {
                            $docEntity = $this->{$table}->patchEntity($document, $documentsInsert, ['validate' => false, 'associated' => 'Reglements']);
                            // debug($docEntity);
                            // die();
                            $docEntity = $this->{$table}->save($docEntity);
                            $this->insertReglemensDevisFactureRelation($docEntity);
                            $this->out($docEntity->indent.'('.$item->ident.'), patch sellsy_id: '.$docEntity->sellsy_doc_id.', progress: '.$progress.', date: '.$docEntity->created->format('d/m/Y').', status: '.$item->step);
                            // $this->out('cat_tarif: '.$item->rateCategoryFormated);
                        } else {
                            unset($documentsInsert['id']);
                            $docEntity = $this->{$table}->newEntity($documentsInsert, ['validate' => false]);
                            $this->out($docEntity->indent.'('.$item->ident.'), new sellsy_id: '.$docEntity->sellsy_doc_id.', progress: '.$progress.', client_nom: '.$item->thirdname.', date_crea: '.$item->created.', created: '.$item->created.', echeance_date: '.$item->payDateCustom.', status: '.$item->step.', status_entity: '.$docEntity->status);
                            // $this->out($docEntity->indent.'('.$item->ident.'), new sellsy_id: '.$docEntity->sellsy_doc_id.', progress: '.$progress.', date: '.$docEntity->created->format('d/m/Y').', status: '.$item->step.', cat_tarif: '.$item->rateCategoryFormated);
                            $docEntity = $this->{$table}->save($docEntity);
                            $this->insertReglemensDevisFactureRelation($docEntity);
                            // debug($docEntity);
                        }
                        
					}
					
				}
    		}

            // return true;
            
        }
        
        $this->out('Fin');
        return true;

    }

    public function getPaymentsFactures($doc_id, $clientEntity)
    {
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Document.getOne',
            'params' => array(
                'doctype' => 'invoice',
                'docid'     => $doc_id
            )
        );
        $doc = @$this->sellsyCurlComponent->requestApi($request)->response;

        $payments = [];

        if (@$doc->hasRelateds == 'Y') {
            if (@$doc->related->payments) {
                foreach ($doc->related->payments->listing as $key => $payment) {
                    $data = [
                        'type' => $payment->amount_type,
                        'client_id' => $clientEntity->id ?? null,
                        'date' => date('Y-m-d', $payment->date),
                        'montant' => $payment->amount,
                        'sellsy_pay_id' => $payment->payid,
                        'reference' => $payment->payid,
                        'note' => $payment->notes,
                        'sellsy_status' => $payment->step,
                        'sellsy_moyen_reglement' => $payment->mediumTxt,
                        'sellsy_client_name'   => $doc->thirdName,
                        'is_in_sellsy'   => true
                    ];
                    if ($reglement = $this->DevisFactures->Reglements->findBySellsyPayId($payment->payid)->first()) {
                        $data['id'] = $reglement->id;
                    }

                    // debug($payment);
                    // die();

                    $payments[] = $data;
                }
            }
        }


        return $payments;
    }

    // pbm : les paiements n'affichent pas les factures associées, donc récupérer depuis une facture
    public function insertReglemensDevisFactureRelation($docEntity)
    {
        // debug($docEntity);
        if (!empty($docEntity->reglements)) {
            foreach ($docEntity->reglements as $key => $reglement) {
                $data = ['reglements_id' => $reglement->id, 'devis_factures_id' => $docEntity->id];
                if (!$this->ReglementsHasDevisFactures->find()->where($data)->first()) {
                    $reglementsHasDevisFacture = $this->ReglementsHasDevisFactures->newEntity($data, ['validate' => false]);
                    $this->ReglementsHasDevisFactures->save($reglementsHasDevisFacture);
                }
            }
        }
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
        $doc_in_sellsy = $this->sellsyCurlComponent->requestApi($request)->response;
        debug($doc_in_sellsy);die;
        $documentsInsert['objet'] = isset($doc_in_sellsy->subject) ? $doc_in_sellsy->subject : null;
        $documentsInsert['date'] = isset($doc_in_sellsy->displayedDate) ? $doc_in_sellsy->displayedDate : null;
        $documentsInsert['montant_ttc'] = isset($doc_in_sellsy->totalAmount) ? floatval($doc_in_sellsy->totalAmount) : null;
        $documentsInsert['montant_ht'] = $doc_in_sellsy->totalAmountTaxesFree;
        $documentsInsert['id_in_sellsy'] = $doc_in_sellsy->id;
        $documentsInsert['deleted_in_sellsy'] = false;
        $documentsInsert['type_document'] = $doc_in_sellsy->linkedtype;
        $documentsInsert['step'] = isset($doc_in_sellsy->step) ? $doc_in_sellsy->step : null;
        debug($documentsInsert);die;
    }

    public function getDevisSellsy($doc_id){
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Document.getOne',
            'params' => array(
                'doctype' => 'estimate',
                'docid'     => $doc_id
            ),
        );
        $requestDoc['params']['search']['steps'] = array('accepted','invoiced');
        $doc_in_sellsy = $this->sellsyCurlComponent->requestApi($request)->response;
        debug($doc_in_sellsy);die;
        $documentsInsert['objet'] = isset($doc_in_sellsy->subject) ? $doc_in_sellsy->subject : null;
        $documentsInsert['date'] = isset($doc_in_sellsy->displayedDate) ? $doc_in_sellsy->displayedDate : null;
        $documentsInsert['montant_ttc'] = isset($doc_in_sellsy->totalAmount) ? floatval($doc_in_sellsy->totalAmount) : null;
        $documentsInsert['montant_ht'] = $doc_in_sellsy->totalAmountTaxesFree;
        $documentsInsert['id_in_sellsy'] = $doc_in_sellsy->id;
        $documentsInsert['deleted_in_sellsy'] = false;
        $documentsInsert['type_document'] = $doc_in_sellsy->linkedtype;
        $documentsInsert['step'] = isset($doc_in_sellsy->step) ? $doc_in_sellsy->step : null;
        debug($documentsInsert);die;
    }

    public function getProspect($prospect_id)
    {
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Prospects.getOne',
            'params' => array(
                'id'     => $prospect_id
            ),
        );
        $prospect = $this->sellsyCurlComponent->requestApi($request)->response;
        return $prospect;
        // debug($prospect);die;
    }

    public function getDocument($doc_id, $type = 'estimate')
    {
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Document.getOne',
            'params' => array(
                'doctype' => $type,
                'id'     => $doc_id
            ),
        );
        $item = $this->sellsyCurlComponent->requestApi($request)->response;
        // return $item;
        debug($item);die;
    }

    public function getClient($id, $type = 'Client', $debug = 0){
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => $type.'.getOne',
            'params' => array(
                'clientid'     => $id
            ),
        );

        if ($type == 'Client') {
            $request['params']['clientid'] = $id;
        } 
        elseif ($type == 'Prospects') {
            $request['params']['id'] = $id;
        }

        $client = $this->sellsyCurlComponent->requestApi($request)->response;
        // debug($client);
        // die();
        $clientToInsert = [];

        if ($client) {
            if ($client != null) {
                
                $clientContacts = isset($client->contacts) ? $client->contacts : null;
                $clientContacts = $clientContacts != null ? json_decode(json_encode($clientContacts), true) : null;
                $clientContacts = is_array($clientContacts) ? array_values($clientContacts) : null;
                $clientContact = $clientContacts != null && isset($clientContacts[0]) ? (object)$clientContacts[0] : null;


                $clientAdress = isset($client->address[0]) ? $client->address[0] : null;

                $clientToInsert['nom'] = isset($client->client->name) ? $client->client->name : null;
                $clientToInsert['prenom'] = isset($clientContact->forename) ? $clientContact->forename : null;
                //$clientToInsert['url_img_profil'] = isset($clientContact->pic) ? $clientContact->pic : null;
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
                $clientToInsert['id_in_sellsy'] = intval($client->client->id);
                $clientToInsert['delete_in_sellsy'] = false; //si sellsy retourne le client, c'est � dire que cen'est pas encore supprimer depuis sellsy'''
                $clientToInsert['client_type'] = $client->client->type;
                $clientToInsert['type_commercial'] = $client->client->relationType;


                $clientToInsert["client_contacts"]  = array();

                $this->loadModel('ClientContacts');
                if(isset($client->contacts)){
                    $listeContact = array();
                   
                    foreach($client->contacts as $key => $contact){
                        // pr($contact);
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
                        $contactFind = $this->ClientContacts->find()->where(["id_in_sellsy" => intval($key)])->first();
                        if($contactFind){
                            $oneContact["id"] = $contactFind->id;
                        }
                        //debug($oneContact);
                        array_push($listeContact, $oneContact);
                    }
                    $clientToInsert["client_contacts"] = $listeContact;
                }
            }
        }

        if ($debug == 1) {
            debug($clientToInsert);
            die();
        }

        return $clientToInsert;
    }

    public function getContactSellsy($contact_id)
    {
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Peoples.getOne',
            'params' => array(
                //'id' => $contact_id
                'thirdcontactid'    => $contact_id,
            ),
        );
        $contact = $this->sellsyCurlComponent->requestApi($request)->response;
        debug($contact);die;

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
        //debug($oneContact);die;

        $contactFind = $this->ClientContacts->find('all')->where(["id_in_sellsy" => intval($contact->linkedid)])->first();
        if($contactFind){
            $oneContact["id"] = $contactFind->id;
        }

        /*$contactFind = $this->ClientContacts->find('all')->where(["id_in_sellsy" => intval($key)])->first();
        if($contactFind){
            $oneContact["id"] = $contactFind->id;
        }*/
    }

    public function getAllOpp(){
        $this->loadModel('Pipelines');
        $this->loadModel('Opportunites');
        $pipelines = $this->Pipelines->find('all')->order('rand()');
                                    //->order(['Pipelines.id'=>'desc']);
        foreach($pipelines as $pipeline){
                $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
                $request = array( 
                    'method' => 'Opportunities.getList', 
                    'params' => array(
                        /*'pagination' => array(
                            'pagenum'   => $page,
                            'nbperpage' => 10
                        ),*/
                        'search' => array(
                            'funnelid'      => $pipeline->id_in_sellsy,
                        )
                    )
                );
                $info = $this->sellsyCurlComponent->requestApi($request)->response->infos;
                //debug($info); die;
                for($page = 1 ; $page < $info->nbpages; $page++){
                    $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
                    $request = array( 
                        'method' => 'Opportunities.getList', 
                        'params' => array(
                            'pagination' => array(
                                'pagenum'   => $page,
                                'nbperpage' => 10
                            ),
                            'search' => array(
                                'funnelid'      => $pipeline->id_in_sellsy,
                            )
                        )
                    );

                    $contacts = $this->sellsyCurlComponent->requestApi($request)->response->result;
                    //debug($contacts); die;
                    foreach($contacts as $contact){
                        //debug($contact); die;
                        if($contact->id){
                            $inBase = $this->Opportunites->find()
                                                ->where(['id_in_sellsy' => $contact->id])
                                                ->first();
                            if(empty($inBase)){
                                $this->getOpportinuteSellsy($contact->id);
                            }else{
                                if(empty($inBase->client_id) || empty($inBase->client_id_in_sellsy)){
                                    $this->getOpportinuteSellsy($contact->id);
                                }
                            }
                        }
                    }
                }
        }

    }

    public function getOpportinuteSellsy($id)
    {
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Opportunities.getOne',
            'params' => array(
                'id' => $id
            ),
        );
        $res = $this->sellsyCurlComponent->requestApi($request);
        if(!empty($res)){
            $contact = $res->response;
            if($contact->id){       
                $this->loadModel('Opportunites');
                $opportunite = $this->Opportunites->newEntity();
                $inBase = $this->Opportunites->find()
                                                ->contain(['LinkedDocs','Staffs'])
                                                ->where(['id_in_sellsy' => $contact->id])
                                                ->first();
                if(!empty($inBase)){
                    $opportunite = $inBase;
                }
                    $data['id_in_sellsy'] = $contact->id;
                    $data['numero'] = $contact->ident;
                    $data['nom'] = $contact->name;
                    $data['montant_potentiel'] = $contact->potential;
                    //$data['date_echeance'] = $contact->
                    $data['pipeline_id'] = $contact->funnelid;
                    $data['pipeline_etape_id'] = $contact->stepid;
                    $data['probabilite'] = $contact->proba;
                    $data['brief'] = $contact->brief;
                    $data['opportunite_statut_id'] = $this->getStatutId($contact->statusLabel);
                    $data['created'] = $contact->created;
                    //Custom field
                    if(!empty($contact->customFields)){
                        foreach($contact->customFields as $fields){

                            foreach($fields->list as $field){

                                if($field->id == 50097){
                                    if(!empty($field->formatted_value)){
                                        if($field->formatted_value == 'Particulier'){
                                            $data['type_client_id'] = 3;
                                        }elseif($field->formatted_value == 'Professionnel'){
                                            $data['type_client_id'] = 2;
                                        }else{
                                            $data['type_client_id'] = 1;
                                        }
                                    }
                                }elseif($field->id == 50483){
                                    if(!empty($field->formatted_value)){
                                        $data['source_lead_id'] = $this->getIdSourceLead($field->formatted_value);
                                    }
                                }elseif($field->id == 50484){
                                    if(!empty($field->formatted_value)){
                                        $data['contact_raison_id'] = $this->getIdContactRaison($field->formatted_value);
                                    }
                                }elseif($field->id == 50482){
                                    if(!empty($field->formatted_value)){
                                        $data['type_evenement_id'] = $this->getIdTypeEvenement($field->formatted_value);
                                    }
                                }elseif($field->id == 50402){
                                    $data['type_demande'] = !empty($field->formatted_value) ? $field->formatted_value : '';
                                }elseif($field->id == 71018){
                                    $data['antenne_retrait'] = !empty($field->formatted_value) ? $field->formatted_value : '';
                                }elseif($field->id == 71019){
                                    $data['antenne_retrait_secondaire'] = !empty($field->formatted_value) ? $field->formatted_value : '';
                                }
                            }
                        }
                    }

                    //Linked doc
                    $listeDocs = array();
                    if(!empty($contact->linkedDocs)){
                        foreach($contact->linkedDocs as $linkedDoc){
                            $oneDoc = array();
                                $oneDoc['context'] = $linkedDoc->context;
                                $oneDoc['doc_doctype'] = $linkedDoc->doc_doctype;
                                $oneDoc['doc_docid_in_sellsy'] = $linkedDoc->doc_docid;
                                $oneDoc['doc_label'] = $linkedDoc->docLabel;
                                $oneDoc['step_label'] = $linkedDoc->stepLabel;
                                $oneDoc['linkedid_in_sellsy'] = $linkedDoc->linkedid;
                                $oneDoc['ident_in_sellsy'] = $linkedDoc->ident;
                            array_push($listeDocs, $oneDoc);
                        }
                    }
                    $data['linked_docs'] = $listeDocs;

                    //Client ou Prospect
                    if(!empty($contact->thirdDetails->linkedid)){
                        //$this->out('$contact->thirdDetails->linkedid '.$contact->thirdDetails->linkedid);
                        //$this->out('$contact->name '.$contact->thirdDetails->type);

                        $data['client_id'] = $this->getClientId($contact->thirdDetails->linkedid,$contact->relationType);
                        $data['client_id_in_sellsy'] = $contact->thirdDetails->linkedid;
                    }

                    //Staff
                    if(!empty($contact->staffs)){
                        $_idsStaff = array();
                        foreach($contact->staffs as $staff ){
                            $oneStaff= array();
                            $idInBase = $this->getStaffId($staff->id);
                            array_push($_idsStaff, $idInBase);
                        }
                        $data['staffs']['_ids'] = $_idsStaff;
                    }

                $opportunite = $this->Opportunites->patchEntity($opportunite, $data);
                
                if ($this->Opportunites->save($opportunite)) {
                    $this->out('Opportunité saved'.$opportunite->id);
                }else{
                    debug($opportunite); die;
                }
            }
        }
    }


    protected function getStaffIdByFullName($fullName){
        $this->loadModel('Staffs');
        $staff = $this->Staffs->find()
                                ->where(["full_name LIKE"=>$fullName])
                                ->first();
        return $staff->id;
    }

    protected function getStaffId($idInSellsy){
        $this->loadModel('Staffs');
        $staff = $this->Staffs->find()
                                ->where(["id_in_sellsy"=>$idInSellsy])
                                ->first();
        return $staff->id;
    }

    protected function getClientId($idIndSellsy, $relationType='Client'){
        $this->loadModel('Clients');
        $client = $this->Clients->find()
                                ->where(['id_in_sellsy' => $idIndSellsy])
                                ->first();
        if(!empty($client)){
            return $client->id;
        }
        /*else{
            //$this->out('$contact->type '.$type);
            //return null; 
            $getType = 'Client';
            if($relationType == 'prospect'){
                $getType = 'Prospects';
            }
            $this->out('idIndSellsy '.$idIndSellsy);
            $clientToInsert = $this->getClient($idIndSellsy, $getType);
            if(!empty($clientToInsert)){
                $this->loadModel('Clients');
                $clientEntity = $this->Clients->newEntity($clientToInsert, ['validate' => false]);
                if (!$clientEntity->getErrors()) {
                    if ($clientEntity = $this->Clients->save($clientEntity)) {
                        return $clientEntity->id;
                    }
                }
            }
        }*/
        return null;
    }


    /*public function setDevisFacture(){
        $this->loadModel('LinkedDocs');
        $linkedDocs = $this->LinkedDocs->find('all');
        foreach($linkedDocs as $linkedDoc){
            if($linkedDoc->invoice){
                $facture = $this->LinkedDocs->Factures->find()->where([''])
            }
        }
    }*/

    public function setClientOpp(){
        die;
        $this->loadModel('Opportunites');
        $this->loadModel('Clients');
        $opportunites = $this->Opportunites->find()
                                ->where([
                                    'client_id IS' => NULL,
                                    //'client_id_in_sellsy <>' => NULL
                                ]);
        foreach($opportunites as $opportunite){
            if(empty($opportunite->client_id) && !empty($opportunite->client_id_in_sellsy)){
                $client = $this->Clients->find()
                                    ->where([
                                        'id_in_sellsy' => $opportunite->client_id_in_sellsy
                                    ])
                                    ->first();
                $opportunite->client_id = $client->id;
                if($this->Opportunites->save($opportunite)){
                    $this->out('Opp update '.$opportunite->id);
                }
            }
        }
    }

    protected function getStatutId($label){
        $this->loadModel('OpportuniteStatuts');
        $sourceLead = $this->OpportuniteStatuts->find()
                                ->where(['nom LIKE' =>"%".$label."%"])
                                ->first();
        if(!empty($sourceLead)){
            return $sourceLead->id;
        }else{
            return null; 
        }
    }

    protected function getIdEtapes($nom){
        $this->loadModel('PipelineEtapes');
        $etape = $this->PipelineEtapes->find()
                                ->where(['nom LIKE' =>"%".$nom."%"])
                                ->first();
        if(!empty($etape)){
            return $etape->id;
        }else{
            return null; // Id de Autre
        }
    }

    protected function getIdPipeline($nom){
        $this->loadModel('Pipelines');
        $pipeline = $this->Pipelines->find()
                                ->where(['nom LIKE' =>"%".$nom."%"])
                                ->first();
        if(!empty($pipeline)){
            return $pipeline->id;
        }else{
            return null; // Id de Autre
        }
    }

    protected function getIdSourceLead($nom){
        $this->loadModel('SourceLeads');
        $sourceLead = $this->SourceLeads->find()
                                ->where(['nom LIKE' =>"%".$nom."%"])
                                ->first();
        if(!empty($sourceLead)){
            return $sourceLead->id;
        }else{
            return 9; // Id de Autre
        }
    }

    protected function getIdContactRaison($nom){
        $this->loadModel('ContactRaisons');
        $contactRaison = $this->ContactRaisons->find()
                                ->where(['nom LIKE' =>"%".$nom."%"])
                                ->first();
        if(!empty($contactRaison)){
            return $contactRaison->id;
        }
        return null;
    }

    protected function getIdTypeEvenement($nom){
        $this->loadModel('TypeEvenements');
        $typeEvenements = $this->TypeEvenements->find()
                                ->where(['nom LIKE' =>"%".$nom."%"])
                                ->first();
        if(!empty($typeEvenements)){
            return $typeEvenements->id;
        }else{
            return 15; // ID de Autre
        }
    }

    public function getStepOfFunnles(){
        die;
        $this->loadModel('Pipelines');
        $pipelines = $this->Pipelines->find('all');
        foreach ($pipelines as $pipeline) {
            $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
            $request = array(
                'method' => 'Opportunities.getStepsForFunnel', 
                'params' => array(
                    'funnelid' => $pipeline->id
                )
            );
            $steps = $this->sellsyCurlComponent->requestApi($request)->response;
            debug($steps); die;
            foreach($steps as $step){
                $etape = array();
                    $etape['nom'] = $step->label;
                    $etape['id_in_sellsy'] = $step->id;
                    $etape['pipeline_id'] = $pipeline->id;
                    $etape['rank'] = $step->rank;
                $pipelineEtape = $this->Pipelines->PipelineEtapes->newEntity();
                $pipelineEtape = $this->Pipelines->PipelineEtapes->patchEntity($pipelineEtape, $etape);
                if($this->Pipelines->PipelineEtapes->save($pipelineEtape)) {
                    $this->out('PipelineEtapes '.$step->id);
                }
            }
           
        }

    }

/*    public function udpateIdStep(){
        $this->loadModel('PipelineEtapes');
        $steps = $this->PipelineEtapes->find("all");
        foreach($steps as $step){
            $step->id = $step->id_in_sellsy;
            if($this->PipelineEtapes->save($step)){
                $this->out('PipelineEtapes '.$step->id);
            }
        }
    }*/

    public function syncFunnels(){
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Opportunities.getFunnels',
            'params' => array()
        );
        $funneles = $this->sellsyCurlComponent->requestApi($request)->response;
        debug($funneles); die;
        $this->loadModel('Pipelines');
        foreach($funneles as $funnele){
            $pipe = array();
                $pipe['id_in_sellsy'] = $funnele->id;
                $pipe['nom'] = $funnele->name;
                $pipe['description'] = $funnele->description;

            $pipeline = $this->Pipelines->newEntity();
            $pipeline = $this->Pipelines->patchEntity($pipeline, $pipe);
            if($this->Pipelines->save($pipeline)) {
                $this->out('Pipelines '.$funnele->id);
            }
        }
    }

    public function syncStaffs(){
        die;
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Staffs.getList',
            'params' => array()
        );
        $stfs = $this->sellsyCurlComponent->requestApi($request)->response->result;
        //debug($staffs); die;
        $this->loadModel('Staffs');
        foreach($stfs as $key => $stf){
            //debug($stf); die;
            $data = array();
                $data['id_in_sellsy'] = $key;
                $data['full_name'] = $stf->fullName;
                $data['nom'] = $stf->name;
                $data['prenom'] = $stf->forename;
                $data['email'] = $stf->email;
                $data['people_id_in_sellsy'] =  $stf->peopleid;

            $staffEntity = $this->Staffs->newEntity();
            $staffEntity = $this->Staffs->patchEntity($staffEntity, $data);
            if($this->Staffs->save($staffEntity)) {
                $this->out('Staff '.$staffEntity->id);
            }
        }
    }

    public function syncCommentaire(){
        $this->loadModel('Opportunites');
        $opportunites = $this->Opportunites->find('all')
                                            ->order('rand()')
                                            ->notMatching('OpportuniteCommentaires');
        //debug($opportunites->toArray()); die;
        foreach($opportunites as $opportunite) {
            $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
            $request = array(
                'method' => 'Annotations.getList',
                'params' => array(
                    'search' => array(
                        'id'    => $opportunite->id_in_sellsy,
                        'type'  => 'opportunity'
                    )
                )
            );
            $response = $this->sellsyCurlComponent->requestApi($request)->response;
            //debug($commentaires); die;
            if(!empty($response->result)){
                $this->loadModel('OpportuniteCommentaires');
                foreach($response->result as $idCommentaire => $commentaire){
                    $data['opportunite_id'] = $opportunite->id;
                    $data['commentaire_id_in_sellsy'] = $idCommentaire;
                    $data['staff_id'] = $this->getStaffId($commentaire->datas->ownerid);
                    $data['timestamp'] = $commentaire->datas->timestamp;
                    $data['date_format'] = $commentaire->datas->date;
                    $data['titre'] = $commentaire->datas->title;
                    $data['commentaire'] = $commentaire->datas->annotationHtmlFormated;

                    $opportuniteCommentaire = $this->OpportuniteCommentaires->newEntity();
                    $commentaireInBase = $this->OpportuniteCommentaires
                                                            ->find()
                                                            ->where([
                                                                'commentaire_id_in_sellsy' => $idCommentaire
                                                            ])
                                                            ->first();
                    if(!empty($commentaireInBase)){
                        $opportuniteCommentaire = $commentaireInBase;
                    }
                    $opportuniteCommentaire = $this->OpportuniteCommentaires->patchEntity($opportuniteCommentaire, $data);
                    if($this->OpportuniteCommentaires->save($opportuniteCommentaire)) {
                        $this->out('Commentaire '.$opportuniteCommentaire->id);
                    }
                }
            }
        }
    }

    public function parse_csv($file, $options = null) {
        $delimiter = empty($options['delimiter']) ? "," : $options['delimiter'];
        $to_object = empty($options['to_object']) ? false : true;
        $str = file_get_contents($file);
        $lines = explode("\n", $str);
        pr($lines);
        $field_names = explode($delimiter, array_shift($lines));
        foreach ($lines as $line) {
            // Skip the empty line
            if (empty($line)) continue;
            $fields = explode($delimiter, $line);
            $_res = $to_object ? new stdClass : array();
            foreach ($field_names as $key => $f) {
                if ($to_object) {
                    $_res->{$f} = $fields[$key];
                } else {
                    $_res[$f] = $fields[$key];
                }
            }
            $res[] = $_res;
        }
        return $res;
    }

    public function importOppCsv(){
        $pathCsv = WWW_ROOT.'export'.DS.'export_opportunites_531931593775937.csv';
        $row = 1;
        if (($handle = fopen($pathCsv, "r")) !== FALSE) {
            while (($ligne = fgetcsv($handle, 1000, ";")) !== FALSE) {
                //debug($data);die;
                /*$num = count($data);
                echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c=0; $c < $num; $c++) {
                    echo $data[$c] . "<br />\n";
                }*/
                //foreach($data as $numLigne => $ligne){
                if($row !=1){  
                    $this->loadModel('Opportunites');
                    $opportunite = $this->Opportunites->newEntity();
                    $inBase = $this->Opportunites->find()
                                                    ->contain(['LinkedDocs','Staffs'])
                                                    ->where(['id_in_sellsy' => $ligne[0]])
                                                    ->first();
                    if(!empty($inBase)){
                        $opportunite = $inBase;
                    } 

                    $data = array();
                    $data['id_in_sellsy'] = $ligne[0];
                    $data['numero'] = $ligne[1];
                    $data['client_id_in_sellsy'] = $ligne[2];
                    $data['client_id'] = $this->getClientId($ligne[2]);
                    $data['nom'] = $ligne[10];
                    $data['opportunite_statut_id'] = $this->getStatutId($ligne[6]);
                    $data['montant_potentiel'] = $this->generateMontant($ligne[15]);
                    $data['date_echeance'] = $this->generateDate($ligne[9]);
                    //$data['created'] = $this->generateDate($ligne[23]);
                    $data['pipeline_id'] = $this->getIdPipeline($ligne[12]);
                    $data['pipeline_etape_id'] = $this->getIdEtapes($ligne[13]);
                    $data['probabilite'] = $this->getIdEtapes($ligne[14]);
                    $data['brief'] = $ligne[16];
                    $data['note'] = $ligne[17];
                    if($ligne[21] == 'Particulier'){
                        $data['type_client_id'] = 3;
                    }elseif($ligne[21] == 'Professionnel'){
                        $data['type_client_id'] = 2;
                    }else{
                        $data['type_client_id'] = 1;
                    }
                    $data['source_lead_id'] = $this->getIdSourceLead($ligne[23]);
                    $data['contact_raison_id'] = $this->getIdContactRaison($ligne[22]);
                    $data['type_evenement_id'] = $this->getIdTypeEvenement($ligne[19]);
                    $data['type_demande'] = $ligne[20] ;
                    $data['antenne_retrait'] = $ligne[24];
                    $data['antenne_retrait_secondaire'] = $ligne[25];

                    //Staff
                    if(!empty($ligne[11])){
                        $_idsStaff = array();
                        /*foreach($contact->staffs as $staff ){
                            $oneStaff= array();
                            $idInBase = $this->getStaffId($staff->id);
                            array_push($_idsStaff, $idInBase);
                        }*/
                        $idInBase = $this->getStaffIdByFullName($ligne[11]);
                        $oneStaff= array();
                        array_push($_idsStaff, $idInBase);

                        $data['staffs']['_ids'] = $_idsStaff;
                    }

                    //debug($data); die;
                    $opportunite = $this->Opportunites->patchEntity($opportunite, $data);
                    if ($this->Opportunites->save($opportunite)) {
                        $this->out('Opportunité saved'.$opportunite->id);
                    }else{
                        $this->out('Opportunité saved error'.$ligne[0]);
                    }
                }
                $row++;
            }
            fclose($handle);
        }
    }

    protected function generateMontant($string){
        $n = '';
        if(!empty($string)){
           $arr = explode(' ',$string); 
           $n = floatval($arr[0]);
        }
        return $n;
    }



    //17/07/2020
    protected function generateDate($dateFormated){
        $newDate = null;
        if(!empty($dateFormated)){
            $dateArray = explode('/', $dateFormated);
            $newDate = $dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0];
        }
        return $newDate;
    }

    public function getAndSaveProspect($idInSellsy){
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request =  array( 
            'method' => 'Prospects.getOne', 
            'params' => array(
                'id'    => $idInSellsy
            )
        );

        $prospect = $this->sellsyCurlComponent->requestApi($request)->response;

        debug($prospect); die;

    }  


    public function likendDoc(){
        $this->loadModel('LinkedDocs');
        $linkedDocs = $this->LinkedDocs->find('all');
        foreach ($linkedDocs as $linkedDoc) {
            if(!empty($linkedDoc->doc_doctype)){
                //$this->out('$linkedDoc->doc_doctype '.$linkedDoc->doc_doctype);
                if($linkedDoc->doc_doctype == 'estimate'){
                    if(empty($linkedDoc->devi_id)){
                        $this->loadModel('Devis');
                        $devisInBase = $this->Devis->find()
                                                ->where([
                                                    'sellsy_doc_id'=>$linkedDoc->doc_docid_in_sellsy
                                                ])->first();
                        if(!empty($devisInBase)){
                            $linkedDoc->devi_id = $devisInBase->id;
                            if($this->LinkedDocs->save($linkedDoc)){
                                $this->out('Devis lié '.$linkedDoc->id);
                            }
                        }
                    }
                }else if($linkedDoc->doc_doctype == 'invoice'){
                    if(empty($linkedDoc->facture_id)){
                        $this->loadModel('DevisFactures');
                        $factureInBase = $this->DevisFactures->find()
                                                ->where([
                                                    'sellsy_doc_id'=>$linkedDoc->doc_docid_in_sellsy
                                                ])->first();
                        $this->out('je passe ici 1');
                        if(!empty($factureInBase)){
                            $this->out('Je passe ici 2');
                            $linkedDoc->facture_id = $factureInBase->id;
                            if($this->LinkedDocs->save($linkedDoc)){
                                $this->out('Facture lié '.$linkedDoc->id);
                            }else{
                                debug($linkedDoc);
                                $this->out('Bug save facture');
                            }
                        }
                    }
                }
            }
        }
    }


}