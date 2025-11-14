<?php
namespace App\Controller;
use Cake\I18n\I18n;
use \Statickidz\GoogleTranslate;
use App\Controller\AppController;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Collection\Collection;
use Cake\I18n\Time;
use Cake\Cache\Cache;
use Cake\I18n\FrozenTime;
use DateTime;
use Cake\Routing\Router;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\Charge;
use Cake\Validation\Validator;
use App\Form\StripeForm;
use App\Controller\Component\SellsyCurlComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Console\ShellDispatcher;
use Cake\Network\Exception\NotFoundException;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;


class DevisController extends AppController
{
    public $defaultTva = false;
    public $stripeApiKeySecret;
    public $stripeApiKeyPublic;

    public function initialize(array $config = [])
    {
        parent::initialize($config);

        $this->loadComponent('Utilities');
        $this->Utilities->loadModels(['Mois', 'Tvas', 'Clients', 'CatalogUnites', 'CatalogProduits', 'Antennes', 'Users', 'DevisPreferences', 'Payss', 'Emails']);
        $this->Auth->allow(['decodeUrl', 'createDevis', 'modelDevisList', 'confirmation','pdfversion','viewPublic','generationPdf', 'makePaymentNew', 'makePayment', 'paiementSession', 'paiement']);
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

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if(in_array('konitys', $typeprofils) || in_array('admin', $typeprofils)) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function import()
    {
        $this->loadComponent('Import');
        $this->Import->saveDevis();
        return $this->redirect(['action' => 'index', 1, 'test' => 1]);
    }

    public function infophp()
    {
        phpinfo(); die();

    }

    public function majTvas()
    {
        $this->Devis->DevisProduits->updateAll(['tva' => '20.00'], ['tva' => '2.00']);
        $this->Devis->DevisProduits->updateAll(['tva' => '0.00'], ['tva' => '1.00']);
        die();
    }

    public function majInfosClients()
    {
        $devis = $this->Devis->find();
        foreach ($devis as $key => $devisEntity) {
            $client = $this->Devis->Clients->findById($devisEntity->client_id)->first();

            $data['client_nom'] = $client->nom;
            $data['client_adresse'] = $client->adresse;
            $data['client_adresse_2'] = $client->adresse_2;
            $data['client_cp'] = $client->cp;
            $data['client_ville'] = $client->ville;
            $data['client_country'] = $client->country;

            $devisEntity = $this->Devis->patchEntity($devisEntity, $data, ['validate' => false]);
            $this->Devis->save($devisEntity);
        }

        die();
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
            
        // si on d'edite on remet les données (infos clients) de la session Ã Æ’Ã†â€™Ã â€šÃ‚Â  celle dans la bdd % id
        if ($reset_infos == 1) {
            $this->delSession('devis_client');
            return $this->redirect(['action' => 'add', $id]);
        }

        // préférence du doc par défaut
        $devisPreferenceEntity = $this->DevisPreferences->find('complete')->first(); 
        $devisPreferenceEntityArray = $devisPreferenceEntity->toArray();
        unset($devisPreferenceEntityArray['id']);
        $indent = $this->Utilities->incrementIndent($this->Devis->find()->orderAsc('indent')->last());
        $model_id = null;
        $isDataInSaveRequest = false;
        
        $ancienStatut = '';
        // enregistrement du devis
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['tva_id'] = $this->defaultTva->id;

            // si modele
            if($data['is_model']  && $data['new_model']) {
                unset($data['id']);
                $data['uuid'] = uniqid();
                $data['indent'] = $indent;
                if(!empty($data['devis_produits'])) {
                    foreach ($data['devis_produits'] as $key => $devis_produits) {
                        if(isset($devis_produits['id'])) {
                            unset($data['devis_produits'][$key]['id']);
                        }
                    }
                }
                if($data['parametre_preference']) {
                    $data = array_merge($data, $devisPreferenceEntityArray);
                }
                
                $devisEntity = $this->Devis->newEntity();
                
            } else {
                // SI NON MODEL
                if($id) {
                    $data['client'] = [
                        'id' => $data['client_id'],
                        'nom' => $data['client_nom'],
                        'adresse' => $data['client_adresse'],
                        'cp' => $data['client_cp'],
                        'ville' => $data['client_ville'],
                        'country' => $data['client_country'],
                    ];
                    $devisEntity = $this->Devis->findById($id)->contain(['DevisEcheances', 'Clients', 'DevisProduits'=> function ($q) {
                        return $q->order(['DevisProduits.i_position'=>'ASC']);
                    }])->first();
                    $ancienStatut = $devisEntity->status;
                }else {
                    $data['indent'] = $indent;
                    $devisEntity = $this->Devis->newEntity();
                }
            }
            
            
            $devisEntity = $this->Devis->patchEntity($devisEntity, $data);

            if($devisEntity->devis_echeances) {
                $devis_echeances_ids = collection($devisEntity->devis_echeances)->extract('id')->toArray();
                // si echeance 2x, 3x etc regénérées en mode édition, ca efface toutes les echeances en cours et réajoute les nouveaux
                if ($data['is_echeance_regenerated'] == 1 && count($devis_echeances_ids)) {
                    $this->Devis->DevisEcheances->deleteAll(['id IN ' => $devis_echeances_ids]);
                }
            }
            
            if (!empty($devisEntity->devis_produits)) {
                foreach ($devisEntity->devis_produits as $key => $devis_produits) {
                    if (empty(array_filter($devis_produits->toArray()))) {
                        unset($devisEntity->devis_produits[$key]);
                    }
                }
            }

            if(!$devisEntity->getErrors()) {
                // temporaire ity fa jerena mendalana ny relation
                if ($devisEntity->id) {
                    if (!isset($data['devis_echeances'])) {
                        $this->Devis->DevisEcheances->deleteAll(['devis_id' => $devisEntity->id]);
                    }
                }
                $newStatut = $devisEntity->status;
                if ($devisEntity = $this->Devis->save($devisEntity)) {

                    $this->addToShortLink($devisEntity);
                    $this->generationPdf($devisEntity->id);
                    if($ancienStatut != $newStatut){
                        $this->setStatutHistorique($devisEntity->id, $newStatut);
                    }
                    $this->Flash->success('Le devis a été enregistré');
                    if($data['is_continue']){
                        return $this->redirect(['action' => 'add', $devisEntity->id, 1]);
                    } if($data['is_model']) {
                        return $this->redirect(['action' => 'ModelList']);
                    } else {
                        return $this->redirect(['action' => 'index']);
                    }
                } else {
                    debug($devisEntity->getErrors());
                    die;
                    $this->Flash->error("Le devis n'a pas pu être enregistré");
                }
            } else {
                debug($devisEntity->getErrors());
                die;
                $this->Flash->error("Le devis n'a pas pu être enregistré");
            }

            $isDataInSaveRequest = true;
        }
        
        
        if ($id) {
            $devisEntity = $this->Devis->findById($id)->contain(['DevisEcheances' => 'Devis', 'InfosBancaires', 'DevisClientContacts', 'Clients', 'Antennes', 'DevisProduits'=> function ($q) {
                return $q->order(['DevisProduits.i_position'=>'ASC']);
            }])->first();

            $ancienStatut = $devisEntity->status;

            $clientEntity = $devisEntity->client;
            $dataClient = [];
            $dataClient['nom'] = $devisEntity->client->nom;
            $dataClient['adresse'] = $devisEntity->client->adresse;
            $dataClient['adresse_2'] = $devisEntity->client->adresse_2;
            $dataClient['cp'] = $devisEntity->client->cp;
            $dataClient['ville'] = $devisEntity->client->ville;
            $dataClient['country'] = $devisEntity->client->country;

            if ($this->request->getSession()->read('devis_client') !== null) {
                $devis_client = $this->request->getSession()->read('devis_client');
                $devisModifiedInSession['client_nom'] = $devis_client->nom;
                $devisModifiedInSession['client_adresse'] = $devis_client->adresse;
                $devisModifiedInSession['client_adresse_2'] = $devis_client->adresse_2;
                $devisModifiedInSession['client_cp'] = $devis_client->cp;
                $devisModifiedInSession['client_ville'] = $devis_client->ville;
                $devisModifiedInSession['client_country'] = $devis_client->country;
                $devisEntity = $this->Devis->patchEntity($devisEntity, $devisModifiedInSession, ['validate' => false]);
                $clientEntity = $this->Devis->Clients->patchEntity($clientEntity, $dataClient, ['validate' => false]);
            } else {
                $devis_client = $clientEntity = $this->Devis->Clients->patchEntity($clientEntity, $dataClient, ['validate' => false]);
            }

            $currentUser = $this->Users->get($this->Devis->get($id)->ref_commercial_id, ['contain' => 'Payss']);
        } else {

            // creation nouveau
            $is_model = $this->request->getQuery('is_model');
            $devis_client = $clientEntity = $this->request->getSession()->read('devis_client');
            // creation MODEL devis : ataoko client par defaut fotsiny io 2501 io
            if($is_model){
                $devis_client = $clientEntity = $this->Clients->findById(2501)->contain('ClientContacts')->first();
            }
            
            $categorie_tarifaire = $this->request->getQuery('categorie_tarifaire');
            $type_doc_id = $this->request->getQuery('type_doc_id');
            
            $newDatas = [
                'indent' => $indent,
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
                'is_model' => $is_model,
                'categorie_tarifaire' => $categorie_tarifaire,
                'client' => [
                    'id' =>  $clientEntity ? $clientEntity->id : "",
                    'nom' =>  $clientEntity ? $clientEntity->nom : "",
                    'adresse' =>  $clientEntity ? $clientEntity->adresse : "",
                    'adresse_2' =>  $clientEntity ? $clientEntity->adresse_2 : "",
                    'cp' =>  $clientEntity ? $clientEntity->cp : "",
                    'ville' =>  $clientEntity ? $clientEntity->ville : "",
                    'country' =>  $clientEntity ? $clientEntity->country : "",
                ]
            ];
            
            if($type_doc_id) {
                $newDatas['type_doc_id'] = $type_doc_id;
            }
            // charge le devis en tant que modèle
            $model_id = $this->request->getQuery('model_devis_id');
            if($model_id) {
                $devisEntity = $this->Devis->findById($model_id)->find('asModele');
            } else {
                $devisEntity = $this->Devis->newEntity();
                $newDatas = array_merge($newDatas, $devisPreferenceEntityArray);
            }

            $devisEntity = $this->Devis->patchEntity($devisEntity,$newDatas, ['validate' => false]);
            $currentUser = $this->Users->get($this->currentUser()->id, ['contain' => 'Payss']);
        }
        
        if ($devisEntity->is_in_sellsy) {
            $this->Flash->error("Les devis sellsy ne peut pas être modifier");
            return $this->redirect($this->referer());
        }

        if (is_null($devis_client)) {
            if (!$isDataInSaveRequest) {
                $this->Flash->error("Aucun client n'a été défini");
            }
            return $this->redirect(['action' => 'index']);
        }

        $devis_client_contact_id = $this->request->getSession()->read('devis_client_contact_id');
        $devis_doc_param = $this->request->getSession()->read('devis_doc_param');
       
        $this->viewBuilder()->setLayout('devis');
        $devis_status = Configure::read('devis_status');
        $type_bornes = Configure::read('type_bornes');
        $civilite = Configure::read('civilite');
        $moyen_reglements = Configure::read('moyen_reglements');
        $type_prelevements = Configure::read('type_prelevements');
        $categorie_tarifaires = Configure::read('categorie_tarifaire');
        $delai_reglements = Configure::read('delai_reglements');
        $newContact = $this->Devis->Clients->ClientContacts->newEntity();
        $devis_type_docs = $this->Devis->DevisTypeDocs->find('list')->orderAsc('nom');
        $commercials = $this->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name'])->where(['toujours_present' => 1]); // profile Konitys Commercial
        $catalogUnites = $this->CatalogUnites->find('list', ['valueField' => 'nom']);
        $catalogProduits = $this->CatalogProduits->find('all');
        $infosBancaires = $this->Devis->InfosBancaires->find('list');
        $categorie = $this->CatalogProduits->CatalogProduitsHasCategories->CatalogCategories->find('list', ['valueField'=>'nom'])->orderAsc('nom');
        $antennes = $this->Antennes->find('listByCity');
        $colVisibilityParams = $devisEntity->get('ColVisibilityParamsAsArray');
        $modelDevisCategorie = $this->Devis->ModeleDevisCategories->find('list', ['valueField'=>'name'])->orderAsc('name');
        $modelDevisSousCategorie = $this->Devis->ModeleDevisSousCategories->find('list', ['valueField'=>'name','groupField' => 'modele_devis_categories_id'])->orderAsc('name');
        $clientContacts = $this->Devis->Clients->ClientContacts->find('list', ['valueField'=>'full_name'])->where(['client_id' => $devis_client->id]);
        $publicLink = $this->Utilities->slEncryption(serialize(['action' => 'view-public', 'id' => $id]));
        $langues = $this->Devis->Langues->find('list')->order(['nom' => 'ASC']);
        $this->delSession('devis_client');

        $this->set(compact('langues', 'type_prelevements', 'devisPreferenceEntity', 'infosBancaires', 'moyen_reglements', 'delai_reglements', 'catalogUnites', 'commercials', 'currentUser', 'devis_client_contact_id','modelDevisCategorie', 'categorie_tarifaires', 'publicLink', 'id', 'clientContacts'));
        $this->set(compact('devis_status', 'id', 'colVisibilityParams', 'devis_client', 'devis_doc_param', 'devisEntity', 'clientEntity', 'clientContacts','catalogProduits','categorie','antennes','modelDevisSousCategorie','devis_type_docs', 'type_bornes', 'civilite','newContact','model_id'));
    }
    
    
    
    
    public function addToShortLink($devisEntity) {
        $parametre = $this->Utilities->slEncryption(serialize(['id' => $devisEntity->id, 'action' => 'view-public']));
        if(! $this->Devis->ShortLinks->findByDeviId($devisEntity->id)->first()) {
            $shortLinkData = [
                'short_link' => 'link/' . uniqid(),
                'link' => 'd/' . $parametre,
                'devi_id' => $devisEntity->id
            ];
            $shortLink = $this->Devis->ShortLinks->newEntity($shortLinkData);
            $this->Devis->ShortLinks->save($shortLink);
        }
        return;
    }

    public function editInfosClient($devis_client_id)
    {
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $clientEntity = $this->Devis->Clients->findById($devis_client_id)->first();
            $clientEntity = $this->Devis->Clients->patchEntity($clientEntity, $data, ['validate' => false]);

            $this->request->getSession()->write('devis_client', $clientEntity);
        
            $this->Flash->success("Les nouveaux informations du client ont été apportées sur le devis");
            return $this->redirect($this->referer());
        }
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
            if($data['devi_id'] && $data['client_id']) {
                $devisEntity = $this->Devis->findById($data['devi_id'])->first();
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
                $devisEntity = $this->Devis->patchEntity($devisEntity, $newData, ['validate' => false]);
                
                if($this->Devis->save($devisEntity)) {
                    $this->generationPdf($data['devi_id']);
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

    
    /**
     * 
     * @param type $devis_client_id
     * @return type
     */
    public function lierClient2()
    {
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            if($data['devi_id'] && $data['client_id_2']) {
                $devisEntity = $this->Devis->findById($data['devi_id'])->first();
                $clientEntity = $this->Clients->findById($data['client_id'])->first();
                $newData = [
                    'client_id_2' => $data['client_id_2'],
                ];
                $devisEntity = $this->Devis->patchEntity($devisEntity, $newData, ['validate' => false]);
                
                if($this->Devis->save($devisEntity)) {
                    $this->generationPdf($data['devi_id']);
                    $this->Flash->success("Affectation 2em client reussie");
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
            
            $devisEntity = $this->Devis->findById($data['devi_id'])->first();
            $newData = ['ref_commercial_id' => $data['ref_commercial_id']];
            $devisEntity = $this->Devis->patchEntity($devisEntity, $newData, ['validate' => false]);
            if ($this->Devis->save($devisEntity)) {
                $this->Flash->success("Modification du commercial réussie");
            } else {
                $this->Flash->error("Aucun commercial n'a été défini");
            }
        
            return $this->redirect($this->referer());
        }
    }

    /**
     * [SellsyImportPdf description]
     * url : /devis/SellsyImportPdf/
     * @param string $type estimate|invoice
     */
    public function SellsyImportPdf($type = 'estimate')
    {
        $shell = new ShellDispatcher();
        $output = $shell->run(['cake', 'sellsy', 'importPdf', $type]);
        pr($output);
        die();
    }

    public function parmiClients()
    {
        $q = $this->Clients->find()
            ->where(['id_in_sellsy >' => 0])
            ->select(['id', 'email', 'nom', 'sellsy_id' => 'id_in_sellsy', 'id_in_sellsy' => 'count(*)'])
            ->group(['id_in_sellsy'])
            ->having(['count(*) > ' => 1])
            ->extract('id')
            ->toArray();

        $this->loadModel('Reglements');
        $d = $this->Devis->find()->where(['Devis.client_id IN' => $q])->contain(['Clients'])->Matching('Clients')->select(['client_id', 'sellsy_client_id', 'id'])->extract('sellsy_client_id');
        debug($d ->toArray());
        die();
    }

    // brouillon special
    public function sellsy($type = 'estimate')
    {

        $q = $this->Clients->find()
            ->where(['id_in_sellsy >' => 0])
            ->select(['id', 'email', 'nom', 'sellsy_id' => 'id_in_sellsy', 'id_in_sellsy' => 'count(*)'])
            ->group(['id_in_sellsy'])
            ->having(['count(*) > ' => 1])
            // ->hydrate(false)
            // ->combine('id', 'email')

        ;
        foreach ($q as $key => $client) {
            $allClients = $this->Clients->find()->where(['id_in_sellsy' => $client->sellsy_id]);
            $allClients = $allClients->toArray();
            unset($allClients[0]);
            $otherClients = collection($allClients)->extract('id')->toArray();
            $this->Clients->deleteAll(['id IN' => $otherClients]);
        }
        die();

        // $listeDevis = $this->Devis->find()->contain(['Clients'])->notMatching('Clients')->select(['client_id', 'sellsy_client_id']);

        // debug($listeDevis ->toArray());
        // die();


        // $interval = [
        //     'start'  => \DateTime::createFromFormat('Y-m-d', '2020-07-01')->getTimestamp(),
        //     'end'  => \DateTime::createFromFormat('Y-m-d', '2020-07-01')->getTimestamp(),
        // ];
        $requestClientPagination = array(
            'method' => 'Prospects.getOne',
            'params' => [
                'id' => 19424151
                // 'search' => $interval ?? [],
                // 'doctype' => 'creditnote'
            ]
        );
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $reponseClientPagination = $this->sellsyCurlComponent->requestApi($requestClientPagination);
        debug($reponseClientPagination);
        die();

        $shell = new \Cake\Console\ShellDispatcher();
        // $output = $shell->run(['cake', 'sellsy', 'getReglement', '2018']);
        // $output = $shell->run(['cake', 'sellsy', 'document', $type]);
        // $output = $shell->run(['cake', 'sellsy', 'synchroReglement']);
        $output = $shell->run(['cake', 'sellsy', 'getClient', 19283728, 'Client', 1]);
        
        // $output = $shell->run(['cake', 'sellsy', 'getFactureSellsy', 19105838]);
        die();
    }

    public function SellsyGetClient($clientEntity)
    {
        $this->loadComponent('SellsyApi');
        if (is_int($clientEntity)) {
            $req = $this->SellsyApi->getClient($clientEntity);
        } else {
            $req = $this->SellsyApi->getClient($clientEntity->id_in_sellsy);
        }
        debug($req);
        die();
    }

    public function SellsyGetProspect($prospect_id = 24672319)
    {
        $this->loadComponent('SellsyApi');
        $req = $this->SellsyApi->getProspect($prospect_id);
        debug($req);
        die();
    }

    public function majEcheances()
    {
        $devis = $this->Devis->find()->where(['Devis.is_in_sellsy' => 0]);
        foreach ($devis as $key => $devi) {

            if (!empty($devi->get('Echeances'))) {
                $data['devis_echeances'] = $devi->get('Echeances');
                $devisEntity = $this->Devis->patchEntity($devi, $data, ['validate' => false]);
                if(!$devisEntity->getErrors()) {
                    debug($this->Devis->save($devisEntity));
                } else {
                    debug($devisEntity->getErrors());
                }
            }
        }
        die();
        //code
    }

    public function countDevise($is_in_sellsy = 0){
        $this->viewBuilder()->setLayout('ajax');
        $options = [
            'keyword' => $this->request->getQuery('keyword'),
            'ref_commercial_id' => $this->request->getQuery('ref_commercial_id'),
            'client_type' => $this->request->getQuery('client_type'),
            'created' => $this->request->getQuery('created'),
            'antennes_id' => $this->request->getQuery('antennes_id'),
            'periode' => $this->request->getQuery('periode'),
            'date_threshold' => $this->request->getQuery('date_threshold'),
            'status' => $this->request->getQuery('status')
        ];

        $devis = $this->Devis
                        ->find('complete')
                        ->find('filtre',$options)
                        ->where(['OR' => ['is_model is null', 'is_model' => 0]])
                        ->where(['Devis.is_in_sellsy' => $is_in_sellsy])
                        ->where([
                            'AND' => [
                                ['Devis.status !=' => 'draft'],
                                ['Devis.status !=' => 'canceled'],
                            ]
                        ]);

        $devis = $devis->select([
                            'total_devise' => $devis->func()->sum('Devis.total_ttc')
                        ])->toArray();
        $this->set(compact('devis'));
    }

    public function index($export = null) 
    {

        $listeDevis = $this->Devis->find('complete');
        $devisEntity = $this->Devis->newEntity();

        $keyword = $this->request->getQuery('keyword');
        $client = $this->request->getQuery('client');
        $contact_client = $this->request->getQuery('contact_client');
        $ref_commercial_id = $this->request->getQuery('ref_commercial_id');
        $client_type = $this->request->getQuery('client_type');
        $created = $this->request->getQuery('created');
        $antennes_id = $this->request->getQuery('antennes_id');
        $periode = $this->request->getQuery('periode');
        $date_threshold = $this->request->getQuery('date_threshold');
        $type_doc_id = $this->request->getQuery('type_doc_id');
        $status = $this->request->getQuery('status');
        $sort = $this->request->getQuery('sort');
        $mois_id = $this->request->getQuery('mois_id') ?? (date('m')-1);
        $direction = $this->request->getQuery('direction');
        $montant = $this->request->getQuery('montant');
        
        $customFinderOptions = $this->request->getQuery();
        
        $commercials = $this->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name']); // profile Konitys Commercial
        $antennes = $this->Antennes->find('listByCity');

        $listeDevis->find('filtre', $customFinderOptions);
                
        $sumDevis = $this->Devis->find('all')->find('filtre', $customFinderOptions)->where([['Devis.status <>' => 'canceled']]);

        $total_ht = $sumDevis->sumOf('total_ht');
        $total_ttc = $sumDevis->sumOf('total_ttc');
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // client existant
            if($data['client'] == 1) {
                $this->request->getSession()->write('devis_client', $this->Clients->findById($data['client_id'])->contain('ClientContacts')->first());
                return $this->redirect(['action' => 'add','model_devis_id' => $data['model_devis_id'], 'categorie_tarifaire' => $data['categorie_tarifaire'], 'type_doc_id' => $data['type_doc_id']]);
            }
            
            // nouveau client 
            if($data['client'] == 2) {

                $clientEntity = $this->Clients->newEntity($data['new_client']);

                foreach ($clientEntity->client_contacts as $key => $client_contact) {
                    if (empty(array_filter($client_contact->toArray()))) {
                        unset($clientEntity->client_contacts[$key]);
                    }
                }

                if ($this->Clients->save($clientEntity)) {
                    
                    $this->Flash->success(__('The client has been saved.'));
                    $this->request->getSession()->write('devis_client', $this->Clients->findById($clientEntity->id)->contain('ClientContacts')->first());

                    return $this->redirect(['action' => 'add','model_devis_id' => $data['model_devis_id'], 'categorie_tarifaire' => $data['categorie_tarifaire'], 'type_doc_id' => $data['type_doc_id']]);
                }
            }
        }
        
        $connaissance_selfizee = Configure::read('connaissance_selfizee');
        $categorie_tarifaire = Configure::read('categorie_tarifaire');
        $devis_status = Configure::read('devis_status');
        $type_bornes = Configure::read('type_bornes');
        $periodes = Configure::read('periodes');
        $genres = Configure::read('genres');
        $type_date = Configure::read('type_date');
        $genres_short = Configure::read('genres_short');
        $type_commercials = Configure::read('type_commercials');
        // $clients = $this->Clients->find('list', ['valueField' => 'nom'])->where(['client_type <>' => 'person'])->order(['nom' => 'asc'])->group('nom');
        $groupeClients = $this->Clients->GroupeClients->find('list')->order(['nom' => 'asc']);
        $secteursActivites = $this->Clients->SecteursActivites->find('list')->order(['name' => 'asc']);
        $modelDevis = $this->Devis->find('list',['valueField' => 'model_name'])->order(['model_name'=>'ASC'])->where(['is_model' => 1]);
        $type_docs = $this->Devis->DevisTypeDocs->find('list')->orderAsc('nom')->toArray();
        $modelCategories = $this->Devis->ModeleDevisCategories->find('list');
        $modelSousCategories = $this->Devis->ModeleDevisSousCategories->find('list',['groupField' => 'modele_devis_categories_id']);
        $contactTypes = $this->Clients->ClientContacts->ContactTypes->find('list');
        $mois = $this->Mois->find('list', ['valueField' => 'mois_annee'])->select(['mois_annee' => 'concat(nom, ". ", "'.date('y').'")']);
        $payss = $this->Clients->Payss->find('listAsc');

        if ($export == 'csv') {
            return $this->exportCsv($listeDevis, $genres_short, $devis_status, $type_docs, $type_bornes);
        }
        
        $listeDevis = $this->paginate($listeDevis, ['limit' => 50]);
        $this->set(compact('contactTypes', 'total_ttc', 'total_ht', 'contact_client', 'client', 'keyword', 'periode', 'periodes', 'date_threshold', 'antennes', 'commercials', 'ref_commercial_id','type_commercials','modelDevis','type_bornes', 'type_docs', 'secteursActivites', 'type_doc_id','montant'));
        $this->set(compact('payss', 'type_date','mois', 'mois_id', 'categorie_tarifaire', 'connaissance_selfizee','modelCategories', 'modelSousCategories', 'client_type', 'status', 'genres', 'created', 'antennes_id', 'devis_status', 'listeDevis', 'devisEntity', 'genres_short','groupeClients', 'customFinderOptions'));
    }

    
    public function exportCsv($listeDevis, $genres_short, $devis_status, $type_docs, $type_bornes, $titres = "Liste devis", $filename = 'export-csv-devis') {
        
            $this->viewBuilder()->setLayout('ajax');
            
            $datas = [];
            $datas [] =  [$titres];
            $datas [] = ['N°', 'Client', 'Date', 'Event', 'Antenne(s)', 'Type', 'Doc', 'Borne', 'Contact', 'Total HT', 'Total TTC', 'Restant dû', 'Etat'];
            foreach ($listeDevis as $devis){
                $ligne = [];
                $ligne[] = $devis->indent;
                $ligne[] = $devis->client ? $devis->client->nom : $devis->client_nom;
                $ligne[] = $devis->date_crea? $devis->date_crea->format('d/m/y') : '-';
                
                $date_event = '-';
                if ($devis->date_evenement) {
                    $date_evenement = explode('/', $devis->date_evenement);
                    $date = date_create(@$date_evenement[2] . '-' . @$date_evenement[1] . '-' . @$date_evenement[0]);
                    $date_event = date_format($date,"d/m/y");
                }

                $ligne[] = $date_event;
                $ligne[] = $devis->get('ListeAntennes');
                $ligne[] = @$genres_short[$devis->client->client_type] ?? '';
                $ligne[] = @$type_docs[$devis->type_doc_id] ?? '--';
                $ligne[] = @$type_bornes[$devis->model_type] ?? '';
                $ligne[] = $devis->commercial ? $devis->commercial->get('FullNameShort') : '-';
                $ligne[] = str_replace('.', ',', $devis->total_ht);
                $ligne[] = str_replace('.', ',', $devis->total_ttc);
                $ligne[] = str_replace('.', ',', $devis->reste_echeance_impayee);
                $ligne[] = @$devis_status[$devis->status];

                $datas [] =  $ligne;
            }
            
            $datas = mb_convert_encoding($datas, 'UTF-16LE', 'UTF-8');
            $this->set(compact('datas'));
            $this->render('export_csv');
            $repons = $this->response->withDownload($filename.".csv");
            return $repons;
    }
    

    public function delete($id)
    {
        
        // $this->request->allowMethod(['post', 'delete']);
        $entity = $this->Devis->get($id);
        $result = $this->Devis->delete($entity);
        if($result) {
            $this->Flash->success(__('Devis supprimé avec succès.'));
        }else {
            $this->Flash->error(__('Une erreur est survenue. Veuillez réessayer plus tard.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * version pdf document devis
     * @param type $devis_id
     * @param type $downloadMode
     * @return type
     */
    public function pdfversion($devis_id, $downloadMode = null)
    {
        $forceGenerate = $this->request->getQuery('forceGenerate');
        $testMode = $this->request->getQuery('test'); // pour faire un debug en rendu html
        $download = $this->request->getQuery('download');
        $devisEntity = $this->Devis->get($devis_id, [
            'contain' => ['Tvas', 'DevisEcheances', 'InfosBancaires', 'DevisClientContacts', 'Clients','Antennes', 'DevisTypeDocs', 'DevisProduits'=> function ($q) {
                return $q->contain('CatalogUnites')->order(['DevisProduits.i_position'=>'ASC']);
            }]
        ]);

        if ($forceGenerate) {
            $this->generationPdf($devis_id);
            return $this->response->withFile(WWW_ROOT  . $devisEntity->get('SellsyDocUrl'), ['download' => $download?$download:$downloadMode,]);
        }
            
        if($devisEntity->get('SellsyDocUrl') != '#') {
            
            if (! $devisEntity->is_in_sellsy) {
                $modified = (int) ($devisEntity->modified? $devisEntity->modified->toUnixString() : 0);
                $date = filemtime(WWW_ROOT  . $devisEntity->get('SellsyDocUrl'));
                
                if ($modified > $date) {

                    $this->generationPdf($devis_id);
                }
            }
            return $this->response->withFile(WWW_ROOT  . $devisEntity->get('SellsyDocUrl'), ['download' => $download?$download:$downloadMode,]);
        } else {
            
            $this->generationPdf($devis_id);
            return $this->response->withFile(WWW_ROOT  . $devisEntity->get('SellsyDocUrl'), ['download' => $download?$download:$downloadMode,]);
        }
        return;
    }
    
    
    /**
     * 
     * @param type $devis_id
     * @param type $downloadMode
     * @return type
     */
    public function generationPdf($devis_id)
    {
        
        $moyen_reglements = Configure::read('moyen_reglements');
        $type_prelevements = Configure::read('type_prelevements');
        $delai_reglements = Configure::read('delai_reglements');

        $devisPreferenceEntity = $this->DevisPreferences->find('complete')->first(); // préférence du doc par défaut

        $devisEntity = $this->Devis->get($devis_id, [
            'contain' => ['Tvas', 'DevisEcheances', 'InfosBancaires', 'DevisClientContacts', 'Clients','Antennes', 'Langues', 'DevisTypeDocs', 'DevisProduits'=> function ($q) {
                return $q->contain('CatalogUnites')->order(['DevisProduits.i_position'=>'ASC']);
            }]
        ]);
            
        if($devisEntity->is_in_sellsy) {
            return ;
        }
            
        $fond = 'img/devis/devis-selfizee-fond.jpg';
        $header = "LOCATION ET VENTE DE BORNE PHOTO EN FRANCE ET INTERNATIONAL. ";
        $footer = "";
        $prefixNum = "Devis selfizee";
        if($devisEntity->devis_type_doc){
            $fond = 'img/devis/fond_pdf/' . $devisEntity->devis_type_doc->image;
            $header = $devisEntity->devis_type_doc->header?:$header;
            $footer = $devisEntity->devis_type_doc->footer?:$footer;
            $prefixNum = $devisEntity->devis_type_doc->prefix_num;
        }
        
            
        $currentUser = $this->Users->get($devisEntity->ref_commercial_id, ['contain' => 'Payss']);
        $colVisibilityParams = $devisEntity->get('ColVisibilityParamsAsArray');
        $thHidev = 0;
        if($colVisibilityParams){
            if($devisEntity->categorie_tarifaire == 'ttc') {
                $colVisibilityParams->montant_ht = 1;
            } else {
                $colVisibilityParams->montant_ttc = 1;
                $colVisibilityParams->tva = $devisEntity->display_tva?:$colVisibilityParams->tva;
            }
            foreach ($colVisibilityParams as $col) {
                if($col) {
                    $thHidev++;
                }
            }
        }

        $this->set(compact('type_prelevements', 'devisPreferenceEntity', 'currentUser','devisEntity','colVisibilityParams','thHidev','moyen_reglements','delai_reglements','fond', 'header', 'footer', 'prefixNum'));
        
        // GENERATION FICHIER
        $viewBuilder = $this->viewBuilder()->setClassName('Dompdf.Pdf')->setLayout('pdf/dompdf.default');
        $pdfOptions = Configure::read('DevisPdf');
        if ($devisEntity->langue && $devisEntity->langue->id != 1) {
            
            $target = $devisEntity->langue->code;
            $trans = new GoogleTranslate();
            $this->set(compact('target', 'trans'));
            $pdfOptions['config']['paginate']['text'] = $trans->translate('fr', $target, 'Page') . '{PAGE_NUM}/{PAGE_COUNT}';
            $viewBuilder->setOptions($pdfOptions);
            $content = $this->render('pdf/pdfversion2');
        } else {
            $viewBuilder->setOptions($pdfOptions);
            $content = $this->render('pdf/pdfversion');
        }
        
        $file_name = PATH_DEVIS . $devisEntity->indent.'.pdf';
        if(file_exists($file_name)) {
            unlink($file_name);
        }
        $file = new File($file_name, true, 0755);
        $file->write($content);
    }
    
    public function view($id = null) {
        
        $this->viewBuilder()->setLayout('devis');
        $moyen_reglements = Configure::read('moyen_reglements');
        $devis_status = Configure::read('devis_status');
        $delai_reglements = Configure::read('delai_reglements');
        $genres = Configure::read('genres');
        $type_commercials = Configure::read('type_commercials');
        $connaissance_selfizee = Configure::read('connaissance_selfizee');
        $domaine = Configure::read('https_payement') . '/';
        $secteursActivites = $this->Clients->SecteursActivites->find('list')->order(['name' => 'asc']);

        $devisPreferenceEntity = $this->DevisPreferences->find('complete')->first(); // préférence du doc par défaut
        $devis_client = null;
        $antenne_names = [];
        if ($id) {
            $devisEntity = $this->Devis->findById($id)->first();
            if(! $devisEntity->is_model) {
                $devisEntity = $this->Devis->findById($id)->find('complete')->contain(['DevisTypeDocs', 'StatutHistoriques' => 'Users', 'FactureSituations'])->first();
            } else {
                $devisEntity = $this->Devis->findById($id)->contain(['Clients', 'Antennes', 'DevisProduits'=> function ($q) {
                    return $q->order(['DevisProduits.i_position'=>'ASC']);
                }])->first();
            }
            
            $clientEntity = $devisEntity->client;
            if(empty($clientEntity)){
                $clientEntity = $this->Devis->Clients->newEntity();
            }
           
            $dataClient['nom'] = $devisEntity->client->nom;
            $dataClient['adresse'] = $devisEntity->client->adresse;
            $dataClient['adresse_2'] = $devisEntity->client->adresse_2;
            $dataClient['cp'] = $devisEntity->client->cp;
            $dataClient['ville'] = $devisEntity->client->ville;
            $dataClient['country'] = $devisEntity->client->country;

            $devis_client = $clientEntity = $this->Devis->Clients->patchEntity($clientEntity, $dataClient, ['validate' => false]);
            $refCom = $this->Users->get($devisEntity->ref_commercial_id, ['contain' => 'Payss']);
        }
        if (! $devisEntity->is_model && is_null($devis_client)) {
            $this->Flash->error("Aucun client n'a été défini");
            return $this->redirect(['action' => 'index']);
        }

        $devis_client_contact_id = $this->request->getSession()->read('devis_client_contact_id');
        $devis_doc_param = $this->request->getSession()->read('devis_doc_param');
        $commercial = $this->Users->findById(84)->first();
        $groupeClients = $this->Clients->GroupeClients->find('list')->order(['nom' => 'asc']);
        $payss = $this->Clients->Payss->find('listAsc');
        $newDevisEntity = $this->Devis->newEntity();
        $this->set(compact('groupeClients', 'commercial', 'devis_status', 'moyen_reglements', 'delai_reglements', 'refCom', 'devis_client_contact_id','genres','type_commercials','connaissance_selfizee'));
        $this->set(compact('devisPreferenceEntity', 'id', 'antenne_names', 'devis_client', 'devis_doc_param', 'devisEntity', 'clientEntity','secteursActivites','newDevisEntity','domaine', 'payss'));
    }
    
    public function ModelList() {
        
        $cat = $this->request->getQuery('category');
        $sousCat = $this->request->getQuery('sous-category');
        $keyword = $this->request->getQuery('keyword_model');
        $model_type = $this->request->getQuery('model_type');
        
        $customFinderOptions = [
            'cat' => $cat,
            'sous-cat' => $sousCat,
            'keyword_model' => $keyword,
            'model_type' => $model_type
        ];
        
        $listeDevis = $this->Devis->find('listModel',$customFinderOptions);

        $devis_status = Configure::read('devis_status');
        $genres = Configure::read('genres');
        $type_bornes = Configure::read('type_bornes');
        $genres_short = Configure::read('genres_short');
        $type_commercials = Configure::read('type_commercials');
        $categories = $this->Devis->ModeleDevisCategories->find('list');
        $sousCategories = $this->Devis->ModeleDevisSousCategories->find('list',['groupField' => 'modele_devis_categories_id']);

        $this->set(compact('devis_status' , 'genres' , 'genres_short' , 'type_commercials', 'listeDevis', 'categories', 'sousCategories', 'cat', 'sousCat', 'type_bornes', 'model_type', 'keyword'));
    }
    
    
    public function paiementSession() {
        
        if ($this->request->is(['post'])) {
            
            $is_test = $this->request->getData('is_test');
            $devis_id_encoded = $this->request->getData('devis_id');
            $echeance = $this->request->getData('echeance');
            $montant =  str_replace([" ", " ", " ", "€", "TTC", ","], ["","","","","","."], $this->request->getData('montant'));
            $montant = floatval($montant)*100;
            
            $devis_id = @current(unserialize(base64_decode($devis_id_encoded)));
            $devisEntity = $this->Devis->findById($devis_id)->first();
            $indent = $devisEntity->indent;
            $img = "https://crm.konitys.fr/img/devis/spherik.jpg";
            if ($devisEntity->model_type == 'classik') {
                $img = "https://crm.konitys.fr/img/devis/classik.jpg";
            }
            
            $secret = $this->stripeApiKeySecret;
            
            if ($is_test) {
                $secret = Configure::read('api_key.dev.secret');
            }
            
            Stripe::setApiKey($secret);

            // Configure::read('https_payement');
            $YOUR_DOMAIN = Configure::read('https_payement');
            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'unit_amount' => $montant,
                        'product_data' => [
                            'name' => "N° commande : $indent",
                            'images' => [$img],
                        ],
                    ],
                'quantity' => 1,
                ]],
                'metadata' => [
                    'devis_id' => $devis_id_encoded,
                    'echeance' => $echeance,
                ],
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/fr/devis/make-payment-new?session_id={CHECKOUT_SESSION_ID}' . ($is_test? "&test=1" : ''),
                //'cancel_url' => $YOUR_DOMAIN . "/fr/devis/paiement/$devis_id"
                'cancel_url' => $YOUR_DOMAIN . Router::url($devisEntity->get('EncryptedUrl')),
            ]);

            return $this->response->withType('application/json')->withStringBody(json_encode(['id' => $checkout_session->id]));
                
        }
        
        return;

    }

    
    public function paiement($id) {
        
        $devisEntity = $this->Devis->findById($id)->find('complete')->first();
        $devisPreferenceEntity = $this->DevisPreferences->find('complete')->first();

        if($devisEntity) {
            
            if(count($devisEntity->devis_factures)) {
                $devisFactureEntity = $devisEntity->devis_factures[0];
                $this->redirect($devisFactureEntity->get('EncryptedUrl'));
            }
            
            $devis_status = Configure::read('devis_status');
            $this->viewBuilder()->setLayout('public');
            $stripeApiKeyPublic = $this->stripeApiKeyPublic;
            $this->loadModel('DocumentMarketings');
            $documentMarketing = $this->DocumentMarketings->find()->first();

            $devisEcheances = collection($devisEntity->devis_echeances);

            /**
             * si 1ere echéance (accompte) = montant total, ne pas afficher la 1ère ligne
             * quand le dernier acompte à  payer = le solde , ne pas rajouter une ligne supplémentaire "régler la totalité du document", car à§a revient au même.
             */
            $firstFindEcheance = $devisEcheances->first();
            $isFirstFindedEcheanceSameAsTotalDevisAmount =  @$firstFindEcheance->montant == $devisEntity->total_ttc;

            $isClientPro = ($devisEntity->get('ClientType') == 'corporation' || ! $devisEntity->get('ClientType'));
            // inclure si des paiements en dehors de la page we (chèque, virement) ont été effectués
            $paiementAutresQueCartes = collection($devisEntity->devis_reglements)->filter(function ($item)
            {
                return $item->moyen_reglement->name_court != 'CB';
            });

            $lastFindEcheance = $devisEcheances->last();
            $isLastFindedEcheanceSameAsTotalDevisAmount =  @$lastFindEcheance->montant == $devisEntity->get('ResteEcheanceImpayee');

            $this->set(compact('devisPreferenceEntity', 'paiementAutresQueCartes', 'isClientPro', 'firstFindEcheance', 'isFirstFindedEcheanceSameAsTotalDevisAmount', 'lastFindEcheance', 'isLastFindedEcheanceSameAsTotalDevisAmount', 'stripeApiKeyPublic', 'devisEntity', 'devis_status','documentMarketing'));
            
            if ($devisEntity->type_doc_id && $devisEntity->type_doc_id != 1) {
                
                if(in_array($devisEntity->type_doc_id, [5,6])) {
                    $this->render('paiement_vente_locfi');
                }
                
                $this->render('paiement_pro');
            }
            
        } else {
            throw new NotFoundException();
        }
    }
    
    
    public function viewPublic($id) {
        
        $devisEntity = $this->Devis->findById($id)->find('complete')->first();
        $devisPreferenceEntity = $this->DevisPreferences->find('complete')->first();

        if($devisEntity) {
            
            if(count($devisEntity->devis_factures)) {
                $devisFactureEntity = $devisEntity->devis_factures[0];
                $this->redirect($devisFactureEntity->get('EncryptedUrl'));
            }
            
            $devis_status = Configure::read('devis_status');
            $this->viewBuilder()->setLayout('public');
            $stripeApiKeyPublic = $this->stripeApiKeyPublic;
            $this->loadModel('DocumentMarketings');
            $documentMarketing = $this->DocumentMarketings->find()->first();

            $devisEcheances = collection($devisEntity->devis_echeances);

            /**
             * si 1ere echéance (accompte) = montant total, ne pas afficher la 1ère ligne
             * quand le dernier acompte à  payer = le solde , ne pas rajouter une ligne supplémentaire "régler la totalité du document", car à§a revient au même.
             */
            $firstFindEcheance = $devisEcheances->first();
            $isFirstFindedEcheanceSameAsTotalDevisAmount =  @$firstFindEcheance->montant == $devisEntity->total_ttc;

            $isClientPro = ($devisEntity->get('ClientType') == 'corporation' || ! $devisEntity->get('ClientType'));
            // inclure si des paiements en dehors de la page we (chèque, virement) ont été effectués
            $paiementAutresQueCartes = collection($devisEntity->devis_reglements)->filter(function ($item)
            {
                return $item->moyen_reglement->name_court != 'CB';
            });

            $lastFindEcheance = $devisEcheances->last();
            $isLastFindedEcheanceSameAsTotalDevisAmount =  @$lastFindEcheance->montant == $devisEntity->get('ResteEcheanceImpayee');

            $this->set(compact('devisPreferenceEntity', 'paiementAutresQueCartes', 'isClientPro', 'firstFindEcheance', 'isFirstFindedEcheanceSameAsTotalDevisAmount', 'lastFindEcheance', 'isLastFindedEcheanceSameAsTotalDevisAmount', 'stripeApiKeyPublic', 'devisEntity', 'devis_status','documentMarketing'));
            
            if ($devisEntity->type_doc_id && $devisEntity->type_doc_id != 1) {
                
                if(in_array($devisEntity->type_doc_id, [5,6])) {
                    $this->render('view_public_vente_locfi');
                }
                
                $this->render('view_public_pro');
            }
            
        } else {
            throw new NotFoundException();
        }
    }
    
    public function toFacture($devis_id) {
        $dataFacture = $this->Devis->findById($devis_id)->find('asModele', ['removed_client' => 0])->toArray();
        if (count($dataFacture)) {
            $this->request->getSession()->write('devis_factures_client', $this->Clients->findById($dataFacture['client_id'])->contain('ClientContacts')->first());
            $this->redirect(['controller' => 'DevisFactures', 'action' => 'add', 'devis_id' => $devis_id]);
        }
        $this->redirect(['action' => 'index']);
    }
    
    public function EditEtat($devis_id, $client_id = null) {
        $devis = $this->Devis->findById($devis_id)->first();
        if ($devis) {
            $devis = $this->Devis->patchEntity($devis, $this->request->getData());
            if($this->Devis->save($devis)){
                $this->setStatutHistorique($devis->id, $devis->status);
                $this->Flash->success(__('L\'état du devis a été bien changé.'));
            } else {
                $this->Flash->success(__('Erreur de modification de l\'état du devis.'));
            }
        }
        
        return $this->redirect($this->referer());
    }

    
    public function EditTypeDoc($devis_id) {
        $devis = $this->Devis->findById($devis_id)->first();
        if ($devis) {
            $devis = $this->Devis->patchEntity($devis, $this->request->getData(), ['validate' => false]);
            if($this->Devis->save($devis)){
                $this->Flash->success(__('Le type de document du devis a été bien changé.'));
            } else {
                $this->Flash->success(__('Erreur de modification du type document du devis.'));
            }
        }
        
        return $this->redirect($this->referer());
    }

    
    /**
     * lié avec additionalData du devis/stripe_payment.js
     * @return [type] [description]
     */
    public function makePaymentNew()
    {
 
        Stripe::setApiKey($this->stripeApiKeySecret);
        $session = \Stripe\Checkout\Session::retrieve($this->request->getQuery('session_id'));
        $customer = Customer::retrieve($session->customer);
        $devis_id_encoded = $session->metadata->devis_id;
        $echeance = $session->metadata->echeance;
        
        $this->loadModel('Reglements');
        $devis_id = @current(unserialize(base64_decode($devis_id_encoded)));
        $devisEntity = $this->Devis->findById($devis_id)->contain(['DevisEcheances', 'DevisReglements', 'DevisStripeHistorics', 'Clients', 'Antennes'])->first();

        $publicUrl = $devisEntity->get('EncryptedUrl');
        $devisEcheancesEntity = null;

        if ($devisEntity !== null) {
            
            $data = [
                'echeance' => $echeance,
                'email' => $customer->email
            ];
            $indent = $devisEntity->indent;

            $statutPayement = '';
            if (isset($data['echeance'])) {
                if ($data['echeance'] == 'total_remaining') {
                    $montant = $devisEntity->get('ResteEcheanceImpayee');
                    $stautPayement = 'paid';
                    $data['status'] = $statutPayement;
                    $data['date_total_paiement'] = Time::now();
                    $data['montant_total_paid'] = $montant;
                } 
                elseif ($devisEcheancesEntity = $this->Devis->DevisEcheances->get($data['echeance'])) {
                    $montant = $devisEcheancesEntity->montant;
                    $statutPayement = 'partially_paid';
                    $data['status'] = $statutPayement;
                    $data['devis_echeances'] = $this->Devis->DevisEcheances->findByDevisId($devisEntity->id)->toArray();
                    foreach ($data['devis_echeances'] as $key => $devis_echeances) {
                        $data['devis_echeances'][$key] = $devis_echeances->toArray();
                        if ($devis_echeances->id == $devisEcheancesEntity->id) {
                            $data['devis_echeances'][$key] = [
                                'id' => $devisEcheancesEntity->id,
                                'is_payed' => 1,
                                'date_paiement' => Time::now()
                            ];
                        }
                    }

                }
                else {
                    $this->Flash->error("Échéance non trouvée");
                    return $this->redirect($publicUrl);
                }
            }

            if (!isset($montant)) {
                $this->Flash->error("Aucun montant n'a été défini");
                return $this->redirect($publicUrl);
            }

            if ($session->payment_status == 'paid') {

                foreach ($devisEntity->devis_echeances as $key => $echeance) {
                    $echeance->isNew(false);
                }

                // cf dicus skype, on peut associer plusieurs devis/factures à  un client, un réglement peut être attribué à  +ieurs devis/factures
                $data['reglement'] = [
                    'type' => 'credit',
                    'client_id' => $devisEntity->client_id,
                    'moyen_reglement_id' => 5,
                    'date' => date('Y-m-d'),
                    'montant' => $montant,
                    'email' => $data['email'],
                    'reference' => $devisEntity->indent,
                    'etat' => 'confirmed',
                    'montant_restant' => $devisEntity->get('ResteEcheanceImpayee') > 0 ? $devisEntity->get('ResteEcheanceImpayee') - $montant : 0
                ];

                if($devisEntity->get('ResteEcheanceImpayee') - $montant <= 0) {
                    $data['status'] = 'paid';
                    $data['date_total_paiement'] = FrozenTime::now();
                    $data['montant_total_paid'] = $montant;
                }

                $devisEntity = $this->Devis->patchEntity($devisEntity, $data, ['validate' => false]);

                if(!$devisEntity->getErrors()) {
                    $devisEntity = $this->Devis->save($devisEntity);
                    $this->insertNewReglementsAndSendEmail($devisEntity);
                    $this->createFactureAfetrPaiement($devisEntity->id);
                    $this->setStatutHistorique($devisEntity->id, $statutPayement);
                    $indent = $devisEntity->indent;
                    $this->generationPdf($devisEntity->id);
                    // $this->Flash->success("Votre paiement a été effectué avec succés");
                    return $this->redirect(['action' => 'confirmation']);
                } else {
                    $this->Flash->error("Le paiement n'a pas pu être effectué, veuillez recommencer");
                    return $this->redirect($publicUrl);
                }
            }
        
        } else {
            $this->Flash->error("Le paiement n'a pas pu être effectué, veuillez recommencer");
            return $this->redirect($publicUrl);
        }

    }
    
    /**
     * lié avec additionalData du devis/stripe_payment.js
     * @return [type] [description]
     */
    public function makePayment($devis_id_encoded)
    {
        $this->loadModel('Reglements');
        $devis_id = @current(unserialize(base64_decode($devis_id_encoded)));
        $devisEntity = $this->Devis->findById($devis_id)->contain(['DevisEcheances', 'DevisReglements', 'DevisStripeHistorics', 'Clients', 'Antennes'])->first();

        $stripeApiKeySecret = $this->stripeApiKeySecret;
        $publicUrl = $devisEntity->get('EncryptedUrl');
        $devisEcheancesEntity = null;

        if ($devisEntity !== null && $this->request->is(['put'])) {
            $data = $this->request->getData();
            $indent = $devisEntity->indent;

            $stripeForm = new StripeForm();
            if (!$stripeForm->validate($data)) {
                foreach ($stripeForm->errors() as $key => $error) {
                    $this->Flash->error(current($error));
                }
                return $this->redirect($publicUrl);
            }

            $statutPayement = '';
            if (isset($data['echeance'])) {
                if ($data['echeance'] == 'total_remaining') {
                    $montant = $devisEntity->get('ResteEcheanceImpayee');
                    $stautPayement = 'paid';
                    $data['status'] = $statutPayement;
                    $data['date_total_paiement'] = Time::now();
                    $data['montant_total_paid'] = $montant;
                } 
                elseif ($devisEcheancesEntity = $this->Devis->DevisEcheances->get($data['echeance'])) {
                    $montant = $devisEcheancesEntity->montant;
                    $statutPayement = 'partially_paid';
                    $data['status'] = $statutPayement;
                    $data['devis_echeances'] = $this->Devis->DevisEcheances->findByDevisId($devisEntity->id)->toArray();
                    foreach ($data['devis_echeances'] as $key => $devis_echeances) {
                        $data['devis_echeances'][$key] = $devis_echeances->toArray();
                        if ($devis_echeances->id == $devisEcheancesEntity->id) {
                            $data['devis_echeances'][$key] = [
                                'id' => $devisEcheancesEntity->id,
                                'is_payed' => 1,
                                'date_paiement' => Time::now()
                            ];
                        }
                    }

                }
                else {
                    $this->Flash->error("Échéance non trouvée");
                    return $this->redirect($publicUrl);
                }
            }

            if (!isset($montant)) {
                $this->Flash->error("Aucun montant n'a été défini");
                return $this->redirect($publicUrl);
            }
            // debug($data);
            // die();
            // activena en mode prod
            // if (($charge = Cache::read('stripe_debug')) === false) {
                Stripe::setApiKey($stripeApiKeySecret);
                $charge = Charge::create([
                    'amount'        => $montant*100, // * 100 car stripe enregistre les unités en centimes
                    'currency'      => 'EUR',
                    'description'   => "Paiement devis numéro : $indent",
                    'source'      => $data['stripeToken'],
                    'receipt_email' => $data['email'],
                    'metadata' => [
                        'indent' => $indent
                    ]
                ]);
                // Cache::write('stripe_debug', $charge);
            // }

            if (@$charge->paid == true && @$charge->status == 'succeeded') {
            // if (true) {

                foreach ($devisEntity->devis_echeances as $key => $echeance) {
                    $echeance->isNew(false);
                }

                // cf dicus skype, on peut associer plusieurs devis/factures à  un client, un réglement peut être attribué à  +ieurs devis/factures
                $data['reglement'] = [
                    'type' => 'credit',
                    'client_id' => $devisEntity->client_id,
                    'moyen_reglement_id' => 5,
                    'date' => date('Y-m-d'),
                    'montant' => $montant,
                    'email' => $data['email'],
                    'reference' => $devisEntity->indent,
                    'etat' => 'confirmed',
                    'montant_restant' => $devisEntity->get('ResteEcheanceImpayee') > 0 ? $devisEntity->get('ResteEcheanceImpayee') - $montant : 0
                ];
                
                if($devisEntity->get('ResteEcheanceImpayee') - $montant <= 0) {
                    $data['status'] = 'paid';
                    $data['date_total_paiement'] = FrozenTime::now();
                    $data['montant_total_paid'] = $montant;
                }

                // debug($devisEntity->get('ResteEcheanceImpayee') - $montant);
                // debug($data['status']);
                // die();
                $devisEntity = $this->Devis->patchEntity($devisEntity, $data, ['validate' => false]);
                // debug($devisEntity);
                // die();
                // $this->insertNewReglementsAndSendEmail($devisEntity);

                if(!$devisEntity->getErrors()) {
                    $devisEntity = $this->Devis->save($devisEntity);
                    $this->insertNewReglementsAndSendEmail($devisEntity);
                    $this->createFactureAfetrPaiement($devisEntity->id);
                    $this->setStatutHistorique($devisEntity->id, $statutPayement);
                    $indent = $devisEntity->indent;
                    $this->generationPdf($devisEntity->id);
                    // $this->Flash->success("Votre paiement a été effectué avec succés");
                    return $this->redirect(['action' => 'confirmation']);
                } else {
                    $this->Flash->error("Le paiement n'a pas pu être effectué, veuillez recommencer");
                    return $this->redirect($publicUrl);
                }
            } else {
            }

        } else {
            $this->Flash->error("Le paiement n'a pas pu être effectué, veuillez recommencer");
            return $this->redirect($publicUrl);
        }

    }

    public function insertNewReglementsAndSendEmail($devisEntity = null)
    {
        $this->viewBuilder()->setLayout(false);
        if ($devisEntity) {
            $reglement = $devisEntity->reglement;
            $reglementEntity = $this->Reglements->newEntity($reglement, ['validate' => false]);
            $send = false;
            if ($reglementEntity = $this->Reglements->save($reglementEntity)) {
                $data = ['reglements_id' => $reglementEntity->id, 'devis_id' => $devisEntity->id];
                $findedRelation = $this->Reglements->ReglementsHasDevis->find()->where($data)->first();
                $send = true;
                if (!$findedRelation) {
                    $reglementHasDevisEntity = $this->Reglements->ReglementsHasDevis->newEntity($data);
                    $this->Reglements->ReglementsHasDevis->save($reglementHasDevisEntity);
                }
            };

            $options = [
                'from' => 'Selfizee',
                'fromEmail' => 'contact@konitys.fr',
                'subject' => 'Confirmation de réservation Selfizee',
                'template' => 'reglement',
                'layout' => 'blank'
            ];

            // die();
            // if ($send == true) {
            if (true) {
                $reglementEmail = $reglementEntity->email;
                $clientEmail = $devisEntity->client->email;
                $bcc = [];
                if ($clientEmail != $reglementEmail && !empty($clientEmail)) {
                    $bcc = [$clientEmail];
                }

                if ($reglementEmail) {
                    if ($this->request->getEnv('REMOTE_ADDR') != '127.0.0.1' && $this->request->getEnv('REMOTE_ADDR') != 'localhost') { // en test
                        // email client
                        $email = $this->Emails->sendTo(['email' => $reglementEmail, 'bcc' => $bcc, 'devisEntity' => $devisEntity, 'reglementEntity' => $reglementEntity], $options);
                        
                        // email konitys
                        $reglements = $this->Reglements->ReglementsHasDevis->find('list')->where(['devis_id' => $devisEntity->id])->toArray();
                        $subject = '';
                        $title = 'Nouvelle réservation';
                        
                        if ($devisEntity->get('ClientType') == 'person') {
                            $annee = '';
                            if(!empty($devisEntity->date_evenement)){
                                $annee = @$devisEntity->date_evenement->format('Y');
                            }
                            $subject = 'Nouvelle réservation Particulier'.($devisEntity->model_type != null ? ' - '.ucfirst($devisEntity->model_type) : '').' - '.$annee;
                            if (count($reglements) > 1) {
                                $subject = 'Règlement d\'un devis Particulier'.($devisEntity->model_type != null ? ' - '.ucfirst($devisEntity->model_type) : '').' - '.$annee;
                                $title = 'Règlement d\'un devis';
                            }
                        } elseif ($devisEntity->get('ClientType') == 'corporation') {
                            $subject = 'Nouvelle réservation Pro'.(count($devisEntity->antennes) > 0 ? ' - Antenne' : '');
                            if (count($reglements) > 1) {
                                $subject = 'Règlement d\'un devis Pro'.(count($devisEntity->antennes) > 0 ? ' - Antenne' : '');
                                $title = 'Règlement d\'un devis';
                            }
                        }

                        $options = [
                            'from' => 'Selfizee',
                            'fromEmail' => 'contact@konitys.fr',
                            'subject' => $subject,
                            'template' => 'reglement_konitys',
                            'layout' => 'blank'
                        ];
                        $email = $this->Emails->sendTo(['email' => 'contact@konitys.fr', 'devisEntity' => $devisEntity, 'reglementEntity' => $reglementEntity, 'title' => $title], $options);
                    }
                    // echo $email['message']; // debug
                    // die();
                }

                // $this->set(compact('email'));
                // $this->render('/Email/test');
            }
        }
    }
    
    
    function createFactureAfetrPaiement($devis_id = null) {
        
        if($devis_id) {
            
            $this->loadModel('Reglements');
            // creation facture a partir du devis
            $factures = $this->Devis->DevisFactures->findByDevisId($devis_id)->contain(['DevisFacturesEcheances', 'DevisFacturesProduits'])->first();
            $devisFacturesData = $this->Devis->findById($devis_id)->find('asModele',['removed_client' => 0, 'to_facture' => 1])->toArray();
            if($factures) {
                
                if($factures->devis_factures_echeances) {
                    $devis_facture_echeances_ids = collection($factures->devis_factures_echeances)->extract('id')->toArray();
                    $this->Devis->DevisFactures->DevisFacturesEcheances->deleteAll(['id IN ' => $devis_facture_echeances_ids]);
                }
                if($factures->devis_factures_produits) {
                    $devis_facture_produit_ids = collection($factures->devis_factures_produits)->extract('id')->toArray();
                    $this->Devis->DevisFactures->DevisFacturesProduits->deleteAll(['id IN ' => $devis_facture_produit_ids]);
                }
                
                $devisFacturesData['devis_factures_produits'] = $devisFacturesData['devis_produits'];
                $devisFacturesData['devis_id'] = $devis_id;
                $devisFacturesEntity = $this->Devis->DevisFactures->patchEntity($factures, $devisFacturesData);
                
            }else {
                $indent = $this->Utilities->incrementIndent($this->Devis->DevisFactures->find()->orderAsc('indent')->last(), 'FK-');
                $devisFacturesData['indent'] = $indent;
                $devisFacturesData['date_crea'] = Chronos::now()->format('Y-m-d');
                $devisFacturesData['created'] = Chronos::now()->format('Y-m-d H:i:s');
                $devisFacturesData['devis_factures_produits'] = $devisFacturesData['devis_produits'];
                $devisFacturesData['devis_id'] = $devis_id;
                $devisFacturesEntity = $this->Devis->DevisFactures->newEntity($devisFacturesData);
            }
            if($this->Devis->DevisFactures->save($devisFacturesEntity)) {
                $devis = $this->Devis->findById($devis_id)->contain(['DevisReglements'])->first();
                $reglements = $devis->devis_reglements;
                foreach ($reglements as $reglement) {
                    $data = ['reglements_id' => $reglement->id, 'devis_factures_id' => $devisFacturesEntity->id];
                    $findedRelation = $this->Reglements->ReglementsHasDevisFactures->find()->where($data)->first();
                    if (!$findedRelation) {
                        $data['montant_lie'] = $reglement->montant;
                        $reglementHasDevisFacturesEntity = $this->Reglements->ReglementsHasDevisFactures->newEntity($data, ['validate' => false]);
                        $this->Reglements->ReglementsHasDevisFactures->save($reglementHasDevisFacturesEntity);
                    }
                }
                
                $devisFacturesEntity->status = $devis->status == 'paid' ? 'paid' : 'partial-payment';
                $this->Devis->DevisFactures->save($devisFacturesEntity);
                
                $this->loadModel('StatutHistoriques');
                $dataStat['devis_facture_id'] = $devisFacturesEntity->id;
                $dataStat['time'] = time();
                $dataStat['statut_document'] = $devisFacturesEntity->status;
                $dataStat['user_id'] = 84;
                $statutHistorique = $this->StatutHistoriques->newEntity($dataStat, ['validate' => false]);
                $this->StatutHistoriques->save($statutHistorique);

                $this->requestAction('/fr/factures/generation-pdf/' . $devisFacturesEntity->id);
            }
        }
    }

    
    public function decodeUrl($param = '') {

        $host = $this->request->host();
        //debug($host); die;

        //if($host != Configure::read('url_payement')){

        if($host != Configure::read('url_payement') && !Configure::read('debug')){

            header('Location:https://'.Configure::read('url_payement')."/d/".$param, true, 301);
            die;
        }
        		
        $parametre = @unserialize($this->Utilities->slDecryption($param));

        $action = $parametre['action'];
        $id = $parametre['id'];
        if($action == 'pdfversion') {
            $download = !empty($parametre['download'])?$parametre['download']:null;
            return $this->setAction('pdfversion', $id,$download);
        }
        if($action == 'view-public') {
            //$this->setAction('viewPublic', $id);
            $this->setAction('paiement', $id);
        }
    }

    public function  confirmation(){
        $this->viewBuilder()->setLayout('public');
    }
    
    public function duplicatDevis($devis_id) {
        
        if($this->request->is(['post', 'put'])) {
            
            $data = $this->request->getData();
            $client = $this->request->getData('client_id');
            
            // client existant
            if($data['client'] == 1) {
                $this->request->getSession()->write('devis_client', $this->Clients->findById($client)->contain('ClientContacts')->first());
                
            } elseif($data['client'] == 2) {

                $clientEntity = $this->Clients->newEntity($data['new_client']);

                foreach ($clientEntity->client_contacts as $key => $client_contact) {
                    if (empty(array_filter($client_contact->toArray()))) {
                        unset($clientEntity->client_contacts[$key]);
                    }
                }

                if ($this->Clients->save($clientEntity)) {
                    $this->Flash->success(__('The client has been saved.'));
                    $this->request->getSession()->write('devis_client', $this->Clients->findById($clientEntity->id)->contain('ClientContacts')->first());
                }
            } elseif($data['client'] == 3) {
                $devisEntity = $this->Devis->findById($devis_id)->first();
                $client_id = $devisEntity->client_id;
                $this->request->getSession()->write('devis_client', $this->Clients->findById($client_id)->contain('ClientContacts')->first());
            }
            return $this->redirect(['action' => 'add','model_devis_id' => $devis_id]);
        } else {
            if($this->request->getQuery('is_model')) {
                return $this->redirect(['action' => 'add','model_devis_id' => $devis_id, 'is_model' => 1]);
            }
        }
        return $this->redirect($this->referer());
    }
    
    /**
     *  pour l'api
     */
    public function createDevis() {
        
        $return = [
            'success' => false, 
            'message' => '',
            'client_id' => null,
            'opportunite_id' => null,
            'devis_classik_id' => null,
            'devis_spherik_id' => null,
        ];
        
        // $this->Utilities->logginto($return, 'devis/create_devis');
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // $this->Utilities->logginto($data, 'devis/create_devis');


            $this->loadModel('Opportunites');
            $dataOpportunite = isset($data['opportunite'])?$data['opportunite']:null;
            $source_lead_id = 0;
            if(count($dataOpportunite)) {
                $source_lead_id = $this->Opportunites->SourceLeads->getIdSourceLead($dataOpportunite['source_lead']);
                if(!$source_lead_id) {
                    $source_lead = $this->Opportunites->SourceLeads->newEntity(['nom' => $dataOpportunite['source_lead']],['validate' => false]);
                    $this->Opportunites->SourceLeads->save($source_lead);
                    $source_lead_id = $source_lead->id;
                }
            }

            $dataClient = $data['client'];
            $dataClient['source_lead_id'] = $source_lead_id;
            $idInWp = $dataClient['id_in_wp'];
            $clientEntity = $this->Clients->findByIdInWp($dataClient['id_in_wp'])->contain('ClientContacts')->first();

            if(!$clientEntity) {
                $clientEntity = $this->Clients->newEntity($dataClient);
                $this->Clients->save($clientEntity);
            }
            
            $return['client_id'] = $clientEntity->id;
            
            $newOpp  = null;
            
            if(count($dataOpportunite)) {
                
                $type_evenement_id = $this->Opportunites->TypeEvenements->find()->find('idTypeEvenement', ['nom' => $dataOpportunite['type_evenement']]);
                if(!$type_evenement_id) {
                    $type_evenement = $this->Opportunites->TypeEvenements->newEntity(['nom' => $dataOpportunite['type_evenement']],['validate' => false]);
                    $this->Opportunites->TypeEvenements->save($type_evenement);
                    $type_evenement_id = $type_evenement->id;
                }

                //option_fond_vert
                if(!empty($dataOpportunite['option_fond_vert'])){
                    if(strtolower($dataOpportunite['option_fond_vert']) == 'oui'){
                        $dataOpportunite['option_fond_vert_id'] = 1;
                    }else if(strtolower($dataOpportunite['option_fond_vert']) == 'non'){
                        $dataOpportunite['option_fond_vert_id'] = 2;
                    }else{
                        $dataOpportunite['option_fond_vert_id'] = 3;
                    }
                }else{
                    $dataOpportunite['option_fond_vert_id'] = 2;
                }
                unset($dataOpportunite['option_fond_vert']);

                //Besion Impression
                if(!empty($dataOpportunite['besion_borne'])){
                    if(strtolower($dataOpportunite['besion_borne']) == 'oui'){
                        $dataOpportunite['besion_borne_id'] = 1;
                    }else{
                        $dataOpportunite['besion_borne_id'] = 2;
                    }
                }else{
                    $dataOpportunite['besion_borne_id'] = 2;
                }
                unset($dataOpportunite['besion_borne']);

                //$numero = $this->Utilities->incrementIndent($this->Opportunites->find()->orderAsc('numero')->last(), 'OPP-', 'numero');

                $dataOpportunite['numero'] = $this->Utilities->incrementNumeroOpportunite();
                $dataOpportunite['source_lead_id'] = $source_lead_id;
                $dataOpportunite['type_evenement_id'] = $type_evenement_id;
                $dataOpportunite['client_id'] = $clientEntity->id;
                $dataOpportunite['id_in_wp'] = $idInWp;
                //$newOpp = $this->Opportunites->newEntity($dataOpportunite,['validate' => false]);
                $newOpp = $this->Opportunites->newEntity();
                $oppInBase = $this->Opportunites->find()->where(['id_in_wp' => $idInWp])->first();
                if(!empty($oppInBase)){
                    $newOpp = $oppInBase;
                }
                $newOpp = $this->Opportunites->patchEntity($newOpp, $dataOpportunite,['validate' => false]);


                if($this->Opportunites->save($newOpp)) {
                    //Save Timeline Opportunité
                    $dTimeline['opportunite_id'] = $newOpp->id;
                    $dTimeline['time_action'] = time();
                    $dTimeline['opportunite_action_id'] = 1;
                    $dTimeline['pipeline_etape_id'] = $newOpp->pipeline_etape_id;
                    $dTimeline['user_id'] = null;
                    $opportuniteTimeline = $this->Opportunites->OpportuniteTimelines->newEntity($dTimeline);
                    $this->Opportunites->OpportuniteTimelines->save($opportuniteTimeline);

                    $return['opportunite_id'] = $newOpp->id;
                    //Create event
                    $evenement['nom_event'] = $newOpp->nom_evenement;
                    $evenement['opportunite_type_borne_id'] = $newOpp->opportunite_type_borne_id;
                    $evenement['nbr_borne'] = $newOpp->nbr_borne;
                    $evenement['nbr_participants'] = $newOpp->nbr_participants;
                    $evenement['nbr_borne'] = $newOpp->nbr_borne;
                    $evenement['client_id'] = $newOpp->client_id;
                    $evenement['type_evenement_id'] = $newOpp->type_evenement_id;
                    $evenement['description'] = $newOpp->demande_precision;
                    $evenement['lieu_exact'] = $newOpp->lieu_evenement;
                    $evenement['is_posted_on_event'] = true;
                    $evenement['horaires'] = '-';
                    $evenement['opportunite_type_borne_id'] = $newOpp->opportunite_type_borne_id;
                    $evenement['option_fond_vert_id'] = $newOpp->opportunite_type_borne_id;
                    $evenement['besion_borne_id'] = $newOpp->besion_borne_id;
                    $evenement['date_event'] = $newOpp->date_debut_event;
                    
                    $evnt = $this->Opportunites->Evenements->newEntity($evenement);
                    if($this->Opportunites->Evenements->save($evnt)){
                        //debug($evnt); die;
                        $newOpp->evenement_id = $evnt->id;
                        if(!$this->Opportunites->save($newOpp)){
                            //debug($newOpp); die;
                        }
                    }

                }
            }
            
            if ($clientEntity->id) {

                $return['success'] = true ;

                if(!empty($data['type']) && !empty($data['devis'])){
                    $devisEntities = [];
                    $type = $data['type'];
                    $idModelEmail = $data['model_email_id'];
                    foreach ($data['devis'] as $devisData) {
                        $valeurDynamic = array_filter($devisData['valeur_dynamic']);
                        $default = [
                            'date_evenement_fin' => ' ',
                            'date_evenement' => ' ', 
                            'ville_principale' => ' ', 
                            'lieu_retrait' => ' ', 
                            'ville_secondaire' => ' ', 
                            'nom_evenement' => ' '
                        ];
                        $valeurDynamic = array_merge($default, $valeurDynamic);
                        $replace = [
                            'date_evenement_fin' => '',
                            'date_evenement' => '#DATE-EVENT#', 
                            'ville_principale' => '#VILLE-PRINCIPALE#', 
                            'lieu_retrait' => '#LIEU-RETRAIT#', 
                            'ville_secondaire' => '#VILLES-SECONDAIRES#', 
                            'nom_evenement' => '#NOM-EVENEMENT#'
                        ];
                        ksort($replace); ksort($valeurDynamic);
                        $newData = $this->Devis->findById($devisData['model_devis_id'])->find('asModele')->toArray();
                        $newData['date_crea'] = Chronos::now()->format('Y-m-d');
                        $newData['created'] = Chronos::now()->format('Y-m-d H:i:s');
                        $newData['date_validite'] = Chronos::now()->addMonth(1)->format('Y-m-d');
                        $newData['date_sign_before'] = Chronos::now()->addMonth(1)->format('Y-m-d');
                        $newData['client_id'] = $clientEntity->id;
                        $newData['client_nom'] = $clientEntity->prenom.' '.$clientEntity->nom;
                        $newData['client_adresse'] = $clientEntity->adresse;
                        $newData['client_adresse_2'] = $clientEntity->adresse_2;
                        $newData['client_cp'] = $clientEntity->cp;
                        $newData['client_ville'] = $clientEntity->ville;
                        $newData['client_country'] = $clientEntity->country;
                        $newData['ref_commercial_id'] = 84;
                        $newData['type_doc_id'] = 1;
                        $newData['delai_reglements'] = $devisData['delai_reglements'];
                        $newData['devis_echeances'] = $devisData['devis_echeances'];
                        $newData['indent'] = $this->Utilities->incrementIndent($this->Devis->find()->orderAsc('indent')->last());
                        $newData['objet'] = str_replace($replace, $valeurDynamic, $newData['objet']);
                        $newData['lieu_retrait'] = $valeurDynamic['lieu_retrait'];
                        $newData['lieu_evenement'] = $devisData['lieu_evenement'];

                        $dateEvent = $valeurDynamic['date_evenement'];
                        $dateArray = explode("/", $dateEvent);
                        if(count($dateArray) == 3 ){
                            $newDateFormat = trim($dateArray[2]).'-'.trim($dateArray[1])."-".trim($dateArray[0]);
                            $newData['date_evenement'] = $newDateFormat;
                        }

                        $dateEventFin = $valeurDynamic['date_evenement'];
                        $dateArrayFin = explode("/", $dateEventFin);
                        if(count($dateArrayFin) == 3 ){
                            $newDateFormat = trim($dateArrayFin[2]).'-'.trim($dateArrayFin[1])."-".trim($dateArrayFin[0]);
                            $newData['date_evenement_fin'] = $newDateFormat;
                        }

                        $newData['id_in_wp'] = $idInWp;

                        //Lier les devis et les antennes
                        $_ids = array();
                        $this->loadModel('Antennes');
                        if(!empty($valeurDynamic['lieu_retrait'])){
                            $ville = trim($valeurDynamic['lieu_retrait']);
                            if(!empty($ville)){
                                $antenne = $this->Antennes->find()
                                                ->where(['ville_excate'=>$ville])
                                                ->first();
                                if(!empty($antenne)){
                                    array_push($_ids, $antenne->id);
                                }
                            }
                        }

                        if(!empty($_ids)){
                            $newData['antennes']['_ids'] = $_ids;
                        }

                        $devisEntity = $this->Devis->newEntity();
                        $devisInBase = $this->Devis->find()->where([
                                                        'id_in_wp' => $idInWp,
                                                        'model_type' => $devisData['model_type']
                                                    ])->contain(['DevisProduits'])->first();
                        if(!empty($devisInBase)){
                            $devisEntity = $devisInBase;
                            unset($newData['indent']);
                            // delete row devis produit
                            if($devisEntity->devis_produits) {
                                $devis_produit_ids = collection($devisEntity->devis_produits)->extract('id')->toArray();
                                if(count($devis_produit_ids)) {
                                    $this->Devis->DevisProduits->deleteAll(['id IN ' => $devis_produit_ids]);
                                }
                            }
                        }
                        $devisEntity = $this->Devis->patchEntity($devisEntity, $newData,['validate' => false]);

                        if($this->Devis->save($devisEntity)) {
                            $this->addToShortLink($devisEntity);
                            $this->generationPdf($devisEntity->id);
                            $devisEntities[] = $devisEntity;
                            $return['devis_' . $newData['model_type'] . '_id'] = $devisEntity->id;

                            //lié l'opportunité et le doc
                            if(!empty($return['opportunite_id'])){
                                $docLie['opportunite_id'] = $return['opportunite_id'];
                                $docLie['devi_id'] = $devisEntity->id;
                                $this->loadModel('LinkedDocs');
                                $linkedDoc = $this->LinkedDocs->newEntity($docLie);
                                $this->LinkedDocs->save($linkedDoc);
                            }
                        }else{
                            print_r($devisEntity);
                        }
                    }

                    /*
                     *Pour ne pas envoyer les mails deux fois on stocke ce qui sont envoyé ou pas. On ne refait pas d'envoi meme si c'est is_send false. On vérifie on envoi manuel. 
                     **/
                    
                    $this->loadModel('WpDevisSends');
                    $isDevisWpSend = $this->WpDevisSends->find()
                                                        ->where(['id_post_wp' =>$idInWp])
                                                        ->first();

                    if(count($devisEntities) && empty($isDevisWpSend)) {
                        $isSend = false;
                        $reponse = $this->sendMailWithMailjet($devisEntities, $clientEntity, $type, $idModelEmail);
                        if($reponse['success']){
                           $isSend = true;
                            foreach($devisEntities as $oneDevis){
                                $oneDevis->status = 'expedie';
                                $oneDevis->message_id_in_mailjet = $reponse['message_id_in_mailjet'];
                                if($this->Devis->save($oneDevis)){
                                    /*$this->loadModel('StatutHistoriques');
                                    $dataStat['devi_id'] = $oneDevis->id;
                                    $dataStat['time'] = time();
                                    $dataStat['statut_document'] = 'expedie';
                                    $statutHistorique = $this->StatutHistoriques->newEntity($dataStat);
                                    $this->StatutHistoriques->save($statutHistorique);*/
                                    $this->setStatutHistorique($oneDevis->id, 'expedie');
                                }

                            }
                        }
                        $send['is_send'] = $isSend;
                        $send['id_post_wp'] = $idInWp;
                        $wpDevisSend = $this->WpDevisSends->newEntity($send);
                        $this->WpDevisSends->save($wpDevisSend);

                        //Envoi sms 
                        //$this->sendSms($clientEntity->tel);
                        
                        /**
                        * Déplacé l'opportunité dans la pipe : Devis auto envoyé ID = 323556 
                        **/
                        if(!empty($newOpp) && !empty($newOpp->id)){
                            $newOpp->pipeline_etape_id = 323556;
                            $this->Opportunites->save($newOpp);
                        }
                    }
                }

            } else {
                $return = ['success' => false, 'message' => $clientEntity->getErrors()];
            }
        }
//        $this->viewBuilder()->setLayout('ajax');
//        $this->set(compact('return'));
        
        return $this->response->withType('application/json')->withStringBody(json_encode($return));
    }

    public function sendMailWithMailjet($devisEntities, $clientEntity, $type, $idModelEmail)
    {

        $this->Utilities->loadModels(['Emails', 'ModelesMails','DocumentMarketings']);
        $modelMail = $this->ModelesMails->get($idModelEmail);

        $subject = $modelMail ? $modelMail->objet : 'SELFIZEE - Devis de location de borne photo';

        $message = $modelMail ? $modelMail->contenu : "";

        $documentMarketing = $this->DocumentMarketings->find()->first();
        $attachements = array();
        //$links = ['devis_classik' => '', 'devis_spherik' => ''];
        $linkClassik = '';
        $linkSpherik = '';
        $domaine = Configure::read('https_payement');
        foreach ($devisEntities as $key => $devisEntity) {
            //$link = $devisEntity->short_links?$devisEntity->short_links[0]->short_link:$domaine.Router::url($devisEntity->get('EncryptedUrl'));
            $link = $domaine.Router::url($devisEntity->get('EncryptedUrl'));
            
            //$links['devis_' . $devisEntity->model_type] = '<a href="'.$link.'"">'.ucfirst($devisEntity->model_type).'-'.$devisEntity->indent.'</a>';
            if($devisEntity->model_type == 'classik'){
                $linkClassik = '<a href="'.$link.'"">'.ucfirst($devisEntity->model_type).'-'.$devisEntity->indent.'</a>';
            }else if($devisEntity->model_type == 'spherik'){
                $linkSpherik = '<a href="'.$link.'"">'.ucfirst($devisEntity->model_type).'-'.$devisEntity->indent.'</a>';
            }

            if(!empty($documentMarketing)){ 
                if($devisEntity->model_type == 'classik' && !empty($documentMarketing->catalogue_classik)){
                    if(file_exists($documentMarketing->path_catalogue_classik)){
                        $oneAttachement = array();
                        $base64ConentPdf = base64_encode(file_get_contents($documentMarketing->path_catalogue_classik, true));
                        $oneAttachement = [
                                                'ContentType' => "application/pdf",
                                                'Filename' => 'Catalogue Classik.pdf',
                                                'Base64Content' => $base64ConentPdf
                                            ];
                        array_push($attachements, $oneAttachement);
                    }
                }elseif($devisEntity->model_type == 'spherik'){
                    
                    $annee = '';
                    if(!empty($devisEntity->date_evenement)){
                        $annee = @$devisEntity->date_evenement->format('Y');
                        if($annee == '2020'){
                            if(!empty($documentMarketing->catalogue_spherik_2020)){
                                if(file_exists($documentMarketing->get('PathCatalogueSpherik2020'))){
                                    $oneAttachement = array();
                                    $base64ConentPdf = base64_encode(file_get_contents($documentMarketing->get('PathCatalogueSpherik2020'), true));
                                    $oneAttachement = [
                                                        'ContentType' => "application/pdf",
                                                        'Filename' => 'Catalogue Spherik.pdf',
                                                        'Base64Content' => $base64ConentPdf
                                                        ];
                                    array_push($attachements, $oneAttachement);
                                }
                            }
                        }else{
                            //2021
                            if(!empty($documentMarketing->catalogue_spherik)){
                                if(file_exists($documentMarketing->path_catalogue_spherik)){

                                    $oneAttachement = array();
                                    $base64ConentPdf = base64_encode(file_get_contents($documentMarketing->path_catalogue_spherik, true));
                                    $oneAttachement = [
                                                        'ContentType' => "application/pdf",
                                                        'Filename' => 'Catalogue Spherik.pdf',
                                                        'Base64Content' => $base64ConentPdf
                                                        ];
                                    array_push($attachements, $oneAttachement);
                                }
                            }
                        }
                    }else{
                        // 2021 par défaut
                        if(!empty($documentMarketing->catalogue_spherik)){
                            if(file_exists($documentMarketing->path_catalogue_spherik)){
                                $oneAttachement = array();
                                $base64ConentPdf = base64_encode(file_get_contents($documentMarketing->path_catalogue_spherik, true));
                                $oneAttachement = [
                                                    'ContentType' => "application/pdf",
                                                    'Filename' => 'Catalogue Spherik.pdf',
                                                    'Base64Content' => $base64ConentPdf
                                                    ];
                                array_push($attachements, $oneAttachement);
                            }
                        }
                    }
                    
                    
                }else{
                    if(file_exists($documentMarketing->path_catalogue_classik)){
                        $oneAttachement = array();
                        $base64ConentPdf = base64_encode(file_get_contents($documentMarketing->path_catalogue_classik, true));
                        $oneAttachement = [
                                            'ContentType' => "application/pdf",
                                            'Filename' => 'Catalogue Classik.pdf',
                                            'Base64Content' => $base64ConentPdf
                                            ];
                        array_push($attachements, $oneAttachement);
                    }
                    if(file_exists($documentMarketing->path_catalogue_spherik)){
                        $oneAttachement = array();
                                $base64ConentPdf = base64_encode(file_get_contents($documentMarketing->path_catalogue_spherik, true));
                                $oneAttachement = [
                                                    'ContentType' => "application/pdf",
                                                    'Filename' => 'Catalogue Spherik.pdf',
                                                    'Base64Content' => $base64ConentPdf
                                                    ];
                                array_push($attachements, $oneAttachement);
                    }
                }
            }
        }
        /*$searche = ['devis_classik' => '[[lien_devis_classik]]', 'devis_spherik' => '[[lien_devis_spherik]]'];
        
        ksort($links);
        ksort($searche);
        $message = str_replace($searche, $links, $message);*/

        $message = str_replace('[[lien_devis_classik]]', $linkClassik, $message);
        $message = str_replace('[[lien_devis_spherik]]', $linkSpherik, $message);

        $this->loadComponent('Mailjet');
        $res = $this->Mailjet->sendEmail($clientEntity->email, $subject, $message, $attachements);

        //var_dump($res);
        $response['success'] = false;
        $response['message_id_in_mailjet'] = null;
        if(!empty($res['Messages'][0]['Status'])){
            if($res['Messages'][0]['Status'] == 'success'){
                $response['success'] = true;
                $response['message_id_in_mailjet'] = $res['Messages'][0]['To'][0]['MessageID'];
            }
        }

        return $response;

    }
    
    public function sendMail($devisEntities, $clientEntity, $type, $idModelEmail) {
        
        $this->Utilities->loadModels(['Emails', 'ModelesMails','DocumentMarketings']);
        //$modelMail = $this->ModelesMails->findByType($type)->first();
        $modelMail = $this->ModelesMails->get($idModelEmail);
        $options = [
            'from' => 'Selfizee',
            'fromEmail' => 'contact@konitys.fr',
            'subject' => $modelMail?$modelMail->objet : 'SELFIZEE - Devis de location de borne photo',
            'template' => 'devis'
        ];
        
        $body = $modelMail?$modelMail->contenu:"";
        
        $email = $clientEntity->email;
        $bcc    = [];
        if($clientEntity->client_contacts) {
            foreach ($clientEntity->client_contacts as $client_contact) {
                if ($client_contact->email) {
                    $bcc[] = $client_contact->email;
                }
            }
        }

        $documentMarketing = $this->DocumentMarketings->find()->first();

        $attachments = [];
        $links = ['devis_classik' => '', 'devis_spherik' => ''];
        //$domaine = 'https://'.Configure::read('url_payement');
        $domaine = Configure::read('https_payement');
        foreach ($devisEntities as $key => $devisEntity) {
            $link = $devisEntity->short_links?$devisEntity->short_links[0]->short_link:$domaine.Router::url($devisEntity->get('EncryptedUrl'));
            
            $links['devis_' . $devisEntity->model_type] = '<a href="'.$link.'"">'.ucfirst($devisEntity->model_type).'-'.$devisEntity->indent.'</a>';

            if(!empty($documentMarketing)){ 
                $attachement = array();
                if($devisEntity->model_type == 'classik' && !empty($documentMarketing->catalogue_classik)){
                    if(file_exists($documentMarketing->path_catalogue_classik)){
                        $attachement['file'] = $documentMarketing->path_catalogue_classik;
                        $attachement['mimetype'] = 'application/pdf';
                        $attachments['Catalogue Classik.pdf'] = $attachement;
                    }
                }elseif($devisEntity->model_type == 'spherik'){

                    $annee = '';
                    if(!empty($devisEntity->date_evenement)){
                        $annee = @$devisEntity->date_evenement->format('Y');
                        if($annee == '2020'){
                            if(!empty($documentMarketing->catalogue_spherik_2020)){
                                if(file_exists($documentMarketing->get('PathCatalogueSpherik2020'))){
                                    $attachement['file'] = $documentMarketing->get('PathCatalogueSpherik2020');
                                    $attachement['mimetype'] = 'application/pdf';
                                    $attachments['Catalogue Spherik.pdf'] = $attachement;
                                }
                            }
                        }else{
                            //2021
                            if(!empty($documentMarketing->catalogue_spherik)){
                                if(file_exists($documentMarketing->path_catalogue_spherik)){
                                    $attachement['file'] = $documentMarketing->path_catalogue_spherik;
                                    $attachement['mimetype'] = 'application/pdf';
                                    $attachments['Catalogue Spherik.pdf'] = $attachement;
                                }
                            }
                        }
                    }else{
                        // 2021 par défaut
                        if(!empty($documentMarketing->catalogue_spherik)){
                            if(file_exists($documentMarketing->path_catalogue_spherik)){
                                $attachement['file'] = $documentMarketing->path_catalogue_spherik;
                                $attachement['mimetype'] = 'application/pdf';
                                $attachments['Catalogue Spherik.pdf'] = $attachement;
                            }
                        }
                    }


                }else{
                    if(file_exists($documentMarketing->path_catalogue_classik)){
                        $attachement['file'] = $documentMarketing->path_catalogue_classik;
                        $attachement['mimetype'] = 'application/pdf';
                        $attachments['Catalogue Classik.pdf'] = $attachement;
                    }
                    if(file_exists($documentMarketing->path_catalogue_spherik)){
                        $attachement['file'] = $documentMarketing->path_catalogue_spherik;
                        $attachement['mimetype'] = 'application/pdf';
                        $attachments['Catalogue Spherik.pdf'] = $attachement;
                    }
                }
            }

        }
        $searche = ['devis_classik' => '[[lien_devis_classik]]', 'devis_spherik' => '[[lien_devis_spherik]]'];
        
        ksort($links);
        ksort($searche);
        $body = str_replace($searche, $links, $body);
        $dataEmail = ['email' => $email, 'bcc' => $bcc, 'body' => $body];
        
         return $this->Emails->sendTo($dataEmail, $options , $attachments);
    }

    public function sendSms($telephone, $text = null){
        if(!empty($telephone) ){
            $numeroDestinataire = trim(trim($telephone));
            $_2PremierLettre = substr($numeroDestinataire,0,2);
            $_3PremierLettre = substr($numeroDestinataire,0,3);
            $numeroDestinataire = str_replace(" ", "", $numeroDestinataire);
            if($_2PremierLettre == "06" || $_2PremierLettre == "07" || $_3PremierLettre == "+33"){ // On fait de l'envoi pour la france seulement
                    $codepaysDefault   = "+33";
                    if (strpos($numeroDestinataire, "+") === false) {
                        $numeroDest         = substr($numeroDestinataire, 1);
                        $numeroDestinataire = $codepaysDefault . $numeroDest;
                    } else {
                        $numeroDestinataire = $numeroDestinataire;
                    }
    
                    if(! $text) {
                        $text = "Bonjour,\nVotre devis Selfizee et la brochure de présentation sont arrivés dans votre boite mail. N'hésitez pas à  vérifier vos spams le cas échéant.\nBonne consultation !\nLa team Selfizee";
                    }
                    
                    $body = ['From' => 'SELFIZEE', 'To'=>$numeroDestinataire, 'Text'=>$text];
                    $mjsms = new \Mailjet\Client('01fa19fab78948018b2d162083aa391f',
                      NULL, true, 
                      ['url' => "api.mailjet.com", 'version' => 'v4', 'call' => false]
                    );
                    $response = $mjsms->post(Resources::$SmsSend, ['body' => $body] );
            }
        }
    }
    
    /**
     *  pour l'api
     */
    public function modelDevisList() {
        
        $this->viewBuilder()->setLayout('ajax');
        
        $listeDevis = $this->Devis->find('listModel',[])->find('modeleWithType');

        $this->set(compact('listeDevis'));
    }

    public function historique($id){
        $devis = $this->Devis->findById($id)->contain(['StatutHistoriques' => 'Users'])->first();
        $devis_status = Configure::read('devis_status');
        $this->set(compact('devis','devis_status'));
    }

    /**
     * copier dans ajaxDevis
     * @param type $devisId
     * @param type $statut
     * @return type
     */
    protected function setStatutHistorique($devisId, $statut){
        if(!empty($statut) && !empty($devisId)){
            $user_id = 84;
            if($this->Auth->user('id')) {
                $user_id = $this->Auth->user('id');
            }
            $this->loadModel('StatutHistoriques');
            $dataStat['devi_id'] = $devisId;
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

                foreach (array_filter($data['devis']) as $devis_id => $value) {
                    $devisEntity = $this->Devis->findById($devis_id)->first();
                    $isTmpFilesCreated = $this->Zip->uploadTmpFile($devisEntity);
                }

                if ($isTmpFilesCreated) {
                    $this->Zip->compressAndDownload($filename = 'Devis.zip'); // compresse et telecharge les fichiers stockés temporairement via ->uploadTmFile()
                } else {
                    $this->Flash->error("Une erreur est survenue, veuillez recommencer la procédure");
                }
            } elseif ($data['action'] == 'delete') {
                
                $devis_ids = array_filter($data['devis']);
                $devis_ids = array_keys($devis_ids);
                $this->Devis->deleteAll(['id IN ' => $devis_ids]);
            }
            
            return $this->redirect($this->referer());
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getGifImages() {

        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        $directory = new Folder(WWW_ROOT . '/img/status-gif/');
        $files = $directory->find('.*', true);

        echo json_encode($files);

    }

    public function gif() {

    }
    
}
