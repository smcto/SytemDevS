<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use \Statickidz\GoogleTranslate;
use Stripe\Stripe;
use Cake\Collection\Collection;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\Charge;
use Cake\Routing\Router;
use Cake\Validation\Validator;
use App\Form\StripeForm;
use Cake\I18n\Time;
use Cake\Cache\Cache;
use Cake\ORM\Query;
use Cake\Database\Expression\QueryExpression;
use Cake\Filesystem\File;


/**
 * DevisFactures Controller
 *
 * @property \App\Model\Table\DevisFacturesTable $DevisFactures
 *
 * @method \App\Model\Entity\DevisFacture[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevisFacturesController extends AppController
{
    public $defaultTva = false;

    /**
     * Propriété initialisée dans App\Controller\AppController
     * @var [string]
     */
    public $action; 

    /**
     * 
     * @param array $config
     */
    public function initialize(array $config = [])
    {

        parent::initialize($config);
        $this->loadComponent('Utilities');
        $this->Utilities->loadModels(['Mois', 'Tvas', 'Clients', 'CatalogUnites', 'CatalogProduits', 'Antennes', 'Users', 'DevisFacturesPreferences', 'Payss', 'DevisPreferences','Emails']);
        $this->Auth->allow(['decodeUrl', 'confirmation', 'pdfversion', 'generationPdf', 'viewPublic', 'makePayment', 'makeReglement', 'paiement', 'paiementSession', 'makePaymentNew']);

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
     * r. = règles
     * r1 . les sous menus dashboards ne sont accessibles que par l'Admin et le Comptable et bloqués pour les autres y compris les commerciaux 
     * @param type $user
     * @return boolean
     */
    public function isAuthorized($user)
    {
        $isRolePermis = (bool) array_intersect($user['profils_alias'] , ['admin', 'compta']);

        if (!$isRolePermis && in_array($this->action, ['dashboardReglementsRetard', 'dashboardSyntheseMensuelle'])) {
            return false;
        }

        $typeprofils = $user['typeprofils'];
        if(array_intersect(['admin', 'konitys'], $typeprofils)) {
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
            $this->delSession('devis_factures_client');
            return $this->redirect(['action' => 'add', $id]);
        }
        // préférence du doc par défaut
        $devisFacturesPreferenceEntity = $this->DevisPreferences->find('complete')->first(); // basé sur preferences devis
        $devisFacturesPreferenceEntityArray = $devisFacturesPreferenceEntity->toArray();
        unset($devisFacturesPreferenceEntityArray['id']);
        $indent = $this->Utilities->incrementIndent($this->DevisFactures->find()->orderAsc('indent')->last(), 'FK-');
        $ancienStatut = '';
        $hasModel = false;
        $isDataInSaveRequest = false;

        // ENREGISTREMENT DEVIS
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['tva_id'] = $this->defaultTva->id;

            // SI MODEL
            if($data['is_model']  && $data['new_model']) {
                unset($data['id']);
                unset($data['indent']);
                $data['uuid'] = uniqid();
                if(!empty($data['devis_factures_produits'])) {
                    foreach ($data['devis_factures_produits'] as $key => $devis_factures_produits) {
                        if(isset($devis_factures_produits['id'])) {
                            unset($data['devis_factures_produits'][$key]['id']);
                        }
                    }
                }
                
                if($data['parametre_preference']) {
                    $data = array_merge($data, $devisFacturesPreferenceEntityArray);
                }
                $devisFacturesEntity = $this->DevisFactures->newEntity();
                
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
                    $devisFacturesEntity = $this->DevisFactures->findById($id)
                        ->contain(['DevisFacturesEcheances', 'InfosBancaires', 'Clients', 'Client2', 'Antennes', 'DevisFacturesProduits'=> function ($q) {
                        return $q->order(['DevisFacturesProduits.i_position'=>'ASC']);
                    }])->first();
                    $ancienStatut = $devisFacturesEntity->status;
                } else {
                    $devisFacturesEntity = $this->DevisFactures->newEntity();
                }
            }
            
            $devisFacturesEntity = $this->DevisFactures->patchEntity($devisFacturesEntity, $data);
            
            if (!empty($devisFacturesEntity->devis_factures_produits)) {
                foreach ($devisFacturesEntity->devis_factures_produits as $key => $devis_factures_produits) {
                    if (empty(array_filter($devis_factures_produits->toArray()))) {
                        unset($devisFacturesEntity->devis_factures_produits[$key]);
                    }
                }
            }

            if(!$devisFacturesEntity->getErrors()) {
                $newStatut = $devisFacturesEntity->status;
                if ($devisFacturesEntity = $this->DevisFactures->save($devisFacturesEntity)) {
                    $this->addToShortLink($devisFacturesEntity);
                    $this->generationPdf($devisFacturesEntity->id);
                    if($ancienStatut != $newStatut){
                        $this->setStatutHistorique($devisFacturesEntity->id, $newStatut);
                    }
                    $this->Flash->success('La facture a été enregistrée');
                    if($data['is_continue']){
                        return $this->redirect(['action' => 'add', $devisFacturesEntity->id, 1]);
                    } if($data['is_model']) {
                        return $this->redirect(['action' => 'ModelList']);
                    } else {
                        return $this->redirect(['action' => 'index']);
                    }
                } else {
                    $this->Flash->error("La factures n'a pas pu être enregistré");
                }
            } else {
                $this->Flash->error("La facture n'a pas pu être enregistré");
            }

            $isDataInSaveRequest = true;
        }

        if ($id) {
            $devisFacturesEntity = $this->DevisFactures->findById($id)
                ->contain([
                    'DevisFacturesEcheances' => function ($q) {return $q->contain(['DevisFactures'])->order(['DevisFacturesEcheances.id'=>'ASC']);}, 
                    'InfosBancaires', 'FactureClientContacts', 'Clients', 'Antennes', 'Client2',
                    'DevisFacturesProduits'=> function ($q) {
                        return $q->order(['DevisFacturesProduits.i_position'=>'ASC']);
                    }
                ])
                ->first()
            ;

            $clientEntity = $devisFacturesEntity->client;
            $dataClient = [];
            $dataClient['nom'] = $devisFacturesEntity->client->nom;
            $dataClient['adresse'] = $devisFacturesEntity->client->adresse;
            $dataClient['adresse_2'] = $devisFacturesEntity->client->adresse_2;
            $dataClient['cp'] = $devisFacturesEntity->client->cp;
            $dataClient['ville'] = $devisFacturesEntity->client->ville;
            $dataClient['country'] = $devisFacturesEntity->client->country;

            if ($this->request->getSession()->read('devis_factures_client') !== null) {
                $devis_factures_client = $this->request->getSession()->read('devis_factures_client');
                $devis_facturesModifiedInSession['client_nom'] = $devis_factures_client->nom;
                $devis_facturesModifiedInSession['client_adresse'] = $devis_factures_client->adresse;
                $devis_facturesModifiedInSession['client_adresse_2'] = $devis_factures_client->adresse_2;
                $devis_facturesModifiedInSession['client_cp'] = $devis_factures_client->cp;
                $devis_facturesModifiedInSession['client_ville'] = $devis_factures_client->ville;
                $devis_facturesModifiedInSession['client_country'] = $devis_factures_client->country;
                $devisFacturesEntity = $this->DevisFactures->patchEntity($devisFacturesEntity, $devis_facturesModifiedInSession, ['validate' => false]);
                $clientEntity = $this->DevisFactures->Clients->patchEntity($clientEntity, $dataClient, ['validate' => false]);
            } else {
                $devis_factures_client = $clientEntity = $this->DevisFactures->Clients->patchEntity($clientEntity, $dataClient, ['validate' => false]);
            }

            $currentUser = $this->Users->get($this->DevisFactures->get($id)->ref_commercial_id, ['contain' => 'Payss']);
            
        } else {
            
            // facturation devis
            $devis_id = $this->request->getQuery('devis_id');
            $devisFacturesData = [];
            if($devis_id) {
                
                $devisFacturesData = $this->DevisFactures->Devis->findById($devis_id)->find('asModele',['removed_client' => 0, 'to_facture' => 1])->toArray();
                $devis_factures_client = $clientEntity = $this->Clients->findById($devisFacturesData['client_id'])->contain('ClientContacts')->first();
                $devisFacturesData['devis_factures_produits'] = $devisFacturesData['devis_produits'];
                $devisFacturesData['devis_id'] = $devis_id;
                $devisFacturesData['date_crea'] = Chronos::now();
                $devisFacturesData['date_validite'] = Chronos::now()->addMonth(1);
                $devisFacturesEntity = $this->DevisFactures->newEntity($devisFacturesData, ['validate' => false]);
                $currentUser = $this->Users->get($devisFacturesData['ref_commercial_id'], ['contain' => 'Payss']);
                $hasModel = true;
            } else {
                
                // creation nouveau
                $is_model = $this->request->getQuery('is_model');
                $devis_factures_client = $clientEntity = $this->request->getSession()->read('devis_factures_client');
                // creation MODEL factures : ataoko client par defaut fotsiny io 2501 io
                if($is_model){
                    $devis_factures_client = $clientEntity = $this->Clients->findById(2501)->contain('ClientContacts')->first();
                }

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
                    'is_model' => $is_model,
                    'categorie_tarifaire' => $categorie_tarifaire,
                    'type_doc_id' => $type_doc_id,
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

                $model_id = $this->request->getQuery('model_devis_facture_id');
                if($model_id) {
                    
                    // charge la factures en tant que modèle
                    $devisFacturesEntity = $this->DevisFactures->findById($model_id)->find('asModele');
                    $hasModel = true;
                } else {
                    
                    // creation facture sans model
                    $devisFacturesEntity = $this->DevisFactures->newEntity();
                    $newDatas = array_merge($newDatas, $devisFacturesPreferenceEntityArray);
                }

                $devisFacturesEntity = $this->DevisFactures->patchEntity($devisFacturesEntity,$newDatas, ['validate' => false]);
                $currentUser = $this->Users->get($this->currentUser()->id, ['contain' => 'Payss']);
            }
        }
        
        if($devisFacturesEntity->is_in_sellsy) {
            $this->Flash->error("Les documents de sellsy ne peut pas être modifier");
            return $this->redirect($this->referer());
        }
        
        if (is_null($devis_factures_client)) {
            if (!$isDataInSaveRequest) {
                $this->Flash->error("Aucun client n'a été défini");
            }
            return $this->redirect(['action' => 'index']);
        }

        $devis_factures_client_contact_id = $this->request->getSession()->read('devis_factures_client_contact_id');
        $devis_factures_doc_param = $this->request->getSession()->read('devis_factures_doc_param');
        
        $this->viewBuilder()->setLayout('devis_factures');
        $type_bornes = Configure::read('type_bornes');
        $civilite = Configure::read('civilite');
        $devis_factures_status = Configure::read('devis_factures_status');
        $moyen_reglements = Configure::read('moyen_reglements');
        $categorie_tarifaires = Configure::read('categorie_tarifaire');
        $delai_reglements = Configure::read('delai_reglements');
        $newContact = $this->DevisFactures->Clients->ClientContacts->newEntity();
        $devis_type_docs = $this->DevisFactures->DevisTypeDocs->find('list')->orderAsc('nom');
        $clientContacts = $this->Clients->ClientContacts->findByClientId($clientEntity->id)->group(['nom', 'prenom'])->find('list', ['valueField' => 'full_name']);
        $commercials = $this->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name']); // profile Konitys Commercial
        $catalogUnites = $this->CatalogUnites->find('list', ['valueField' => 'nom']);
        $catalogProduits = $this->CatalogProduits->find('all');
        $infosBancaires = $this->DevisFactures->InfosBancaires->find('list');
        $categorie = $this->CatalogProduits->CatalogProduitsHasCategories->CatalogCategories->find('list', ['valueField'=>'nom'])->orderAsc('nom');
        $antennes = $this->Antennes->find('listByCity');
        $colVisibilityParams = $devisFacturesEntity->get('ColVisibilityParamsAsArray');
        $modelDevisFacturesCategorie = $this->DevisFactures->ModeleDevisFacturesCategories->find('list', ['valueField'=>'name'])->orderAsc('name');
        $modelDevisFacturesSousCategorie = $this->DevisFactures->ModeleDevisFacturesSousCategories->find('list', ['valueField'=>'name','groupField' => 'modele_devis_factures_category_id'])->orderAsc('name');
        $publicLink = $this->Utilities->slEncryption(serialize(['action' => 'view-public', 'id' => $id]));
        $client_2 = [];
        if($devisFacturesEntity->client_id_2) {
            $client2 = $this->Clients->findById($devisFacturesEntity->client_id_2)->first();
            $client_2 = $client2?[$client2->id => $client2->full_name] : [];
        }
        $langues = $this->DevisFactures->Langues->find('list')->order(['nom' => 'ASC']);
        $this->delSession('devis_factures_client');

        $this->set(compact('client_2', 'langues', 'type_bornes', 'devisFacturesPreferenceEntity', 'infosBancaires', 'moyen_reglements', 'delai_reglements', 'catalogUnites', 'commercials', 'currentUser', 'devis_factures_client_contact_id','modelDevisFacturesCategorie', 'categorie_tarifaires', 'publicLink','devis_type_docs'));
        $this->set(compact('indent', 'devis_factures_status', 'id', 'colVisibilityParams', 'devis_factures_client', 'devis_factures_doc_param', 'devisFacturesEntity', 'clientEntity', 'clientContacts','catalogProduits','categorie','antennes','modelDevisFacturesSousCategorie', 'newContact', 'civilite', 'hasModel'));
    }
    
    
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addSituation($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $data = $this->request->getData();
            if($id) {
                $factureSituationEntity = $this->DevisFactures->findById($id)->find('complete', ['is_situation' => 1])->first();
            } else {
                $factureSituationEntity = $this->DevisFactures->newEntity();
            }
            
            $factureSituationEntity = $this->DevisFactures->patchEntity($factureSituationEntity, $data);
            if ($this->DevisFactures->save($factureSituationEntity)) {
                $this->generationPdf($factureSituationEntity->id);
                $this->Flash->success('La facture de situation a été enregistré');
                if($data['is_continue']) {
                    $this->redirect(['action' => 'addSituation', $factureSituationEntity->id]);
                } else {
                    $this->redirect(['controller' => 'Devis', 'action' => 'view', $factureSituationEntity->devis_id]);
                }
            } else {
                debug($factureSituationEntity->getErrors());
                $this->Flash->error("La facture de situation n'a pas pu être enregistré");
            }
        }
        
        $this->viewBuilder()->setLayout('devis_factures');
        $devis_id = $this->request->getQuery('devis_id');
        // creation new
        if($devis_id) {
            
            $indent = $this->Utilities->incrementIndent($this->DevisFactures->find()->orderAsc('indent')->last(), 'FK-');
            $newDatas = [
                'indent' => $indent,
                'date_crea' => Chronos::now(),
            ];
            
            $data = $this->DevisFactures->Devis->findById($devis_id)->contain(['FactureSituations'])->find('toSituation');
            $data = array_merge($data, $newDatas);
            $data['numero'] = count($data['facture_situations']) + 1;
            
            if($data) {
                
                $factureSituationEntity = $this->DevisFactures->newEntity($data);
                $currentUser = $this->Users->get($this->currentUser()->id, ['contain' => 'Payss']);
            }
        } elseif ($id) {
            $factureSituationEntity = $this->DevisFactures->findById($id)->find('complete', ['is_situation' => 1])->first();
            $currentUser = $this->Users->get($factureSituationEntity->ref_commercial_id, ['contain' => 'Payss']);
        }
        
        $facture_situations_status = Configure::read('facture_situations_status');
        $commercials = $this->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name'])->where(['toujours_present' => 1]); // profile Konitys Commercial
        $this->set(compact('id', 'devis_id', 'factureSituationEntity', 'commercials', 'facture_situations_status', 'currentUser'));
    }

    
    
    public function addToShortLink($devisFacturesEntity) {
        
        $parametre = $this->Utilities->slEncryption(serialize(['id' => $devisFacturesEntity->id, 'action' => 'view-public']));
        if(! $this->DevisFactures->ShortLinks->findByDevisFactureId($devisFacturesEntity->id)->first()) {
            $shortLinkData = [
                'short_link' => 'link/' . uniqid(),
                'link' => 'f/' . $parametre,
                'devis_facture_id' => $devisFacturesEntity->id
            ];
            $shortLink = $this->DevisFactures->ShortLinks->newEntity($shortLinkData);
            $this->DevisFactures->ShortLinks->save($shortLink);
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
            $clientEntity = $this->DevisFactures->Clients->findById($client_id)->first();
            $clientEntity = $this->DevisFactures->Clients->patchEntity($clientEntity, $data, ['validate' => false]);

            $this->request->getSession()->write('devis_factures_client', $clientEntity);
        
            $this->Flash->success("Les informations du client ont été apportées sur le devis");
            return $this->redirect($this->referer());
        }
    }

    public function board(){
        $currentYear = date('Y');
        $facturePart = $this->DevisFactures
                                ->find()
                                ->innerJoinWith('Clients', function (Query $q) {
                                    return $q->where(['Clients.client_type' => 'person']);
                                })
                                ->where([
                                    'AND' => [
                                        ['DevisFactures.status !=' => 'canceled'],
                                    ]
                                ])
                                ->where(function (QueryExpression $exp, Query $q) {
                                    $year = $q->func()->year([
                                        'DevisFactures.date_crea' => 'identifier'
                                    ]);
                                    return $exp
                                        ->gte($year, date('Y'));
                                });
        $facturePart = $facturePart
                    ->select([
                        'total_ht' => $facturePart->func()->sum('DevisFactures.total_ht'),
                        'total_ttc' => $facturePart->func()->sum('DevisFactures.total_ttc')
                    ])->toArray();

        $this->loadModel('FactureDeductions');
        $pca = $this->FactureDeductions->find()
                                        ->where(['annee' => $currentYear])
                                        ->first();

        $facturePartN1 = $this->DevisFactures
                                ->find()
                                ->innerJoinWith('Clients', function (Query $q) {
                                    return $q->where(['Clients.client_type' => 'person']);
                                })
                                ->where([
                                    'AND' => [
                                        ['DevisFactures.status !=' => 'canceled'],
                                    ]
                                ])
                                ->where(function (QueryExpression $exp, Query $q) {
                                    $year = $q->func()->year([
                                        'DevisFactures.date_crea' => 'identifier'
                                    ]);
                                    $y1 = intval(date('Y')) + 1 ;
                                    return $exp
                                        ->gte($year, $y1);
                                });
        $facturePartN1 = $facturePartN1
                    ->select([
                        'total_ht' => $facturePartN1->func()->sum('DevisFactures.total_ht'),
                        'total_ttc' => $facturePartN1->func()->sum('DevisFactures.total_ttc')
                    ])->toArray();

        $deduction = $this->FactureDeductions->find()
                                        ->where(['annee' => intval($currentYear) - 1])
                                        ->first();

        //Pro
        $facturePro = $this->DevisFactures
                                ->find()
                                ->innerJoinWith('Clients', function (Query $q) {
                                    return $q->where(['Clients.client_type' => 'corporation']);
                                })
                                ->where([
                                    'AND' => [
                                        ['DevisFactures.status !=' => 'canceled'],
                                    ]
                                ])
                                ->where(function (QueryExpression $exp, Query $q) {
                                    $year = $q->func()->year([
                                        'DevisFactures.date_crea' => 'identifier'
                                    ]);
                                    return $exp
                                        ->gte($year, date('Y'));
                                });
        $facturePro = $facturePro
                    ->select([
                        'total_ht' => $facturePro->func()->sum('DevisFactures.total_ht'),
                        'total_ttc' => $facturePro->func()->sum('DevisFactures.total_ttc')
                    ])->toArray();

        $factureProN1 = $this->DevisFactures
                                ->find()
                                ->innerJoinWith('Clients', function (Query $q) {
                                    return $q->where(['Clients.client_type' => 'corporation']);
                                })
                                ->where([
                                    'AND' => [
                                        ['DevisFactures.status !=' => 'canceled'],
                                    ]
                                ])
                                ->where(function (QueryExpression $exp, Query $q) {
                                    $year = $q->func()->year([
                                        'DevisFactures.date_crea' => 'identifier'
                                    ]);
                                    $y1 = intval(date('Y')) + 1 ;
                                    return $exp
                                        ->gte($year, $y1);
                                });
        $factureProN1 = $factureProN1
                    ->select([
                        'total_ht' => $factureProN1->func()->sum('DevisFactures.total_ht'),
                        'total_ttc' => $factureProN1->func()->sum('DevisFactures.total_ttc')
                    ])->toArray();

        $this->set(compact('currentYear','facturePart','pca','facturePartN1','deduction','facturePro','factureProN1'));
    }

    public function tableau(){
        $facturePart = $this->DevisFactures
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
                                        //['DevisFactures.status !=' => 'draft'],
                                        ['DevisFactures.status !=' => 'canceled'],
                                    ]
                                ])
                                ->where(function (QueryExpression $exp, Query $q) {
                                    $year = $q->func()->year([
                                        'DevisFactures.date_crea' => 'identifier'
                                    ]);
                                    return $exp
                                        ->gte($year, 2020);
                                });

        $facturePart = $facturePart
                    ->select([
                        'total_ht' => $facturePart->func()->sum('DevisFactures.total_ht'),
                        'total_ttc' => $facturePart->func()->sum('DevisFactures.total_ttc')
                    ])->toArray();

        $facturePro = $this->DevisFactures
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
                                        //['DevisFactures.status !=' => 'draft'],
                                        ['DevisFactures.status !=' => 'canceled'],
                                    ]
                                ])
                                ->where(function (QueryExpression $exp, Query $q) {
                                    $year = $q->func()->year([
                                        'DevisFactures.date_crea' => 'identifier'
                                    ]);
                                    return $exp
                                        ->gte($year, 2020);
                                });

        $facturePro = $facturePro
                    ->select([
                        'total_ht' => $facturePro->func()->sum('DevisFactures.total_ht'),
                        'total_ttc' => $facturePro->func()->sum('DevisFactures.total_ttc')
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
            'antennes_id' => $this->request->getQuery('antennes_id'),
            'periode' => $this->request->getQuery('periode'),
            'date_threshold' => $this->request->getQuery('date_threshold'),
            'status' => $this->request->getQuery('status')
        ];

        $facture = $this->DevisFactures
                        ->find('complete')
                        ->find('filtre',$options)
                        ->where(['DevisFactures.is_in_sellsy' => $is_in_sellsy])
                        ->where([
                                    'AND' => [
                                        ['DevisFactures.status !=' => 'draft'],
                                        ['DevisFactures.status !=' => 'canceled'],
                                    ]
                            ]);

        $facture = $facture
                    ->select([
                        'total_ht' => $facture->func()->sum('DevisFactures.total_ht'),
                        'total_ttc' => $facture->func()->sum('DevisFactures.total_ttc')
                    ])->toArray();
        //debug($facture);
        $this->set(compact('facture'));
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
            if($data['facture_id'] && $data['client_id']) {
                $factureEntity = $this->DevisFactures->findById($data['facture_id'])->first();
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
                $factureEntity = $this->DevisFactures->patchEntity($factureEntity, $newData, ['validate' => false]);
                
                if($this->DevisFactures->save($factureEntity)) {
                    $this->generationPdf($data['facture_id']);
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
            if($data['facture_id'] && $data['client_id_2']) {
                $factureEntity = $this->DevisFactures->findById($data['facture_id'])->first();
                $newData = [
                    'client_id_2' => $data['client_id_2'],
                ];
                $factureEntity = $this->DevisFactures->patchEntity($factureEntity, $newData, ['validate' => false]);
                
                if($this->DevisFactures->save($factureEntity)) {
                    $this->generationPdf($data['facture_id']);
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
            
            $devisFactureEntity = $this->DevisFactures->findById($data['facture_id'])->first();
            $newData = ['ref_commercial_id' => $data['ref_commercial_id']];
            $devisFactureEntity = $this->DevisFactures->patchEntity($devisFactureEntity, $newData, ['validate' => false]);
            if ($this->DevisFactures->save($devisFactureEntity)) {
                $this->Flash->success("Modification du commercial réussie");
            } else {
                $this->Flash->error("Aucun commercial n'a été défini");
            }
        
            return $this->redirect($this->referer());
        }
    }

    /**
     * 
     * @return type
     */
    public function index($export = null) 
    {
        $listeDevisFactures = $this->DevisFactures->find('complete'); //->where(['DevisFactures.is_in_sellsy' => $is_in_sellsy]);
        // debug($listeDevisFactures->where(['Clients.id' => 1853])->toArray());
        // die();
        $devisFacturesEntity = $this->DevisFactures->newEntity();

        $indent = $this->request->getQuery('indent');
        $ref_commercial_id = $this->request->getQuery('ref_commercial_id');
        $client_type = $this->request->getQuery('client_type');
        $created = $this->request->getQuery('created');
        $antenne_id = $this->request->getQuery('antenne_id');
        $keyword = $this->request->getQuery('keyword');
        $periode = $this->request->getQuery('periode');
        $date_threshold = $this->request->getQuery('date_threshold');
        $status = $this->request->getQuery('status');
        $date_evenement = $this->request->getQuery('date_evenement');
        $type_doc_id = $this->request->getQuery('type_doc_id');
        $is_in_sellsy = $this->request->getQuery('is_in_sellsy');
        $mois_id = $this->request->getQuery('mois_id') ?? (date('m')-1);
        $sort = $this->request->getQuery('sort');
        $direction = $this->request->getQuery('direction');
        
        $customFinderOptions = [
            'keyword' => $keyword,
            'ref_commercial_id' => $ref_commercial_id,
            'client_type' => $client_type,
            'is_in_sellsy' => $is_in_sellsy,
            'created' => $created,
            'antenne_id' => $antenne_id,
            'periode' => $periode,
            'date_threshold' => $date_threshold,
            'status' => $status,
            'type_doc_id' => $type_doc_id,
            'mois_id' => $mois_id,
            'sort' => $sort,
            'direction' => $direction
        ];

        $commercials = $this->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name']); // profile Konitys Commercial
        $antennes = $this->Antennes->find('listByCity');

        $listeDevisFactures->find('filtre', $customFinderOptions);
        
        $sumFacturesAll = $this->DevisFactures->find('all')->find('filtre', $customFinderOptions);
        $sumFactures = $this->DevisFactures->find('all')->find('filtre', $customFinderOptions)->where(['DevisFactures.status <>' => 'canceled']);

        $sumFacturesAll = new Collection($sumFacturesAll->toArray());
        $sumFactures = new Collection($sumFactures->toArray());
        

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // client existant
            if($data['client'] == 1) {
                $this->request->getSession()->write('devis_factures_client', $this->Clients->findById($data['client_id'])->contain('ClientContacts')->first());
                return $this->redirect(['action' => 'add','model_devis_facture_id' => $data['model_devis_facture_id'], 'categorie_tarifaire' => $data['categorie_tarifaire'], 'type_doc_id' => $data['type_doc_id']]);
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
                    $this->request->getSession()->write('devis_factures_client', $this->Clients->findById($clientEntity->id)->contain('ClientContacts')->first());

                    return $this->redirect(['action' => 'add','model_devis_facture_id' => $data['model_devis_facture_id'], 'categorie_tarifaire' => $data['categorie_tarifaire']]);
                }
            }
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
        $modelDevisFactures = $this->DevisFactures->find('list',['valueField' => 'model_name'])->where(['is_model' => 1]);        
        $type_docs = $this->DevisFactures->DevisTypeDocs->find('list')->orderAsc('nom')->toArray();
        $modelCategories = $this->DevisFactures->ModeleDevisFacturesCategories->find('list');
        $modelSousCategories = $this->DevisFactures->ModeleDevisFacturesSousCategories->find('list',['groupField' => 'modele_devis_factures_category_id']);
        $contactTypes = $this->Clients->ClientContacts->ContactTypes->find('list');
        $mois = $this->Mois->find('list', ['valueField' => 'mois_annee'])->select(['mois_annee' => 'concat(nom, ". ", "'.date('y').'")']);
        $payss = $this->Clients->Payss->find('listAsc');


        if ($export == 'csv') {
            return $this->exportCsv($listeDevisFactures, $genres_short, $devis_factures_status, $type_docs);
        }
        
        $listeDevisFactures = $this->paginate($listeDevisFactures, ['limit' => 50, 'order' => ['DevisFactures.indent' => 'DESC']]);
        $this->set(compact('payss', 'contactTypes','date_evenement', 'indent','periode', 'periodes', 'date_threshold', 'antennes', 'commercials','ref_commercial_id','categorie_tarifaire', 'connaissance_selfizee','modelCategories', 'modelSousCategories', 'client_type', 'sumFactures', 'sumFacturesAll'));
        $this->set(compact('mois_id', 'mois', 'status', 'genres', 'created', 'antenne_id', 'keyword', 'devis_factures_status', 'listeDevisFactures', 'devisFacturesEntity', 'genres_short','groupeClients','type_commercials', 'modelDevisFactures', 'customFinderOptions', 'secteursActivites', 'type_docs', 'type_doc_id'));
    }
    
    
    public function exportCsv($listeDevisFactures, $genres_short, $devis_factures_status, $type_docs, $titres = "Liste factures", $filename = 'export-csv-facture') {
        
            $this->viewBuilder()->setLayout('ajax');
            
            $datas = [];
            $datas [] =  [$titres];
            $datas [] = ['N°', 'Client', 'Date', 'Event', 'Antenne(s)', 'Type', 'Doc', 'Contact', 'Total HT', 'Total TTC', 'Restant dû', 'Etat'];
            foreach ($listeDevisFactures as $facture){
                $ligne = [];
                $ligne[] = $facture->indent;
                $ligne[] = $facture->client ? $facture->client->nom : $facture->client_nom;
                $ligne[] = $facture->created ? $facture->created->format('d/m/y') : '-';
                
                $date_event = '-';
                if ($facture->date_evenement) {
                    $date_evenement = explode('/', $facture->date_evenement);
                    $date = date_create(@$date_evenement[2] . '-' . @$date_evenement[1] . '-' . @$date_evenement[0]);
                    $date_event = date_format($date,"d/m/y");
                }

                $ligne[] = $date_event;
                $ligne[] = $facture->get('ListeAntennes');
                $ligne[] = @$genres_short[$facture->client->client_type] ?? '';
                $ligne[] = @$type_docs[$facture->type_doc_id] ?? '--';
                $ligne[] = $facture->commercial ? $facture->commercial->get('FullNameShort') : '-';
                $ligne[] = str_replace('.', ',', $facture->total_ht);
                $ligne[] = str_replace('.', ',', $facture->total_ttc);
                $ligne[] = str_replace('.', ',', $facture->reste_echeance_impayee);
                $ligne[] = @$devis_factures_status[$facture->status];

                $datas [] =  $ligne;
            }
            
            $datas = mb_convert_encoding($datas, 'UTF-16LE', 'UTF-8');
            $this->set(compact('datas'));
            $this->render('export_csv');
            $repons = $this->response->withDownload($filename.".csv");
            return $repons;
    }
    
    
    
    public function updateEcheance() 
    {
        $this->loadModel('DevisFacturesEcheances');
        $listeDevisFactures = $this->DevisFactures->find('complete')->where(['DevisFactures.is_in_sellsy' => 1]);
        $listeDevisFactures = $this->paginate($listeDevisFactures, ['limit' => 50, 'order' => ['DevisFactures.indent' => 'DESC']]);
        foreach ($listeDevisFactures as $devisFacture) {
            $reglements = $devisFacture->facture_reglements;
            
            if(count($reglements)) {
                
                $totalReglement = 0;
                foreach($reglements as $reglement) {
                    
                    echo $devisFacture->id;
                    $totalReglement += $reglement->montant;
                    $datas = [
                        'montant' => $reglement->montant,
                        'date' => $reglement->date?$reglement->date->format('Y-m-d'):null,
                        'is_payed' => 1,
                        'devis_facture_id' => $devisFacture->id,
                        'is_accompte' => 0,
                        'date_paiement' => $reglement->date?$reglement->date->format('Y-m-d'):null,
                    ];
                    $newEcheance = $this->DevisFacturesEcheances->newEntity($datas);
                    if($this->DevisFacturesEcheances->save($newEcheance)) {
                        echo ' enregistrement reussit ';
                    }else {
                        echo ' enregistrement echoé ';
                    }
                }
                
                if($devisFacture->total_ttc - $totalReglement > 0) {
                    $datas = [
                        'montant' => $devisFacture->total_ttc - $totalReglement,
                        'is_payed' => 0,
                        'devis_facture_id' => $devisFacture->id,
                        'is_accompte' => 0,
                    ];
                    $newEcheance = $this->DevisFacturesEcheances->newEntity($datas);
                    if($this->DevisFacturesEcheances->save($newEcheance)) {
                        echo ' enregistrement reussit ';
                    }else {
                        echo ' enregistrement echoé ';
                    }
                }
            }
        }
        die;
    }
    
    
    
    
    public function ModelList() {
        
        $cat = $this->request->getQuery('category');
        $sousCat = $this->request->getQuery('sous-category');
        
        $customFinderOptions = [
            'cat' => $cat,
            'sous-cat' => $sousCat,
        ];
        
        $listeDevisFactures = $this->DevisFactures->find('listModel',$customFinderOptions);

        $devis_factures_status = Configure::read('devis_factures_status');
        $genres = Configure::read('genres');
        $genres_short = Configure::read('genres_short');
        $type_commercials = Configure::read('type_commercials');
        $categories = $this->DevisFactures->ModeleDevisFacturesCategories->find('list');
        $sousCategories = $this->DevisFactures->ModeleDevisFacturesSousCategories->find('list',['groupField' => 'modele_devis_factures_category_id']);

        $this->set(compact('devis_factures_status' , 'genres' , 'genres_short' , 'type_commercials', 'listeDevisFactures', 'categories', 'sousCategories', 'cat', 'sousCat'));
    }
    
    // version pdf document devis
    public function pdfversion($devis_factures_id, $downloadMode = null)
    {

        $forceGenerate = $this->request->getQuery('forceGenerate');
        $test = $this->request->getQuery('test');
        $download = $this->request->getQuery('download');
        $devisFacturesEntity = $this->DevisFactures->findById($devis_factures_id)->first();

        if ($forceGenerate) {
            $this->generationPdf($devis_factures_id, $test);
            return $this->response->withFile(WWW_ROOT  . $devisFacturesEntity->get('SellsyDocUrl'), ['download' => $download?$download:$downloadMode,]);
        }
        
        if($devisFacturesEntity->get('SellsyDocUrl') != '#') {
            
            if (! $devisFacturesEntity->is_in_sellsy) {
                $modified = (int) ($devisFacturesEntity->modified? $devisFacturesEntity->modified->toUnixString() : 0);
                $date = filemtime(WWW_ROOT  . $devisFacturesEntity->get('SellsyDocUrl'));
                
                if ($modified > $date) {

                    $this->generationPdf($devis_factures_id);
                }
            }
            return $this->response->withFile(WWW_ROOT  . $devisFacturesEntity->get('SellsyDocUrl'), ['download' => $download?$download:$downloadMode,]);
        } else {
            $this->generationPdf($devis_factures_id, $test);
            return $this->response->withFile(WWW_ROOT  . $devisFacturesEntity->get('SellsyDocUrl'), ['download' => $download?$download:$downloadMode,]);
        }
        return;
    }
    
    
    
    /**
     * 
     * @param type $devis_factures_id
     * @param type $downloadMode
     * @return type
     */
    public function generationPdf($devis_factures_id, $test = null)
    {

        $moyen_reglements = Configure::read('moyen_reglements');
        $delai_reglements = Configure::read('delai_reglements');

        $devisFacturesPreferenceEntity = $this->DevisFacturesPreferences->find('complete')->first(); // préférence du doc par défaut

        $date_crea = Chronos::now();
        $is_situation = $this->DevisFactures->findById($devis_factures_id)->first()->is_situation;
        $devisFacturesEntity = $this->DevisFactures->findById($devis_factures_id)->find('complete', ['is_situation' => $is_situation])->first();
        
        if($devisFacturesEntity->is_in_sellsy) {
            return ;
        }
        
        $this->loadModel('DevisFacturesFooter');
        $footer = $this->DevisFacturesFooter->findById(1)->first()->text;
        
        $currentUser = $this->Users->get($devisFacturesEntity->ref_commercial_id, ['contain' => 'Payss']);
        $colVisibilityParams = $devisFacturesEntity->get('ColVisibilityParamsAsArray');
        
        if($devisFacturesEntity->categorie_tarifaire == 'ttc') {
            $colVisibilityParams->qty = 1;
            $colVisibilityParams->remise = 1;
            $colVisibilityParams->prix_unit_ht = 1;
            $colVisibilityParams->tva = 1;
            $colVisibilityParams->montant_ht = 1;
        } else {
            $colVisibilityParams->montant_ttc = 1;
            $colVisibilityParams->tva = $devisFacturesEntity->display_tva?:$colVisibilityParams->tva;
        }
        $thHidev = 0;
        if($colVisibilityParams){
            foreach ($colVisibilityParams as $col) {
                if($col) {
                    $thHidev++;
                }
            }
        }

        $this->set(compact('devisFacturesPreferenceEntity', 'currentUser','date_crea','devisFacturesEntity','colVisibilityParams','thHidev','moyen_reglements','delai_reglements', 'footer'));
        
        // GENERATION FICHIER
        $viewBuilder = $this->viewBuilder()->setClassName('Dompdf.Pdf')->setLayout('pdf/dompdf.default');
        $pdfOptions = Configure::read('FacturePdf');
        if ($devisFacturesEntity->langue && $devisFacturesEntity->langue->id != 1) {
            
            $target = $devisFacturesEntity->langue->code;
            $trans = new GoogleTranslate();
            $this->set(compact('target', 'trans'));
            $pdfOptions['config']['paginate']['text'] = $trans->translate('fr', $target, 'Page') . '{PAGE_NUM}/{PAGE_COUNT}';
            $viewBuilder->setOptions($pdfOptions);
            
            if($is_situation) {
                $content = $this->render('pdf/pdf_situation2');
            } else {
                $content = $this->render('pdf/pdfversion2');
            }
        } else {
            
            $viewBuilder->setOptions($pdfOptions);
            if($is_situation) {
                $content = $this->render('pdf/pdf_situation');
            } else {
                $content = $this->render('pdf/pdfversion');
            }
        }

        $file_name = PATH_DEVIS_FACTURES . $devisFacturesEntity->indent.'.pdf';

        if(file_exists($file_name)) {
            unlink($file_name);
        }
        $file = new File($file_name, true, 0755);
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
        $devis_factures_status = Configure::read('devis_factures_status');
        $devis_status = Configure::read('devis_status');
        $facture_situations_status = Configure::read('facture_situations_status');
        $genres = Configure::read('genres');
        $type_commercials = Configure::read('type_commercials');
        $connaissance_selfizee = Configure::read('connaissance_selfizee');        
        $domaine = Configure::read('https_payement') . '/';

        $secteursActivites = $this->Clients->SecteursActivites->find('list')->order(['name' => 'asc']);
        $historiques = [];

        if ($id) {
            $devisFacturesEntity = $this->DevisFactures->findById($id)->first();
            $is_situation = $devisFacturesEntity->is_situation;
            if(! $devisFacturesEntity->is_model) {
                $devisFacturesEntity = $this->DevisFactures->findById($id)->find('complete', ['is_situation' => $is_situation])
                        ->contain(['Devis' => ['StatutHistoriques' => 'Users', 'DevisFactures', 'Commercial']])
                        ->contain(['DevisTypeDocs', 'StatutHistoriques' => 'Users'])->first();
                
                foreach ($devisFacturesEntity->statut_historiques as $status) {
                    $historiques[$status->time->i18nFormat('HH/mm/dd/MM/yy', 'Europe/Paris')] = [
                        'type' => 'status',
                        'action' => $status->statut_document,
                        'date' => $status->time,
                        'user' => $status->user,
                    ];
                }
                
                foreach ($devisFacturesEntity->facture_reglements as $reglement) {
                    $historiques[$reglement->created->i18nFormat('HH/mm/dd/MM/yy', 'Europe/Paris')] = [
                        'type' => 'reglement',
                        'action' => $reglement->statut_document,
                        'date' => $reglement->created,
                        'user' => $reglement->user,
                        'reglement_id' => $reglement->id
                    ];
                }
                
                ksort($historiques);
                
            } else {
                $devisFacturesEntity = $this->DevisFactures->findById($id)
                ->contain(['Clients', 'Antennes', 'DevisFacturesProduits' => function ($q) {
                    return $q->order(['DevisFacturesProduits.i_position'=>'ASC']);
                }])->first();
            }
            
            $clientEntity = $devisFacturesEntity->client;
            
            $dataClient['nom'] = $devisFacturesEntity->client_nom;
            $dataClient['adresse'] = $devisFacturesEntity->client_adresse;
            $dataClient['adresse_2'] = $devisFacturesEntity->client_adresse_2;
            $dataClient['cp'] = $devisFacturesEntity->client_cp;
            $dataClient['ville'] = $devisFacturesEntity->client_ville;
            $dataClient['country'] = $devisFacturesEntity->client_country;

            $devis_client = $clientEntity = $this->DevisFactures->Clients->patchEntity($clientEntity, $dataClient, ['validate' => false]);
        }

        if (is_null($devis_client)) {
            $this->Flash->error("Aucun client n'a été défini");
            return $this->redirect(['action' => 'index']);
        }
                
        $newDevisFacturesEntity = $this->DevisFactures->newEntity();
        
        // creation reglement 
        $this->loadModel('Reglements');
        $type_reglement = Configure::read('type_reglement');
        $etat_reglement = Configure::read('etat_reglement');
        $moyen_reglements = $this->Reglements->MoyenReglements->find('list');
        $commercials = $this->Reglements->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name']);
        $new_reglement = $this->Reglements->newEntity();
        $commercial = $this->Reglements->Users->findById(84)->first();
            
        $devisEntity = $devisFacturesEntity->devis ? $devisFacturesEntity->devis: null;
        
        $this->set(compact('historiques', 'facture_situations_status', 'devis_status','devisEntity', 'moyen_reglements', 'newDevisFacturesEntity','genres','type_commercials','connaissance_selfizee', 'commercials', 'new_reglement'));
        $this->set(compact('id', 'devisFacturesEntity', 'secteursActivites','devis_factures_status', 'domaine', 'type_reglement', 'etat_reglement', 'commercial'));
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
        $devis_facture = $this->DevisFactures->get($id);
        if ($this->DevisFactures->delete($devis_facture)) {
            $this->Flash->success(__('The devis_facture has been deleted.'));
        } else {
            $this->Flash->error(__('The devis_facture could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
    
    public function viewPublic($id) {
        
        $devisFacturesEntity = $this->DevisFactures->findById($id)->find('complete')->contain(['Devis', 'InfosBancaires'])->first();
        $this->loadModel('DevisPreferences');
        $devisPreferenceEntity = $this->DevisPreferences->find('complete')->first();
        
        if($devisFacturesEntity) {
            $devis_factures_status = Configure::read('devis_factures_status');
            $this->viewBuilder()->setLayout('public');
            $stripeApiKeyPublic = $this->stripeApiKeyPublic;
            $this->loadModel('DocumentMarketings');
            $documentMarketing = $this->DocumentMarketings->find()->first();

            /**
             * si 1ere echéance (accompte) = montant total, ne pas afficher la 1ère ligne
             * quand le dernier acompte à payer = le solde , ne pas rajouter une ligne supplémentaire "régler la totalité du document", car ça revient au même.
             */
            
            $devisFacturesEcheances = collection($devisFacturesEntity->devis_factures_echeances);
            $firstFindEcheance = $devisFacturesEcheances->first();
            $isFirstFindedEcheanceSameAsTotalDevisAmount =  @$firstFindEcheance->montant == $devisFacturesEntity->total_ttc;
            $lastFindEcheance = $devisFacturesEcheances->last();
            $isLastFindedEcheanceSameAsTotalDevisAmount =  @$lastFindEcheance->montant == $devisFacturesEntity->get('ResteEcheanceImpayee');
            $isClientPro = ($devisFacturesEntity->get('ClientType') == 'corporation' || ! $devisFacturesEntity->get('ClientType'));
            $tva = $this->defaultTva;
            $devisFacturesEntity->tva = $this->defaultTva;

            // inclure si des paiements en dehors de la page we (chèque, virement) ont été effectués
            $paiementAutresQueCartes = collection($devisFacturesEntity->facture_reglements)->filter(function ($item)
            {
                return $item->moyen_reglement->name_court != 'CB';
            });

            if($devisFacturesEntity->is_in_sellsy) {
                
                $devisFacturesEcheances = collection((array) json_decode($devisFacturesEntity->sellsy_echeances));

                $firstFindEcheance = $devisFacturesEcheances->first();
                $isFirstFindedEcheanceSameAsTotalDevisAmount =  @$firstFindEcheance->amount == $devisFacturesEntity->total_ttc;

                $lastFindEcheance = $devisFacturesEcheances->last();
                $isLastFindedEcheanceSameAsTotalDevisAmount =  @$lastFindEcheance->amount == $devisFacturesEntity->get('ResteEcheanceImpayee');

                // $this->render('view_public_sellsy');
            }
            
            $this->set(compact('paiementAutresQueCartes', 'devisPreferenceEntity', 'isClientPro', 'firstFindEcheance', 'devisFacturesEntity', 'devis_factures_status', 'devisFacturesEcheances', 'isFirstFindedEcheanceSameAsTotalDevisAmount', 'lastFindEcheance', 'isLastFindedEcheanceSameAsTotalDevisAmount', 'documentMarketing'));

            if ($devisFacturesEntity->type_doc_id && $devisFacturesEntity->type_doc_id != 1) {
                
                if(in_array($devisFacturesEntity->type_doc_id, [5,6])) {
                    $this->render('view_public_vente_locfi');
                }
                
                $this->render('view_public_pro');
            }
            
        } else {
            throw new NotFoundException();
        }
    }

    
    public function paiementSession() {
        
        if ($this->request->is(['post'])) {
            
            $is_test = $this->request->getData('is_test');
            $facture_id_encoded = $this->request->getData('facture_id');
            $echeance = $this->request->getData('echeance');
            $montant =  str_replace([" ", " ", " ", "€", "TTC", ","], ["","","","","","."], $this->request->getData('montant'));
            $montant = floatval($montant)*100;
            
            $facture_id = @current(unserialize(base64_decode($facture_id_encoded)));
            $devisFactureEntity = $this->DevisFactures->findById($facture_id)->first();
            $indent = $devisFactureEntity->indent;
            $img = "https://crm.konitys.fr/img/devis/spherik.jpg";
            if ($devisFactureEntity->model_type == 'classik') {
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
                            'name' => "Règlement facture numéro : $indent",
                            'images' => [$img],
                        ],
                    ],
                'quantity' => 1,
                ]],
                'metadata' => [
                    'facture_id' => $facture_id_encoded,
                    'echeance' => $echeance,
                ],
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/fr/factures/make-payment-new?session_id={CHECKOUT_SESSION_ID}' . ($is_test? "&test=1" : ''),
                //'cancel_url' => $YOUR_DOMAIN . "/fr/factures/paiement/$facture_id"
                'cancel_url' => Router::url($devisFactureEntity->get('EncryptedUrl')),
            ]);

            return $this->response->withType('application/json')->withStringBody(json_encode(['id' => $checkout_session->id]));
                
        }
        
        return;

    }

    
    public function paiement($id) {
        
        $devisFacturesEntity = $this->DevisFactures->findById($id)->find('complete')->contain(['Devis', 'InfosBancaires'])->first();
        $this->loadModel('DevisPreferences');
        $devisPreferenceEntity = $this->DevisPreferences->find('complete')->first();
        
        if($devisFacturesEntity) {
            $devis_factures_status = Configure::read('devis_factures_status');
            $this->viewBuilder()->setLayout('public');
            $stripeApiKeyPublic = $this->stripeApiKeyPublic;
            $this->loadModel('DocumentMarketings');
            $documentMarketing = $this->DocumentMarketings->find()->first();

            /**
             * si 1ere echéance (accompte) = montant total, ne pas afficher la 1ère ligne
             * quand le dernier acompte à payer = le solde , ne pas rajouter une ligne supplémentaire "régler la totalité du document", car ça revient au même.
             */
            
            $devisFacturesEcheances = collection($devisFacturesEntity->devis_factures_echeances);
            $firstFindEcheance = $devisFacturesEcheances->first();
            $isFirstFindedEcheanceSameAsTotalDevisAmount =  @$firstFindEcheance->montant == $devisFacturesEntity->total_ttc;
            $lastFindEcheance = $devisFacturesEcheances->last();
            $isLastFindedEcheanceSameAsTotalDevisAmount =  @$lastFindEcheance->montant == $devisFacturesEntity->get('ResteEcheanceImpayee');
            $isClientPro = ($devisFacturesEntity->get('ClientType') == 'corporation' || ! $devisFacturesEntity->get('ClientType'));
            $tva = $this->defaultTva;
            $devisFacturesEntity->tva = $this->defaultTva;

            // inclure si des paiements en dehors de la page we (chèque, virement) ont été effectués
            $paiementAutresQueCartes = collection($devisFacturesEntity->facture_reglements)->filter(function ($item)
            {
                return $item->moyen_reglement->name_court != 'CB';
            });

            if($devisFacturesEntity->is_in_sellsy) {
                
                $devisFacturesEcheances = collection((array) json_decode($devisFacturesEntity->sellsy_echeances));

                $firstFindEcheance = $devisFacturesEcheances->first();
                $isFirstFindedEcheanceSameAsTotalDevisAmount =  @$firstFindEcheance->amount == $devisFacturesEntity->total_ttc;

                $lastFindEcheance = $devisFacturesEcheances->last();
                $isLastFindedEcheanceSameAsTotalDevisAmount =  @$lastFindEcheance->amount == $devisFacturesEntity->get('ResteEcheanceImpayee');

                // $this->render('view_public_sellsy');
            }
            
            $this->set(compact('paiementAutresQueCartes', 'stripeApiKeyPublic', 'devisPreferenceEntity', 'isClientPro', 'firstFindEcheance', 'devisFacturesEntity', 'devis_factures_status', 'devisFacturesEcheances', 'isFirstFindedEcheanceSameAsTotalDevisAmount', 'lastFindEcheance', 'isLastFindedEcheanceSameAsTotalDevisAmount', 'documentMarketing'));

            if ($devisFacturesEntity->type_doc_id && $devisFacturesEntity->type_doc_id != 1) {
                
                if(in_array($devisFacturesEntity->type_doc_id, [5,6])) {
                    $this->render('paiement_vente_locfi');
                }
                
                $this->render('paiement_pro');
            }
            
        } else {
            throw new NotFoundException();
        }
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
        $devis_facture_id_encoded = $session->metadata->facture_id;
        $echeance = $session->metadata->echeance;
        
        $this->loadModel('Reglements');
        
        $this->loadModel('Reglements');
        $devis_facture_id = @current(unserialize(base64_decode($devis_facture_id_encoded)));
        $devisFacturesEntity = $this->DevisFactures->findById($devis_facture_id)->find('complete')->first();

        $publicUrl = $devisFacturesEntity->get('EncryptedUrl');
        $devisEcheancesEntity = null;

        if ($devisFacturesEntity !== null) {

            $data = [
                'echeance' => $echeance,
                'email' => $customer->email
            ];
            
            $indent = $devisFacturesEntity->indent;

            $paymentStatut = '';
            if (isset($data['echeance'])) {
                if ($data['echeance'] == 'total_remaining') {
                    $montant = $devisFacturesEntity->get('ResteEcheanceImpayee');
                    $paymentStatut = 'paid';
                    $data['status'] = $paymentStatut;
                    $data['date_total_paiement'] = Time::now();
                    $data['montant_total_paid'] = $montant;
                } 
                elseif ($devisEcheancesEntity = $this->DevisFactures->DevisFacturesEcheances->get($data['echeance'])) {
                    $montant = $devisEcheancesEntity->montant;
                    $paymentStatut = 'partial-payment';
                    $data['status'] = $paymentStatut;
                    $data['devis_factures_echeances'] = $this->DevisFactures->DevisFacturesEcheances->findByDevisFactureId($devisFacturesEntity->id)->toArray();
                    foreach ($data['devis_factures_echeances'] as $key => $devisFactureEcheance) {
                        $data['devis_factures_echeances'][$key] = $devisFactureEcheance->toArray();
                        if ($devisFactureEcheance->id == $devisEcheancesEntity->id) {
                            $data['devis_factures_echeances'][$key] = [
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

                // cf dicus skype, on peut associer plusieurs devis/factures à un client, un réglement peut être attribué à +ieurs devis/factures
                $data['reglement'] = [
                    'type' => 'credit',
                    'client_id' => $devisFacturesEntity->client_id,
                    'moyen_reglement_id' => 5,
                    'date' => date('Y-m-d'),
                    'montant' => $montant,
                    'email' => $data['email'],
                    'reference' => $devisFacturesEntity->indent,
                    'etat' => 'confirmed',
                    'montant_restant' => $devisFacturesEntity->get('ResteEcheanceImpayee') > 0 ? $devisFacturesEntity->get('ResteEcheanceImpayee') - $montant : 0
                ];

                
                if($devisFacturesEntity->get('ResteEcheanceImpayee') - $montant <= 0) {
                    $data['status'] = 'paid';
                    $data['date_total_paiement'] = Time::now();
                    $data['montant_total_paid'] = $montant;
                }

                $devisFacturesEntity = $this->DevisFactures->patchEntity($devisFacturesEntity, $data, ['validate' => false, 'associated' => ['DevisFacturesEcheances']]);
    
                if(!$devisFacturesEntity->getErrors()) {
                    $devisFacturesEntity = $this->DevisFactures->save($devisFacturesEntity);
                    $this->insertNewReglementsAndSendEmail($devisFacturesEntity);
                    $indent = $devisFacturesEntity->indent;
                    if( ! $devisFacturesEntity->is_in_sellsy) {
                        $this->generationPdf($devisFacturesEntity->id);
                    }
                    //$this->setStatutHistorique($devisFacturesEntity->id, $paymentStatut);
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
    public function makePayment($devis_facture_id_encoded)
    {
        $this->loadModel('Reglements');
        $devis_facture_id = @current(unserialize(base64_decode($devis_facture_id_encoded)));
        $devisFacturesEntity = $this->DevisFactures->findById($devis_facture_id)->find('complete')->first();

        $stripeApiKeySecret = $this->stripeApiKeySecret;
        $publicUrl = $devisFacturesEntity->get('EncryptedUrl');
        $devisEcheancesEntity = null;

        if ($devisFacturesEntity !== null && $this->request->is(['put'])) {
            $data = $this->request->getData();    

            $indent = $devisFacturesEntity->indent;

            $stripeForm = new StripeForm();
            if (!$stripeForm->validate($data)) {
                foreach ($stripeForm->errors() as $key => $error) {
                    $this->Flash->error(current($error));
                }
                return $this->redirect($publicUrl);
            }

            $paymentStatut = '';
            if (isset($data['echeance'])) {
                if ($data['echeance'] == 'total_remaining') {
                    $montant = $devisFacturesEntity->get('ResteEcheanceImpayee');
                    $paymentStatut = 'paid';
                    $data['status'] = $paymentStatut;
                    $data['date_total_paiement'] = Time::now();
                    $data['montant_total_paid'] = $montant;
                } 
                elseif ($devisEcheancesEntity = $this->DevisFactures->DevisFacturesEcheances->get($data['echeance'])) {
                    $montant = $devisEcheancesEntity->montant;
                    $paymentStatut = 'partial-payment';
                    $data['status'] = $paymentStatut;
                    $data['devis_factures_echeances'] = $this->DevisFactures->DevisFacturesEcheances->findByDevisFactureId($devisFacturesEntity->id)->toArray();
                    foreach ($data['devis_factures_echeances'] as $key => $devisFactureEcheance) {
                        $data['devis_factures_echeances'][$key] = $devisFactureEcheance->toArray();
                        if ($devisFactureEcheance->id == $devisEcheancesEntity->id) {
                            $data['devis_factures_echeances'][$key] = [
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
            //     Cache::write('stripe_debug', $charge);
            // }

            if (@$charge->paid == true && @$charge->status == 'succeeded') {
            // if(true){

                // cf dicus skype, on peut associer plusieurs devis/factures à un client, un réglement peut être attribué à +ieurs devis/factures
                $data['reglement'] = [
                    'type' => 'credit',
                    'client_id' => $devisFacturesEntity->client_id,
                    'moyen_reglement_id' => 5,
                    'date' => date('Y-m-d'),
                    'montant' => $montant,
                    'email' => $data['email'],
                    'reference' => $devisFacturesEntity->indent,
                    'etat' => 'confirmed',
                    'montant_restant' => $devisFacturesEntity->get('ResteEcheanceImpayee') > 0 ? $devisFacturesEntity->get('ResteEcheanceImpayee') - $montant : 0
                ];

                
                if($devisFacturesEntity->get('ResteEcheanceImpayee') - $montant <= 0) {
                    $data['status'] = 'paid';
                    $data['date_total_paiement'] = Time::now();
                    $data['montant_total_paid'] = $montant;
                }

                // debug($data);
                // die();
                // debug($devisFacturesEntity);
                $devisFacturesEntity = $this->DevisFactures->patchEntity($devisFacturesEntity, $data, ['validate' => false, 'associated' => ['DevisFacturesEcheances']]);
                // debug($devisFacturesEntity);
                // $this->insertNewReglementsAndSendEmail($devisFacturesEntity);
                // die();

                if(!$devisFacturesEntity->getErrors()) {
                    $devisFacturesEntity = $this->DevisFactures->save($devisFacturesEntity);
                    $this->insertNewReglementsAndSendEmail($devisFacturesEntity);
                    $indent = $devisFacturesEntity->indent;
                    if( ! $devisFacturesEntity->is_in_sellsy) {
                        $this->generationPdf($devisFacturesEntity->id);
                    }
                    //$this->setStatutHistorique($devisFacturesEntity->id, $paymentStatut);
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

    public function insertNewReglementsAndSendEmail($devisFacturesEntity = null)
    {
        $this->viewBuilder()->setLayout(false);
        $send = false;
        if ($devisFacturesEntity) {
            $reglement = $devisFacturesEntity->reglement;
            $reglementEntity = $this->Reglements->newEntity($reglement, ['validate' => false]);
            if ($reglementEntity = $this->Reglements->save($reglementEntity)) {
                $data = ['reglements_id' => $reglementEntity->id, 'devis_factures_id' => $devisFacturesEntity->id, 'montant_lie' => $reglementEntity->montant];
                $findedRelation = $this->Reglements->ReglementsHasDevisFactures->find()->where($data)->first();
                $send = true;
                if (!$findedRelation) {
                    $reglementHasDevisFacturesEntity = $this->Reglements->ReglementsHasDevisFactures->newEntity($data);
                    $this->Reglements->ReglementsHasDevisFactures->save($reglementHasDevisFacturesEntity);
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
                $clientEmail = $devisFacturesEntity->client->email;
                $bcc = [];
                if ($clientEmail != $reglementEmail && !empty($clientEmail)) {
                    $bcc = [$clientEmail];
                }

                if ($reglementEmail) {
                    if ($this->request->getEnv('REMOTE_ADDR') != '127.0.0.1' && $this->request->getEnv('REMOTE_ADDR') != 'localhost') { // en test
                        // email client
                        $email = $this->Emails->sendTo(['email' => $reglementEmail, 'bcc' => $bcc, 'devisEntity' => $devisFacturesEntity, 'reglementEntity' => $reglementEntity], $options);
                        
                        // email konitys
                        $reglements = $this->Reglements->ReglementsHasDevisFactures->find('list')->where(['devis_factures_id' => $devisFacturesEntity->id])->toArray();
                        $subject = '';
                        $title = 'Nouvelle réservation';
                        if ($devisFacturesEntity->get('ClientType') == 'person') {
                            $subject = 'Nouvelle réservation Particulier'.($devisFacturesEntity->model_type != null ? ' - '.ucfirst($devisFacturesEntity->model_type) : '');
                            if (count($reglements) > 1) {
                                $subject = 'Règlement d\'une facture Particulier'.($devisFacturesEntity->model_type != null ? ' - '.ucfirst($devisFacturesEntity->model_type) : '');
                                $title = 'Règlement d\'une facture';
                            }
                        } elseif ($devisFacturesEntity->get('ClientType') == 'corporation') {
                            $subject = 'Nouvelle réservation Pro'.(count($devisFacturesEntity->antennes) > 0 ? ' - Antenne' : '');
                            if (count($reglements) > 1) {
                                $subject = 'Règlement d\'une facture Pro'.(count($devisFacturesEntity->antennes) > 0 ? ' - Antenne' : '');
                                $title = 'Règlement d\'une facture';
                            }
                        }

                        $options = [
                            'from' => 'Selfizee',
                            'fromEmail' => 'contact@konitys.fr',
                            'subject' => $subject,
                            'template' => 'reglement_konitys',
                            'layout' => 'blank'
                        ];
                        $email = $this->Emails->sendTo(['email' => 'contact@konitys.fr', 'devisEntity' => $devisFacturesEntity, 'reglementEntity' => $reglementEntity, 'title' => $title], $options);
                    }
                    // echo $email['message']; // debug
                    // die();
                }

                // $this->set(compact('email'));
                // $this->render('/Email/test');
            }
        }
    }

    /**
     * lié avec additionalData du devis/stripe_payment.js
     * @return [type] [description]
     */
    public function makeReglement($devis_facture_id)
    {
        $this->loadModel('Reglements');
        $devisFacturesEntity = $this->DevisFactures->findById($devis_facture_id)->first();

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            
            $devisFacturesEntity = $this->DevisFactures->patchEntity($devisFacturesEntity, $data, ['validate' => false]);
            if(!$devisFacturesEntity->getErrors()) {
                $this->DevisFactures->save($devisFacturesEntity);
                if(! $devisFacturesEntity->is_in_sellsy) {
                    $this->generationPdf($devisFacturesEntity->id);
                }
                $this->Flash->success("Votre commentaire a bien été enregistré");
            }
            return $this->redirect($this->referer());
        }

    }

    public function confirmation()
    {
        $this->viewBuilder()->setLayout(false);
        $this->render('/Devis/confirmation');
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
            //$this->setAction('viewPublic', $id);
            $this->setAction('paiement', $id);
        }
    }
    
    
    public function EditEtat($devis_facture_id, $client_id = null) {
        $devis_facture = $this->DevisFactures->findById($devis_facture_id)->first();
        if ($devis_facture) {
            $devis_facture = $this->DevisFactures->patchEntity($devis_facture, $this->request->getData());
            if($this->DevisFactures->save($devis_facture)){
                $this->setStatutHistorique($devis_facture->id, $devis_facture->status);
                $this->Flash->success(__('L\'état de la facture a été bien changé.'));
            } else {
                $this->Flash->success(__('Erreur de modification de l\'état du devis.'));
            }
        }
                
        return $this->redirect($this->referer());
    }
    
    
    public function EditTypeDoc($devis_facture_id) {
        $devis_facture = $this->DevisFactures->findById($devis_facture_id)->first();
        if ($devis_facture) {
            $devis_facture = $this->DevisFactures->patchEntity($devis_facture, $this->request->getData(), ['validate' => false]);
            if($this->DevisFactures->save($devis_facture)){
                $this->Flash->success(__('Le type de document du devis a été bien changé.'));
            } else {
                $this->Flash->success(__('Erreur de modification du type document du devis.'));
            }
        }
        
        return $this->redirect($this->referer());
    }

    public function duplicatFacture($facture_id) {
        
        if($this->request->is(['post', 'put'])) {
            
            $data = $this->request->getData();
            $client = $this->request->getData('client_id');
            
            // client existant
            if($data['client'] == 1) {
                $this->request->getSession()->write('devis_factures_client', $this->Clients->findById($client)->contain('ClientContacts')->first());                
            } elseif($data['client'] == 2) {

                $clientEntity = $this->Clients->newEntity($data['new_client']);

                foreach ($clientEntity->client_contacts as $key => $client_contact) {
                    if (empty(array_filter($client_contact->toArray()))) {
                        unset($clientEntity->client_contacts[$key]);
                    }
                }

                if ($this->Clients->save($clientEntity)) {
                    $this->Flash->success(__('The client has been saved.'));
                    $this->request->getSession()->write('devis_factures_client', $this->Clients->findById($clientEntity->id)->contain('ClientContacts')->first());
                }
            } elseif($data['client'] == 3) {
                $devisFactureEntity = $this->DevisFactures->findById($facture_id)->first();
                $client_id = $devisFactureEntity->client_id;
                $this->request->getSession()->write('devis_factures_client', $this->Clients->findById($client_id)->contain('ClientContacts')->first());
            }
            
            $this->redirect(['action' => 'add', 'model_devis_facture_id' => $facture_id]);
        }
    }

    public function historique($id){
        $devis = $this->DevisFactures->findById($id)->contain(['StatutHistoriques' => 'Users'])->first();
        $facture_status = Configure::read('devis_factures_status');
        $this->set(compact('devis','facture_status'));
    }

    /**
     * Meme fucntion dans ajax et reglement
     * @param type $factureId
     * @param type $statut
     * @return type
     */
    protected function setStatutHistorique($factureId, $statut){
        if(!empty($statut) && !empty($factureId)){
            $user_id = 84;
            if($this->Auth->user('id')) {
                $user_id = $this->Auth->user('id');
            }
            $this->loadModel('StatutHistoriques');
            $dataStat['devis_facture_id'] = $factureId;
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

                foreach (array_filter($data['devis_factures']) as $devis_facture_id => $value) {
                    $devisFactureEntity = $this->DevisFactures->findById($devis_facture_id)->first();
                    $isTmpFilesCreated = $this->Zip->uploadTmpFile($devisFactureEntity);
                }

                if ($isTmpFilesCreated) {
                    $this->Zip->compressAndDownload($filename = 'Factures.zip'); // compresse et telecharge les fichiers stockés temporairement via ->uploadTmFile()
                } else {
                    $this->Flash->error("Une erreur est survenue, veuillez recommencer la procédure");
                }
            }
            
            return $this->redirect($this->referer());
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function toAvoir($facture_id) {
        $dataFacture = $this->DevisFactures->findById($facture_id)->find('asModele', ['removed_client' => 0])->toArray();
        if (count($dataFacture)) {
            $this->request->getSession()->write('avoirs_client', $this->Clients->findById($dataFacture['client_id'])->contain('ClientContacts')->first());
            $this->redirect(['controller' => 'Avoirs', 'action' => 'add', 'facture_id' => $facture_id]);
        }
        $this->redirect(['action' => 'index']);
    }
    
    
    public function reglementsRetard() {
        
    }

    /**
     * NB : les montants à afficher, il faut faire un calcul en tenant compte des règlements effectués / restants dû. 
     * et non pas le montant total de la facture
     * NB : définition des factures en retard est dans le cron/j
     * @return [type] [description]
     */
    public function dashboardReglementsRetard() 
    {
        $now = Chronos::now();
        $with_decimal = $this->request->getQuery('with_decimal');

        $this->viewBuilder()->setLayout('dashboard');
        $factures = $this->DevisFactures->find();
        $totalFactures = $factures->sumOf('total_ttc');

        $facturesEnRetard = $this->DevisFactures->find('Retard');
        $facturesNonReglees = $this->DevisFactures->find('NonReglees'); // ou en attente de règlement
        $facturesEnDelai = $this->DevisFactures->find('Delai');

        $totalFacturesNonReglees = $facturesNonReglees->sumOf('ResteMontantTotal');
        $totalFacturesEnRetard = $facturesEnRetard->sumOf('ResteMontantTotal');

        $totalFacturesDelai = $facturesEnDelai->sumOf('ResteMontantTotal');
        $facturesAvecJourRetard = $this->DevisFactures->find('AvecJrRetard');
        $facturesEnRetardInferieure30js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard <' => 30]);
        $facturesEnRetardEntre30j60js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 30, 'nb_jour_retard <' => 60]);
        $facturesEnRetardEntre60j90js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 60, 'nb_jour_retard <' => 90]);
        $facturesEnRetardSuperieure90js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 90]);

        $totalFacturesEnRetardInferieure30js = $facturesEnRetardInferieure30js->sumOf('ResteMontantTotal');
        $totalFacturesEnRetardEntre30j60js = $facturesEnRetardEntre30j60js->sumOf('ResteMontantTotal');
        $totalFacturesEnRetardEntre60j90js = $facturesEnRetardEntre60j90js->sumOf('ResteMontantTotal');
        $totalFacturesEnRetardSuperieure90js = $facturesEnRetardSuperieure90js->sumOf('ResteMontantTotal');

        // Détails des sommes dûes
        $nbFacturesEnDelai = $facturesEnDelai->count();
        $nbFacturesEnRetardInferieure30js = $facturesEnRetardInferieure30js->count();
        $nbFacturesEnRetardEntre30j60js = $facturesEnRetardEntre30j60js->count();
        $nbFacturesEnRetardEntre60j90js = $facturesEnRetardEntre60j90js->count();
        $nbFacturesEnRetardSuperieure90js = $facturesEnRetardSuperieure90js->count();

        // Répartition par types de factures en retard
        $facturesRetardEvent = $facturesEnRetard->match(['type_doc_id' => 4])->sumOf('ResteMontantTotal');
        $facturesRetardPart = $facturesEnRetard->match(['type_doc_id' => 1])->sumOf('ResteMontantTotal');
        $facturesRetardLocFi = $facturesEnRetard->match(['type_doc_id' => 6])->sumOf('ResteMontantTotal');
        $facturesRetardVente = $facturesEnRetard->match(['type_doc_id' => 5])->sumOf('ResteMontantTotal');

        // Répartition par types de factures en attente de règlement
        $facturesEnAttentedEvent = $facturesNonReglees->match(['type_doc_id' => 4])->sumOf('ResteMontantTotal');
        $facturesEnAttentedPart = $facturesNonReglees->match(['type_doc_id' => 1])->sumOf('ResteMontantTotal');
        $facturesEnAttentedLocFi = $facturesNonReglees->match(['type_doc_id' => 6])->sumOf('ResteMontantTotal');
        $facturesEnAttentedVente = $facturesNonReglees->match(['type_doc_id' => 5])->sumOf('ResteMontantTotal');

        // Détail par type de facture
        
        // Loc'event pro 
        $totalFacturesEventDelai = $facturesEnDelai->match(['type_doc_id' => 4])->sumOf('ResteMontantTotal');
        $nbFacturesEventDelai = $facturesEnDelai->match(['type_doc_id' => 4])->count();

        $retardEventInferieure30js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard <' => 30])->match(['type_doc_id' => 4]);
        $facturesRetardEventInferieure30js = $retardEventInferieure30js->sumOf('ResteMontantTotal');
        $nbFacturesRetardEventInferieure30js = $retardEventInferieure30js->count();

        $retardEventEntre30j60js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 30, 'nb_jour_retard <' => 60])->match(['type_doc_id' => 4]);
        $facturesRetardEventEntre30j60js = $retardEventEntre30j60js->sumOf('ResteMontantTotal');
        $nbFacturesRetardEventEntre30j60js = $retardEventEntre30j60js->count();

        $retardEventEntre60j90js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 60, 'nb_jour_retard <' => 90])->match(['type_doc_id' => 4]);
        $facturesRetardEventEntre60j90js = $retardEventEntre60j90js->sumOf('ResteMontantTotal');
        $nbFacturesRetardEventEntre60j90js = $retardEventEntre60j90js->count();

        $retardEventSuperieure90js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 30])->match(['type_doc_id' => 4]);
        $facturesRetardEventSuperieure90js = $retardEventSuperieure90js->sumOf('ResteMontantTotal');
        $nbFacturesRetardEventSuperieure90js = $retardEventSuperieure90js->count();

        $totalLocEvent = $totalFacturesEventDelai+ $facturesRetardEventInferieure30js+ $facturesRetardEventEntre30j60js+ $facturesRetardEventEntre60j90js+ $facturesRetardEventSuperieure90js;

        // Loc Fi 
        $totalFacturesLocFiDelai = $facturesEnDelai->match(['type_doc_id' => 6])->sumOf('ResteMontantTotal');
        $nbFacturesLocFiDelai = $facturesEnDelai->match(['type_doc_id' => 6])->count();

        $retardLocFiInferieure30js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard <' => 30])->match(['type_doc_id' => 6]);
        $facturesRetardLocFiInferieure30js = $retardLocFiInferieure30js->sumOf('ResteMontantTotal');
        $nbRetardLocFiInferieure30js = $retardLocFiInferieure30js->count();

        $retardLocFiEntre30j60js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 30, 'nb_jour_retard <' => 60])->match(['type_doc_id' => 6]);
        $facturesRetardLocFiEntre30j60js = $retardLocFiEntre30j60js->sumOf('ResteMontantTotal');
        $nbRetardLocFiEntre30j60js = $retardLocFiEntre30j60js->count();

        $retardLocFiEntre60j90js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 60, 'nb_jour_retard <' => 90])->match(['type_doc_id' => 6]);
        $facturesRetardLocFiEntre60j90js = $retardLocFiEntre60j90js->sumOf('ResteMontantTotal');
        $nbRetardLocFiEntre60j90js = $retardLocFiEntre60j90js->count();

        $retardLocFiSuperieure90js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 30])->match(['type_doc_id' => 6]);
        $facturesRetardLocFiSuperieure90js = $retardLocFiSuperieure90js->sumOf('ResteMontantTotal');
        $nbRetardLocFiSuperieure90js = $retardLocFiSuperieure90js->count();

        $totalRetardLocFi = $totalFacturesLocFiDelai+ $facturesRetardLocFiInferieure30js+ $facturesRetardLocFiEntre30j60js+ $facturesRetardLocFiEntre60j90js+ $facturesRetardLocFiSuperieure90js;

        // Achat
        $totalFacturesVenteDelai = $facturesEnDelai->match(['type_doc_id' => 5])->sumOf('ResteMontantTotal');
        $nbtacturesVenteDelai = $facturesEnDelai->match(['type_doc_id' => 5])->count();

        $retardVenteInferieure30js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard <' => 30])->match(['type_doc_id' => 5]);
        $facturesRetardVenteInferieure30js = $retardVenteInferieure30js->sumOf('ResteMontantTotal');
        $nbRetardVenteInferieure30js = $retardVenteInferieure30js->count();

        $retardVenteEntre30j60js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 30, 'nb_jour_retard <' => 60])->match(['type_doc_id' => 5]);
        $facturesRetardVenteEntre30j60js = $retardVenteEntre30j60js->sumOf('ResteMontantTotal');
        $nbRetardVenteEntre30j60js = $retardVenteEntre30j60js->count();

        $retardVenteEntre60j90js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 60, 'nb_jour_retard <' => 90])->match(['type_doc_id' => 5]);
        $facturesRetardVenteEntre60j90js = $retardVenteEntre60j90js->sumOf('ResteMontantTotal');
        $nbRetardVenteEntre60j90js = $retardVenteEntre60j90js->count();

        $retardVenteSuperieure90js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 30])->match(['type_doc_id' => 5]);
        $facturesRetardVenteSuperieure90js = $retardVenteSuperieure90js->sumOf('ResteMontantTotal');
        $nbRetardVenteSuperieure90js = $retardVenteSuperieure90js->count();

        $totalRetardVente = $totalFacturesVenteDelai+ $facturesRetardVenteInferieure30js+ $facturesRetardVenteEntre30j60js+ $facturesRetardVenteEntre60j90js+ $facturesRetardVenteSuperieure90js;


        // Part
        $totalFacturesPartDelai = $facturesEnDelai->match(['type_doc_id' => 1])->sumOf('ResteMontantTotal');
        $nbFacturesPartDelai = $facturesEnDelai->match(['type_doc_id' => 1])->count();

        $retardPartInferieure30js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard <' => 30])->match(['type_doc_id' => 1]);
        $facturesRetardPartInferieure30js = $retardPartInferieure30js->sumOf('ResteMontantTotal');
        $nbRetardPartInferieure30js = $retardPartInferieure30js->count();

        $retardPartEntre30j60js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 30, 'nb_jour_retard <' => 60])->match(['type_doc_id' => 1]);
        $facturesRetardPartEntre30j60js = $retardPartEntre30j60js->sumOf('ResteMontantTotal');
        $nbRetardPartEntre30j60js = $retardPartEntre30j60js->count();

        $retardPartEntre60j90js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 60, 'nb_jour_retard <' => 90])->match(['type_doc_id' => 1]);
        $facturesRetardPartEntre60j90js = $retardPartEntre60j90js->sumOf('ResteMontantTotal');
        $nbRetardPartEntre60j90js = $retardPartEntre60j90js->count();

        $retardPartSuperieure90js = $this->DevisFactures->find('AvecJrRetard', ['nb_jour_retard >=' => 30])->match(['type_doc_id' => 1]);
        $facturesRetardPartSuperieure90js = $retardPartSuperieure90js->sumOf('ResteMontantTotal');
        $nbRetardPartSuperieure90js = $retardPartSuperieure90js->count();

        $totalFacturesRetardPart = $totalFacturesPartDelai+$facturesRetardPartInferieure30js+$facturesRetardPartEntre30j60js+$facturesRetardPartEntre60j90js+$facturesRetardPartSuperieure90js;

        // ----- fin délai par type de facture -----

        // Factures en attente de règlement par commercial
        $facturesEnAttenteReglementLucie = $facturesNonReglees->match(['ref_commercial_id' => 85])->sumOf('ResteMontantTotal');
        $facturesEnAttenteReglementBertrant = $facturesNonReglees->match(['ref_commercial_id' => 86])->sumOf('ResteMontantTotal');
        $facturesEnAttenteReglementGregory = $facturesNonReglees->match(['ref_commercial_id' => 34])->sumOf('ResteMontantTotal');
        $facturesEnAttenteReglementBenjamin = $facturesNonReglees->match(['ref_commercial_id' => 33])->sumOf('ResteMontantTotal');

        // Factures en retard par commercial
        $facturesRetardLucie = $facturesEnRetard->match(['ref_commercial_id' => 85])->sumOf('ResteMontantTotal');
        $facturesRetardBertrant = $facturesEnRetard->match(['ref_commercial_id' => 86])->sumOf('ResteMontantTotal');
        $facturesRetardGregory = $facturesEnRetard->match(['ref_commercial_id' => 34])->sumOf('ResteMontantTotal');
        $facturesRetardBenjamin = $facturesEnRetard->match(['ref_commercial_id' => 33])->sumOf('ResteMontantTotal');

        // Détail par commercial
        // Lucie
        $facturesLucieEnDelai = $facturesEnDelai->match(['ref_commercial_id' => 85])->sumOf('ResteMontantTotal');
        $nbfacturesLucieEnDelai = $facturesEnDelai->match(['ref_commercial_id' => 85])->count();

        $enRetardInferieure30js = $facturesEnRetardInferieure30js->match(['ref_commercial_id' => 85]);
        $facturesLucieEnRetardInferieure30js = $enRetardInferieure30js->sumOf('ResteMontantTotal');
        $nbLucieEnRetardInferieure30js = $enRetardInferieure30js->count();

        $enRetardEntre30j60js = $facturesEnRetardEntre30j60js->match(['ref_commercial_id' => 85]);
        $facturesLucieEnRetardEntre30j60js = $enRetardEntre30j60js->sumOf('ResteMontantTotal');
        $nbLucieEnRetardEntre30j60js = $enRetardEntre30j60js->count();

        $enRetardEntre60j90js = $facturesEnRetardEntre60j90js->match(['ref_commercial_id' => 85]);
        $facturesLucieEnRetardEntre60j90js = $enRetardEntre60j90js->sumOf('ResteMontantTotal');
        $nbLucieEnRetardEntre60j90js = $enRetardEntre60j90js->count();

        $enRetardSuperieure90js = $facturesEnRetardSuperieure90js->match(['ref_commercial_id' => 85]);
        $facturesLucieEnRetardSuperieure90js = $enRetardSuperieure90js->sumOf('ResteMontantTotal');
        $nbLucieEnRetardSuperieure90js = $enRetardSuperieure90js->count();

        $totalFacturesLucieEnRetart = $facturesLucieEnDelai+ $facturesLucieEnRetardInferieure30js+ $facturesLucieEnRetardEntre30j60js+ $facturesLucieEnRetardEntre60j90js+ $facturesLucieEnRetardSuperieure90js;

        // Bertrant
        $facturesBertrantEnDelai = $facturesEnDelai->match(['ref_commercial_id' => 86])->sumOf('ResteMontantTotal');
        $nbfacturesBertrantEnDelai = $facturesEnDelai->match(['ref_commercial_id' => 86])->count();

        $enRetardInferieure30js = $facturesEnRetardInferieure30js->match(['ref_commercial_id' => 86]);
        $facturesBertrantEnRetardInferieure30js = $enRetardInferieure30js->sumOf('ResteMontantTotal');
        $nbBertrantEnRetardInferieure30js = $enRetardInferieure30js->count();

        $enRetardEntre30j60js = $facturesEnRetardEntre30j60js->match(['ref_commercial_id' => 86]);
        $facturesBertrantEnRetardEntre30j60js = $enRetardEntre30j60js->sumOf('ResteMontantTotal');
        $nbBertrantEnRetardEntre30j60js = $enRetardEntre30j60js->count();

        $enRetardEntre60j90js = $facturesEnRetardEntre60j90js->match(['ref_commercial_id' => 86]);
        $facturesBertrantEnRetardEntre60j90js = $enRetardEntre60j90js->sumOf('ResteMontantTotal');
        $nbBertrantEnRetardEntre60j90js = $enRetardEntre60j90js->count();

        $enRetardSuperieure90js = $facturesEnRetardSuperieure90js->match(['ref_commercial_id' => 86]);
        $facturesBertrantEnRetardSuperieure90js = $enRetardSuperieure90js->sumOf('ResteMontantTotal');
        $nbBertrantEnRetardSuperieure90js = $enRetardSuperieure90js->count();

        $totalFacturesBertrantEnRetard = $facturesBertrantEnDelai+ $facturesBertrantEnRetardInferieure30js+ $facturesBertrantEnRetardEntre30j60js+ $facturesBertrantEnRetardEntre60j90js+ $facturesBertrantEnRetardSuperieure90js;

        // Gregory
        $facturesGregoryEnDelai = $facturesEnDelai->match(['ref_commercial_id' => 34])->sumOf('ResteMontantTotal');
        $nbfacturesGregoryEnDelai = $facturesEnDelai->match(['ref_commercial_id' => 34])->count();

        $enRetardInferieure30js = $facturesEnRetardInferieure30js->match(['ref_commercial_id' => 34]);
        $facturesGregoryEnRetardInferieure30js = $enRetardInferieure30js->sumOf('ResteMontantTotal');
        $nbGregoryEnRetardInferieure30js = $enRetardInferieure30js->count();

        $enRetardEntre30j60js = $facturesEnRetardEntre30j60js->match(['ref_commercial_id' => 34]);
        $facturesGregoryEnRetardEntre30j60js = $enRetardEntre30j60js->sumOf('ResteMontantTotal');
        $nbGregoryEnRetardEntre30j60js = $enRetardEntre30j60js->count();

        $enRetardEntre60j90js = $facturesEnRetardEntre60j90js->match(['ref_commercial_id' => 34]);
        $facturesGregoryEnRetardEntre60j90js = $enRetardEntre60j90js->sumOf('ResteMontantTotal');
        $nbGregoryEnRetardEntre60j90js = $enRetardEntre60j90js->count();

        $enRetardSuperieure90js = $facturesEnRetardSuperieure90js->match(['ref_commercial_id' => 34]);
        $facturesGregoryEnRetardSuperieure90js = $enRetardSuperieure90js->sumOf('ResteMontantTotal');
        $nbGregoryEnRetardSuperieure90js = $enRetardSuperieure90js->count();

        $totalfacturesGregoryEnRetard = $facturesGregoryEnDelai+ $facturesGregoryEnRetardInferieure30js+ $facturesGregoryEnRetardEntre30j60js+ $facturesGregoryEnRetardEntre60j90js+ $facturesGregoryEnRetardSuperieure90js;

        // Benjamin
        $facturesBenjaminEnDelai = $facturesEnDelai->match(['ref_commercial_id' => 33])->sumOf('ResteMontantTotal');
        $nbfacturesBenjaminEnDelai = $facturesEnDelai->match(['ref_commercial_id' => 33])->count();

        $enRetardInferieure30js = $facturesEnRetardInferieure30js->match(['ref_commercial_id' => 33]);
        $facturesBenjaminEnRetardInferieure30js = $enRetardInferieure30js->sumOf('ResteMontantTotal');
        $nbBenjaminEnRetardInferieure30js = $enRetardInferieure30js->count();

        $enRetardEntre30j60js = $facturesEnRetardEntre30j60js->match(['ref_commercial_id' => 33]);
        $facturesBenjaminEnRetardEntre30j60js = $enRetardEntre30j60js->sumOf('ResteMontantTotal');
        $nbBenjaminEnRetardEntre30j60js = $enRetardEntre30j60js->count();

        $enRetardEntre60j90js = $facturesEnRetardEntre60j90js->match(['ref_commercial_id' => 33]);
        $facturesBenjaminEnRetardEntre60j90js = $enRetardEntre60j90js->sumOf('ResteMontantTotal');
        $nbBenjaminEnRetardEntre60j90js = $enRetardEntre60j90js->count();

        $enRetardSuperieure90js = $facturesEnRetardSuperieure90js->match(['ref_commercial_id' => 33]);
        $facturesBenjaminEnRetardSuperieure90js = $enRetardSuperieure90js->sumOf('ResteMontantTotal');
        $nbBenjaminEnRetardSuperieure90js = $enRetardSuperieure90js->count();

        $totalFacturesBenjaminEnRetard = $facturesBenjaminEnDelai+ $facturesBenjaminEnRetardInferieure30js+ $facturesBenjaminEnRetardEntre30j60js+ $facturesBenjaminEnRetardEntre60j90js+ $facturesBenjaminEnRetardSuperieure90js;

        // Fin : Détail par commercial
        $this->set(compact('nbfacturesLucieEnDelai', 'nbLucieEnRetardInferieure30js', 'nbLucieEnRetardEntre30j60js', 'nbLucieEnRetardEntre60j90js', 'nbLucieEnRetardSuperieure90js', 'nbfacturesBertrantEnDelai', 'nbBertrantEnRetardInferieure30js', 'nbBertrantEnRetardEntre30j60js', 'nbBertrantEnRetardEntre60j90js', 'nbBertrantEnRetardSuperieure90js', 'nbfacturesGregoryEnDelai', 'nbGregoryEnRetardInferieure30js', 'nbGregoryEnRetardEntre30j60js', 'nbGregoryEnRetardEntre60j90js', 'nbGregoryEnRetardSuperieure90js', 'nbfacturesBenjaminEnDelai', 'nbBenjaminEnRetardInferieure30js', 'nbBenjaminEnRetardEntre30j60js', 'nbBenjaminEnRetardEntre60j90js', 'nbBenjaminEnRetardSuperieure90js', 'nbtacturesVenteDelai', 'nbRetardVenteInferieure30js', 'nbRetardVenteEntre30j60js', 'nbRetardVenteEntre60j90js', 'nbRetardVenteSuperieure90js', 'nbFacturesPartDelai', 'nbRetardPartInferieure30js', 'nbRetardPartEntre30j60js', 'nbRetardPartEntre60j90js', 'nbRetardPartSuperieure90js', 'nbFacturesLocFiDelai', 'nbRetardLocFiInferieure30js', 'nbRetardLocFiEntre30j60js', 'nbRetardLocFiEntre60j90js', 'nbRetardLocFiSuperieure90js', 'nbFacturesEventDelai', 'nbFacturesRetardEventInferieure30js', 'nbFacturesRetardEventEntre30j60js', 'nbFacturesRetardEventEntre60j90js', 'nbFacturesRetardEventSuperieure90js', 'totalFacturesLucieEnRetart', 'totalFacturesBertrantEnRetard', 'totalfacturesGregoryEnRetard', 'totalFacturesBenjaminEnRetard', 'totalLocEvent', 'totalRetardLocFi', 'totalRetardVente', 'totalFacturesRetardPart', 'totalLocEvent', 'totalRetardLocFi', 'totalRetardVente', 'totalFacturesRetardPart', 'facturesEnAttenteReglementLucie', 'facturesEnAttenteReglementBertrant', 'facturesEnAttenteReglementGregory', 'facturesEnAttenteReglementBenjamin', 'facturesEnAttentedEvent', 'facturesEnAttentedPart', 'facturesEnAttentedLocFi', 'facturesEnAttentedVente', 'with_decimal', 'facturesGregoryEnDelai', 'facturesGregoryEnRetardInferieure30js', 'facturesGregoryEnRetardEntre30j60js', 'facturesGregoryEnRetardEntre60j90js', 'facturesGregoryEnRetardSuperieure90js', 'facturesBenjaminEnDelai', 'facturesBenjaminEnRetardInferieure30js', 'facturesBenjaminEnRetardEntre30j60js', 'facturesBenjaminEnRetardEntre60j90js', 'facturesBenjaminEnRetardSuperieure90js', 'facturesBertrantEnDelai', 'facturesBertrantEnRetardInferieure30js', 'facturesBertrantEnRetardEntre30j60js', 'facturesBertrantEnRetardEntre60j90js', 'facturesBertrantEnRetardSuperieure90js', 'facturesLucieEnDelai', 'facturesLucieEnRetardInferieure30js', 'facturesLucieEnRetardEntre30j60js', 'facturesLucieEnRetardEntre60j90js', 'facturesLucieEnRetardSuperieure90js', 'facturesRetardLucie', 'facturesRetardBertrant', 'facturesRetardGregory', 'facturesRetardBenjamin', 'totalFacturesLocFiDelai', 'facturesRetardLocFiInferieure30js', 'facturesRetardLocFiEntre30j60js', 'facturesRetardLocFiEntre60j90js', 'facturesRetardLocFiSuperieure90js', 'totalFacturesVenteDelai', 'facturesRetardVenteInferieure30js', 'facturesRetardVenteEntre30j60js', 'facturesRetardVenteEntre60j90js', 'facturesRetardVenteSuperieure90js', 'totalFacturesPartDelai', 'facturesRetardPartInferieure30js', 'facturesRetardPartEntre30j60js', 'facturesRetardPartEntre60j90js', 'facturesRetardPartSuperieure90js', 'totalFacturesEventDelai', 'facturesRetardEventInferieure30js', 'facturesRetardEventEntre30j60js', 'facturesRetardEventEntre60j90js', 'facturesRetardEventSuperieure90js', 'facturesRetardPart', 'facturesRetardEvent', 'facturesRetardLocFi', 'facturesRetardVente', 'totalFacturesEnRetard', 'totalFactures', 'totalFacturesNonReglees', 'totalFacturesDelai', 'totalFacturesEnRetardInferieure30js', 'totalFacturesEnRetardEntre30j60js', 'totalFacturesEnRetardEntre60j90js', 'totalFacturesEnRetardSuperieure90js', 'nbFacturesEnRetardInferieure30js', 'nbFacturesEnRetardEntre30j60js', 'nbFacturesEnRetardEntre60j90js', 'nbFacturesEnRetardSuperieure90js', 'nbFacturesEnDelai'));
    }

    public function dashboardSyntheseMensuelle() {

        $this->viewBuilder()->setLayout('dashboard');
    }
    
    
    /**
     * 
     * @return type
     */
    public function facturesRetard() 
    {

        $listeDevisFactures = $this->DevisFactures->find('complete')->where(['DevisFactures.status' => 'delay']);

        $devisFacturesEntity = $this->DevisFactures->newEntity();

        $indent = $this->request->getQuery('indent');
        $ref_commercial_id = $this->request->getQuery('ref_commercial_id');
        $client_type = $this->request->getQuery('client_type');
        $created = $this->request->getQuery('created');
        $antenne_id = $this->request->getQuery('antenne_id');
        $keyword = $this->request->getQuery('keyword');
        $periode = $this->request->getQuery('periode');
        $date_threshold = $this->request->getQuery('date_threshold');
        $status = $this->request->getQuery('status');
        $date_evenement = $this->request->getQuery('date_evenement');
        $type_doc_id = $this->request->getQuery('type_doc_id');
        $is_in_sellsy = $this->request->getQuery('is_in_sellsy');
        $mois_id = $this->request->getQuery('mois_id') ?? (date('m')-1);
        $sort = $this->request->getQuery('sort');
        $direction = $this->request->getQuery('direction');
        $progression = $this->request->getQuery('progression');
        
        $customFinderOptions = [
            'keyword' => $keyword,
            'ref_commercial_id' => $ref_commercial_id,
            'client_type' => $client_type,
            'is_in_sellsy' => $is_in_sellsy,
            'created' => $created,
            'antenne_id' => $antenne_id,
            'periode' => $periode,
            'date_threshold' => $date_threshold,
            'status' => $status,
            'type_doc_id' => $type_doc_id,
            'mois_id' => $mois_id,
            'sort' => $sort,
            'direction' => $direction,
            'progression' => $progression
        ];
        
        $commercials = $this->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name']); // profile Konitys Commercial
        $antennes = $this->Antennes->find('listByCity');

        $listeDevisFactures->find('filtre', $customFinderOptions);
        
        $sumFactures = $this->DevisFactures->find('all')->find('filtre', $customFinderOptions)->where(['DevisFactures.status' => 'delay']);

        $sumFactures = new Collection($sumFactures->toArray());
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // client existant
            if($data['client'] == 1) {
                $this->request->getSession()->write('devis_factures_client', $this->Clients->findById($data['client_id'])->contain('ClientContacts')->first());
                return $this->redirect(['action' => 'add','model_devis_facture_id' => $data['model_devis_facture_id'], 'categorie_tarifaire' => $data['categorie_tarifaire'], 'type_doc_id' => $data['type_doc_id']]);
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
                    $this->request->getSession()->write('devis_factures_client', $this->Clients->findById($clientEntity->id)->contain('ClientContacts')->first());

                    return $this->redirect(['action' => 'add','model_devis_facture_id' => $data['model_devis_facture_id'], 'categorie_tarifaire' => $data['categorie_tarifaire']]);
                }
            }
        }
                    
        $progressions = Configure::read('devis_factures_progression');
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
        $modelDevisFactures = $this->DevisFactures->find('list',['valueField' => 'model_name'])->where(['is_model' => 1]);        
        $type_docs = $this->DevisFactures->DevisTypeDocs->find('list')->orderAsc('nom')->toArray();
        $modelCategories = $this->DevisFactures->ModeleDevisFacturesCategories->find('list');
        $modelSousCategories = $this->DevisFactures->ModeleDevisFacturesSousCategories->find('list',['groupField' => 'modele_devis_factures_category_id']);
        $contactTypes = $this->Clients->ClientContacts->ContactTypes->find('list');
        $mois = $this->Mois->find('list', ['valueField' => 'mois_annee'])->select(['mois_annee' => 'concat(nom, ". ", "'.date('y').'")']);
        $payss = $this->Clients->Payss->find('listAsc');


        $listeDevisFactures = $this->paginate($listeDevisFactures, ['limit' => 50, 'order' => ['DevisFactures.indent' => 'DESC']]);
        $this->set(@compact('payss', 'sumFactures', 'contactTypes', 'progressions', 'progression', 'total_ht', 'total_ttc','date_evenement', 'indent','periode', 'periodes', 'date_threshold', 'antennes', 'commercials','ref_commercial_id','categorie_tarifaire', 'connaissance_selfizee','modelCategories', 'modelSousCategories', 'client_type'));
        $this->set(@compact('mois_id', 'mois', 'status', 'genres', 'created', 'antenne_id', 'keyword', 'devis_factures_status', 'listeDevisFactures', 'devisFacturesEntity', 'genres_short','groupeClients','type_commercials', 'modelDevisFactures', 'customFinderOptions', 'secteursActivites', 'type_docs', 'type_doc_id'));
    }
    
}
