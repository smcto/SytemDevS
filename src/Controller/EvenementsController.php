<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\I18n\Date;
use Cake\Mailer\Email;


/**
 * Evenements Controller
 *
 * @property \App\Model\Table\EvenementsTable $Evenements
 *
 * @method \App\Model\Entity\Evenement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EvenementsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('RequestHandler');

    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if(array_intersect(['admin', 'konitys'], $typeprofils)) {
            return true;
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $antenne = $this->request->getQuery('antenne');
        $key = $this->request->getQuery('key');
        $type_evenement = $this->request->getQuery('type_evenement');
        $type_animation = $this->request->getQuery('type_animation');
        $type_client = $this->request->getQuery('type_client');
        $periodeType = $this->request->getQuery('periodeType');
        $numero_borne = $this->request->getQuery('numero_borne');

        $customFinderOptions = [
            'key' => $key,
            'antenne' => $antenne,
            'type_evenement' => $type_evenement,
            'type_animation' => $type_animation,
            'type_client' => $type_client,
            'periodeType' => $periodeType,
            'numero_borne' => $numero_borne,
        ];

        $this->paginate = [
            'contain' => ['Clients', 'TypeEvenements', 'TypeAnimations', 'Antennes', 'DateEvenements', 'Bornes', 'EvenementBriefs'],
            'finder' => [
                'filtre' => $customFinderOptions
            ]
        ];
        $evenements = $this->paginate($this->Evenements);
        //debug($evenements->count());die;
        $antennes = $this->Evenements->Antennes->find('list', ['valueField' => 'ville_principale']);
        $type_evenements = $this->Evenements->TypeEvenements->find('list', ['valueField' => 'nom']);
        $type_animations = $this->Evenements->TypeAnimations->find('list', ['valueField' => 'nom']);
        $bornes_affectes = $this->Evenements->Bornes->find('list', ['valueField' => 'numero']);
        $type_clients = ['person'=>'Particulier', 'corporation'=>'Professionel'];

        $this->set(compact('antenne','key', 'type_client', 'type_animation', 'type_evenement', 'type_clients', 'type_animations', 'type_evenements', 'periodeType'));
        $this->set(compact('evenements','antennes', 'bornes_affectes', 'numero_borne'));
    }

    function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($date_1, $date_2);

        return $interval->format($differenceFormat);
    }

    public function relance($type = null)
    {
        $now =  date("Y-m-d"); // === new Date(date("Y-m-d")); $interval = $this->dateDifference($now2, $now);
        $nbr_jrs_avant = 2;
        $nbr_jrs_apres = 2;
        $date_reference_avant = date("Y-m-d", strtotime($now. "+".$nbr_jrs_avant." days"));
        $date_reference_apres = date("Y-m-d", strtotime($now. "-".$nbr_jrs_apres." days"));
        //debug($date_reference_avant);
        //debug($date_reference_apres);die;
        $date_evenements = $this->Evenements->DateEvenements->find('all', [
            'contain' =>
                [
                    'Evenements' => [
                        'TypeEvenements',
                        'Antennes',
                        'Clients' => function ($q) {
                            $q->where(['Clients.client_type' => 'person']);
                            $q->matching('Documents', function ($q) {
                                //return $qq->where(['Documents.deleted_in_sellsy IS' => false, 'OR' => [['Documents.step =' => 'late'], ['Documents.step =' => 'payinprogress'] ]]);
                                return $q;
                            });
                            return $q;
                        }
                    ]
                ]
        ])->group('DateEvenements.id');
        if($type == 1){ // >=
            $date_evenements = $date_evenements->where(['date_debut >=' => $date_reference_avant]);
        }
        if($type == 2){ // <=
            $date_evenements = $date_evenements->where(['date_fin <=' => $date_reference_apres]);
        }
        $date_evenements = $date_evenements->toArray();

        /*debug(count($date_evenements));
        debug($date_evenements);die;*/

        /*if(!empty($date_evenements)) {
            foreach ($date_evenements as $date_evenement) {
                //debug($date_evenement->evenement->client);
                if (!empty($date_evenement->evenement->client->email)) {
                    $destinateur = $date_evenement->evenement->client->email;
                    $email = new Email('default');
                    $email->setViewVars(['date_evenement' => $date_evenement,])
                        ->setTemplate('relance')
                        ->setEmailFormat('html')
                        ->setFrom(["contact@loesys.fr" => 'Konitys'])
                        ->setSubject('Konitys')
                        ->setTo('celest1.pr@gmail.com');
                        //->setTo($destinateur);
                        if ($email->send()) {
                            //$this->out('Sent...');

                            $date_evenement = $this->Evenements->DateEvenements->get($date_evenement->id);
                            $date_evenement->is_sent_relance_av = true;
                            $date_evenement->date_relance_av = $now;
                            $this->Evenements->DateEvenements->save($date_evenement);

                            echo 'OK';
                        }
                }
            }
        }die;*/

        //NB: ajout champ ds dateEvenements: is_sent_relance_av / date_relance_av / is_sent_relance_ap / date_relance_ap

        $this->set(compact('date_evenements', 'type'));
    }


    public function recap()
    {
        $evenements = $this->Evenements->find('all', [
                    'contain' => [
                        'TypeEvenements',
                        'Antennes',
                        'Clients' => function ($q) {
                            $q->where(['Clients.client_type' => 'person']);
                            /*$q->matching('Documents', function ($q) {
                                return $q->where(['Documents.deleted_in_sellsy IS' => false ]);
                                return $q;
                            });*/
                            return $q;
                        }
                    ]
        ])->where(['envoyer_recap IS'=> true]);

        /*debug(count($date_evenements));
        debug($date_evenements);die;*/

        /*if(!empty($date_evenements)) {
            foreach ($date_evenements as $date_evenement) {
                //debug($date_evenement->evenement->client);
                if (!empty($date_evenement->evenement->client->email)) {
                    $destinateur = $date_evenement->evenement->client->email;
                    $email = new Email('default');
                    $email->setViewVars(['date_evenement' => $date_evenement,])
                        ->setTemplate('relance')
                        ->setEmailFormat('html')
                        ->setFrom(["contact@loesys.fr" => 'Konitys'])
                        ->setSubject('Konitys')
                        ->setTo('celest1.pr@gmail.com');
                        //->setTo($destinateur);
                        if ($email->send()) {
                            //$this->out('Sent...');

                            $date_evenement = $this->Evenements->DateEvenements->get($date_evenement->id);
                            $date_evenement->is_sent_relance_av = true;
                            $date_evenement->date_relance_av = $now;
                            $this->Evenements->DateEvenements->save($date_evenement);

                            echo 'OK';
                        }
                }
            }
        }die;*/

        //NB: ajout champ ds dateEvenements: is_sent_relance_av / date_relance_av / is_sent_relance_ap / date_relance_ap

        $this->set(compact('evenements'));
    }

    public function chiffreCA() {
        $evenements = $this->Evenements->find('all', [
            'contain' => [
            'Antennes',
             'Clients' => 'Documents',
        ]
        ])->toArray();

        $documents = $this->Evenements->Clients->Documents->find('all', [
            'contain' => [
                'Clients' => ['Evenements' => ['Antennes']]
            ]
        ])->toArray();

        $antennes = $this->Evenements->Antennes->find('all', [
            'contain' => [
                'Evenements' => [
                    'Clients' => function ($q) {
                        //$q->where(['Clients.client_type' => 'person']);
                        $q->contain('Documents', function ($q) {
                            //$q->where(['Documents.step' => 'invoiced']);
                            return $q;
                        });
                        return $q;
                        }
                      ]
                    ]
        ])->toArray();

        /*debug(count($antennes));
        debug($antennes);die;*/

        $total_CA_facture_pro = 0;
        $total_CA_facture_part = 0;
        $total_CA_accepte = 0;
        $total_CA = 0;
        foreach ($antennes[0]->evenements as $evenement){
            //debug($evenement->nom_event);
            if(!empty($evenement->client)) {
                if(!empty($evenement->client->documents)) {
                    $documents = $evenement->client->documents;
                    foreach ($documents as $devis){
                        //==== TOTAL
                        $total_CA = $total_CA + $devis->montant_ttc;
                        //==== Facture
                        if($evenement->client->client_type == "corporation" && $devis->step == "invoiced"){
                            $total_CA_facture_pro = $total_CA_facture_pro + $devis->montant_ttc;
                        }
                        if($evenement->client->client_type == "person" && $devis->step == "invoiced"){
                            $total_CA_facture_part = $total_CA_facture_part + $devis->montant_ttc;
                        }
                        //==== Accepte
                        if($devis->step == "accepted"){
                            $total_CA_accepte = $total_CA_accepte + $devis->montant_ttc;
                        }
                    }
                }
                //debug($evenement->id . ' Client : ' . $evenement->client_id);
            }
        }

        debug('total_CA_facture_pro : '.$total_CA_facture_pro);
        debug('total_CA_facture_part : '.$total_CA_facture_part);
        debug('total_CA_accepte : '.$total_CA_accepte);die;

        debug($antennes[0]->evenements);die;
    }

    public function map()
    {
        $antenne = $this->request->getQuery('antenne');
        $key = $this->request->getQuery('key');

        $type_evenement = $this->request->getQuery('type_evenement');
        $type_animation = $this->request->getQuery('type_animation');
        $type_client = $this->request->getQuery('type_client');
        $periodeType = $this->request->getQuery('periodeType');
        $numero_borne = $this->request->getQuery('numero_borne');

        $customFinderOptions = [
            'key' => $key,
            'antenne' => $antenne,
            'type_evenement' => $type_evenement,
            'type_animation' => $type_animation,
            'type_client' => $type_client,
            'periodeType' => $periodeType,
            'numero_borne' => $numero_borne,
        ];

        $this->paginate = [
            'contain' => ['Clients', 'TypeEvenements', 'TypeAnimations', 'Antennes', 'Bornes'],
            'finder' => [
                'filtre' => $customFinderOptions
            ]
        ];
        $evenements = $this->paginate($this->Evenements);
        //debug($evenements);die;

        $antennes = $this->Evenements->Antennes->find('list', ['valueField' => 'ville_principale']);
        $type_evenements = $this->Evenements->TypeEvenements->find('list', ['valueField' => 'nom']);
        $type_animations = $this->Evenements->TypeAnimations->find('list', ['valueField' => 'nom']);
        $bornes_affectes = $this->Evenements->Bornes->find('list', ['valueField' => 'numero']);
        $type_clients = ['person'=>'Particulier', 'corporation'=>'Professionel'];

        $this->set(compact('antenne','key', 'type_client', 'type_animation', 'type_evenement', 'type_clients', 'type_animations', 'type_evenements', 'periodeType'));
        $this->set(compact('evenements','antennes', 'bornes_affectes', 'numero_borne'));
    }
	
	public function briefs($id = 0){
		$this->loadModel('Evenements');
		$this->loadModel('EvenementBriefs');
		
		$evenement = $this->Evenements->find('all',[
			'conditions'=>['Evenements.id'=>$id],
			'contain'=>['EvenementBriefs', 'Clients']
		])->first();
		
		if(!$evenement || !$evenement->evenement_brief){
			return $this->redirect(['action' => 'index']);
		}
		
		// debug($evenement);exit;
		
		$this->set(compact('evenement'));
	}
	
    /**
     * View method
     *
     * @param string|null $id Evenement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $evenement = $this->Evenements->get($id, [
            'contain' => ['Clients', 'TypeEvenements', 'Antennes', 'DateEvenements']
        ]);

        $this->set('evenement', $evenement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $evenement = $this->Evenements->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            //debug($data);die;
            //===== gestion Responsable & contacts
            $ids_contact = [];
            if(!empty($data['contacts']['_ids'])) {
                foreach ($data['contacts']['_ids'] as $id) {
                    $ids_contact [] = $id;
                }
            }
            if(!empty($ids_contact)) {
                unset($data['contacts']);
                foreach ($ids_contact as $key => $id) {
                    $data['contacts'][$key]['id'] = intval($id);
                    $data['contacts'][$key]['_joinData']['is_responsable'] = false;
                }
            }
            $j = count($ids_contact);
            if(!empty($data['responsable_id'])) {
                $data['responsables'][$j]['id'] = intval($data['responsable_id']);
                $data['responsables'][$j]['_joinData']['is_responsable'] = true;
                unset($data['responsable_id']);
            }
            //debug($data);die;

            $evenement = $this->Evenements->patchEntity($evenement, $data, [
                'associated' => ['DateEvenements','Documents', 'Contacts', 'Responsables']
            ]);
           //debug($evenement);die;
            if ($this->Evenements->save($evenement)) {

                //============ ENVOYE EMAIL RECAP
                $messagerecap = "";
                if($evenement->envoyer_recap) {
                    $evenement = $this->Evenements->get($evenement->id, [
                        'contain' => [
                            'Clients' => function ($q) {
                                $q->where(['Clients.client_type' => 'person']);
                                return $q;
                            }
                        ]
                    ]);

                    if (!empty($evenement->client->email)) {
                        $destinateur = $evenement->client->email;
                        $email = new Email('default');
                        $email->setViewVars(['evenement' => $evenement,])
                            ->setTemplate('recap')
                            ->setEmailFormat('html')
                            ->setFrom(["contact@konitys.fr" => 'Konitys'])
                            ->setSubject('Konitys')
                            ->setTo('celest1.pr@gmail.com');
                            //->setTo($destinateur);
                        if ($email->send()) {
                            //$this->out('Sent...');;
                            $evenement->is_envoye_recap = true;
                            $this->Evenements->save($evenement);
                            $messagerecap = "Email recap envoyé.";
                            //echo 'OK';
                        }
                    }
                }
                //===========


                $this->Flash->success(__('The evenement has been saved. '.$messagerecap));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The evenement could not be saved. Please, try again.'));
        }
        $clients = $this->Evenements->Clients->find('list', ['valueField' => 'nom']);
        $typeEvenements = $this->Evenements->TypeEvenements->find('list', ['valueField' => 'nom']);
        $natureEvenements = $this->Evenements->NatureEvenements->find('list', ['valueField' => 'options']);
        $typeAnimations = $this->Evenements->TypeAnimations->find('list', ['valueField' => 'nom']);
        $antennes = $this->Evenements->Antennes->find('list', ['valueField' => 'ville_principale']);

        $typeProfilKonitys = [0=>1, 1=>2, 2=>3];
        $responsablesList = $this->Evenements->Antennes->Users->find('list', ['valueField' => 'full_name'])
                ->matching('UserTypeProfils', function($q) use($typeProfilKonitys) {
                    return $q->where(['UserTypeProfils.type_profil_id IN'=>$typeProfilKonitys]);
                });
        $contactsList = $this->Evenements->Antennes->Users->find('list', ['valueField' => 'full_name'])
            ->matching('UserTypeProfils', function($q)use($typeProfilKonitys) {
                return $q->where(['UserTypeProfils.type_profil_id NOT IN'=>$typeProfilKonitys]);
            });
        //debug($responsablesList->toArray());die;
		
		$installations = $this->Evenements->TypeInstallations->find('list', ['conditions' => ['type' => 1], 'valueField' => 'nom']);
		$desinstallations = $this->Evenements->TypeInstallations->find('list', ['conditions' => ['type' => 0], 'valueField' => 'nom']);
		
        $this->set(compact('evenement', 'clients', 'typeEvenements','natureEvenements', 'antennes', 'typeAnimations', 'responsablesList',  'contactsList', 'installations', 'desinstallations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Evenement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		// Parametrage pour lié un évènement à un brief
		$parametre = ['id'=>$id, 'etape'=>0];
		$parametre = $this->Utilities->slEncryption(serialize($parametre));
		
        $evenement = $this->Evenements->get($id, [
            'contain' => ['DateEvenements', 'Clients','Documents', 'TypeAnimations', 'TypeEvenements', 'Antennes', 'Contacts', 'Responsables', 'NatureEvenements']
        ]);
        //debug($evenement);die;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            //debug($data);die;

            //===== gestion Responsable & contacts
            $ids_contact = [];
            if(!empty($data['contacts']['_ids'])) {
                foreach ($data['contacts']['_ids'] as $id) {
                    $ids_contact [] = $id;
                }
            }
            if(!empty($ids_contact)) {
                unset($data['contacts']);
                foreach ($ids_contact as $key => $id) {
                    $data['contacts'][$key]['id'] = intval($id);
                    $data['contacts'][$key]['_joinData']['is_responsable'] = false;
                }
            }
            $j = count($ids_contact);
            if(!empty($data['responsable_id'])) {
                $data['responsables'][$j]['id'] = intval($data['responsable_id']);
                $data['responsables'][$j]['_joinData']['is_responsable'] = true;
                unset($data['responsable_id']);
            }
            //debug($data);die;

            $evenement = $this->Evenements->patchEntity($evenement, $data, [
                'associated' => ['DateEvenements','Documents', 'Contacts', 'Responsables']
            ]);
            //debug($evenement);die;
            if ($this->Evenements->save($evenement)) {
                if (isset($data['asuppr'])) {
                    for ($i = 0; $i < count($data['asuppr']); $i++) {
                        if ($data['asuppr'][$i] !== '') {
                            $evenementdateId = $data['asuppr'][$i];
                            $dateAsuppr = $this->Evenements->DateEvenements->get($evenementdateId);
                            $this->Evenements->DateEvenements->delete($dateAsuppr);
                        }
                    }
                }
                $this->Flash->success(__('The evenement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The evenement could not be saved. Please, try again.'));
        }
        //$clientType = ['1'=>'corporation' , '2'=>'person' ];
        $clientType = ['corporation'=>1 , 'person'=>2 ];
        $evenement->client_type = $clientType[$evenement->client->client_type];
        $clients = $this->Evenements->Clients->find('list', ['valueField' => 'nom', 'conditions'=> ['client_type ='=>$evenement->client->client_type]]);
        $typeEvenements = $this->Evenements->TypeEvenements->find('list', ['valueField' => 'nom']);

        if(($evenement->client->client_type)=='corporation'){
            $naturetype = 'Professionnel';
        }
        if(($evenement->client->client_type)=='person'){
        $naturetype = 'Particulier';
        }

        $natureEvenements = $this->Evenements->NatureEvenements->find('list', ['valueField' => 'options', 'conditions'=> ['type ='=>$naturetype]]);
        $typeAnimations = $this->Evenements->TypeAnimations->find('list', ['valueField' => 'nom']);
        $antennes = $this->Evenements->Antennes->find('list', ['valueField' => 'ville_principale']);

        $typeProfilKonitys = [0=>1, 1=>2, 2=>3];
        $responsablesList = $this->Evenements->Antennes->Users->find('list', ['valueField' => 'full_name'])
            ->matching('UserTypeProfils', function($q) use($typeProfilKonitys) {
                return $q->where(['UserTypeProfils.type_profil_id IN'=>$typeProfilKonitys]);
            });
        $contactsList = $this->Evenements->Antennes->Users->find('list', ['valueField' => 'full_name'])
            ->matching('UserTypeProfils', function($q)use($typeProfilKonitys) {
                return $q->where(['UserTypeProfils.type_profil_id NOT IN'=>$typeProfilKonitys]);
            });
        //debug($responsablesList->toArray());die;
		$installations = $this->Evenements->TypeInstallations->find('list', ['conditions' => ['type' => 1], 'valueField' => 'nom']);
		$desinstallations = $this->Evenements->TypeInstallations->find('list', ['conditions' => ['type' => 0], 'valueField' => 'nom']);
		
		// debug($desinstallations->toArray());die;
		// exit;
       
	   $bornes = $this->Evenements->Antennes->Bornes->find('list', ['valueField' => 'numero'])
            ->where(['antenne_id =' => $evenement->antenne_id]);

        $devis = $this->Evenements->Documents->find('list',['valueField'=>'objet'])->where(['client_id'=>$evenement->client->id,'type_document'=>'estimate']);
        $this->set(compact('evenement', 'clients', 'typeEvenements', 'natureEvenements','antennes', 'personnes','devis', 'typeAnimations', 'contactsList', 'responsablesList', 'bornes', 'installations', 'desinstallations', 'parametre'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Evenement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $evenement = $this->Evenements->get($id);
        //debug($evenement);die;
        if ($this->Evenements->delete($evenement)) {
            $this->Flash->success(__('The evenement has been deleted.'));
        } else {
            $this->Flash->error(__('The evenement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function agenda(){
        /*$typeEvenements = $this->Evenements->TypeEvenements->find('list', ['valueField' => 'nom']);
        $antennes = $this->Evenements->Antennes->find('list', ['valueField' => 'ville_principale']);
        $clientType = ['corporation' => 'Professionel', 'person' => 'Particulier'];

        $this->set(compact('antenne', 'key', 'type_client', 'type_evenement'));
        $this->set(compact('dateEvenements', 'antennes', 'typeEvenements'));*/

    }

    public function getDatesEvents($start = null , $end = null){
        $events = $this->Evenements->DateEvenements->find('all', ['contain'=>['Evenements'=>['TypeEvenements', 'TypeAnimations', 'Clients']]])
                                                    ->where(['DateEvenements.date_debut IS NOT'=> NULL, 'DateEvenements.date_fin IS NOT'=> NULL]);
        if(!empty($start) && !empty($end)) {
            $events->where(function ($exp) use ($start, $end) {
                $exp->lte('DateEvenements.date_debut', $end);
                $exp->gte('DateEvenements.date_debut', $start);
                return $exp;
            });
        }
        //debug($events->toArray());die;
        //echo json_encode($events->toArray());
        $this->set('events', $events);
    }

    public function getEvent($id){
        $event = $this->Evenements->DateEvenements->get(intval($id), ['contain'=>['Evenements'=>['TypeEvenements', 'Clients']]]);
        $this->set('event', $event);
    }

    public function getListeClient()
    {
        $data = $this->request->getData();
        $client_type ="";
        if($data) {
            $type_client_id = $data['type_client_id'];
            if($type_client_id == 1){
                $client_type = "corporation";
            } else if($type_client_id == 2){
                $client_type = "person";
            }
        }

        $clients = $this->Evenements->Clients->find('list', ['valueField' => 'nom'])
            ->where(['client_type =' => $client_type]);
        //debug($clients->toArray());die;
        //echo json_encode($clients);
        $this->set('clients', $clients);
    }

    public function getListeNature()
    {
        $data = $this->request->getData();
        $client_type ="";
        if($data) {
            $type_client_id = $data['type_client_id'];
            if($type_client_id == 2){
                $client_type = "Particulier";
            } else if($type_client_id == 1){
                $client_type = "Professionnel";
            }
        }

        $natures = $this->Evenements->NatureEvenements->find('list', ['valueField' => 'options'])
            ->where(['type =' => $client_type]);
        //debug($natures->toArray());die;
        //echo json_encode($natures);
        $this->set('natures', $natures);
    }

    public function getListeBorne()
    {
        $data = $this->request->getData();
        $bornes = $this->Evenements->Antennes->Bornes->find('list', ['valueField' => 'numero'])
            ->where(['antenne_id =' => $data['antenne_id']]);

        $this->set('bornes', $bornes);
    }
    
    public function pipeline(){
        $this->loadModel('Pipes');
        
        $idPipe = $this->request->getQuery('pipe');
        if(empty($idPipe)){
            $idPipe = 1;
        }
        
        $pipe = $this->Pipes->get($idPipe);

        $etapes = $this->Pipes->PipeEtapes->find()
                        ->contain(['Evenements'=>['TypeAnimations', 'Antennes', 'Clients', 'Bornes', 'DateEvenements'], 'Pipes'])
                        ->where(['pipe_id'=>$idPipe]);

        //debug($etapes->toArray());die;

        //============= FILTRES
        $etapes_filtres = $this->Pipes->PipeEtapes->find()
            ->contain(['Pipes'])
            ->where(['pipe_id'=>$idPipe]);
        $type_evenement = $this->request->getQuery('type_evenement');
        if(!empty($type_evenement)) {
            $etapes = $etapes_filtres->contain(['Evenements' => function ($q) use ($type_evenement) {
                $q->contain(['TypeAnimations', 'Antennes', 'Bornes', 'Clients', 'DateEvenements']);
                return $q->where(['Evenements.type_evenement_id' => $type_evenement]);
            }]);
        }


        $type_animation = $this->request->getQuery('type_animation');
        if(!empty($type_animation)) {
            $etapes = $etapes_filtres->contain(['Evenements' => function ($q) use ($type_animation) {
                $q->contain(['TypeAnimations', 'Antennes', 'Bornes', 'Clients', 'DateEvenements']);
                return $q->where(['Evenements.type_animation_id' => $type_animation]);
            }]);
        }

        $type_client = $this->request->getQuery('type_client');
        if(!empty($type_client)){
            $etapes = $etapes_filtres->contain(['Evenements' => function ($q) use ($type_client) {
                $q->contain(['TypeAnimations', 'Antennes', 'Bornes', 'DateEvenements']);
                return $q->contain('Clients', function ($q) use ($type_client) {
                   return $q->where(['Clients.client_type' => $type_client]);
                });
            }]);
        }

        $antenne = $this->request->getQuery('antenne');
        if(!empty($antenne)){
            $etapes = $etapes_filtres->contain(['Evenements' => function ($q) use ($antenne) {
                $q->contain(['TypeAnimations', 'Bornes', 'Clients', 'DateEvenements']);

                return $q->where(['Evenements.antenne_id' => $antenne]);
            }]);
        }

        $periodeType = $this->request->getQuery('periodeType');
        if(!empty($periodeType)){
            $periodeType = explode('_', $periodeType);
            if($periodeType['0'] == "w"){
                $etapes = $etapes_filtres->contain(['Evenements' => function ($q) use ($periodeType) {

                    $q->contain(['TypeAnimations', 'Antennes', 'Bornes', 'Clients', 'DateEvenements']);
                    return $q->matching('DateEvenements', function ($q) use ($periodeType) {
                        return $q->where(['WEEK(DateEvenements.date_debut)'=> $periodeType['1'], 'WEEK(DateEvenements.date_fin)'=> $periodeType['1']]);
                    });
                }]);

            } elseif($periodeType['0'] == "m"){
                $etapes = $etapes_filtres->contain(['Evenements' => function ($q) use ($periodeType) {

                    $q->contain(['TypeAnimations', 'Antennes', 'Bornes', 'Clients', 'DateEvenements']);
                    return $q->matching('DateEvenements', function ($q) use ($periodeType) {
                        return $q->where(['MONTH(DateEvenements.date_debut)'=> $periodeType['1'], 'MONTH(DateEvenements.date_fin)'=> $periodeType['1']]);
                    });
                }]);
            }
        }

        $numero_borne =$this->request->getQuery('numero_borne');
        if(!empty($numero_borne)){
            $etapes = $etapes_filtres->contain(['Evenements' => function ($q) use ($numero_borne) {
                $q->contain(['TypeAnimations', 'Antennes', 'Clients', 'DateEvenements']);
                return $q->innerJoinWith('Bornes', function ($q) use ($numero_borne) {
                    return $q->where(['Bornes.numero' => $numero_borne]);
                });
            }]);
        }

        //debug($etapes->toArray());die;

        $antennes = $this->Evenements->Antennes->find('list', ['valueField' => 'ville_principale']);
        $type_evenements = $this->Evenements->TypeEvenements->find('list', ['valueField' => 'nom']);
        $type_animations = $this->Evenements->TypeAnimations->find('list', ['valueField' => 'nom']);
        $bornes_affectes = $this->Evenements->Bornes->find('list', ['valueField' => 'numero']);
        $type_clients = ['person'=>'Particulier', 'corporation'=>'Professionel'];
        //============== FIN FILTRES


        $data = $etapes->toArray();
        $idEvenement = (new Collection($data))->extract('evenements.{*}.id')->toList();

        $evenements = $this->Evenements->find('list',['valueField'=>'nom_event', 'contain'=>['TypeEvenements']]);
        //debug($idEvenement); 
        if(!empty($idEvenement)){
            $evenements = $evenements->where(['Evenements.id NOT IN'=>$idEvenement]);
        }
        
        $this->loadModel('EvenementPipeEtapes');
        $evenementPipeEtape = $this->EvenementPipeEtapes->newEntity();
        
        $allPipes = $this->Pipes->find('list',['valueField' => 'nom']);
        
        $this->set('idPipe',$idPipe);
        $this->set('allPipes',$allPipes);
        $this->set('pipe',$pipe);
        $this->set('etapes',$etapes);
        $this->set('evenements', $evenements);
        $this->set('evenementPipeEtape', $evenementPipeEtape);

        $this->set(compact('antenne','key', 'type_client', 'type_animation', 'type_evenement', 'type_clients', 'type_animations', 'type_evenements', 'periodeType'));
        $this->set(compact('antennes', 'bornes_affectes', 'numero_borne'));
    }
}
