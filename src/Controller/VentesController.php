<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;

use App\Traits\AppTrait;

/**
 * si ajout de champs, ne pas oublier de les mettre dans l'action edit cf. étape
 */

class VentesController extends AppController
{
    public $vente_id , $vente_mode;

    use AppTrait;

    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->loadComponent('Utilities');
        $this->Utilities->loadModels(['Ventes', 'Users', 'Bornes', 'Clients', 'Parcs', 'TypeEquipements']);

        $creaActions = ['add', 'materiel', 'optionsConsommables', 'briefProjet', 'livraison', 'recap', 'view'];
        $action = $this->request->getParam('action');
        $this->loadModel('VillesCodePostals');

        if (in_array($action, $creaActions)) {
            $this->viewBuilder()->setLayout('vente');
        }

        // debug($this->getAllInfosVente());

        // si edition
        $vente_id = $this->vente_id = $this->request->getSession()->read('vente_id');
        $vente_mode = $this->vente_mode = $this->request->getSession()->read('vente_mode');
        $this->set(@compact('vente_id', 'vente_mode'));

        // $this->request->getSession()->delete('vente_materiel.ventes_type_consommables');
        // $entity = $this->Ventes->get(1);
        // $result = $this->Ventes->delete($entity);
        // $this->reset(false);     
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');

        $isRolePermis = (bool) array_intersect($user['profils_alias'] , ['admin', 'compta']);

        if (!$isRolePermis && in_array($this->action, ['dashboard'])) {
            return false;
        }

        $typeprofils = $user['typeprofils'];
        if(in_array('konitys', $typeprofils) || in_array('admin', $typeprofils)) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function debug()
    {
        $this->loadComponent('SellsyApi');
        debug($this->SellsyApi->getClient());
        die();
    }

    public function facturations($isArchive = false)
    {
        $parc_id = $parc = $this->request->getQuery('parc');
        // seb : par defaut liste les ventes qui sont en parc "location financière" avec le statut "expédié"
        $ventes = $this->Ventes->find('complete')->find('LocaExpedie')->find('FactureNonTraitees');
        // liste les ventes qui sont dans le parc des ventes (peut importe le statut)
        if ($this->request->getQuery('parc') == 1) {
            $ventes = $this->Ventes->findByParcId(1)->find('complete');
        }
        // liste les ventes traités en accompte réglé ou facture envoyée
        if ($isArchive == true) {
            $ventes = $this->Ventes->find('complete')->find('FactureTraitees');
        } 

        $vente_statuts = Configure::read('vente_statut');
        $vente_etat_facturations = Configure::read('vente_etat_facturation');

        $this->set(@compact('ventes', 'vente_statuts', 'vente_etat_facturations', 'isArchive', 'parc_id'));
    }

    public function majStateBilling($vente_id, $isArchive = null)
    {
        $venteEntity = $this->Ventes->findById($vente_id)->first();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            $venteEntity = $this->Ventes->patchEntity($venteEntity, $data, ['validate' => false]);

            if(!$venteEntity->getErrors()) {
                $this->Ventes->save($venteEntity);
                $this->Flash->success("Mise à jour réussie");
                return $this->redirect(['action' => 'facturations', $isArchive]);
            }
            return $this->redirect($this->referer());
        }
    }

    public function index($vente_statut = null)
    {
        
        $vente_statuts = $vente_statuts_filtre = Configure::read('vente_statut');
        $vente_statut_couleurs = Configure::read('vente_statut_couleur');
        $vente_etat_facturations = Configure::read('vente_etat_facturation');
        
        $numero = $this->request->getQuery('numero');
        $client_id = $this->request->getQuery('client');
        $ident = $this->request->getQuery('numero_devis');
        $groupe_client_id = $this->request->getQuery('groupe_client');
        $user_id = $this->request->getQuery('user');
        $statut_vente = $this->request->getQuery('vente_statut');

        $customFinderOptions = [
            'client_id' => $client_id,
            'groupe_client_id' => $groupe_client_id,
            'user_id' => $user_id,
            'vente_statut' => $statut_vente,
            'numero' => $numero,
            'numero_devis' => $ident
        ];
        
        if ($vente_statut == null) {
            unset($vente_statuts_filtre['expedie']);
            $conditions = ['OR' => [['vente_statut !=' => 'expedie'], ['vente_statut is' => NULL]]];
            $ventes = $this->Ventes->find('complete')->find('filtre', $customFinderOptions)->find('VentesLocaFi')->where($conditions);
        } else {
            $conditions = ['vente_statut' => $vente_statut];
            $ventes = $this->Ventes->find('complete')->find('filtre', $customFinderOptions)->find('VentesLocaFi')->where($conditions);
        }

        $venteEntity = $this->Ventes->newEntity();

        if ($numero) {
            $ventes->where(['Bornes.numero' => $numero]);
        }
        if ($client_id) {
            $ventes->where(['Ventes.client_id' => $client_id]);
        }

        if ($ident) {
            $ventes->contain(['Documents'])->matching('Documents')->where(['Documents.ident' => $ident]);
        }

        $borne_has_vente = $this->Ventes->find('list',['valueField'=>'borne_id','conditions' => ['borne_id is not null']])->toArray();

        $bornes = $this->Ventes->Bornes->find('ListForVentes')->toArray();

        if(count($borne_has_vente)){
            $bornes = $this->Ventes->Bornes
                ->find('list',[
                    'valueField'=>function ($e) {
                        return $e->model_borne->gammes_borne->notation.$e->numero;
                    },
                    'groupField' => function ($e) {
                        return $e->parc_id. ';' .$e->model_borne->gamme_borne_id;
                    },
                ])
                ->where(['Bornes.id NOT IN' => $borne_has_vente])
                ->contain(['ModelBornes'=> 'GammesBornes'])
                ->order(['numero' => 'ASC'])
                ->toArray();
        }
        
        $clientsCorporations = $this->Clients->findByClientType('corporation') ->find('list', ['valueField' => 'nom']);
        $groupeClients = $this->Ventes->Clients->GroupeClients->find('list',['valueField' => 'nom']);
        $users = $this->Ventes->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name']);
        $groupedGammesBornes = $this->Ventes->GammesBornes->find('countByVentes')->where($conditions)->filter(function ($v, $k) {return $v->nb > 0; });

        $countVentes = [];
        foreach ($vente_statuts as $vente_statut_key => $vente_statu_value){
            $conditions = ['vente_statut' => $vente_statut_key];
            $countVentes[$vente_statut_key]['total'] = count($this->Ventes->find('complete')->find('filtre',$customFinderOptions)->where($conditions)->toArray());
            $countVentes[$vente_statut_key]['parGamme'] = $this->Ventes->GammesBornes->find('countByVentes')->where($conditions)->filter(function ($v, $k) {return $v->nb > 0; });

        }
        $conditions = ['vente_statut is' => NULL];
        $countVentes['en_attente']['total'] = count($this->Ventes->find('complete')->find('filtre',$customFinderOptions)->where($conditions)->toArray());
        $countVentes['en_attente']['parGamme'] = $this->Ventes->GammesBornes->find('countByVentes')->where($conditions)->filter(function ($v, $k) {return $v->nb > 0; });

        $this->set(@compact('vente_statut_couleurs', 'vente_statuts_filtre', 'vente_etat_facturations', 'groupedGammesBornes', 'ventes', 'bornes', 'venteEntity', 'vente_statut', 'vente_statuts', 'numero', 'client_id', 'ident'));
        $this->set(@compact('clientsCorporations','client_id','users','user_id','groupeClients','groupe_client_id','statut_vente','countVentes'));
    }

    /**
     * si modemarker == 1, => mode création reset session step 1
     * @param [type] $modemarker [description]
     */
    public function add($modemarker = null)
    {
        $parcs = $this->Ventes->Parcs->find('vente')->find('list', ['valueField' => 'nom2']);
        $is_agency = Configure::read('is_agency');
        $entity_jurids = Configure::read('entity_jurids');
        $genres = Configure::read('genres'); 
        $yes_or_no = Configure::read('yes_or_no');
        $contactTypes = $this->Clients->ClientContacts->ContactTypes->find('list');
        $payss = $this->Clients->Payss->find('listAsc');
        $facturation_achat_type = Configure::read('facturation_achat_type');
        $this->loadComponent('Upload');

        if ($modemarker == 1) { /*si nouveau*/
            $this->reset();
        }

        $vente_mode = $this->request->getSession()->read('vente_mode');

        // mais faut rechercher que les clients professionnels (par les particuliers).
        // $clients = $this->Clients->find('corporationList')/*->where(['nom LIKE' => '%Charlène%'])*/;
        $clientsContacts = [];
        $venteEntity = $this->Ventes->newEntity();
        $isVilleNotFinded = false;
        if ($dataClient = $this->request->getSession()->read('vente_client')) {
            // debug($dataClient);
            // die();
            $clientId = isset($dataClient['client']['id']) ? $dataClient['client']['id'] : null;

            $clientEntity = $this->Clients->findById($clientId)->first(); // contact en tant que commercial
            $venteEntity = $this->Ventes->newEntity($dataClient, ['associated' => ['Clients.ClientContacts', 'Clients.SecteursActivites']]);
            $documents_devis_clients = $this->Ventes->Documents->find()->where(['client_id' => $clientId, 'type_document' => 'estimate']);
            $parc_durees = $this->Ventes->Parcs->ParcDurees->findByParcId($venteEntity->parc_id)->find('list', ['valueField' => 'valeur']);
            $clients = $this->Clients->find('list')->where(['id' => $clientId]);

            $cp = $dataClient['client']['cp'] ?? '';
            $villesFrances = [];
            if ($cp) {
                $villesFrances = $this->VillesCodePostals->VillesFrances->find()->where(['ville_code_postal LIKE' => "%$cp%"])->find('list', [
                    'keyField' => 'ville_nom',
                    'valueField' => 'ville_nom'
                ])->toArray();

                if (!empty($clientEntity->ville) && empty($villesFrances)) {
                    $isVilleNotFinded = true;
                }
            }
            $this->set(@compact('clientEntity', 'documents_devis_clients', 'parc_durees', 'clients', 'villesFrances'));
        }
        // debug($venteEntity);

        $users = $this->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name']); // profile Konitys Commercial


        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            if (!isset($data['documents'])) {
                $data['documents']['_ids'] = [];
            }
            if (!isset($data['ventes_devis_uploads'])) {
                $data['ventes_devis_uploads'] = [];
            }

            if (empty($data['facturation_accord_signature_file']['name'])) {
                $data['facturation_accord_signature_file'] = $dataClient['facturation_accord_signature_file'] ?? '';
            } else {
                $facturation_accord_signature_file = $this->Upload->moveFiles($data['facturation_accord_signature_file'], ['path' => 'ventes'.DS.'accord_signatures']);
                $data['facturation_accord_signature_file'] = $facturation_accord_signature_file;
            }

            // debug($data);
            // die();
            $this->request->getSession()->write('vente_client', $data);

            if ($this->request->getQuery('save_directly_from_top_bottom')) {
                $this->recap('save');
            }
            return $this->redirect(['action' => 'materiel']);
        }

        // $this->loadComponent('SellsyApi');
        // debug($this->SellsyApi->getAllCustomersList());
        // die();

        $groupeClients = $this->Ventes->GroupeClients->find('list')->order(['nom' => 'asc']);
        $secteursActivites = $this->Clients->SecteursActivites->find('list')->order(['name' => 'asc']);
        $this->set(@compact('secteursActivites', 'isVilleNotFinded', 'payss', 'dataClient', 'contactTypes', 'genres', 'read', 'vente_mode', 'groupeClients', 'modemarker', 'facturation_achat_type', 'clientsContacts', 'entity_jurids', 'yes_or_no', 'venteEntity', 'users', 'clients',  'is_agency', 'parcs'));
    }

    public function edit($id)
    {
        $this->reset();
        
        $venteData = $this->Ventes->findById($id)->find('complete')->first()->toArray();
        $venteData['id'] = $id;

        $this->loadComponent('Vente');

        $this->Vente->putInSession('vente_client', $venteData, ["client", "is_sous_location", "is_client_belongs_to_group", "groupe_client_id", "user_id", "parc_id", "parc_duree_id", "client_name_notsellsy", "contrat_debut", "contrat_fin", "type_vente", "nb_mois", "client_id", "is_client_not_in_sellsy", "ventes_devis_uploads", "is_agence", "is_agence", "client_name", "proprietaire", "contact_client_id", "commercial_fullname", "commercial_email", "commercial_telmobile", "commercial_telfixe", "client_nom", "client_prenom", "client_email", "client_adresse", "client_addr_lat", "client_addr_lng", "facturation_entity_jurid", "facturation_cp", "facturation_ville", "facturation_date_signature", "facturation_accord_signature_file", "facturation_achat_type", "facturation_achat_type", "facturation_other_society_name", "facturation_other_adress", "facturation_other_cp", "facturation_other_ville", "facturation_other_tel", "facturation_other_email", "facturation_montant_ht", "is_allow_to_communicate_achat", "is_allow_to_communicate_achat", "documents", "client_telephone", "client_cp" ,"client_ville","client_pays"]);
        $this->Vente->putInSession('vente_materiel', $venteData, ["equipements_accessoires_ventes", "equipements_protections_ventes", "checked_accessories", "is_accessoires", "ventes_accessoires", "ventes_type_consommables", "equipement_imp_id", "is_without_imprimante", "is_without_imprimante", "gamme_borne_id", "model_borne_id", "couleur_borne_id", "equipement_apn_id", "type_equipement_id", "is_valise_transport", "is_housse_protection", "is_marque_blanche", "is_marque_blanche", "is_custom_gravure", "is_custom_gravure", "gravure_note", "logiciel", "materiel_note", "equipement_ventes"]);
        $this->Vente->putInSession('vente_options_consommables', $venteData, ["checked_consommables", "ventes_sous_consommables", "is_carton_bobine", "materiel_other_note"]);
        $this->Vente->putInSession('vente_briefprojet', $venteData, ["vente_crea_contact_client_id", "is_contact_crea_different_than_contact_client", "contact_crea_fullname", "contact_crea_lastname", "contact_crea_fonction", "contact_crea_email", "contact_crea_telmobile", "contact_crea_telfixe", "contact_crea_note", "config_crea_note"]);
        $this->Vente->putInSession('vente_livraison', $venteData, ["livraison_type_date", "livraison_pays_id", "livraison_client_adresse", "livraison_contact_note", "vente_livraison_contact_client_id", "livraison_crea_fonction", "livraison_crea_lastname", "livraison_is_as_soon_as_possible", "livraison_date", "is_livraison_different_than_contact_client", "livraison_crea_fullname", "livraison_crea_email", "livraison_crea_telmobile", "livraison_crea_telfixe", "is_livraison_adresse_diff_than_client_addr", "livraison_is_client_livr_adress", 'livraison_client_ville', 'livraison_client_cp', "livraison_date_first_usage", "livraison_infos_sup"]);

        // debug($this->request->getSession()->read('vente_client'));
        // die();

        $this->request->getSession()->write('vente_id', $id);
        $this->request->getSession()->write('vente_mode', 'edition');

        return $this->redirect(['action' => 'add']);
    }

    public function majState($vente_id)
    {
        $venteEntity = $this->Ventes->findById($vente_id)->first();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $this->loadComponent('Upload');
            // debug($data);
            // die();
            $bon_de_livraison = $this->Upload->moveFiles($data['bon_de_livraison'], ['path' => 'ventes'.DS.'bons_de_livraison']);
            $data['bon_de_livraison'] = $bon_de_livraison;

            if ($venteEntity->bon_de_livraison && empty($data['bon_de_livraison'])) unset($data['bon_de_livraison']);
            
            $venteEntity = $this->Ventes->patchEntity($venteEntity, $data, ['validate' => false]);

            if(!$venteEntity->getErrors()) {
                $this->Ventes->save($venteEntity);
                $this->Flash->success("Mise à jour réussie");
            }
            return $this->redirect($this->referer());
        }
    }
    
    public function venteToBorne($venteId){
        
        if($this->request->is(['patch', 'post', 'put'])){
            $data = $this->request->getData();
            $vente = $this->Ventes->get($venteId, [
                'contain' =>['Clients' => 'ClientContacts', 'VentesAccessoires', 'EquipementVentes', 'EquipementsProtectionsVentes']
            ]);
            
            if($vente->parc_id){

                $client = false;
                if($vente->client_id == null) {
                    // create client in table client
                    $this->loadModel('Clients');
                    $dataClients = [
                        'nom' => $vente->client_name_notsellsy,
                        'adresse' => $vente->client_adresse,
                        'email' => $vente->client_email,
                        'addr_lat' => $vente->client_addr_lat,
                        'addr_lng' => $vente->client_addr_lng,
                    ];

                    $newClient = $this->Clients->newEntity($dataClients, ['validate' => false]);
                    $client = $this->Clients->save($newClient);
                }

                if($client || ($vente->client != null && count($vente->client->client_contacts) == 0)){

                        $this->loadModel('ClientContacts');
                        // create contact in table contact
                        $dataContact = [
                                'non' => $vente->client_nom,
                                'prenon' => $vente->client_prenom,
                                'tel' => $vente->contact_crea_telmobile,
                                'email' => $vente->contact_crea_email,
                                'client_id' => $vente->client_id?$vente->client_id:($client?$client->id:null),
                        ];
                        $newContact = $this->ClientContacts->newEntity($dataContact,['validate' => false]);
                        $this->ClientContacts->save($newContact);
                }


                // Mise à jour des équipements de la borne
                $borneEntity = $this->Ventes->Bornes->findById($data['borne_id'])->contain(['EquipementBornes' => function ($q)
                {
                    return $q->hydrate(false);
                }, 'BornesAccessoires', 'EquipementsProtectionsBornes' => ['Equipements', 'TypeEquipements' => 'Equipements']])->first();

                if ($borneEntity) {

                    // rapporter les modifications de la vente vers la borne lors de l'affectation de celle-ci à la vente cf. équipements & protections
                    $equipementsBornesVentesData = [];

                    if ($vente->equipement_ventes) {
                        $equipmentsFromVentes = collection($vente->equipement_ventes);
                        foreach ($borneEntity->equipement_bornes as $key => $equipementBorne) {
                            if ($findedEqpmtBorneFromVente = $equipmentsFromVentes->firstMatch(['type_equipement_id' => $equipementBorne['type_equipement_id']])) {
                                $equipementsBornesVentesData[] = [
                                    'id' => $equipementBorne['id'],
                                    'equipement_id' => $findedEqpmtBorneFromVente['equipement_id'],
                                    'type_equipement_id' => $findedEqpmtBorneFromVente['type_equipement_id'],
                                    'aucun' => $findedEqpmtBorneFromVente['aucun'],
                                ];
                            }
                        }
                    }

                    // ------------- à supprimer si pas utile --------------
                    // $equipementsProtectionsBornesVentesData = [];
                    // $equipmentsProtectionsFromBorne = collection($borneEntity->equipements_protections_bornes);
                    

                    // foreach ($vente->equipements_protections_ventes as $key => $equipementsProtectionsVente) {
                    //     unset($equipementsProtectionsVente->id);

                    //     if ($findedEquipmentProtectionBorne = $equipmentsProtectionsFromBorne->firstMatch(['type_equipement_id' => $equipementsProtectionsVente['type_equipement_id']])) {
                    //         $equipementsProtectionsBornesVentesData[] = [
                    //             'id' => $findedEquipmentProtectionBorne['id'],
                    //             'equipement_id' => $equipementsProtectionsVente['equipement_id'],
                    //             'type_equipement_id' => $equipementsProtectionsVente['type_equipement_id'],
                    //             'qty' => $equipementsProtectionsVente['qty'],
                    //         ];
                    //     }
                    // }

                    $equipementsProtectionsBornesVentesData = [];
                    $this->Ventes->Bornes->EquipementsProtectionsBornes->deleteAll(['borne_id' => $borneEntity->id]);
                    foreach ($vente->equipements_protections_ventes as $key => $equipementsProtectionsVente) {
                        $equipementsProtectionsBornesVentesData[] = [
                            'borne_id' => $borneEntity->id,
                            'type_equipement_id' => $equipementsProtectionsVente->type_equipement_id,
                            'equipement_id' => $equipementsProtectionsVente->equipement_id,
                            'qty' => $equipementsProtectionsVente->qty,
                        ];
                    }



                    $borneData = [
                        'couleur_id' => $vente->couleur_borne_id,
                        'model_borne_id' => $vente->model_borne_id,
                        'equipement_bornes' => $equipementsBornesVentesData,
                        'equipements_protections_bornes' => $equipementsProtectionsBornesVentesData
                    ];

                    // ----------------------------------- FIN modifs équipements & protections ---------------------------------------------------

                    $borneEntity = $this->Ventes->Bornes->patchEntity($borneEntity, $borneData/*, ['associated' => ['ModelBornes.GammesBornes']]*/);
                    // $this->Ventes->Bornes->save($borneEntity);
                    // debug($borneData);
                    // die();

                    // debug($vente);
                    // die();

                    // debug($vente);
                    // debug($borneEntity);
                    // die();
                }
                
                if($borneEntity) {
                    $dataAccessoires = [];

                    if($borneEntity->bornes_accessoires) {
                        $bornes_accessoires_ids = collection($borneEntity->bornes_accessoires)->extract('id')->toArray();
                        $this->Ventes->Bornes->BornesAccessoires->deleteAll(['id IN ' => $bornes_accessoires_ids]);
                    }

                    foreach ($vente->ventes_accessoires as $ventes_accessoires) {
                        $dataAccessoires[] = [
                            'accessoire_id' => $ventes_accessoires->accessoire_id,
                            'sous_accessoire_id' => $ventes_accessoires->sous_accessoire_id,
                            'qty' => $ventes_accessoires->qty,
                            'note' => $ventes_accessoires->note
                        ];
                    }
                    $patchData = [
                        'parc_id' => $vente->parc_id,
                        'client_id' => $vente->client_id?$vente->client_id:($client?$client->id:null),
                        'checked_accessories' => $vente->checked_accessories,
                        'bornes_accessoires' => $dataAccessoires
                    ];

                    $patchData['is_sous_louee'] = $vente->is_sous_location;
                    $borneEntity = $this->Ventes->Bornes->patchEntity($borneEntity, $patchData,['validate' => false]);
                    $this->Ventes->Bornes->save($borneEntity);
                    $this->Flash->success("La borne a bien été affectée");

                }
                
                $ventes = TableRegistry::getTableLocator()->get('Ventes');
                $query = $ventes->query();
                $query->update()
                ->set([
                    'borne_id' => $data['borne_id']
                ])
                ->where(['id' => $venteId])
                ->execute();

            }else {
                $this->Flash->error('Aucun type de vente associé, veuillez l\'ajouter dans la fiche vente.');
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    public function addContacts($vente_id = null)
    {
        $dataClient = $this->request->getSession()->read('vente_client');

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();


            $clientsContacts = $data['client_contacts'] ?? [];
            if (isset($data['client'])) { // certains formulaires ont ce clé
                $clientsContacts = $data['client']['client_contacts'] ?? [];
            }


            $contacts = [];
            foreach ($clientsContacts as $key => $clientsContact) {
                if (is_int($key) && array_filter($clientsContact)) {
                    $contacts[] = $clientsContact;
                }
            }

            $dataClient['client']['client_contacts'] = $contacts;

            foreach ($contacts as $key => $clientContact) {
                // si -- direct save
                // $clientContactEntity = $this->Clients->ClientContacts->newEntity();
                // if ($clientContact['id']) {
                //     $clientContactEntity = $this->Clients->ClientContacts->findById($clientContact['id'])->first();
                // }

                // $this->Clients->ClientContacts->save($clientContactEntity, ['validate' => false]);

                // Src Probleme : si nouvelle vente et rajouter des contacts, 
                $this->request->getSession()->write('vente_client.client.client_contacts.'.$key, $clientContact);
                // $this->request->getSession()->write('vente_briefprojet.client.client_contacts.'.$key, $clientContact);
            }

            // si l'action mettre à jour les contacts a été cliquée, à supprimer 
            // if ($this->request->is('ajax')) {
            //     $this->request->getSession()->write('vente_briefprojet.is_contact_crea_different_than_contact_client', 1);
            //     $body = $this->request->getSession()->read('vente_client.client.client_contacts');
            //     return $this->response->withType('application/json')->withStringBody(json_encode($body));
            // }
        
            $this->Flash->success("Informations contacts ajoutées");
            return $this->redirect($this->referer());
        }
        die('lol');
    }

    public function materiel()
    {
        $dataClient = $this->request->getSession()->read('vente_client');
        // debug($dataClient);
        // die();
        $vente_mode = $this->vente_mode;
        $vente_id = $this->vente_id;

        // $dataClient = $this->request->getSession()->delete('vente_materiel');
        if (!$dataClient) {
            $this->Flash->error('Veuillez remplir le formulaire à l\'étape client et facturation');
            return $this->redirect(['action' => 'add']);
        }

        $yes_or_no = Configure::read('yes_or_no');
        $venteEntity = $this->Ventes->newEntity();

        if ($dataMateriel = $this->request->getSession()->read('vente_materiel')) {
            $venteEntity = $this->Ventes->newEntity($dataMateriel);
        }

        if ($vente_mode == 'edition') {
            $ventesAccessoires = $this->Ventes->VentesAccessoires->findByVenteId($vente_id);
            $vente = $this->Ventes->findById($vente_id)->contain(['EquipementsProtectionsVentes', 'EquipementsAccessoiresVentes'])->first();
            $venteEntity = $this->Ventes->patchEntity($venteEntity, $dataMateriel);
        }

        if ($venteEntity->equipements_accessoires_ventes) {
            foreach ($venteEntity->equipements_accessoires_ventes as $key => $equipementsAccessoiresVente) {
                $equipementsAccessoiresVente->type_equipement = $this->TypeEquipements->findById($equipementsAccessoiresVente->type_equipement_id)->first();
                $equipementsAccessoiresVente->type_equipement->equipements = $this->TypeEquipements->Equipements->findByTypeEquipementId($equipementsAccessoiresVente->type_equipement_id)->toArray();
            }
        }

        if ($venteEntity->equipements_protections_ventes) {
            foreach ($venteEntity->equipements_protections_ventes as $key => $equipementProtectionsVente) {
                $equipementProtectionsVente->type_equipement = $this->TypeEquipements->findById($equipementProtectionsVente->type_equipement_id)->first();
                $equipementProtectionsVente->type_equipement->equipements = $this->TypeEquipements->Equipements->findByTypeEquipementId($equipementProtectionsVente->type_equipement_id)->toArray();
            }
        }

        if ($venteEntity->gamme_borne_id) {
            $gamme_borne_id = $venteEntity->gamme_borne_id;

            $typeEquipementsPieds = $this->TypeEquipements->find('list', ['valueField' => 'nom'])->find('byGamme')->where(['TypeEquipements.id IN' => [3,9], 'TypeEquipementsGammes.gamme_borne_id' => $gamme_borne_id]);
            $modelBornes = $this->Bornes->ModelBornes->find('list', ['valueField' => 'nom'])->order(['nom' => 'ASC'])->where(['ModelBornes.gamme_borne_id' => $gamme_borne_id]);

            $accessoires = $this->Ventes->VentesAccessoires->Accessoires
                ->find()
                ->contain(['SousAccessoires' => 'SousAccessoiresGammes'])
                ->matching('SousAccessoires.SousAccessoiresGammes')
                ->where(['SousAccessoiresGammes.gamme_borne_id' => $dataMateriel['gamme_borne_id']])
                ->group('Accessoires.id')
            ;

            $this->set(@compact('typeEquipementsPieds', 'gamme_borne_id', 'modelBornes', 'accessoires'));
        }

        // debug($venteEntity);


        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            // debug($data);
            // die();

            $this->request->getSession()->write('vente_materiel', $data);
            if ($this->request->getQuery('save_directly_from_top_bottom')) {
                $this->recap('save');
            }
            return $this->redirect(['action' => 'optionsConsommables']);
        }


        $gammesBornes = $this->Bornes->GammesBornes->find('list')->order(['name' => 'ASC']);
        $couleurBornes = $this->Bornes->Couleurs->find('list', ['valueField' => 'couleur'])->order(['couleur' => 'ASC']);
        $typeEquipementsAppPhotos = $this->Bornes->Equipements->TypeEquipements->find('list', ['valueField' => 'nom'])->find('byGamme')->where(['TypeEquipements.id IN' => [2,8]]);
        $equipements = $this->Bornes->Equipements->find('list', ['valueField' => 'valeur', 'groupField' => 'type_equipement_id'])->toArray();
        $typeEquipementsAccessoires = $this->Bornes->Equipements->TypeEquipements->findByIsAccessoire(1)->contain(['Equipements']);
        $typeEquipementsProtections = $this->Bornes->Equipements->TypeEquipements->findByIsProtection(1)->contain(['Equipements']);
        $equipement_ventes = $dataMateriel ? ($dataMateriel['equipement_ventes'] ?? null) : null;
        $gamme = null;
        if ($venteEntity->gamme_borne_id) {
            $gamme = $this->Bornes->GammesBornes->find('all')->where(['GammesBornes.id' => $venteEntity->gamme_borne_id])->contain(['TypeEquipements' => function ($q) {return $q->where(['TypeEquipements.is_structurel' => 1, 'TypeEquipements.is_vente' => 1]);}])->first();
        }
        $parcs = $this->Parcs->find('list', ['valueField' => 'nom']);

        $this->set(@compact('parcs', 'typeEquipementsProtections', 'typeEquipementsAccessoires', 'ventesAccessoires', 'gamme', 'equipements', 'equipement_ventes', 'typeEquipementsAccessoires', 'ventesAccessoires', 'venteEntity', 'gammesBornes', 'modelBornes', 'couleurBornes', 'yes_or_no', 'equipementsImprimantes', 'typeConsommables', 'typeEquipementsAppPhotos'));
    }

    public function optionsConsommables()
    {
        $this->loadModel('TypeConsommables');
        $dataMateriel = $this->request->getSession()->read('vente_materiel');
        $typeConsommables = $this->TypeConsommables->find()->contain(['SousTypesConsommables'])->toArray();

        if (!$dataMateriel) {
            $this->Flash->error('Veuillez remplir le formulaire à l\'étape matériel');
            return $this->redirect(['action' => 'materiel']);
        }

        $venteEntity = $this->Ventes->newEntity();
        if ($dataBriefProjet = $this->request->getSession()->read('vente_options_consommables')) {
            $venteEntity = $this->Ventes->newEntity($dataBriefProjet);
            $ventesSousConsommables = $this->Ventes->VentesSousConsommables->findByVenteId($this->vente_id);
            $typeConsommablesList = $this->TypeConsommables->find('list')->toArray();
            $this->set(@compact('ventesSousConsommables', 'typeConsommablesList'));
        }

        // debug($venteEntity);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            $this->request->getSession()->write('vente_options_consommables', $data);
            if ($this->request->getQuery('save_directly_from_top_bottom')) {
                $this->recap('save');
            }
            return $this->redirect(['action' => 'briefProjet']);
        }

        $this->set(@compact('venteEntity', 'typeConsommables'));
    }

    public function briefProjet()
    {
        $venteOptionsConsommables = $this->request->getSession()->read('vente_options_consommables');
        $contactTypes = $this->Clients->ClientContacts->ContactTypes->find('list');

        if (!$venteOptionsConsommables) {
            $this->Flash->error('Veuillez remplir le formulaire à l\'étape vente options / consommables');
            return $this->redirect(['action' => 'optionsConsommables']);
        }


        $venteClient = $this->request->getSession()->read('vente_client');
        // debug($venteClient);
        // die();

        $venteEntity = $this->Ventes->newEntity();
        $venteEntity = $this->Ventes->patchEntity($venteEntity, $venteClient, ['validate' => false, 'associated' => ['Clients.ClientContacts']]);

        $clientId = isset($venteClient['client_id']) ? $venteClient['client_id'] : null;
        $clientEntity = $this->Clients->findById($clientId)->contain(['ClientContacts'])->first();
        

        if ($dataBriefProjet = $this->request->getSession()->read('vente_briefprojet')) {
            $venteEntity = $this->Ventes->patchEntity($venteEntity, $dataBriefProjet, ['validate' => false, 'associated' => ['Clients.ClientContacts']]);
            if (isset($dataBriefProjet['vente_crea_contact_client_id'])) {
                $venteEntity->set('vente_crea_contact_client_id', $dataBriefProjet['vente_crea_contact_client_id']);
            }
        }

        $clientContacts = [];

        if (!empty($clientEntity->client_contacts)) {
            $clientContacts = collection($clientEntity->client_contacts)->filter(function ($r)
            {
                return !empty(trim($r->full_name));
            })
            ->combine('id', 'full_name');
        }
        

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $newClientContact = $data['client']['client_contact'];
            $findedContact = collection($venteClient['client']['client_contacts'])->firstMatch(['is_from_crea' => 1]);

            if ($findedContact == null) {
                $lastKey = collection($venteClient['client']['client_contacts'] ?? [])->count();
                $niem = $lastKey+1;
                $newClientContact['key'] = $niem;
                if (!empty($newClientContact['nom']) && !empty($newClientContact['prenom']) && !empty($newClientContact['email'])) {
                    $this->request->getSession()->write('vente_client.client.client_contacts.'.$niem, $newClientContact);
                }
            } else {
                $newClientContact['key'] = $findedContact['key'];
                $this->request->getSession()->write('vente_client.client.client_contacts.'.$findedContact['key'], $newClientContact);
            }

            $this->request->getSession()->write('vente_briefprojet', $data);
            $this->request->getSession()->write('vente_briefprojet.vente_crea_contact_client_id', $data['vente_crea_contact_client_id']);
            // $this->request->getSession()->write('vente_client.client.client_contacts', $data['client']['client_contacts']);
            if ($this->request->getQuery('save_directly_from_top_bottom')) {
                $this->recap('save');
            }
            return $this->redirect(['action' => 'livraison']);
        }

        $this->set(@compact('venteEntity', 'clientEntity', 'contactTypes', 'clientContacts'));
    }

    public function livraison()
    {
        $typeVentes = Configure::read('typeVentes');
        $livraison_type_dates = Configure::read('livraison_type_date');
        $dataBriefProjet = $this->request->getSession()->read('vente_briefprojet');
        // $dataBriefProjet = $this->request->getSession()->delete('vente_livraison');
        if (!$dataBriefProjet) {
            $this->Flash->error('Veuillez remplir le formulaire à l\'étape créa et config');
            return $this->redirect(['action' => 'briefProjet']);
        }

        $venteClient = $this->request->getSession()->read('vente_client');
        // debug($venteClient);
        // die();
        $clientId = isset($venteClient['client_id']) ? $venteClient['client_id'] : null;
        $clientEntity = $this->Clients->findById($clientId)->contain(['ClientContacts'])->first();
        if ($clientEntity == null) {
            $clientEntity = $this->Clients->newEntity();
        }

        $venteEntity = $this->Ventes->newEntity();
        $venteEntity = $this->Ventes->patchEntity($venteEntity, $venteClient, ['validate' => false, 'associated' => ['Clients.ClientContacts']]);

        $clientContacts = [];
        if (!empty($clientEntity->client_contacts)) {
            $clientContacts = collection($clientEntity->client_contacts)->filter(function ($r)
            {
                return !empty(trim($r->full_name));
            })
            ->combine('id', 'full_name');
        }

        if ($dataLivraison = $this->request->getSession()->read('vente_livraison')) {
            $venteEntity = $this->Ventes->newEntity($dataLivraison);
            // debug($venteEntity);
            // die;
            if ($dataLivraison['livraison_date_first_usage'] == '') unset($venteEntity->livraison_date_first_usage);
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $newClientContact = $data['client']['client_contact'];
            $findedContact = collection($venteClient['client']['client_contacts'])->firstMatch(['is_from_livraison' => 1]);
            if ($findedContact == null) {
                $lastKey = collection($venteClient['client']['client_contacts'] ?? [])->count();
                $niem = $lastKey+1;
                $newClientContact['key'] = $niem;
                if (!empty($newClientContact['nom']) && !empty($newClientContact['prenom']) && !empty($newClientContact['email'])) {
                    $this->request->getSession()->write('vente_client.client.client_contacts.'.$niem, $newClientContact);
                }
                
            } else {
                $newClientContact['key'] = $findedContact['key'];
                $this->request->getSession()->write('vente_client.client.client_contacts.'.$findedContact['key'], $newClientContact);
            }
            $this->request->getSession()->write('vente_livraison', $data);
            if ($this->request->getQuery('save_directly_from_top_bottom')) {
                $this->recap('save');
            }
            return $this->redirect(['action' => 'recap']);
        }

        $clientData = $this->request->getSession()->read('vente_client');
        $payss = $this->Clients->Payss->find('listAsc');

        $this->set(@compact('livraison_type_dates', 'venteEntity', 'typeVentes', 'payss', 'clientData', 'clientEntity', 'clientContacts'));
    }


    public function saveOldNewClients()
    {
        $ventes = $this->Ventes->find('complete');
        foreach ($ventes as $vente) {

            $emptyClientContactData = [
                'nom' => '',
                'prenom' => '',
                'position is' => null,
                'email is' => null,
                'tel is' => null,
                'id_in_sellsy is' => null,
            ];

            if ($emptyClientContact = $this->Ventes->Clients->ClientContacts->find()->where($emptyClientContactData)->first()) {
                $this->Ventes->Clients->ClientContacts->delete($emptyClientContact);
            }

            $clientData = [
                'nom' => $vente->client_nom,
                'prenom' => $vente->client_prenom,
                'email' => $vente->client_email,
                'telephone' => $vente->client_telephone,
                'addr_lat LIKE' => $vente->client_addr_lat,
                'addr_lng LIKE' => $vente->client_addr_lng,
                'client_type' => 'corporation'
            ];

            $oldClient = $this->Ventes->Clients->find()->where($clientData)->first();
            if ($oldClient) {
                $clientData['nom'] = $vente->client_name_notsellsy;
                $clientData['main_contact'] = [
                    'nom' => $vente->client_nom,
                    'prenom' => $vente->client_prenom,
                    'email' => $vente->client_email,
                    'tel' => $vente->client_telephone,
                ];

                $oldClientContact = $this->Ventes->Clients->ClientContacts->find()->where($clientData['main_contact'])->first();
                if ($oldClientContact) {
                    $this->Ventes->Clients->ClientContacts->delete($oldClientContact);
                }

                if (!$oldClientContact) {
                    $client = $this->Ventes->Clients->patchEntity($oldClient, $clientData);
                    $client = $this->Ventes->Clients->save($client);
                    debug($client);
                }
            }

            // if ($vente->is_client_not_in_sellsy == true) {
            //     $clientData = [
            //         // client
            //         'nom' => $vente->client_name_notsellsy,
            //         'cp' => $vente->client_cp,
            //         'ville' => $vente->client_ville,
            //         'addr_lat' => $vente->client_addr_lat,
            //         'addr_lng' => $vente->client_addr_lng,
            //         // client_contact
            //         'main_contact' => [
            //             'nom' => $vente->client_name_notsellsy,
            //             'prenom' => $vente->client_prenom,
            //             'email' => $vente->client_email,
            //             'telephone' => $vente->client_telephone,
            //         ]
            //     ];
            //     if (!$this->Ventes->Clients->find()->where([
            //         'nom' => $vente->client_name_notsellsy,
            //         'cp' => $vente->client_cp,
            //         'ville' => $vente->client_ville,
            //         'addr_lat' => $vente->client_addr_lat,
            //         'addr_lng' => $vente->client_addr_lng
            //     ])->first()) { // évite les duplications
            //         $clientEntity = $this->Ventes->Clients->newEntity($clientData, ['validate' => false]);
            //         $this->Ventes->Clients->save($clientEntity);
            //     }
            // }



            // die();
        }

        exit();
    }

    public function recap($mode = null)
    {
        $dataLivraison = $this->request->getSession()->read('vente_livraison');
        $vente_mode = $this->request->getSession()->read('vente_mode');
        $vente_id = $this->request->getSession()->read('vente_id');
        if (!$dataLivraison) {
            $this->Flash->error('Veuillez remplir le formulaire à l\'étape livraison');
            return $this->redirect(['action' => 'livraison']);
        }

        $is_agency_template = Configure::read('is_agency_template');
        $livraison_type_dates = Configure::read('livraison_type_date');
        $entity_jurids = Configure::read('entity_jurids');
        $yes_or_no = Configure::read('yes_or_no');
        $genres = Configure::read('genres');
        $contactTypes = $this->Clients->ClientContacts->ContactTypes->find('list')->toArray();
        $yes_or_no_template = Configure::read('yes_or_no_template');
        $facturation_achat_type = Configure::read('facturation_achat_type');
        $sousTypesConsommables = $this->Ventes->VentesSousConsommables->SousTypesConsommables->find()->indexBy('id')->toArray();
        $sousAccessoires = $this->Ventes->VentesAccessoires->Accessoires->SousAccessoires->find()->indexBy('id')->toArray();
        $ventesAccessoires = $this->Ventes->VentesAccessoires->Accessoires->find()->indexBy('id')->toArray();

        $venteData = $this->getAllInfosVente();
        // debug($venteData);
        // die();

        // enlève les ids temporaires des contacts clients cf. brief-project
        if (isset($venteData['client']['client_contacts'])) {
            foreach ($venteData['client']['client_contacts'] as $key => $clientContact) {
                if (isset($clientContact['id'])) {
                    if (strpos($clientContact['id'], 'not_saved') !== false) {
                        unset($clientContact['id']);
                        $venteData['client']['client_contacts'][$key] = $clientContact;
                    }
                }
            }
        }

        $dataTypeParc = $this->setParcTypeOnClient($venteData);

        $associated = [
            'Clients' => ['validate' => false],
            'Clients.ClientContacts',
            'Clients.SecteursActivites',
            'VentesAccessoires',
            'VentesSousConsommables',
            'VentesDevisUploads',
            'Documents',
            'EquipementVentes',
            'EquipementsAccessoiresVentes' => ['Equipements', 'TypeEquipements' => 'Equipements'],
            'EquipementsProtectionsVentes' => ['Equipements', 'TypeEquipements' => 'Equipements'],
        ];

        
        if ($vente_mode != "edition") { /*Ajout*/
            $venteEntity = $this->Ventes->newEntity($venteData, [
                'validate' => false, 
                'associated' => $associated
            ]);

            

        } else { /*Edition*/
            $venteEntity = $this->Ventes->findById($vente_id)->find('complete')->first();
            $venteEntity = $this->Ventes->patchEntity($venteEntity, $venteData, ['validate' => false,
                'associated' => $associated
            ]);
        }

        if ($venteEntity->equipements_accessoires_ventes) {
            foreach ($venteEntity->equipements_accessoires_ventes as $key => $equipementsAccessoiresVente) {
                $equipementsAccessoiresVente->type_equipement = $this->TypeEquipements->findById($equipementsAccessoiresVente->type_equipement_id)->first();
                $equipementsAccessoiresVente->equipement = $this->TypeEquipements->Equipements->findById($equipementsAccessoiresVente->equipement_id)->first();
            }
        }

        if ($venteEntity->equipements_protections_ventes) {
            foreach ($venteEntity->equipements_protections_ventes as $key => $equipementsProtectionsVente) {
                $equipementsProtectionsVente->type_equipement = $this->TypeEquipements->findById($equipementsProtectionsVente->type_equipement_id)->first();
                $equipementsProtectionsVente->equipement = $this->TypeEquipements->Equipements->findById($equipementsProtectionsVente->equipement_id)->first();
            }
        }

        // debug($venteEntity->equipements_protections_ventes);
        // die();

        $secteurs_activites = $venteEntity->client->secteurs_activites;

        if ($venteEntity->is_client_not_in_sellsy == true) { // si nouveau client
            $venteEntity->client->isNew(true);
            $contacts = [];
            foreach ($venteEntity->client->client_contacts as $key => $clientContact) {
                if (is_int($clientContact->id)) {
                    $contacts[] = $clientContact;
                } else {
                    if (!$clientContact->get('IsInfosEmpty')) {
                        $clientContact->portable = $clientContact->tel;
                        $contacts[] = $clientContact;
                    }
                }
            }            

            $clientEntity = $venteEntity->client;
            if ($clientEntity) {
                $venteEntity->client = $clientEntity; // seulement pour les affichages
                $venteEntity->client->client_contacts = $contacts;
            }
        } else {
            $venteEntity->client->isNew(false);

            $clientEntity = $this->Clients->findById($venteEntity->client->id)->first();

            $contacts = [];
            foreach ($venteEntity->client->client_contacts as $key => $clientContact) {
                // debug($clientContact);
                if (!empty($clientContact->full_name)) {
                    if (is_int($clientContact->id)) {
                        $clientContact->isNew(false);
                        $contacts[] = $clientContact;
                    } else {
                        $contacts[] = $clientContact;
                    }
                }

            }            

            if ($clientEntity) {
                $venteEntity->client = $clientEntity; // seulement pour les affichages
                $venteEntity->client->client_contacts = $contacts;
            }
        }

        if ($secteurs_activites) {
            $venteEntity->client->secteurs_activites = $secteurs_activites;
        }

        // pour affichage mail
        if ($venteEntity->gamme_borne_id) {
            $venteEntity->gamme_borne = $this->Ventes->GammesBornes->findById($venteEntity->gamme_borne_id)->first();
        }
        if ($venteEntity->user_id) {
            $venteEntity->user = $this->Ventes->Users->findById($venteEntity->user_id)->first();
        }
        if ($venteEntity->model_borne_id) {
            $venteEntity->model_borne = $this->Ventes->GammesBornes->ModelBornes->findById($venteEntity->model_borne_id)->first();
        }
        if ($venteEntity->parc_id) {
            $venteEntity->parc = $this->Ventes->Parcs->findById($venteEntity->parc_id)->first();
        }

        if ($venteEntity->parc_duree_id) {
            $venteEntity->parc_duree = $this->Ventes->ParcDurees->findById($venteEntity->parc_duree_id)->first();
            if ($venteEntity->contrat_debut) {
                $venteEntity->contrat_fin = $venteEntity->contrat_debut->addMonth($venteEntity->parc_duree->get('Duree'));
            }
        }

        if ($venteEntity->parc_id) {
            $venteEntity->parc = $this->Ventes->Parcs->findById($venteEntity->parc_id)->first();
        }

        if ($venteEntity->client->pays_id) {
            $venteEntity->client->pays = $this->Ventes->Clients->Payss->findById($venteEntity->client->pays_id)->first();
        }

        if ($venteEntity->client->pays_id) {
            $venteEntity->client->pays = $this->Ventes->Clients->Payss->findById($venteEntity->client->pays_id)->first();
        }

        if ($venteEntity->livraison_pays_id) {
            $venteEntity->livraison_pays = $this->Ventes->Clients->Payss->findById($venteEntity->livraison_pays_id)->first();
        }

        // debug($venteData);
        // debug($venteEntity);
        // die();
        if ($mode == 'save') {
            if(!$venteEntity->getErrors()) {
                if ($venteEntity = $this->Ventes->save($venteEntity)) {
                    // debug($venteEntity);
                    // die();
                    $this->reset(false);

                    if ($vente_mode != 'edition') { 
                        // --------------- envoi Email ------------------

                        $this->loadModel('Emails');
                        $options = [
                            'test' => false,
                            'from' => 'Konitys',
                            'fromEmail' => 's.mahe@konitys.fr',
                            'subject' => 'Nouvelle acquisition '. ($venteEntity->gamme_borne ? '('.$venteEntity->gamme_borne->name.')' : '') .' '. $venteEntity->parc->abreviation. ' : '.$venteEntity->client->get('FullName'),
                            'template' => 'vente_crea',
                        ];

                        $optionsCompta = [
                            'test' => false,
                            'from' => 'Konitys',
                            'fromEmail' => 's.mahe@konitys.fr',
                            'subject' => 'Nouvelle acquisition '. ($venteEntity->gamme_borne ? '('.$venteEntity->gamme_borne->name.')' : '') .' '. $venteEntity->parc->abreviation. ' : '.$venteEntity->client->get('FullName').', est créée et est à facturer',
                            'template' => 'vente_crea'
                        ];

                        $host = $this->request->getEnv('HTTP_HOST');
                        if ($host != '127.0.0.1') { /*Temporaire*/
                        // if (true) { /*Temporaire*/
                            $email = $this->Emails->sendTo(['email' => 'logistique@konitys.fr', 'bcc' => ['m.constantin@konitys.fr', 's.mahe@konitys.fr', 'andriam.nars@gmail.com'], 'venteEntity' => $venteEntity], $options/*, $attachmentsOptions*/);
                            // $email = $this->Emails->sendTo(['email' => 'andriam.nars@gmail.com', 'venteEntity' => $venteEntity], $options/*, $attachmentsOptions*/);
                            // echo ($email['message']); die;

                            // on va envoyer un email au service compta de chez nous, qd le formulaire de vente est soumis, et que c'est une vente qui est en "achat direct"
                            if ($venteEntity->parc_id == 1) {
                                // envoi email users konitys compta
                                $konitysComptaUsers = $this->Users->find('filtre', ['group_user' => 4]);

                                if ($konitysComptaUsers->count() > 0) {
                                    $comptaMainEmail = $konitysComptaUsers->buffered()->first()->get('email');
                                    $comptaBccEmails = $konitysComptaUsers->buffered()->skip(1)->extract('email')->toList();

                                    $email = $emailToKonitysCompta = $this->Emails->sendTo(['email' => $comptaMainEmail, 'bcc' => $comptaBccEmails, 'venteEntity' => $venteEntity], $optionsCompta/*, $attachmentsOptions*/);
                                    // $email = $emailToKonitysCompta = $this->Emails->sendTo(['email' => 'andriam.nars@gmail.com', 'venteEntity' => $venteEntity], $optionsCompta/*, $attachmentsOptions*/);
                                    // echo $email['message'];
                                    // die();
                                }

                            }

                            // die();

                            if ($email) {
                                $this->Flash->success('La fiche de vente a bien été créée');
                                return $this->redirect(['action' => 'index']);
                            }
                            // $this->set(@compact('email'));
                            // $this->render('/Email/html/email_test');

                        } else {
                            // en mode local 
                            $this->Flash->success('La fiche de vente a bien été créée');
                            return $this->redirect(['action' => 'index']);
                        }

                        // --------------- end Email ------------------
                    } else {
                        $this->Flash->success('La fiche de vente a bien été modifiée');
                        return $this->redirect(['action' => 'index']);
                    }
                } else {
                    debug($venteEntity->getErrors());
                    die();
                }
            } else {
                debug($venteEntity->getErrors());
                die();
            }
        }

        $userEntity = $this->Users->findById($venteEntity->user_id)->first();
        $clientEntity = $this->Clients->findById($venteEntity->client_id)->first();

        $parc_durees = $this->Ventes->Parcs->ParcDurees->findByParcId($venteEntity->parc_id)->find('list', ['valueField' => 'valeur'])->toArray();
        $parcs = $this->Ventes->Parcs->findById($venteEntity->parc_id)->find('list', ['valueField' => 'nom2'])->toArray();


        $gammesBornes = $this->Bornes->GammesBornes->find('list')->order(['name' => 'ASC'])->toArray();
        $modelBornes = $this->Bornes->ModelBornes->find('list', ['valueField' => 'nom'])->order(['nom' => 'ASC'])->toArray();
        $couleurBornes = $this->Bornes->Couleurs->find('list', ['valueField' => 'couleur'])->order(['couleur' => 'ASC'])->toArray();
        $equipements = $this->Bornes->Equipements->find('list', ['valueField' => 'valeur'])->toArray();
        $typesEquipements = $this->Bornes->Equipements->TypeEquipements->find('list')->toArray();

        if ($venteEntity->gamme_borne_id) {
            $gamme_borne_id = $venteEntity->gamme_borne_id;
            $this->loadModel('TypeEquipements');
            $typeEquipements = $this->TypeEquipements->find()/*->find('list', ['valueField' => 'nom'])*/;

            $typeEquipements
                ->contain(['TypeEquipementsGammes', 'Equipements'])
                ->matching('TypeEquipementsGammes')
                ->where(['TypeEquipementsGammes.gamme_borne_id' => $gamme_borne_id])
            ;

            // $equipementsApnInGammeBornes = collection(Hash::flatten($typeEquipements->extract('equipements')->toArray()))->combine('id', 'valeur');
            $equipementsApnInGammeBornes = $this->Bornes->Equipements->TypeEquipements->find('list', ['valueField' => 'nom'])->find('byGamme')->where(['TypeEquipements.id IN' => [2,8]]);
            $typeEquipements = $typeEquipements->combine('id', 'nom');

            $this->set(@compact('typeEquipements', 'gamme_borne_id', 'equipementsApnInGammeBornes'));
        }

        // debug($venteEntity);
        // die();

        $this->set(@compact('livraison_type_dates', 'contactTypes', 'genres', 'sousAccessoires', 'is_agency_template', 'yes_or_no_template', 'ventesAccessoires', 'sousTypesConsommables', 'parcs', 'facturation_achat_type', 'venteEntity', 'userEntity', 'clientEntity', 'yes_or_no', 'parc_durees', 'nbMois', 'is_agency', 'entity_jurids', 'gammesBornes', 'modelBornes', 'couleurBornes', 'equipements', 'typesEquipements'));
    }

    public function getAllInfosVente()
    {
        $vente_client = $this->request->getSession()->read('vente_client');
        if ($vente_client['parc_id'] == 4) {
            $vente_client['client']['is_location_financiere'] = 1;
        }
        if ($vente_client['parc_id'] == 9) {
            $vente_client['client']['is_location_lng_duree'] = 1;
        }
        if ($vente_client['parc_id'] == 10) {
            $vente_client['client']['is_borne_occasion'] = 1;
        }
        if ($vente_client['parc_id'] == 1) {
            $vente_client['client']['is_vente'] = 1;
        }

        $vente_materiel = $this->request->getSession()->read('vente_materiel');
        $vente_options_consommables = $this->request->getSession()->read('vente_options_consommables');
        $vente_livraison = $this->request->getSession()->read('vente_livraison');
        $vente_briefprojet = $this->request->getSession()->read('vente_briefprojet');

        $infosVenteData = Hash::merge($vente_client ?? [] , $vente_materiel ?? [] ,$vente_options_consommables ?? [], $vente_livraison ?? [] , $vente_briefprojet ?? []);
        return $infosVenteData;
    }

    public function reset($mode = false)
    {
        $this->request->getSession()->delete('vente_client');
        $this->request->getSession()->delete('vente_materiel');
        $this->request->getSession()->delete('vente_livraison');
        $this->request->getSession()->delete('vente_briefprojet');
        $this->request->getSession()->delete('vente_options_consommables');
        $this->request->getSession()->delete('vente_mode');
        $this->request->getSession()->delete('vente_id');

        if ($mode == true) {
            $this->response = $this->redirect(['action' => 'add']);
            $this->response->send();
            exit();
        }

        return;
    }

    protected function essaiEnvoi($venteEntity)
    {
        $options = [
            'test' => true,
            'from' => 'Konitys',
            'fromEmail' => 's.mahe@konitys.fr',
            'subject' => 'Fiche de vente créée',
            'template' => 'vente_crea',
        ];
        $this->loadModel('Emails');
        $email = $this->Emails->sendTo(['email' => 'andriam.nars@gmail.com', 'venteEntity' => $venteEntity], $options/*, $attachmentsOptions*/);
        echo $email['message'];
        die();
    }

    public function view($id)
    {
        $venteEntity = $this->Ventes->findById($id)->find('complete')->first();
        $bornes = $this->Ventes->Bornes->find('ListForVentes')->toArray();

        if(! $venteEntity) {
            $this->Flash->error(__('Vente incomplete, veuillez compléter s\'il vous plait.'));
            return $this->redirect(['action' => 'add', $id]);
        }
        
        $parc_durees = $this->Ventes->Parcs->ParcDurees->findByParcId($venteEntity->parc_id)->find('list', ['valueField' => 'valeur'])->toArray();
        $parcs = $this->Ventes->Parcs->findById($venteEntity->parc_id)->find('list', ['valueField' => 'nom'])->toArray();
        $sousTypesConsommables = $this->Ventes->VentesSousConsommables->SousTypesConsommables->find()->indexBy('id')->toArray();
        $sousAccessoires = $this->Ventes->VentesAccessoires->Accessoires->SousAccessoires->find()->indexBy('id')->toArray();
        $ventesAccessoires = $this->Ventes->VentesAccessoires->Accessoires->find()->indexBy('id')->toArray();

        $is_agency = Configure::read('is_agency');
        $entity_jurids = Configure::read('entity_jurids');
        $yes_or_no = Configure::read('yes_or_no');
        $is_agency_template = Configure::read('is_agency_template');
        $yes_or_no_template = Configure::read('yes_or_no_template');
        $genres = Configure::read('genres');
        $facturation_achat_type = Configure::read('facturation_achat_type');
        $contactTypes = $this->Clients->ClientContacts->ContactTypes->find('list')->toArray();
        $livraison_type_dates = Configure::read('livraison_type_date');
        $vente_etat_facturations = Configure::read('vente_etat_facturation');

        $userEntity = $this->Users->findById($venteEntity->user_id)->first();
        $clientEntity = $this->Clients->findById($venteEntity->client_id)->first();

        $gammesBornes = $this->Bornes->GammesBornes->find('list')->order(['name' => 'ASC'])->toArray();
        $modelBornes = $this->Bornes->ModelBornes->find('list', ['valueField' => 'nom'])->order(['nom' => 'ASC'])->toArray();
        $couleurBornes = $this->Bornes->Couleurs->find('list', ['valueField' => 'couleur'])->order(['couleur' => 'ASC'])->toArray();
        $equipements = $this->Bornes->Equipements->find('list', ['valueField' => 'valeur'])->toArray();
        $typesEquipements = $this->Bornes->Equipements->TypeEquipements->find('list')->toArray();

        if ($venteEntity->gamme_borne_id) {
            $gamme_borne_id = $venteEntity->gamme_borne_id;
            $this->loadModel('TypeEquipements');
            $typeEquipements = $this->TypeEquipements->find()/*->find('list', ['valueField' => 'nom'])*/;

            $typeEquipements
                ->contain(['TypeEquipementsGammes', 'Equipements'])
                ->matching('TypeEquipementsGammes')
                ->where(['TypeEquipementsGammes.gamme_borne_id' => $gamme_borne_id])
            ;

            // $equipementsApnInGammeBornes = collection(Hash::flatten($typeEquipements->extract('equipements')->toArray()))->combine('id', 'valeur');
            $equipementsApnInGammeBornes = $this->Bornes->Equipements->TypeEquipements->find('list', ['valueField' => 'nom'])->find('byGamme')->where(['TypeEquipements.id IN' => [2,8]]);
            $typeEquipements = $typeEquipements->combine('id', 'nom');

            $this->set(@compact('typeEquipements', 'gamme_borne_id', 'equipementsApnInGammeBornes'));
        }

        $vente_statuts = Configure::read('vente_statut');
        $this->set(@compact('livraison_type_dates', 'genres', 'bornes', 'contactTypes', 'vente_etat_facturations', 'sousAccessoires', 'is_agency_template', 'yes_or_no_template', 'sousTypesConsommables', 'gammesBornes', 'modelBornes', 'couleurBornes', 'ventesAccessoires', 'equipements', 'userEntity', 'clientEntity', 'venteEntity', 'parc_durees', 'parcs', 'is_agency', 'entity_jurids', 'yes_or_no', 'facturation_achat_type','vente_statuts', 'typesEquipements'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vente = $this->Ventes->get($id);
        if ($this->Ventes->delete($vente)) {
            $this->Flash->success(__('The sale has been deleted.'));
        } else {
            $this->Flash->error(__('The sale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function convertSellsyPdfToDsiplayable()
    {
        $http = new \Cake\Http\Client();
        $url = $this->request->getQuery('url');
        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $parsedQuery);
            if (isset($parsedQuery['id'])) {
                $id = $parsedQuery['id'];
                $buildSellsyFileUrl = "https://file.sellsy.com?id=$id";
                return $this->response->withType('application/pdf')->withStringBody($http->get("https://file.sellsy.com/?id=JUQ4RiVEQm0lMTIyJUNGJUVFJTlEJUNGJThBJUJEJUMwJUVCJThBJUI5JTA5JUQ1JUQzJUUzJUVGJTJBJTE0UyVFNTEyZ3MyJUIzJTlCJUIxJUJDJTNBJTNERCU1QyUxNUYlMUQlRTclRTFUJUQwJUNCKyVGMyVFNCUyQSUyNCUxQiVGRCVFOCVCNyUyQW5lJUE1XyU5NkolOTklRDRuYSVEOCVDRCUzQiUxMSUyMSVGRCVFMyU5OSUzQiU3RSUyMyVCMCVDMSUxNyVBMnYlRUElQUZXJUE5SyVCMiVGQiVERWYlREYlMkYlRTAxJUNE")->body);
            }
        }

        return $this->response;
    }

    public function clean()
    {
        $ventes = $this->Ventes->find();
        foreach ($ventes as $key => $vente) {
            $this->Ventes->delete($vente);
        }

        die();
    }
    
    public function dashboard() {
        
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $periode = TableRegistry::getTableLocator()->get('Periodes');
            $periode->query()->update()
            ->set($data)
            ->where(['id' => 1])
            ->execute();
        }
        $mois = ['01' => 'Janvier','02' => 'Février','03' => 'Mars','04' => 'Avril','05' => 'Mai','06' => 'Juin','07' => 'Jullet','08' => 'Août','10' => 'Septembre','11' => 'Octobre','11' => 'Novembre','12' => 'Décembre'];
        $annees = ['18' => '2018','19' => '2019','20' => '2020'];
        $periodeString = "Periode : ";
        
        $mensuel = null;
        $annuel = null;
        $dateDebut = null;
        $dateFin = null;
        
        $periode = TableRegistry::getTableLocator()->get('Periodes');
        $row = $periode->find()->first();
        $typePeriode = trim($row['type']);
        if(trim($row['type']) == 'mensuel'){
            $mensuel = trim($row['mensuel'])&& trim($row['annuel'])?$row['mensuel'] . '-' . $row['annuel']:null;
            $periodeString .= $mois[$row['mensuel']] . ' ' . $annees[$row['annuel']];
        }
        if(trim($row['type']) == 'annuel'){
            $annuel = trim($row['annuel'])?$row['annuel']:null;
            $periodeString .= $annees[$row['annuel']];
        }
        if(trim($row['type']) == 'periode' && trim($row['date_debut']) && trim($row['date_fin'])){
            $dateFin = trim($row['date_fin']);
            $dateDebut = trim($row['date_debut']);
            $date = date_create($dateDebut);
            $periodeString .= date_format($date,'d-M-Y') . ' au ';
            $date = date_create($dateFin);
            $periodeString .= date_format($date,'d-M-Y');
        }
        
        $customFinderOptions = [
            'mensuel' => $mensuel,
            'annuel' => $annuel,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
        ];
        
        $colors = Configure::read('colors');
        $this->loadModel('VentesConsommables');
        // total vente
        $totalVente = count($this->Ventes->find('complete')->find('filtre',$customFinderOptions)->toArray());
        // total ca
        $chiffreAffaire = $this->Ventes->find('caVente')->find('filtre',$customFinderOptions)->first();
        $totalCa = $chiffreAffaire->sum;
        // total vente consommable
        $totalCons = count($this->VentesConsommables->find('complete')->toArray());
        // vente par type de parc
        $legendeVenteParc = [];
        $groupByParc = $this->Ventes->find('countByParc')->find('filtre',$customFinderOptions)->toArray();
        $dataParcs = $this->renderChartDataDoughnut($groupByParc, $legendeVenteParc);
        foreach ($groupByParc as $vente){
            $parcs[$vente->parc->nom2] = $vente->parc->id;
        }
        
        // vente par gamme
        $legendeVenteGamme = [];
        $groupedGammesBornes = $this->Ventes->GammesBornes->find('countByVentes')->find('filtre',$customFinderOptions)->filter(function ($v, $k) {return $v->nb > 0; })->toArray();
        $dataGammes = $this->renderChartDataDoughnut($groupedGammesBornes, $legendeVenteGamme);
        
        // vente consommable par type
        $this->loadModel('VentesHasSousConsommables');
        $legendeVenteTypeCons = [];
        $groupedTypeCons = $this->VentesHasSousConsommables->find('countByTypeConsommables')->find('filtre',$customFinderOptions)->filter(function ($v, $k) {return $v->nb > 0; })->toArray();
        $dataTypeCons = $this->renderChartDataDoughnut($groupedTypeCons, $legendeVenteTypeCons);
        
        // tableau top vendeurs
        $userVentes = [];
        $queryUserVentes = $this->Ventes->find('countByUser')->find('filtre',$customFinderOptions)->filter(function ($v, $k) {return $v->nb > 0; })->toArray();
        foreach ($queryUserVentes as $result) {
            $userVente = [];
            $userVente['user'] = $result->user;
            $userVente['total']['sum'] = $result->sum;
            $userVente['total']['nb'] = $result->nb;
            foreach ($parcs as $parc_name => $parc_id){
                $v = $this->Ventes->find('countByUser',['parc' => $parc_id, 'user' => $result->user->id])->find('filtre',$customFinderOptions)->first();
                $userVente[$parc_name]['sum'] = $v ? $v->sum:0;
                $userVente[$parc_name]['nb'] = $v ? $v->nb:0;
            }
            $cumule = $this->Ventes->find('countByUser',['user' => $result->user->id])->first();
            $userVente['cumule']['sum'] = $cumule ? $cumule->sum:0;
            $userVentes[] = $userVente;
        }
        
        unset($customFinderOptions['mensuel']);
        // vente par parc par mois
        $groupByParcByMonth = $this->Ventes->find('countByParcAndMonth')->find('filtre',$customFinderOptions)->filter(function ($v, $k) {return $v->nb > 0; })->toArray();
        $dataParcByMonth = $this->renderBarChartData($groupByParcByMonth);

        // vente par gamme par mois
        $groupedByGammesByDate = $this->Ventes->GammesBornes->find('countByVentesByDate')->find('filtre',$customFinderOptions)->filter(function ($v, $k) {return $v->nb > 0; })->toArray();
        $dataGammeByMonth = $this->renderBarChartData($groupedByGammesByDate);

        // vente par type client par mois
        $groupedByClientTypeByDate = $this->Ventes->find('countByTypeClientByMonth')->find('filtre',$customFinderOptions)->filter(function ($v, $k) {return $v->nb > 0; })->toArray();
        $dataClientByMonth = $this->renderBarChartData($groupedByClientTypeByDate);

        
        // activite recente
        $activities = [];
        $avtivitiesVentes = [];
        $activityVentes = $this->Ventes->find('complete',['limit'=>3])->toArray();
        $activityCons    = $this->VentesConsommables->find('complete',['limit'=>3])->toArray();
        foreach ($activityVentes as $activityVente) {
            $avtivitiesVentes[$activityVente->created->format('Y-m-d-H-i-s')] = $activityVente;
        }
        foreach ($activityCons as $activityVenteCons) {
            $avtivitiesVentes[$activityVenteCons->created->format('Y-m-d-H-i-s')] = $activityVenteCons;
        }
        ksort($avtivitiesVentes);
        $i = 0;
        $iconColors = ['btn-info','btn-success','btn-danger'];
        $now = date_create();
        foreach ($avtivitiesVentes as $activity){
            $time = "Il y a ";
            $diff = date_diff($now,$activity->created);
            if($diff->d = 0) {
                $time .= $diff->h? $diff->h . " Heurs":"";
                $time .= $diff->i? $diff->i . " Minutes":"";
            }
            $activities[] = [
                'user' => $activity->user->get('full_name'),
                'client' => $activity->client->nom,
                'date' => $activity->created,
                'time' => $time,
                'byDate' => $diff->d?false:true,
                'title' => trim(strstr(get_class($activity), 'Consommable'))?'Vente Consommable':'Vente',
                'color' => $iconColors[$i],
            ];
            $i++;
            if($i > 2){
                break;
            }
        }
        if($mensuel){
            $dateArray = explode('-',$mensuel);
            $mensuel = count($dateArray)?$dateArray[0]:null;
            $annuel    = count($dateArray)?$dateArray[1]:null;
        }
        
        $this->set(@compact('totalVente', 'totalCons', 'legendeVenteParc','dataParcs','dataGammes','legendeVenteGamme','dataParcByMonth', 'mensuel','annuel','dateDebut','dateFin','typePeriode',
                'dataGammeByMonth','userVentes','parcs','dataTypeCons','legendeVenteTypeCons','dataClientByMonth','totalCa','mois','annees','periodeString','activities'));
    }
    
    
    public function renderChartDataDoughnut($datas,&$legende){
        $nombreByGammes = [];
        $colorGamme = [];
        $colors = Configure::read('colors');
        $i = 0;
        $labelGamme = [];
        foreach ($datas as $data){
            $legende[] = ['y' => $data->nb, 'name' => $data->name, 'color' => $colors[$i]];
            $nombreByGammes[] = $data->nb;
            $colorGamme[] = $colors[$i++];
            $labelGamme[] = $data->name;
        }
        return $dataToChart = [
            'datasets' => [[
                'data' => $nombreByGammes ,
                'backgroundColor' => $colorGamme,
            ]],
            'labels' => $labelGamme,
        ];
    }
    
    public function renderBarChartData($datas) {
        
        $dataLabels = [];
        $dataBar = [];
        $xAxis = [];
        $colors = Configure::read('colors');
        $i = 0;
        foreach ($datas as $data){
            $dataLabels[$data->name][] = [ 'x' => $data->month, 'y' => $data->nb];
            if(!in_array($data->month, $xAxis)){
                $xAxis[] = $data->month;
            }
        }
        foreach ($dataLabels as $type => $value) {
            $dataBar[] = [
                'label' => $type,
                'backgroundColor' => $colors[$i],
                'stack' => 'Stack ' . $i++,
                'data' => $value
            ];
        }
        
        return [
            'labels' => $xAxis,
            'datasets' => $dataBar
        ];
    }

    public function ajusterDureeFinContrat()
    {
        $ventes = $this->Ventes->find()->where(['parc_duree_id is not' => null, 'contrat_debut is not' => null, 'Ventes.parc_id IN' => [4, 9]])->contain(['ParcDurees'])->order(['Ventes.id' => 'DESC']);
        foreach ($ventes as $key => $vente) {

            $addedTime = $vente->parc_duree->get('Duree');
            $data = [
                'contrat_fin' => $vente->contrat_debut->modify('+ '.$addedTime)
            ];
            $vente = $this->Ventes->patchEntity($vente, $data, ['validate' => false]);
            $this->Ventes->save($vente);
        }
        die();
    }
    
}