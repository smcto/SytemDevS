<?php
namespace App\Controller;

use App\Controller\AppController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\Core\Configure;
use Cake\Utility\Text;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public $typeProfilKonitys;

    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->typeProfilKonitys = Configure::read('typeProfilKonitys');
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        //debug($user);die;
        $typeprofils = $user['typeprofils'];
        if(array_intersect(['admin', 'konitys'], $typeprofils)) {
            return true;
        }
        //return parent::isAuthorized($user);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($group_user = null)
    {
        $typeProfil = $this->request->getQuery('typeprofil');
        $antenne = $this->request->getQuery('antenne');
        $key = $this->request->getQuery('key');
        $exportXlsx = $this->request->getQuery('exportxlsx');

        $customFinderOptions = [
            'key' => $key,
            'typeProfil' => $typeProfil,
            'antenne' => $antenne,
            'group_user' => $group_user
        ];
        
        if($exportXlsx) {
            $users = $this->Users->find('all')
                    ->find('filtre', $customFinderOptions)
                    ->contain(['Clients', 'Antennes', 'Fournisseurs', 'Profils', 'Situations', 'Statuts', 'AntennesRattachees'])
                    ->group(['Users.id']);
            
            return $this->exportExcel($users);
        }

        $this->paginate = [
            'contain' => ['Clients', 'Antennes', 'Fournisseurs', 'Profils', 'Situations', 'Statuts', 'AntennesRattachees'],
            'finder' => [
                'filtre' => $customFinderOptions
            ],
            'group' =>'Users.id',
        ];
        $users = $this->paginate($this->Users);
        $this->loadModel('TypeProfils');
        $antennes = $this->Users->Antennes->find('list', ['valueField' => 'ville_principale']);

        //==== gestion infos à gauche avec les filtre
        $typeProfilKonitys = $this->typeProfilKonitys;
        $typeProfils = $this->TypeProfils->find('all', ['contain' => ['Users']]);
        $typeProfilsList = $this->TypeProfils->find('list', ['valueField' => 'nom']);

        if(!empty($group_user) && $group_user == 1) {//==== Contact
            $typeProfils->where(["TypeProfils.id NOT IN" => $typeProfilKonitys]);
            $typeProfilsList->where(["TypeProfils.id NOT IN" => $typeProfilKonitys]);
        } else
        if(!empty($group_user) && $group_user == 2) {//==== Utilisateur konitys
            $typeProfils->where(["TypeProfils.id IN" => $typeProfilKonitys]);
            $typeProfilsList->where(["TypeProfils.id IN" => $typeProfilKonitys]);
        }

        if(!empty($typeProfil)){
            $typeProfils->where(["TypeProfils.id"=>$typeProfil]);
        }

        if(!empty($antenne)) {
            $typeProfils->contain('Users.AntennesRattachees', function ($q) use ($antenne) {
                return $q->where(['AntennesRattachees.id'=> $antenne]);
            });
            foreach ($typeProfils as $k => $profil) {
                foreach ($profil->users as $cle => $user) {
                    if (empty($user->antennes_rattachees)) {
                        unset($profil->users[$cle]);
                    }
                }
            }
        }

        $this->set(compact('users', 'antennes', 'typeProfils', 'typeProfilsList','typeProfil'));
        $this->set(compact('typeProfil','antenne','key', 'group_user','customFinderOptions'));
    }

    /**
     *
     * Map method
     */
    public function map($group_user = null)
    {
        $typeProfil = $this->request->getQuery('typeprofil');
        $antenne = $this->request->getQuery('antenne');
        $key = $this->request->getQuery('key');

        $customFinderOptions = [
            'key' => $key,
            'typeProfil' => $typeProfil,
            'antenne' => $antenne,
            'group_user' => $group_user
        ];

        $this->paginate = [
            'contain' => ['Clients', 'Antennes', 'Fournisseurs', 'Profils', 'Situations', 'Statuts', 'AntennesRattachees'],
            'finder' => [
                'filtre' => $customFinderOptions
            ],
            'group' =>'Users.id',
            //'limit' =>10
        ];
        $users = $this->paginate($this->Users);
        $this->loadModel('TypeProfils');
        $antennes = $this->Users->Antennes->find('list', ['valueField' => 'ville_principale']);

        //==== gestion infos à gauche avec les filtre
        $typeProfilKonitys = $this->typeProfilKonitys;
        $typeProfils = $this->TypeProfils->find('all', ['contain' => ['Users']]);
        $typeProfilsList = $this->TypeProfils->find('list', ['valueField' => 'nom']);

        if(!empty($group_user) && $group_user == 1) {//==== Contact
            $typeProfils->where(["TypeProfils.id NOT IN" => $typeProfilKonitys]);
            $typeProfilsList->where(["TypeProfils.id NOT IN" => $typeProfilKonitys]);
        } else
            if(!empty($group_user) && $group_user == 2) {//==== Utilisateur konitys
                $typeProfils->where(["TypeProfils.id IN" => $typeProfilKonitys]);
                $typeProfilsList->where(["TypeProfils.id IN" => $typeProfilKonitys]);
            }

        if(!empty($typeProfil)){
            $typeProfils->where(["TypeProfils.id"=>$typeProfil]);
        }

        if(!empty($antenne)) {
            $typeProfils->contain('Users.AntennesRattachees', function ($q) use ($antenne) {
                return $q->where(['AntennesRattachees.id'=> $antenne]);
            });
            foreach ($typeProfils as $k => $profil) {
                foreach ($profil->users as $cle => $user) {
                    if (empty($user->antennes_rattachees)) {
                        unset($profil->users[$cle]);
                    }
                }
            }
        }

        $this->set(compact('users', 'antennes', 'typeProfils', 'typeProfilsList'));
        $this->set(compact('typeProfil','antenne','key', 'group_user'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Profils', 'Clients', 'Antennes', 'Fournisseurs', 'UserTypeProfils', 'Situations', 'AntennesRattachees', 'Factures'=>['EtatFactures', 'Evenements'], 'Payss']
        ]);
        //debug($user);die;
        $typeProfilKonitys = $this->typeProfilKonitys;
        if(!empty($user->profils)){
            foreach ($user->profils as $profil){
               //debug($user->profils[0]);
               if (in_array($user->profils[0]->id, $typeProfilKonitys)){
                   $user->group_user = 2;
               } else {
                   $user->group_user = 1;
               }
            }
        }

        $this->loadModel('Evenements');
        $event = $this->Evenements->find()
            ->order(['Evenements.id' => 'DESC'])
            ->contain(['Clients', 'TypeEvenements', 'TypeAnimations', 'Antennes', 'DateEvenements'])
            ->matching('Contacts', function ($q) use($id) {
                return $q->where(['Contacts.id'=>$id]);
            });

        $event2 = $this->Evenements->find()
            ->order(['Evenements.id' => 'DESC'])
            ->contain(['Clients', 'TypeEvenements', 'TypeAnimations', 'Antennes', 'DateEvenements'])
            ->matching('Responsables', function ($q) use($id) {
                return $q->where(['Responsables.id'=>$id]);
            });

        $interventions = $event->toArray() + $event2->toArray();
        //debug($interventions);die;

        $this->set('user', $user);
        $this->set('interventions', $interventions);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($group_user = null)
    {

        /*$num = "+33630682013";
        $phonecode = "+33";
        $code = substr($num, 0, strlen($phonecode));
        debug($code);die;*/

        $user = $this->Users->newEntity();
        $user->group_user = $group_user;
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            //debug($data);die;

            if (!empty($data['photo_file']['name'])) {
                $extension = pathinfo($data['photo_file']['name'], PATHINFO_EXTENSION);
                $newFilename = Text::uuid() . "." . $extension;
                $path = 'uploads/contacts/';
                if (move_uploaded_file($data['photo_file']['tmp_name'], $path . $newFilename)) {
                    $data['photo_nom'] = $newFilename;
                }
            }
            if($data['telephone_fixe'] == $data['phonecode']) { $data['telephone_fixe'] = "";} ;

            /*$data['telephone_portable'] = $data['phonecode']."".$data['telephone_portable'];
            if(!empty($data['telephone_fixe'])) $data['telephone_fixe'] = $data['phonecode']."".$data['telephone_fixe'];*/
            //debug($data);die;
            $user = $this->Users->patchEntity($user, $data, [
                'associated' => ['Profils', 'AntennesRattachees']
            ]);
            //debug($user);die;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index', intval($user->group_user)]);
            } else {
                //debug($user);die;
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $statuts = $this->Users->Statuts->find('list', ['valueField' => 'titre']);
        $clients = $this->Users->Clients->find('list', ['valueField' => 'nom']);
        $antennes = $this->Users->Antennes->find('list', ['valueField' => 'ville_principale']);
        $fournisseurs = $this->Users->Fournisseurs->find('list', ['valueField' => 'nom']);
        $this->loadModel('TypeProfils');
        $this->loadModel('Situations');
        $situationProfesionnelles = $this->Situations->find('list', ['valueField' => 'titre']);
        $countries = $this->Users->Payss->find('list', ['valueField' => function ($e) {
            return $e->name_fr . '   +'. $e->phonecode;
        }]);
        $countries2 = $this->Users->Payss->find('all');
        //debug($countries2->toArray());die;
        $typeProfilKonitys = $this->typeProfilKonitys;

        if(!empty($group_user) && $group_user == 1) {
            $typeProfils = $this->TypeProfils->find('list', ['valueField' => 'nom'])->where(["TypeProfils.id NOT IN" => $typeProfilKonitys]);
        }
        if(!empty($group_user) && $group_user == 2) {
            $typeProfils = $this->TypeProfils->find('list', ['valueField' => 'nom'])->where(["TypeProfils.id IN" => $typeProfilKonitys]);
        }

        $this->set(compact('user', 'statuts', 'clients', 'antennes', 'fournisseurs', 'typeProfils', 'situationProfesionnelles', 'countries', 'countries2', 'group_user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $group_user = null )
    {
        $user = $this->Users->get($id, [
            'contain' => ['Profils','Antennes', 'Situations', 'AntennesRattachees', 'Payss',]
        ]);
        $user->group_user = $group_user;
        //debug($user);die;
        $old_photo = $user->photo_nom;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if($data['telephone_fixe'] == $data['phonecode']) { $data['telephone_fixe'] = "";} ;

            //debug($data);die;
            if (!empty($data['photo_file']['name'])) {
                $extension = pathinfo($data['photo_file']['name'], PATHINFO_EXTENSION);
                $newFilename = Text::uuid() . "." . $extension;
                $path = 'uploads/contacts/';
                if (move_uploaded_file($data['photo_file']['tmp_name'], $path . $newFilename)) {
                    $data['photo_nom'] = $newFilename;
                    if(!empty($old_photo) && file_exists($path.$old_photo)) {
                        unlink($path.$old_photo);
                    }
                }
            }


            /*$data['telephone_portable'] = $data['phonecode']."".$data['telephone_portable'];
            if(!empty($data['telephone_fixe'])) $data['telephone_fixe'] = $data['phonecode']."".$data['telephone_fixe'];*/
            $user = $this->Users->patchEntity($user, $data, [
                'associated'=>['Profils', 'AntennesRattachees']
            ]);
            //debug($user);die;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index', intval($user->group_user)]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $statuts = $this->Users->Statuts->find('list', ['valueField' => 'titre']);
        $clients = $this->Users->Clients->find('list', ['valueField' => 'nom']);
        // $antennes = $this->Users->Antennes->find('list', ['valueField' => 'ville_principale']);
        $antennes = $this->Users->Antennes->find('list', ['valueField' => 'ville_principale'])->where(['is_deleted' => '0'])->orderAsc('ville_principale');;
        $fournisseurs = $this->Users->Fournisseurs->find('list', ['valueField' => 'nom']);
        $this->loadModel('TypeProfils');
        $this->loadModel('Situations');
        $typeProfils = $this->TypeProfils->find('list', ['valueField' => 'nom']);
        $situationProfesionnelles = $this->Situations->find('list', ['valueField' => 'titre']);
        $countries = $this->Users->Payss->find('list', ['valueField' => function ($e) {
            return $e->name_fr . '   +'. $e->phonecode;
        }]);
        $countries2 = $this->Users->Payss->find('all');

        $typeProfilKonitys = $this->typeProfilKonitys;

        if(!empty($group_user) && $group_user == 1) {
            $typeProfils = $this->TypeProfils->find('list', ['valueField' => 'nom'])->where(["TypeProfils.id NOT IN" => $typeProfilKonitys]);
        }
        if(!empty($group_user) && $group_user == 2) {
            $typeProfils = $this->TypeProfils->find('list', ['valueField' => 'nom'])->where(["TypeProfils.id IN" => $typeProfilKonitys]);
        }

        $this->set(compact('user', 'clients', 'antennes', 'fournisseurs', 'typeProfils', 'situationProfesionnelles', 'countries', 'countries2' , 'statuts', 'group_user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $group_user)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index', $group_user]);
    }

    public function forceLogin($id_contact){
        $user  = $this->Users->get($id_contact)->toArray();
        $this->Auth->setUser($user);
        $sessions = $this->getRequest()->getSession();
        //debug($sessions->read('Auth.User'));die;//debug($this->Auth->user());die;
        $typeProfils = $this->Users->UserTypeProfils->find('list', ['valueField'=>'type_profil_id'])->where(['user_id'=>$user['id']])->toArray();
        $antennes_rattachees = $this->Users->UserHasAntennes->find('list', ['valueField'=>'antenne_id'])->where(['user_id'=>$user['id']])->toArray();
        //debug($anttennesRattachees);die;
        $typeProfilsNames = [];
        foreach ($typeProfils as $key => $profil){
            if($profil == 1) {
                $typeProfilsNames [$profil] = "admin";
            } else  if($profil == 2) {
                $typeProfilsNames [$profil] = "konitys";
            } else  if($profil == 3) {
                $typeProfilsNames [$profil] = "konitys";
            } else  if($profil == 4) {
                $typeProfilsNames [$profil] = "antenne";
            } else  if($profil == 5) {
                $typeProfilsNames [$profil] = "installateur";
            }
        }
        $sessions->write('Auth.User.typeprofilskeys', $typeProfils);
        $sessions->write('Auth.User.typeprofils', $typeProfilsNames);
        $sessions->write('Auth.User.antennes_rattachees', $antennes_rattachees);
        if(in_array(1, $typeProfils)){ // admin
            return $this->redirect($this->Auth->redirectUrl());
        } else if(in_array(4, $typeProfils)){ // antenne
            return $this->redirect('/fr/dashboards/antennes');
        } else if(in_array(5, $typeProfils)){ // installateur
            return $this->redirect('/fr/dashboards/installateurs');
        }else{
            $this->Flash->error("Utilisateur invalide");
            return null;
        }
    }

    public function login($id_contact = null)
    {

        if(empty($id_contact)) {
            $this->viewBuilder()->setLayout('login');
            // die();
            if ($this->request->is('post')) {
                $user = $this->Auth->identify();
                //debug(gettype($user));die;
                if ($user) {

                    $this->Auth->setUser($user);

                    $sessions = $this->getRequest()->getSession();
                    $typeProfils = $this->Users->UserTypeProfils->find('list', ['valueField' => 'type_profil_id'])->where(['user_id' => $user['id']])->toArray();
                    $antennes_rattachees = $this->Users->UserHasAntennes->find('list', ['valueField' => 'antenne_id'])->where(['user_id' => $user['id']])->toArray();
                    //debug($anttennesRattachees);die;
                    $antennes_rattachees_list = $this->Users->get($user['id'], ['contain'=> 'AntennesRattachees'])->antennes_rattachees;
                    $typeProfilsNames = [];

                    foreach ($typeProfils as $key => $profil) {
                        if ($profil == 1) {
                            $typeProfilsNames [$profil] = "admin";
                        } else if (in_array($profil, [2, 3 , 11, 12, 10])) {
                            $typeProfilsNames [$profil] = "konitys";
                        }  else if ($profil == 4) {
                            $typeProfilsNames [$profil] = "antenne";
                        } else if ($profil == 5) {
                            $typeProfilsNames [$profil] = "installateur";
                        }
                    }
                    $profils = $this->Users->findById($user['id'])->contain(['Profils' => function ($q)
                    {
                        return $q->hydrate(false);
                    }])->first()->profils;

                    $profils_alias = [];
                    if ($profils) {
                        $profils_alias = collection($profils)->extract('alias')->toArray();
                    }


                    $sessions->write('Auth.User.typeprofilskeys', $typeProfils);
                    $sessions->write('Auth.User.typeprofils', $typeProfilsNames);
                    $sessions->write('Auth.User.profils_alias', $profils_alias);
                    $sessions->write('Auth.User.antennes_rattachees', $antennes_rattachees);
                    $sessions->write('Auth.User.antennes_rattachees_list', $antennes_rattachees_list);
                    //debug($sessions->read('Auth.User'));die;
                    if (in_array(1, $typeProfils)) { // admin
                        //return $this->redirect('/dashboards');
                        return $this->redirect($this->Auth->redirectUrl());
                    } else if (in_array(11, $typeProfils)) { // commercial
                        return $this->redirect('/fr/ventes');
                    }else if (in_array(4, $typeProfils)) { // antenne
                        return $this->redirect('/fr/dashboards/antennes');
                    } else if (in_array(5, $typeProfils)) { // installateur
                        return $this->redirect('/fr/dashboards/installateurs');
                    } else {
                        return $this->redirect($this->Auth->redirectUrl());
                    }
                } else {
                    $this->Flash->error(__("Username or password incorrect"));
                }
            }
        } else {
            //================ FORCE LOGIN CONTACT
            $contact  = $this->Users->get($id_contact)->toArray();
            $this->Auth->setUser($contact);
            $sessions = $this->getRequest()->getSession();
            //debug($sessions->read('Auth.User'));die;//debug($this->Auth->user());die;
            $typeProfils = $this->Users->UserTypeProfils->find('list', ['valueField'=>'type_profil_id'])->where(['user_id'=>$contact['id']])->toArray();
            $antennes_rattachees = $this->Users->UserHasAntennes->find('list', ['valueField'=>'antenne_id'])->where(['user_id'=>$contact['id']])->toArray();
            $antennes_rattachees_list = $this->Users->get($contact['id'], ['contain'=> 'AntennesRattachees'])->antennes_rattachees;
            //debug($antennes_rattachees_list);die;
            $typeProfilsNames = [];
            foreach ($typeProfils as $key => $profil){
                if($profil == 1) {
                    $typeProfilsNames [$profil] = "admin";
                } else if (in_array($profil, [2, 3 , 11, 12, 10])) {
                    $typeProfilsNames [$profil] = "konitys";
                } else if($profil == 4) {
                    $typeProfilsNames [$profil] = "antenne";
                } else  if($profil == 5) {
                    $typeProfilsNames [$profil] = "installateur";
                }
            }
            $profils = $this->Users->findById($contact['id'])->contain(['Profils' => function ($q)
            {
                return $q->hydrate(false);
            }])->first()->profils;

            $profils_alias = [];
            if ($profils) {
                $profils_alias = collection($profils)->extract('alias')->toArray();
            }
            $sessions->write('Auth.User.typeprofilskeys', $typeProfils);
            $sessions->write('Auth.User.profils_alias', $profils_alias);
            $sessions->write('Auth.User.typeprofils', $typeProfilsNames);
            $sessions->write('Auth.User.antennes_rattachees', $antennes_rattachees);
            $sessions->write('Auth.User.antennes_rattachees_list', $antennes_rattachees_list);
            if(in_array(1, $typeProfils)){ // admin
                return $this->redirect($this->Auth->redirectUrl());
            } else if(in_array(4, $typeProfils)){ // antenne
                return $this->redirect('/fr/dashboards/antennes');
            } else if(in_array(5, $typeProfils)){ // installateur
                return $this->redirect('/fr/dashboards/installateurs');
            }else{
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
    }
    

    public function logout()
    {
        $this->Flash->success(__("You have been disconnected."));
        return $this->redirect($this->Auth->logout());
    }

    public function intervention($id_user = null)
    {
        $this->loadModel('Evenements');
        $event = $this->Evenements->find()
            ->order(['Evenements.id' => 'DESC'])
            ->matching('Contacts', function ($q) use($id_user) {
                return $q->where(['Contacts.id'=>$id_user]);
            });

        $event2 = $this->Evenements->find()
            ->order(['Evenements.id' => 'DESC'])
            ->matching('Responsables', function ($q) use($id_user) {
                return $q->where(['Responsables.id'=>$id_user]);
            });
        $evenements = $event->toArray() + $event2->toArray();
        /*debug(count($event->toArray()));
        debug(count($event2->toArray()));
        debug(count($evenements));die;*/
        debug($evenements);die;
    }

    //==== fusion contacts users
    /*public function migration()
    {
        $contactsUser =  $this->Users->Contacts->find('all');
        $users = $this->Users->find('list');
        //$contactsUser2 =  $this->Users->Contacts->find('all')->innerJoinWith('Users')->where(['Contacts.user_id IS NOT'=> NULL]);
        /*debug(count($contactsUser->toArray()));
        debug(count($contactsUser2->toArray()));die;
        //debug($contactsUser->toArray());die;
        foreach ($contactsUser as $key => $contact) {
            if(in_array($contact->user_id, $users->toArray())) {
                $user = $this->Users->get($contact->user_id);
                if ($user) {
                    //debug(" Contact: ".$contact->id." user_id: ".$user->id);
                    $user->nom = $contact->nom;
                    $user->prenom = $contact->prenom;
                    $user->email = $contact->email;
                    $user->antenne_id = $contact->antenne_id;
                    $user->situation_id = $contact->situation_id;
                    $user->client_id = $contact->client_id;
                    $user->statut_id = $contact->statut_id;

                    $user->telephone_portable = $contact->telephone_portable;
                    $user->telephone_fixe = $contact->telephone_fixe;
                    $user->country_id = $contact->country_id;
                    $user->date_naissance = $contact->date_naissance;
                    $user->info_a_savoir = $contact->info_a_savoir;
                    $user->mode_renumeration = $contact->mode_renumeration;
                    $user->is_vehicule = $contact->is_vehicule;
                    $user->modele_vehicule = $contact->modele_vehicule;
                    $user->nbr_borne_transportable_vehicule = $contact->nbr_borne_transportable_vehicule;
                    $user->commentaire_vehicule = $contact->commentaire_vehicule;
                    $user->photo_nom = $contact->photo_nom;
                    $user->situation_id = $contact->situation_id;
                    $user->statut_id = $contact->statut_id;
                    $user->description_rapide = $contact->description_rapide;
                    $user->vehicule = $contact->vehicule;
                    $user->capacite_chargement_borne = $contact->capacite_chargement_borne;
                    $user->creneaux_disponibilite = $contact->creneaux_disponibilite;
                    $user->zone_intervention = $contact->zone_intervention;
                    $user->fonction = $contact->fonction;
                    $user->adresse = $contact->adresse;
                    $user->cp = $contact->cp;
                    $user->ville = $contact->ville;
                    $user->pays = $contact->pays;
                    $user->commentaire_interne = $contact->commentaire_interne;

                    if($this->Users->save($user)){
                        debug("OK :".$key." ===>".$contact->id);
                    } else {debug("KO :".$key." ===>".$contact->id);
                    }
                }
            } else {
                //debug(" Contact: ".$contact->id." user_id: ".$contact->user_id);
                $user = $this->Users->newEntity();
                $user->nom = $contact->nom;
                $user->prenom = $contact->prenom;
                $user->email = $contact->email;
                $user->antenne_id = $contact->antenne_id;
                $user->situation_id = $contact->situation_id;
                $user->client_id = $contact->client_id;
                $user->statut_id = $contact->statut_id;
                $user->created = $contact->created;
                $user->modified = $contact->modified;

                $user->telephone_portable = $contact->telephone_portable;
                $user->telephone_fixe = $contact->telephone_fixe;
                $user->country_id = $contact->country_id;
                $user->date_naissance = $contact->date_naissance;
                $user->info_a_savoir = $contact->info_a_savoir;
                $user->mode_renumeration = $contact->mode_renumeration;
                $user->is_vehicule = $contact->is_vehicule;
                $user->modele_vehicule = $contact->modele_vehicule;
                $user->nbr_borne_transportable_vehicule = $contact->nbr_borne_transportable_vehicule;
                $user->commentaire_vehicule = $contact->commentaire_vehicule;
                $user->photo_nom = $contact->photo_nom;
                $user->situation_id = $contact->situation_id;
                $user->statut_id = $contact->statut_id;
                $user->description_rapide = $contact->description_rapide;
                $user->vehicule = $contact->vehicule;
                $user->capacite_chargement_borne = $contact->capacite_chargement_borne;
                $user->creneaux_disponibilite = $contact->creneaux_disponibilite;
                $user->zone_intervention = $contact->zone_intervention;
                $user->fonction = $contact->fonction;
                $user->adresse = $contact->adresse;
                $user->cp = $contact->cp;
                $user->ville = $contact->ville;
                $user->pays = $contact->pays;
                $user->commentaire_interne = $contact->commentaire_interne;
                if($this->Users->save($user)){
                    debug("OK :".$key." ===>".$contact->id);
                } else {debug("KO :".$key." ===>".$contact->id);
                }
            }
        }die;

    }*/

    
    
    public function exportExcel($contacts = []) {

        $niveau_info = Configure::read('niveau_info');
        $source = Configure::read('source');
        $spreadsheet = new Spreadsheet();
        $datas = [];
        $datas[] = ['Nom et prenom' ,'Civilité', 'Date naiss', 'Info à savoir', 'Modèle de rémunération', 'Véhiculé', 'Modèle véhicule', 'Nombre bornes transportable', 'Commentaire vehicule',
                        'Téléphone portable', 'Téléphone fixe', 'email', 'adresse', 'Cp', 'Ville', 'Situation professionnelle', 'description rapide', 'Source', 'Description source', 'Commentaire interne',
                        'Antennes' ,'Niveau technique informatique', 'Description'];
        foreach ($contacts as  $contact){
            $ligne = [];
            $ligne[] = $contact->full_name;
            $ligne[] = $contact->civilite?'Femme':'Homme';
            $ligne[] = $contact->date_naissance?$contact->date_naissance->format('d-m-Y'):'';
            $ligne[] = $contact->info_a_savoir;
            $ligne[] = $contact->mode_renumeration;
            $ligne[] = $contact->is_vehicule?'Véhiculé':"-";
            $ligne[] = $contact->modele_vehicule;
            $ligne[] = $contact->nbr_borne_transportable_vehicule;
            $ligne[] = str_replace(['&nbsp;'], [' '], strip_tags($contact->commentaire_vehicule));
            $ligne[] = ' ' . $contact->telephone_portable;
            $ligne[] = ' ' . $contact->telephone_fixe;
            $ligne[] = $contact->email;
            $ligne[] = $contact->adresse;
            $ligne[] = $contact->cp;
            $ligne[] = $contact->ville;
            $ligne[] = $contact->situation?$contact->situation->titre:'-';
            $ligne[] = $contact->description_rapide;
            $ligne[] = @$source[$contact->source];
            $ligne[] = str_replace(['&nbsp;'], [' '], strip_tags($contact->description_source));
            $ligne[] = str_replace(['&nbsp;'], [' '], strip_tags($contact->commentaire_interne));
            $antennes = [];
            foreach ($contact->antennes_rattachees as $antenne) {
                $antennes[] = $antenne->ville_principale;
            }
            $ligne[] = implode(', ', $antennes);
            $ligne[] = @$niveau_info[$contact->niveau_tech_info];
            $ligne[] = str_replace(['&nbsp;'], [' '], strip_tags($contact->description_niveau_tech_info));
            $datas [] =  $ligne;
        }
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($datas, NULL, 'A1');
        $writer = new Xlsx($spreadsheet);
        if(!empty($datas)) {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Export Utilisateur.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        }
    }
}
