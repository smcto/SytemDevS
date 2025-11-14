<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use Cake\ORM\Query;
use \Statickidz\GoogleTranslate;
use Cake\Database\Expression\QueryExpression;
use Cake\Filesystem\File;


/**
 * Avoirs Controller
 *
 * @property \App\Model\Table\AvoirsTable $Avoirs
 *
 * @method \App\Model\Entity\DevisFacture[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AvoirsController extends AppController
{
    public $defaultTva = false;

    /**
     * 
     * @param array $config
     */
    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->loadComponent('Utilities');
        $this->Utilities->loadModels(['Mois', 'Tvas', 'Clients', 'CatalogUnites', 'CatalogProduits', 'Users', 'DevisPreferences', 'Payss', 'DevisPreferences']);
        $this->Auth->allow(['decodeUrl', 'confirmation', 'pdfversion', 'viewPublic', 'makePayment', 'makeReglement']);

        $tvas = $this->Tvas->find('list', ['keyField' => 'valeur']);

        if (!$this->defaultTva) {
            $this->defaultTva = $defaultTva = $this->Tvas->findByIsDefault(1)->first();
        }

        $this->stripeApiKeySecret = Configure::read('api_key.prod.secret');
        $stripeApiKeyPublic = $this->stripeApiKeyPublic = Configure::read('api_key.prod.public');

        if ($this->request->getQuery('test') || $this->request->getEnv('REMOTE_ADDR') == '127.0.0.1') {
            $this->stripeApiKeySecret = Configure::read('api_key.dev.secret');
            $stripeApiKeyPublic = $this->stripeApiKeyPublic = Configure::read('api_key.dev.public');
        }
        
        $this->set(compact('tvas', 'defaultTva', 'stripeApiKeyPublic'));
    }
    
    /**
     * 
     * @param type $user
     * @return boolean
     */
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if(in_array('konitys', $typeprofils) || in_array('admin', $typeprofils)) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function delSession($key)
    {
        $this->request->getSession()->delete($key);
        return;
    }

    /**
     * 
     * @param type $id
     * @param type $reset_infos
     * @return type
     */
    public function add($id = null, $reset_infos = null) {
        
        // si on d'edite on remet les données (infos clients) de la session à celle dans la bdd % id
        if ($reset_infos == 1) {
            $this->delSession('avoirs_client');
            return $this->redirect(['action' => 'add', $id]);
        }
        // préférence du doc par défaut
        $avoirsPreferenceEntity = $this->DevisPreferences->find('complete')->first(); // basé sur preferences devis
        $avoirsPreferenceEntityArray = $avoirsPreferenceEntity->toArray();
        unset($avoirsPreferenceEntityArray['id']);
        $indent = $this->Utilities->incrementIndent($this->Avoirs->find()->orderAsc('indent')->last(), 'AVR-');
        $hasModel = false;
        $isDataInSaveRequest = false;

        
        // ENREGISTREMENT DEVIS
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['tva_id'] = $this->defaultTva->id;

            if($id) {
                $avoirsEntity = $this->Avoirs->findById($id)->contain(['InfosBancaires', 'Clients', 'AvoirsProduits'=> function ($q) {
                    return $q->order(['AvoirsProduits.i_position'=>'ASC']);
                }])->first();
            } else {
                $data['indent'] = $indent;
                $avoirsEntity = $this->Avoirs->newEntity();
            }
            
            $avoirsEntity = $this->Avoirs->patchEntity($avoirsEntity, $data);
            
            if (!empty($avoirsEntity->avoirs_produits)) {
                foreach ($avoirsEntity->avoirs_produits as $key => $avoirs_produits) {
                    if (empty(array_filter($avoirs_produits->toArray()))) {
                        unset($avoirsEntity->avoirs_produits[$key]);
                    }
                }
            }

            if(!$avoirsEntity->getErrors()) {

                if ($avoirsEntity = $this->Avoirs->save($avoirsEntity)) {
                    // $this->addToShortLink($avoirsEntity);
                    if($avoirsEntity->devis_facture_id) {
                        $this->requestAction('/fr/devis-factures/generation-pdf/' . $avoirsEntity->devis_facture_id);
                    }
                    $this->generationPdf($avoirsEntity->id);
                    $this->Flash->success('La factures a été enregistré');
                    if($data['is_continue']){
                        return $this->redirect(['action' => 'add', $avoirsEntity->id, 1]);
                    }else {
                        return $this->redirect(['action' => 'index']);
                    }
                } else {
                    $this->Flash->error("La factures n'a pas pu être enregistré");
                }
            } else {
                debug($avoirsEntity->getErrors());
                $this->Flash->error("L'avoir n'a pas pu être enregistré");
            }

            $isDataInSaveRequest = true;
        }

        if ($id) {
            $avoirsEntity = $this->Avoirs->findById($id)
                ->contain([
                    'InfosBancaires', 'AvoirsClientContacts', 'Clients', 'DevisFactures',
                    'AvoirsProduits'=> function ($q) {
                        return $q->order(['AvoirsProduits.i_position'=>'ASC']);
                    }
                ])
                ->first()
            ;

            $clientEntity = $avoirsEntity->client;
            $dataClient = [];
            $dataClient['nom'] = $avoirsEntity->client_nom;
            $dataClient['adresse'] = $avoirsEntity->client_adresse;
            $dataClient['adresse_2'] = $avoirsEntity->client_adresse_2;
            $dataClient['cp'] = $avoirsEntity->client_cp;
            $dataClient['ville'] = $avoirsEntity->client_ville;
            $dataClient['country'] = $avoirsEntity->client_country;

            if ($this->request->getSession()->read('avoirs_client') !== null) {
                $avoirs_client = $this->request->getSession()->read('avoirs_client');
                $avoirsModifiedInSession['client_nom'] = $avoirs_client->nom;
                $avoirsModifiedInSession['client_adresse'] = $avoirs_client->adresse;
                $avoirsModifiedInSession['client_adresse_2'] = $avoirs_client->adresse_2;
                $avoirsModifiedInSession['client_cp'] = $avoirs_client->cp;
                $avoirsModifiedInSession['client_ville'] = $avoirs_client->ville;
                $avoirsModifiedInSession['client_country'] = $avoirs_client->country;
                $avoirsEntity = $this->Avoirs->patchEntity($avoirsEntity, $avoirsModifiedInSession, ['validate' => false]);
                $clientEntity = $this->Avoirs->Clients->patchEntity($clientEntity, $dataClient, ['validate' => false]);
            } else {
                $avoirs_client = $clientEntity = $this->Avoirs->Clients->patchEntity($clientEntity, $dataClient, ['validate' => false]);
            }

            $currentUser = $this->Users->get($this->Avoirs->get($id)->ref_commercial_id, ['contain' => 'Payss']);
            
        } else {
            
            // facturation to avoir
            $facture_id = $this->request->getQuery('facture_id');
            $devisFacturesData = [];
            if($facture_id) {
                
                $devisFacturesData = $this->Avoirs->DevisFactures->findById($facture_id)->find('asModele',['removed_client' => 0, 'to_facture' => 1])->toArray();
                $avoirs_client = $clientEntity = $this->Clients->findById($devisFacturesData['client_id'])->contain('ClientContacts')->first();
                $devisFacturesData['avoirs_produits'] = $devisFacturesData['devis_factures_produits'];
                $devisFacturesData['devis_facture_id'] = $facture_id;
                $devisFacturesData['date_crea'] = Chronos::now();
                $devisFacturesData['date_validite'] = Chronos::now()->addMonth(1);
                $avoirsEntity = $this->Avoirs->newEntity($devisFacturesData, ['validate' => false]);
                $currentUser = $this->Users->get($devisFacturesData['ref_commercial_id'], ['contain' => 'Payss']);
                $hasModel = true;
            } else {
                
                // creation nouveau
                $avoirs_client = $clientEntity = $this->request->getSession()->read('avoirs_client');

                $categorie_tarifaire = $this->request->getQuery('categorie_tarifaire');
                $type_doc_id = $this->request->getQuery('type_doc_id');
                $newDatas = [
                    'date_crea' => Chronos::now(),
                    'date_validite' => Chronos::now()->addMonth(1),
                    'date_sign_before' => Chronos::now()->addMonth(1),
                    'client_id' => $clientEntity ? $clientEntity->id : "",
                    'client_nom' => $clientEntity ? $clientEntity->nom : "",
                    'client_adresse' => $clientEntity ? $clientEntity->adresse : "",
                    'client_adresse_2' => $clientEntity ? $clientEntity->adresse_2 : "",
                    'client_cp' => $clientEntity ? $clientEntity->cp : "",
                    'client_ville' => $clientEntity ? $clientEntity->ville : "",
                    'client_country' => $clientEntity ? $clientEntity->country : "",
                    'categorie_tarifaire' => $categorie_tarifaire,
                    'type_doc_id' => $type_doc_id
                ];

                $model_id = $this->request->getQuery('model_id');
                if($model_id) {
                    
                    // charge l'avoir en tant que modèle
                    $avoirsEntity = $this->Avoirs->findById($model_id)->find('asModele');
                    $hasModel = true;
                } else {
                    
                    // creation facture sans model
                    $avoirsEntity = $this->Avoirs->newEntity();
                    $newDatas = array_merge($newDatas, $avoirsPreferenceEntityArray);
                }

                $avoirsEntity = $this->Avoirs->patchEntity($avoirsEntity,$newDatas, ['validate' => false]);
                $currentUser = $this->Users->get($this->currentUser()->id, ['contain' => 'Payss']);
            }
        }
        
        if (is_null($avoirs_client)) {
            if (!$isDataInSaveRequest) {
                $this->Flash->error("Aucun client n'a été défini");
            }
            return $this->redirect(['action' => 'index']);
        }

        $avoirs_client_contact_id = $this->request->getSession()->read('avoirs_client_contact_id');
        $devis_factures_doc_param = $this->request->getSession()->read('devis_factures_doc_param');
        
        $this->viewBuilder()->setLayout('devis_factures');
        $type_bornes = Configure::read('type_bornes');
        $civilite = Configure::read('civilite');
        $devis_factures_status = Configure::read('devis_factures_status');
        $moyen_reglements = Configure::read('moyen_reglements');
        $categorie_tarifaires = Configure::read('categorie_tarifaire');
        $delai_reglements = Configure::read('delai_reglements');
        $newContact = $this->Avoirs->Clients->ClientContacts->newEntity();
        $clientContacts = $this->Clients->ClientContacts->findByClientId($clientEntity->id)->group(['nom', 'prenom'])->find('list', ['valueField' => 'full_name']);
        $commercials = $this->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name']); // profile Konitys Commercial
        $catalogUnites = $this->CatalogUnites->find('list', ['valueField' => 'nom']);
        $catalogProduits = $this->CatalogProduits->find('all');
        $infosBancaires = $this->Avoirs->InfosBancaires->find('list');
        $categorie = $this->CatalogProduits->CatalogProduitsHasCategories->CatalogCategories->find('list', ['valueField'=>'nom'])->orderAsc('nom');
        $colVisibilityParams = $avoirsEntity->get('ColVisibilityParamsAsArray');
        $publicLink = $this->Utilities->slEncryption(serialize(['action' => 'view-public', 'id' => $id]));
        $type_docs = $this->Avoirs->DevisTypeDocs->find('list')->orderAsc('nom');
        $langues = $this->Avoirs->Langues->find('list')->order(['nom' => 'ASC']);
        $factures = $this->Avoirs->DevisFactures->find('list', ['valueField' => 'indent'])->where(['client_id' => $avoirs_client->id]);
        $this->delSession('avoirs_client');

        $this->set(compact('type_bornes', 'factures', 'langues', 'avoirsPreferenceEntity', 'infosBancaires', 'moyen_reglements', 'delai_reglements', 'catalogUnites', 'commercials', 'currentUser', 'avoirs_client_contact_id', 'categorie_tarifaires', 'publicLink', 'hasModel'));
        $this->set(compact('indent', 'devis_factures_status', 'id', 'colVisibilityParams', 'avoirs_client', 'devis_factures_doc_param', 'avoirsEntity', 'clientEntity', 'clientContacts','catalogProduits','categorie', 'newContact', 'civilite', 'type_docs'));
    }
    
    
    /**
     * 
     * @param type $devis_client_id
     * @return type
     */
    public function editClient()
    {
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            if($data['avoir_id'] && $data['client_id']) {
                $avoirsEntity = $this->Avoirs->findById($data['avoir_id'])->first();
                $clientEntity = $this->Clients->findById($data['client_id'])->first();
                $newData = [
                    'client_id' => $clientEntity->id,
                    'client_nom' => $clientEntity->nom,
                    'client_adresse' => $clientEntity->adresse,
                    'client_adresse_2' => $clientEntity->adresse_2,
                    'client_cp' => $clientEntity->cp,
                    'client_ville' => $clientEntity->ville,
                    'client_country' => $clientEntity->country
                ];
                $avoirsEntity = $this->Avoirs->patchEntity($avoirsEntity, $newData, ['validate' => false]);
                
                if($this->Avoirs->save($avoirsEntity)) {
                    $this->generationPdf($data['avoir_id']);
                    $this->Flash->success("Affectation client reussie");
                } else {
                    
                    $this->Flash->error("Aucun client n'a été défini");
                }
            }
            return $this->redirect($this->referer());
        }
        $this->Flash->error("Erreur d'enregistrement");
        return $this->redirect($this->referer());
    }

    public function editCommercial()
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            
            $avoirsEntity = $this->Avoirs->findById($data['avoir_id'])->first();
            $newData = ['ref_commercial_id' => $data['ref_commercial_id']];
            $avoirsEntity = $this->Avoirs->patchEntity($avoirsEntity, $newData, ['validate' => false]);
            if ($this->Avoirs->save($avoirsEntity)) {
                $this->Flash->success("Modification du commercial réussie");
            } else {
                $this->Flash->error("Aucun commercial n'a été défini");
            }
        
            return $this->redirect($this->referer());
        }
    }
    
    public function addToShortLink($avoirsEntity) {
        
        $parametre = $this->Utilities->slEncryption(serialize(['id' => $avoirsEntity->id, 'action' => 'view-public']));
        if(! $this->Avoirs->ShortLinks->findByDevisFactureId($avoirsEntity->id)->first()) {
            $shortLinkData = [
                'short_link' => 'link/' . uniqid(),
                'link' => 'f/' . $parametre,
                'devis_facture_id' => $avoirsEntity->id
            ];
            $shortLink = $this->Avoirs->ShortLinks->newEntity($shortLinkData);
            $this->Avoirs->ShortLinks->save($shortLink);
        }
        return;
    }
    
    /**
     * 
     * @return type
     */
    public function editInfosClient($client_id)
    {
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $clientEntity = $this->Avoirs->Clients->findById($client_id)->first();
            $clientEntity = $this->Avoirs->Clients->patchEntity($clientEntity, $data, ['validate' => false]);

            $this->request->getSession()->write('avoirs_client', $clientEntity);
        
            $this->Flash->success("Les informations du client ont été apportées sur le devis");
            return $this->redirect($this->referer());
        }
    }

    public function board(){
        $facturePart = $this->Avoirs
                                ->find()
                                /*->contain('Clients', function (Query $q) {
                                    return $q
                                        ->where(['Clients.client_type' => 'person']);
                                })*/
                                ->innerJoinWith('Clients', function (Query $q) {
                                    return $q->where(['Clients.client_type' => 'person']);
                                })
                                ->where([
                                    'AND' => [
                                        //['Avoirs.status !=' => 'draft'],
                                        ['Avoirs.status !=' => 'canceled'],
                                    ]
                                ])
                                ->where(function (QueryExpression $exp, Query $q) {
                                    $year = $q->func()->year([
                                        'Avoirs.date_crea' => 'identifier'
                                    ]);
                                    return $exp
                                        ->gte($year, 2020);
                                });

        $facturePart = $facturePart
                    ->select([
                        'total_ht' => $facturePart->func()->sum('Avoirs.total_ht'),
                        'total_ttc' => $facturePart->func()->sum('Avoirs.total_ttc')
                    ])->toArray();

        $facturePro = $this->Avoirs
                                ->find()
                                /*->contain('Clients', function (Query $q) {
                                    return $q
                                        ->where(['Clients.client_type' => 'corporation']);
                                })*/
                                ->innerJoinWith('Clients', function (Query $q) {
                                    return $q->where(['Clients.client_type' => 'corporation']);
                                })
                                ->where([
                                    'AND' => [
                                        //['Avoirs.status !=' => 'draft'],
                                        ['Avoirs.status !=' => 'canceled'],
                                    ]
                                ])
                                ->where(function (QueryExpression $exp, Query $q) {
                                    $year = $q->func()->year([
                                        'Avoirs.date_crea' => 'identifier'
                                    ]);
                                    return $exp
                                        ->gte($year, 2020);
                                });

        $facturePro = $facturePro
                    ->select([
                        'total_ht' => $facturePro->func()->sum('Avoirs.total_ht'),
                        'total_ttc' => $facturePro->func()->sum('Avoirs.total_ttc')
                    ])->toArray();
        //debug($facturePro); die;

        $this->set(compact('facturePart','facturePro'));
    }

    public function countFacture($is_in_sellsy = 0){
        $this->viewBuilder()->setLayout('ajax');
        $options = [
            'keyword' => $this->request->getQuery('keyword'),
            'ref_commercial_id' => $this->request->getQuery('ref_commercial_id'),
            'client_type' => $this->request->getQuery('client_type'),
            'created' => $this->request->getQuery('created'),
            'periode' => $this->request->getQuery('periode'),
            'date_threshold' => $this->request->getQuery('date_threshold'),
            'status' => $this->request->getQuery('status')
        ];

        $facture = $this->Avoirs
                        ->find('complete')
                        ->find('filtre',$options)
                        ->where(['Avoirs.is_in_sellsy' => $is_in_sellsy])
                        ->where([
                                    'AND' => [
                                        ['Avoirs.status !=' => 'draft'],
                                        ['Avoirs.status !=' => 'canceled'],
                                    ]
                            ]);

        $facture = $facture
                    ->select([
                        'total_ht' => $facture->func()->sum('Avoirs.total_ht'),
                        'total_ttc' => $facture->func()->sum('Avoirs.total_ttc')
                    ])->toArray();
        //debug($facture);
        $this->set(compact('facture'));
    }
    
    
    /**
     * 
     * @return type
     */
    public function index($export = null) 
    {
        $listeAvoirs = $this->Avoirs->find('complete'); //->where(['Avoirs.is_in_sellsy' => $is_in_sellsy]);
        $avoirsEntity = $this->Avoirs->newEntity();

        $indent = $this->request->getQuery('indent');
        $ref_commercial_id = $this->request->getQuery('ref_commercial_id');
        $client_type = $this->request->getQuery('client_type');
        $created = $this->request->getQuery('created');
        $antenne_id = $this->request->getQuery('antenne_id');
        $keyword = $this->request->getQuery('keyword');
        $periode = $this->request->getQuery('periode');
        $date_threshold = $this->request->getQuery('date_threshold');
        $status = $this->request->getQuery('status');
        $mois_id = $this->request->getQuery('mois_id') ?? (date('m')-1);
        $date_evenement = $this->request->getQuery('date_evenement');
        $type_doc_id = $this->request->getQuery('type_doc_id');
        
        $customFinderOptions = [
            'keyword' => $keyword,
            'ref_commercial_id' => $ref_commercial_id,
            'client_type' => $client_type,
            'created' => $created,
            'antenne_id' => $antenne_id,
            'periode' => $periode,
            'date_threshold' => $date_threshold,
            'mois_id' => $mois_id,
            'status' => $status,
            'type_doc_id' => $type_doc_id
        ];
        
        $commercials = $this->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name']); // profile Konitys Commercial

        $listeAvoirs->find('filtre', compact('mois_id', 'date_evenement', 'keyword', 'ref_commercial_id', 'client_type', 'created', 'antenne_id', 'periode', 'date_threshold', 'status', 'type_doc_id'));

        $sumAvoirs = $this->Avoirs->find('complete')->find('filtre', compact('mois_id', 'date_evenement', 'keyword', 'ref_commercial_id', 'client_type', 'created', 'antenne_id', 'periode', 'date_threshold', 'status', 'type_doc_id'))->where([['Avoirs.status <>' => 'canceled']]);
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $this->request->getSession()->write('avoirs_client', $this->Clients->findById($data['client_id'])->contain('ClientContacts')->first());
            return $this->redirect(['action' => 'add', 'categorie_tarifaire' => $data['categorie_tarifaire'], 'type_doc_id' => $data['type_doc_id']]);
        }
        
        $connaissance_selfizee = Configure::read('connaissance_selfizee');
        $categorie_tarifaire = Configure::read('categorie_tarifaire');
        $devis_factures_status = Configure::read('devis_factures_status');
        $periodes = Configure::read('periodes');
        $genres = Configure::read('genres');
        $genres_short = Configure::read('genres_short');
        // $clients = $this->Clients->find('list', ['valueField' => 'nom'])->order(['nom' => 'asc'])->group('nom');
        $groupeClients = $this->Clients->GroupeClients->find('list')->order(['nom' => 'asc']);
        $secteursActivites = $this->Clients->SecteursActivites->find('list')->order(['name' => 'asc']);
        $type_commercials = Configure::read('type_commercials');
        $type_docs = $this->Avoirs->DevisTypeDocs->find('list')->orderAsc('nom');
        $mois = $this->Mois->find('list', ['valueField' => 'mois_annee'])->select(['mois_annee' => 'concat(nom, ". ", "'.date('y').'")']);
        
        if ($export == 'csv') {
            return $this->exportCsv($listeAvoirs, $genres_short, $devis_factures_status);
        }
        
        $listeAvoirs = $this->paginate($listeAvoirs, ['limit' => 50, 'order' => ['Avoirs.indent' => 'DESC']]);
        $this->set(compact('sumAvoirs', 'mois', 'mois_id', 'date_evenement', 'indent','periode', 'periodes', 'date_threshold', 'commercials', 'ref_commercial_id','categorie_tarifaire', 'connaissance_selfizee', 'client_type', 'status', 'genres', 'created', 'antenne_id', 'keyword', 'devis_factures_status', 'listeAvoirs', 'avoirsEntity', 'genres_short','groupeClients','type_commercials', 'customFinderOptions', 'secteursActivites', 'type_docs', 'type_doc_id'));
    }
    
    
    public function exportCsv($listeAvoirs, $genres_short, $devis_factures_status, $titres = "Liste avoirs", $filename = 'export-csv-avoirs') {
        
            $this->viewBuilder()->setLayout('ajax');
            
            $datas = [];
            $datas [] =  [$titres];
            $datas [] = ['N°', 'Client', 'Facture', 'Date', 'Type', 'Contact', 'Total HT', 'Total TTC', 'Etat'];
            foreach ($listeAvoirs as $avoir){
                $ligne = [];
                $ligne[] = $avoir->indent;
                $ligne[] = $avoir->client ? $avoir->client->nom : $avoir->client_nom;
                $ligne[] = $avoir->devis_facture? $avoir->devis_facture->indent : '-';
                $ligne[] = $avoir->date_crea? $avoir->date_crea->format('d/m/y') : '-';
                $ligne[] = @$genres_short[$avoir->client->client_type] ?? '';
                $ligne[] = $avoir->commercial ? $avoir->commercial->get('FullNameShort') : '-';
                $ligne[] = str_replace('.', ',', $avoir->total_ht);
                $ligne[] = str_replace('.', ',', $avoir->total_ttc);
                $ligne[] = @$devis_factures_status[$avoir->status];

                $datas [] =  $ligne;
            }
            
            $datas = mb_convert_encoding($datas, 'UTF-16LE', 'UTF-8');
            $this->set(compact('datas'));
            $this->render('export_csv');
            $repons = $this->response->withDownload($filename.".csv");
            return $repons;
    }
    
    public function ModelList() {
        
        $cat = $this->request->getQuery('category');
        $sousCat = $this->request->getQuery('sous-category');
        
        $customFinderOptions = [
            'cat' => $cat,
            'sous-cat' => $sousCat,
        ];
        
        $listeAvoirs = $this->Avoirs->find('listModel',$customFinderOptions);

        $devis_factures_status = Configure::read('devis_factures_status');
        $genres = Configure::read('genres');
        $genres_short = Configure::read('genres_short');
        $type_commercials = Configure::read('type_commercials');

        $this->set(compact('devis_factures_status' , 'genres' , 'genres_short' , 'type_commercials', 'listeAvoirs', 'categories', 'sousCategories', 'cat', 'sousCat'));
    }
    
    // version pdf document devis
    public function pdfversion($avoir_id, $downloadMode = null)
    {
        $forceGenerate = $this->request->getQuery('forceGenerate');
        $testMode = $this->request->getQuery('test'); // pour faire un debug en rendu html
        $download = $this->request->getQuery('download');
        $avoirsEntity = $this->Avoirs->findById($avoir_id)->find('complete')->first();

        if ($forceGenerate) {            
            $this->generationPdf($avoir_id, $test);
            return $this->response->withFile(WWW_ROOT  . $avoirsEntity->get('SellsyDocUrl'), ['download' => $download?$download:$downloadMode,]);
        }
        
        if($avoirsEntity->get('SellsyDocUrl') != '#') {
            return $this->response->withFile(WWW_ROOT  . $avoirsEntity->get('SellsyDocUrl'), ['download' => $download?$download:$downloadMode,]);
        } else {
            $this->generationPdf($avoir_id);
            if (file_exists(WWW_ROOT  . $avoirsEntity->get('SellsyDocUrl'))) {
                return $this->response->withFile(WWW_ROOT  . $avoirsEntity->get('SellsyDocUrl'), ['download' => $download?$download:$downloadMode]);
            } else {
                echo "Le fichier $avoirsEntity->indent.pdf non présent sur le serveur";
                die();
            }
        }
        return;
    }
    
    
    
    /**
     * 
     * @param type $avoir_id
     * @param type $downloadMode
     * @return type
     */
    public function generationPdf($avoir_id)
    {
        $moyen_reglements = Configure::read('moyen_reglements');
        $delai_reglements = Configure::read('delai_reglements');

        $avoirsPreferenceEntity = $this->DevisPreferences->find('complete')->first(); // préférence du doc par défaut

        $date_crea = Chronos::now();
        $avoirsEntity = $this->Avoirs->findById($avoir_id)->find('complete')->first();
        
        if($avoirsEntity->is_in_sellsy) {
            return ;
        }
        
        $currentUser = $this->Users->get($avoirsEntity->ref_commercial_id, ['contain' => 'Payss']);
        $colVisibilityParams = $avoirsEntity->get('ColVisibilityParamsAsArray');
        $this->loadModel('DevisFacturesFooter');
        $footer = $this->DevisFacturesFooter->findById(1)->first()->text;

        if($avoirsEntity->categorie_tarifaire == 'ttc') {
            $colVisibilityParams->qty = 1;
            $colVisibilityParams->remise = 1;
            $colVisibilityParams->prix_unit_ht = 1;
            $colVisibilityParams->tva = 1;
            $colVisibilityParams->montant_ht = 1;
        } else {
            $colVisibilityParams->montant_ttc = 1;
            $colVisibilityParams->tva = $avoirsEntity->display_tva?:$colVisibilityParams->tva;
        }
        $thHidev = 0;
        if($colVisibilityParams){
            foreach ($colVisibilityParams as $col) {
                if($col) {
                    $thHidev++;
                }
            }
        }

        $this->set(compact('avoirsPreferenceEntity', 'currentUser','date_crea','avoirsEntity','colVisibilityParams','thHidev','moyen_reglements','delai_reglements', 'footer'));
        
        // GENERATION FICHIER
        $viewBuilder = $this->viewBuilder()->setClassName('Dompdf.Pdf')->setLayout('pdf/dompdf.default');
        $pdfOptions = Configure::read('FacturePdf');
        if ($avoirsEntity->langue && $avoirsEntity->langue->id != 1) {
            
            $target = $avoirsEntity->langue->code;
            $trans = new GoogleTranslate();
            $this->set(compact('target', 'trans'));
            $pdfOptions['config']['paginate']['text'] = $trans->translate('fr', $target, 'Page') . '{PAGE_NUM}/{PAGE_COUNT}';
            $viewBuilder->setOptions($pdfOptions);
            $content = $this->render('pdf/pdfversion2');
        } else {
            $viewBuilder->setOptions($pdfOptions);
            $content = $this->render('pdf/pdfversion');
        }
        
        $file_name = PATH_AVOIRS . $avoirsEntity->indent.'.pdf';
        if(file_exists($file_name)) {
            unlink($file_name);
        }
        $file = new File($file_name);
        $file->write($content);
        return;
            
    }
    
    
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function view($id = null) {
        
        $this->viewBuilder()->setLayout('devis_factures');
        $moyen_reglements = Configure::read('moyen_reglements');
        $devis_avoirs_status = Configure::read('devis_avoirs_status');
        $delai_reglements = Configure::read('delai_reglements');
        $genres = Configure::read('genres');
        $avoirsPreferenceEntity = $this->DevisPreferences->find('complete')->first(); // préférence du doc par défaut

        $antenne_names = [];
        if ($id) {
            
            $avoirEntity = $this->Avoirs->findById($id)->contain(['Clients', 'DevisFactures', 'Commercial', 'AvoirsProduits'=> function ($q) {
                return $q->order(['AvoirsProduits.i_position'=>'ASC']);
            }])->first();
            
            $clientEntity = $avoirEntity->client;
            
            $dataClient['nom'] = $avoirEntity->client_nom;
            $dataClient['adresse'] = $avoirEntity->client_adresse;
            $dataClient['adresse_2'] = $avoirEntity->client_adresse_2;
            $dataClient['cp'] = $avoirEntity->client_cp;
            $dataClient['ville'] = $avoirEntity->client_ville;
            $dataClient['country'] = $avoirEntity->client_country;

            $devis_client = $clientEntity = $this->Avoirs->Clients->patchEntity($clientEntity, $dataClient, ['validate' => false]);
        }

        if (is_null($devis_client)) {
            $this->Flash->error("Aucun client n'a été défini");
            return $this->redirect(['action' => 'index']);
        }

        $devis_adress = $this->request->getSession()->read('devis_adress');
        $avoirs_client_contact_id = $this->request->getSession()->read('avoirs_client_contact_id');
        $devis_doc_param = $this->request->getSession()->read('devis_doc_param');
        
        $currentUser = $this->currentUser();
        $refCom = $this->Users->get($avoirEntity->ref_commercial_id, ['contain' => 'Payss']);
        
        $parametre = $this->Utilities->slEncryption(serialize(['action' => 'view-public', 'id' => $id]));
        $newAvoirEntity = $this->Avoirs->newEntity();
        $this->set(compact('moyen_reglements', 'delai_reglements', 'refCom', 'avoirs_client_contact_id', 'parametre','devis_avoirs_status','newAvoirEntity'));
        $this->set(compact('avoirsPreferenceEntity', 'id', 'antenne_names', 'devis_client', 'devis_adress', 'devis_doc_param', 'avoirEntity', 'clientEntity', 'genres'));
    }

    /**
     * Delete method
     *
     * @param string|null $id DevisFacture id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $avoir = $this->Avoirs->get($id);
        if ($this->Avoirs->delete($avoir)) {
            $this->Flash->success(__('The devis_facture has been deleted.'));
        } else {
            $this->Flash->error(__('The devis_facture could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function viewPublic($id) {
        
        $avoirsEntity = $this->Avoirs->findById($id)->find('complete')->contain(['Devis', 'InfosBancaires'])->first();
        $this->loadModel('DevisPreferences');
        $devisPreferenceEntity = $this->DevisPreferences->find('complete')->first();
        
        if($avoirsEntity) {
            $devis_factures_status = Configure::read('devis_factures_status');
            $this->viewBuilder()->setLayout('public');
            $stripeApiKeyPublic = $this->stripeApiKeyPublic;
            $this->loadModel('DocumentMarketings');
            $documentMarketing = $this->DocumentMarketings->find()->first();

            /**
             * si 1ere echéance (accompte) = montant total, ne pas afficher la 1ère ligne
             * quand le dernier acompte à payer = le solde , ne pas rajouter une ligne supplémentaire "régler la totalité du document", car ça revient au même.
             */
            
            $devisFacturesEcheances = collection($avoirsEntity->devis_factures_echeances);
            $firstFindEcheance = $devisFacturesEcheances->first();
            $isFirstFindedEcheanceSameAsTotalDevisAmount =  @$firstFindEcheance->montant == $avoirsEntity->total_ttc;
            $lastFindEcheance = $devisFacturesEcheances->last();
            $isLastFindedEcheanceSameAsTotalDevisAmount =  @$lastFindEcheance->montant == $avoirsEntity->get('ResteEcheanceImpayee');
            $isClientPro = $avoirsEntity->get('ClientType') == 'corporation';
            $tva = $this->defaultTva;
            $avoirsEntity->tva = $this->defaultTva;

            // inclure si des paiements en dehors de la page we (chèque, virement) ont été effectués
            $paiementAutresQueCartes = collection($avoirsEntity->facture_reglements)->filter(function ($item)
            {
                return $item->moyen_reglement->name_court != 'CB';
            });

            if($avoirsEntity->is_in_sellsy) {
                
                $devisFacturesEcheances = collection((array) json_decode($avoirsEntity->sellsy_echeances));

                $firstFindEcheance = $devisFacturesEcheances->first();
                $isFirstFindedEcheanceSameAsTotalDevisAmount =  @$firstFindEcheance->amount == $avoirsEntity->total_ttc;

                $lastFindEcheance = $devisFacturesEcheances->last();
                $isLastFindedEcheanceSameAsTotalDevisAmount =  @$lastFindEcheance->amount == $avoirsEntity->get('ResteEcheanceImpayee');

                // $this->render('view_public_sellsy');
            }
            
            $this->set(compact('paiementAutresQueCartes', 'devisPreferenceEntity', 'isClientPro', 'firstFindEcheance', 'avoirsEntity', 'devis_factures_status', 'devisFacturesEcheances', 'isFirstFindedEcheanceSameAsTotalDevisAmount', 'lastFindEcheance', 'isLastFindedEcheanceSameAsTotalDevisAmount', 'documentMarketing'));

            if ($isClientPro) {
                $this->render('view_public_pro');
            }
            
        } else {
            throw new NotFoundException();
        }
    }

    public function decodeUrl($param = '') {
        		
        $parametre = @unserialize($this->Utilities->slDecryption($param));
        
        $action = $parametre['action'];
        $id = $parametre['id'];
        if($action == 'pdfversion') {
            $download = !empty($parametre['download'])?$parametre['download']:null;
            return $this->setAction('pdfversion', $id,$download);
        }
        if($action == 'view-public') {
            $this->setAction('viewPublic', $id);
        }
    }
    
    
    public function EditEtat($avoir_id, $client_id = null) {
        $avoir = $this->Avoirs->findById($avoir_id)->first();
        if ($avoir) {
            $avoir = $this->Avoirs->patchEntity($avoir, $this->request->getData());
            if($this->Avoirs->save($avoir)){
                $this->setStatutHistorique($avoir->id, $avoir->status);
                $this->Flash->success(__('L\'état de la facture a été bien changé.'));
            } else {
                $this->Flash->success(__('Erreur de modification de l\'état du devis.'));
            }
        }
        
        return $this->redirect($this->referer());
    }
    
    public function duplicatAvoir($facture_id) {
        
        if($this->request->is(['post', 'put'])) {
            
            $data = $this->request->getData();
            $client = $this->request->getData('client_id');
            
            $this->request->getSession()->write('avoirs_client', $this->Clients->findById($client)->contain('ClientContacts')->first());                
 
            $this->redirect(['action' => 'add', 'model_id' => $facture_id]);
        }
    }
    
    /**
     * 
     * @param type $id
     */
    public function historique($id){
        $avoir = $this->Avoirs->findById($id)->contain(['StatutHistoriques' => 'Users'])->first();
        $devis_avoirs_status = Configure::read('devis_avoirs_status');
        $this->set(compact('avoir','devis_avoirs_status'));
    }
    
    /**
     * Meme fucntion dans ajax
     * @param type $avoirId
     * @param type $statut
     * @return type
     */
    protected function setStatutHistorique($avoirId, $statut){
        if(!empty($statut) && !empty($avoirId)){
            $user_id = 84;
            if($this->Auth->user('id')) {
                $user_id = $this->Auth->user('id');
            }
            $this->loadModel('StatutHistoriques');
            $dataStat['avoir_id'] = $avoirId;
            $dataStat['time'] = time();
            $dataStat['statut_document'] = $statut;
            $dataStat['user_id'] = $user_id;
            $statutHistorique = $this->StatutHistoriques->newEntity($dataStat);
            $res = $this->StatutHistoriques->save($statutHistorique);
            return $res;
        }
    }
    
    
    public function multipleAction()
    {
        if ($this->request->is(['post'])) {

            $this->loadComponent('Zip');
            $data = $this->request->getData();

            if ($data['action'] == 'zip') {

                $this->Zip->cleanZipFolder(); // pour ne pas saturer le serveur
                $isTmpFilesCreated = false;

                foreach (array_filter($data['avoirs']) as $avoir_id => $value) {
                    $avoirEntity = $this->Avoirs->findById($avoir_id)->first();
                    $isTmpFilesCreated = $this->Zip->uploadTmpFile($avoirEntity);
                }

                if ($isTmpFilesCreated) {
                    $this->Zip->compressAndDownload($filename = 'Avoirs.zip'); // compresse et telecharge les fichiers stockés temporairement via ->uploadTmFile()
                } else {
                    $this->Flash->error("Une erreur est survenue, veuillez recommencer la procédure");
                }
            }
            
            return $this->redirect($this->referer());
        }

        return $this->redirect(['action' => 'index']);
    }
}
