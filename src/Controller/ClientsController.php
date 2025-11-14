<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Console\ShellDispatcher;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use App\Traits\AppTrait;


class ClientsController extends AppController
{
    use AppTrait;

    public function isAuthorized($user)
    {

        $isRolePermis = (bool) array_intersect($user['profils_alias'] , ['admin', 'compta']);

        if (!$isRolePermis && in_array($this->action, ['dashboard'])) {
            return false;
        }

        $typeprofils = $user['typeprofils'];
        if(array_intersect(['admin', 'konitys'], $typeprofils)) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->loadModel('VillesCodePostals');
        $this->loadModel('CommentairesClients');
        $this->loadModel('ContactTypes');
    }


    public function index()
    {
        $key = $this->request->getQuery('key');
        $type = $this->request->getQuery('type');
        
        $customFinderOptions = [
            'key' => $key,
            'type' => $type
        ];
        
        $this->paginate = [
            'finder' => [
                'filtre' => $customFinderOptions
            ]
        ];
        
        $clients = $this->paginate($this->Clients);

        $this->set(compact('clients','key','type'));
    }


    public function view($id = null)
    {

        return $this->redirect(['action' => 'fiche', $id]);
    }

    public function edit($id = null)
    {
        $client = $this->Clients->get($id, [
            'contain' => ['ClientContacts','GroupeClients']
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $client = $this->Clients->patchEntity($client, $this->request->getData());
            if ($this->Clients->save($client)) {
                
                $data = $this->request->getData();
                 if(!empty($data['contact_id'])){
                    $contacts = TableRegistry::getTableLocator()->get('ClientContacts');
                    $query = $contacts->query();
                    $query->update()
                        ->set([
                            'nom' => $data['contact_nom'],
                            'prenom' => isset($data['contact_prenom'])?$data['contact_prenom']:null,
                        ])
                        ->where(['id' => $data['contact_id']])
                        ->execute();
                }else{
                        $contacts = TableRegistry::getTableLocator()->get('ClientContacts');
                        $query = $contacts->query();
                        $query->insert(['nom','prenom','client_id'])->values(['nom' => $data['contact_nom'],'prenom' => $data['contact_prenom'],'client_id'=>$id])->execute();
                }
                
                $this->Flash->success(__('The client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client could not be saved. Please, try again.'));
        }
        
        $groupeClients = $this->Clients->GroupeClients->find('list',['valueField'=>'nom']);
        $type_clients = ['person'=>'Particulier', 'corporation'=>'Professionel'];
        $secteursActivites = $this->Clients->SecteursActivites->find('list')->order(['name' => 'asc']);

        $this->set(compact('secteursActivites', 'client','type_clients','groupeClients'));
    }

    
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Clients->get($id);
        $client = $this->Clients->patchEntity($client, ['deleted' => 1]);
        if ($this->Clients->save($client)) {
            $this->Flash->success(__('The client has been deleted.'));
        } else {
            $this->Flash->error(__('The client could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());    
    }
    
    public function synchro($type = 'client'){
        ini_set('max_execution_time', 7200); 
        $this->autoRender = false;
        $shell = new ShellDispatcher();
        $output = $shell->run(['cake', 'sellsy', 'client', $type]);

        if (0 === $output) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }


    // ----- FACTURES & DEVIS -------

    public function add($id = null, $redirect = 'fiche')
    {
        // $this->Clients->delete($this->Clients->findById('2502')->contain('ClientContacts')->first());
        $currentUser = $this->currentUser();
        $clientEntity = $this->Clients->newEntity();
        if ($id) {
            $clientEntity = $this->Clients->findById($id)->contain(['ClientContacts', 'SecteursActivites'])->first();
            $villesFrances = [];
            if ($clientEntity->cp) {
                $villesFrances = $this->VillesCodePostals->VillesFrances->find()->where(['ville_code_postal LIKE' => "%$clientEntity->cp%"])->find('list', [
                    'keyField' => 'ville_nom',
                    'valueField' => 'ville_nom'
                ]);
            }
        }
        $genres = Configure::read('genres'); 
        $type_commercials = Configure::read('type_commercials');
        $connaissance_selfizee = Configure::read('connaissance_selfizee');
        $filtres_contrats = Configure::read('filtres_contrats');

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $clientEntity = $this->Clients->patchEntity($clientEntity, $data);

            foreach ($clientEntity->client_contacts as $key => $client_contact) {
                $client_contact = array_map('trim', $client_contact->toArray());
                if (empty(array_filter($client_contact))) {
                    unset($clientEntity->client_contacts[$key]);
                }
            }


            // Completer ville base si pas inclus dans liste ville_frances
            if (isset($data['is_ville_manuel']) &&  $data['is_ville_manuel'] == 1) {
                $this->loadModel('VillesFrances');
                if (!empty($data['cp']) && !empty($data['ville']) && !$this->VillesFrances->find()->where(['ville_code_postal' => $data['cp'], 'ville_nom' => $data['ville']])->first()) {

                    $villeFranceEntity = $this->VillesFrances->newEntity([
                        'ville_nom' => $data['ville'],
                        'ville_code_postal' => $data['cp']
                    ]);

                    $villeFranceEntity = $this->VillesFrances->save($villeFranceEntity);
                }
            }

            if ($clientEntity->isNew() == true) {
                $clientEntity->set('user_id', $currentUser->id);
            }

            if ($c = $this->Clients->save($clientEntity)) {
                // debug($c);
                // die();
                $this->Flash->success(__('The client has been saved.'));
                
                if($redirect == 'referer') {
                    return $this->redirect($this->referer());
                }
                return $this->redirect(['action' => $redirect, $clientEntity->id]);
            }
            $this->Flash->error(__('The client could not be saved. Please, try again.'));
        }

        $villesCodePostals = $this->VillesCodePostals->find('list')->group('ville_cp_fk_code_postal');
        $groupeClients = $this->Clients->GroupeClients->find('list')->order(['nom' => 'asc']);
        $secteursActivites = $this->Clients->SecteursActivites->find('list')->order(['name' => 'asc']);
        $contactTypes = $this->ContactTypes->find('list');
        $isVilleClientInVilleFrances = (bool) $this->VillesCodePostals->VillesFrances->find()->where(['ville_code_postal LIKE' => "%$clientEntity->cp%", 'ville_nom' => $clientEntity->ville])->count();
        $payss = $this->Clients->Payss->find('listAsc');

        $this->set(@compact('payss', 'isVilleClientInVilleFrances', 'filtres_contrats', 'contactTypes', 'secteursActivites', 'clientEntity', 'id', 'genres', 'type_commercials', 'groupeClients', 'villesCodePostals', 'villesFrances', 'connaissance_selfizee'));
    }

    public function fiche($id)
    {
        $clientEntity = $this->Clients->findById($id)
                ->find('complete')
                ->contain(['Opportunites' => ['OpportuniteStatuts', 'Pipelines', 'PipelineEtapes', 'TypeClients', 'TypeEvenements','Staffs']])
                ->contain(['CommentairesClients' => 'Users',])
                ->contain(['Reglements' => ['Users', 'DevisFactures', 'Devis' => 'Commercial']])
                ->contain(['Avoirs' => ['Commercial', 'DevisFactures'], 'Users'])
                ->contain(['Bornes' => ['Parcs', 'Users', 'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients'=> 'GroupeClients','Couleurs','Logiciels','TypeContrats','EtatBornes']])
                ->first();

        if(! $clientEntity) {
            $this->Flash->error(__('Ce client n\'existe plus'));
            return $this->redirect(['action' => 'liste']);
        }
        
        if($this->request->is(['post', 'put'])) {
            $controller = $this->request->getData('controller');
            $model_devis_id = $this->request->getData('model_devis_id');
            $categorie_tarifaire = $this->request->getData('categorie_tarifaire');
            $type_docs = $this->request->getData('type_doc_id');
            if($controller == 'Devis') {
                $this->request->getSession()->write('devis_client', $this->Clients->findById($id)->contain('ClientContacts')->first());
            }elseif ($controller == 'DevisFactures') {
                $this->request->getSession()->write('devis_factures_client', $this->Clients->findById($id)->contain('ClientContacts')->first());
            }elseif ($controller == 'Avoirs') {
                $this->request->getSession()->write('avoirs_client', $this->Clients->findById($id)->contain('ClientContacts')->first());
            }
            return $this->redirect(['controller' => $controller, 'action' => 'add', 'model_devis_id' => $model_devis_id, 'categorie_tarifaire' => $categorie_tarifaire, 'type_doc_id' => $type_docs]);
        }

        $has_devis = $has_factures = false;
        $genres = Configure::read('genres');
        $yes_or_no = Configure::read('yes_or_no');
        $type_commercials = Configure::read('type_commercials');
        $devis_status = Configure::read('devis_status');
        $facture_status = Configure::read('devis_factures_status');        
        $filtres_contrats = Configure::read('filtres_contrats');

        $totalDevis = $totalAttente = $totalDone = $totalRefused = 0;
        $countDevis = [
            'total' => 0,
            'attente' => 0,
            'done' => 0,
            'refused' => 0,
        ];
        foreach ($clientEntity->devis as $devis) {
            if( ! $devis->is_model) {
                $has_devis = true;
                $countDevis['total'] += 1;
                $totalDevis += $devis->total_ht;
                if($devis->status == 'done') {
                    $totalDone += $devis->total_ht;
                    $countDevis['done'] += 1;
                }
                elseif($devis->status == 'refused') {
                    $totalRefused += $devis->total_ht;
                    $countDevis['refused'] += 1;
                }  
                else {
                    $totalAttente += $devis->total_ht;
                    $countDevis['attente'] += 1;
                }
            }
        }

        $type_reglements = Configure::read('type_reglement');
        $etat_reglements = Configure::read('etat_reglement');
        
        $factures = [];
        $totalFactures = ['count' => 0, 'total_ht' => 0, 'total_ttc' => 0];
        foreach ($clientEntity->factures as $facture) {
            if( ! $facture->is_model) {
                $has_factures = 1;
                $totalFactures['count'] += 1;
                $totalFactures['total_ht'] += $facture->total_ht;
                $totalFactures['total_ttc'] += $facture->total_ttc;
                
                if(!empty($factures[$facture->status])) {
                    $factures[$facture->status]['count'] += 1;
                    $factures[$facture->status]['total_ht'] += $facture->total_ht;
                    $factures[$facture->status]['total_ttc'] += $facture->total_ttc;
                } else {
                    $factures[$facture->status] = [
                        'count' => 1,
                        'total_ht' => $facture->total_ht,
                        'total_ttc' => $facture->total_ttc,
                    ];
                }
            }
        }
        
        $categorie_tarifaires = Configure::read('categorie_tarifaire');
        $modelDevis = $this->Clients->Devis->find('list',['valueField' => 'model_name'])
                ->order(['model_name'=>'ASC'])
                ->where(['is_model' => 1]);
        $modelCategories = $this->Clients->Devis->ModeleDevisCategories->find('list');
        $type_docs = $this->Clients->Devis->DevisTypeDocs->find('list')->toArray();
        $modelSousCategories = $this->Clients->Devis->ModeleDevisSousCategories->find('list',['groupField' => 'modele_devis_categories_id']);
        // reglement
        
        $type_reglement = Configure::read('type_reglement');
        $etat_reglement = Configure::read('etat_reglement');
        $type_bornes = Configure::read('type_bornes');
        $moyen_reglements = $this->Clients->Reglements->MoyenReglements->find('list');
        $new_reglement = $this->Clients->Reglements->newEntity();
        $commentaireClientEntity = $this->Clients->CommentairesClients->newEntity();
        $commercial = $this->Clients->Users->findById(84)->first();
        $secteursActivites = $this->Clients->SecteursActivites->find('list')->order(['name' => 'asc']);
        $connaissance_selfizee = Configure::read('connaissance_selfizee');
        $groupeClients = $this->Clients->GroupeClients->find('list')->order(['nom' => 'asc']);
        $contactTypes = $this->Clients->ClientContacts->ContactTypes->find('list');
        $villesFrances = $this->VillesCodePostals->VillesFrances->find()->where(['ville_code_postal LIKE' => "%$clientEntity->cp%"])->find('list', [
            'keyField' => 'ville_nom',
            'valueField' => 'ville_nom'
        ])->toArray();


        $isVilleClientInVilleFrances = (bool) $this->VillesCodePostals->VillesFrances->find()->where(['ville_code_postal LIKE' => "%$clientEntity->cp%", 'ville_nom' => strtoupper($clientEntity->ville)])->count();
        $payss = $this->Clients->Payss->find('listAsc');
        $connaissance_selfizees = Configure::read('connaissance_selfizee');

        $this->set(compact('isVilleClientInVilleFrances', 'filtres_contrats', 'type_bornes', 'contactTypes', 'commentaireClientEntity', 'factures', 'totalFactures', 'has_devis', 'has_factures', 'modelCategories', 'modelSousCategories', 'categorie_tarifaires', 'type_docs', 'type_reglement', 'etat_reglement', 'moyen_reglements', 'new_reglement', 'connaissance_selfizee'));
        $this->set(compact('connaissance_selfizees', 'payss', 'villesFrances', 'groupeClients','type_reglements', 'etat_reglements', 'clientEntity', 'genres', 'yes_or_no', 'type_commercials', 'modelDevis','totalDevis', 'totalAttente', 'totalDone', 'totalRefused','countDevis', 'facture_status', 'devis_status', 'commercial', 'secteursActivites'));
    }

    public function ajoutCommentaire($client_id, $commentaire_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $currentUser = $this->currentUser();
            $data['user_id'] = $currentUser->id;
            $data['client_id'] = $client_id;
            
            $commentaireClientEntity = $this->CommentairesClients->newEntity($data, ['validate' => false]);

            if ($commentaire_id != null) {
                $commentaireClientEntity = $this->CommentairesClients->findById($commentaire_id)->first();
                $commentaireClientEntity = $this->CommentairesClients->patchEntity($commentaireClientEntity, $data, ['validate' => false]);
            }
            if(!$commentaireClientEntity->getErrors()) {
                $this->CommentairesClients->save($commentaireClientEntity);
            }
        
            $this->Flash->success("Le commentaire a bien été enregistré");
            return $this->redirect($this->referer());
        }
    }

    public function findCommentaire($id)
    {
        $commentaireClientEntity = $this->CommentairesClients->findById($id)->first();
        $body = $commentaireClientEntity;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function deleteCommentaire($client_id, $commentaire_id)
    {
        $commentaireClientEntity = $this->CommentairesClients->get($commentaire_id);
        $result = $this->CommentairesClients->delete($commentaireClientEntity);

        $this->Flash->success("Le commentaire a bien été supprimé");
        return $this->redirect(['action' => 'fiche', $client_id]);
    }

    public function liste()
    {
        $key = $this->request->getQuery('key');
        $contact_key = $this->request->getQuery('contact_key');
        $type = $this->request->getQuery('type');
        $type_commercial = $this->request->getQuery('type_commercial');
        $groupe_client_id = $this->request->getQuery('groupe_client_id');
        $type_contrats = $this->request->getQuery('type_contrats');
        $ref_commercial_id = $this->request->getQuery('ref_commercial_id');
        $adresse_key = $this->request->getQuery('adresse_key');
        $secteurs_activite = $this->request->getQuery('secteurs_activite');
        
        $genres = Configure::read('genres');
        $genres_short = Configure::read('genres_short');
        $type_commercials = Configure::read('type_commercials');
        $type_commercials_short = Configure::read('type_commercials_short');
        $connaissance_selfizee = Configure::read('connaissance_selfizee');
        $filtres_contrats = Configure::read('filtres_contrats');
        

        $customFinderOptions = $this->request->getQuery();
        $clients = $this->Clients->find('filtre', $customFinderOptions)->contain(['SecteursActivites', 'GroupeClients', 'ClientContacts', 'Devis' => 'Commercial', 'DevisFactures', 'Avoirs', 'Bornes' => ['ModelBornes' => 'GammesBornes']]);
        $clients = $this->paginate($clients, ['order' => ['Clients.created' => 'DESC', 'maxLimit' => false]]);
        $secteursActivites = $this->Clients->SecteursActivites->find('list')->order(['name' => 'asc']);
        $commercials = $this->Clients->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name'])->where(['toujours_present' => 1]);
        $payss = $this->Clients->Payss->find('listAsc');

        $groupeClients = $this->Clients->GroupeClients->find('list',['valueField' => 'nom']);
        $this->set(compact('payss', 'adresse_key', 'secteurs_activite', 'ref_commercial_id', 'genres_short', 'type_commercials_short', 'commercials', 'type_commercial', 'type_contrats', 'filtres_contrats', 'clients','key','contact_key' ,'type', 'genres', 'type_commercials', 'groupeClients', 'groupe_client_id', 'secteursActivites', 'connaissance_selfizee'));
    }

    public function deleteClient($id = null)
    {
        // $this->request->allowMethod(['post', 'delete']);
        $client = $this->Clients->get($id, ['contain' => ['Devis', 'DevisFactures']]);

        if ($client->get('CountDevis') > 0) {
            $this->Flash->error("Ce client est rattaché à plusieurs devis et ne peut pas être supprimé.");
            return $this->redirect(['action' => 'liste']);
        }
        if ($client->get('CountFactures') > 0) {
            $this->Flash->error("Ce client est rattaché à plusieurs factures et ne peut pas être supprimé.");
            return $this->redirect(['action' => 'liste']);
        }

        $client = $this->Clients->patchEntity($client, ['deleted' => 1]);
        if ($this->Clients->save($client)) {
            $this->Flash->success(__('The client has been deleted.'));
        } else {
            $this->Flash->error(__('The client could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    public function doublon($offset = 0) {
        $clients = $this->Clients->find()
                ->select(['ids' => 'GROUP_CONCAT(id)', 'nbre' => 'count(id)'])
                ->group(['nom'])
                ->having(['nbre >' => 1])
                ->limit(100)
                ->offset($offset)
                ;
        
        foreach($clients as $client) {
            debug($client->ids);
            $client_ids = explode(',', $client->ids);
            foreach ($client_ids as $id) {
                debug($id);
                $borne = $this->Clients->Bornes->findByClientId($id)->toArray();
                debug(count($borne));
                if(count($borne)) {
                    continue;
                }
                $ventes = $this->Clients->Ventes->findByClientId($id)->toArray();
                debug(count($ventes));
                if(count($ventes)) {
                    continue;
                }
                $evenements = $this->Clients->Evenements->findByClientId($id)->toArray();
                debug(count($borne));
                if(count($borne)) {
                    continue;
                }
                $opportunites = $this->Clients->Opportunites->findByClientId($id)->toArray();
                debug(count($opportunites));
                if(count($opportunites)) {
                    continue;
                }
                $reglements = $this->Clients->Reglements->findByClientId($id)->toArray();
                debug(count($reglements));
                if(count($reglements)) {
                    continue;
                }
                $documents = $this->Clients->Documents->findByClientId($id)->toArray();
                debug(count($documents));
                if(count($documents)) {
                    continue;
                }
                $devis = $this->Clients->Devis->findByClientId($id)->toArray();
                debug(count($devis));
                if(count($devis)) {
                    continue;
                }
                $factures = $this->Clients->DevisFactures->findByClientId($id)->toArray();
                debug(count($factures));
                if(count($factures)) {
                    continue;
                }
                $commentaires = $this->Clients->CommentairesClients->findByClientId($id)->toArray();
                debug(count($commentaires));
                if(count($commentaires)) {
                    continue;
                }
                $client = $this->Clients->get($id);
                $this->Clients->delete($client);
                debug('delete' . $id);
            }
        }
        
        die;
    }

    public function majCheckboxTypeBornes()
    {
        $clients = $this->Clients->find()->contain(['Bornes'])->matching('Bornes')->select(['id']);
        foreach ($clients as $key => $client) {
            $data = [];
            foreach ($client->bornes as $key => $borne) {
                $data['parc_id'] = $borne->parc_id;
                $info = $this->setParcTypeOnClient($data);
                $this->Clients->updateAll($info, ['id' => $client->id]);
            }
        }
        die('ok');
    }

    public function dashboard() {

        $this->viewBuilder()->setLayout('dashboard');
    }
    
    
    public function multipleAction()
    {
        if ($this->request->is(['post'])) {

            $this->loadComponent('Zip');
            $data = $this->request->getData();
            

            if ($data['action'] == 'secteurActivite') {

                $clients_ids = array_filter($data['clients']);
                $clients_ids = array_keys($clients_ids);
                $clients = $this->Clients->find('all')->contain(['SecteursActivites'])->where(['id IN' =>$clients_ids])->toList();
                
                foreach ($clients as $client) {
                    $client = $this->Clients->patchEntity($client, ['secteurs_activites' => $data['secteurs_activites']], ['validate' => false]);
                    $this->Clients->save($client);
                }
                
            } elseif ($data['action'] == 'delete') {
                
                $clients_ids = array_filter($data['clients']);
                $clients_ids = array_keys($clients_ids);
                $this->Clients->updateAll(['deleted' => 1],['id IN' => $clients_ids]);
            }
            
            return $this->redirect($this->referer());
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function editSectuerActivities($client_id) {
        
        if($client_id) {

            $data = $this->request->getData();
            $client = $this->Clients->find('all')->contain(['SecteursActivites'])->where(['id' =>$client_id])->first();
            $client = $this->Clients->patchEntity($client, ['secteurs_activites' => $data['secteurs_activites']], ['validate' => false]);
            $this->Clients->save($client);
            
            $this->Flash->success(__('The client has been saved.'));

        }else {
            
            $this->Flash->error(__('The client could not be saved. Please, try again.'));
        }
          
        return $this->redirect($this->referer());
    }
}
