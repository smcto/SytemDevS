<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\I18n\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\Utility\Text;
use Cake\ORM\TableRegistry;

/**
 * Antennes Controller
 *
 * @property \App\Model\Table\AntennesTable $Antennes
 *
 * @method \App\Model\Entity\Antenne[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AntennesController extends AppController
{

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if(array_intersect(['admin', 'konitys'], $typeprofils)) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($exportExcel = null)
    {
        $etat = $this->request->getQuery('etat');
        $fondvert = $this->request->getQuery('fondvert');
        $key = $this->request->getQuery('key');
        $ville_principale = $this->request->getQuery('ville_principale');
        $sous_antenne = $this->request->getQuery('sous_antenne');

        $customFinderOptions = [
            'key' => $key,
            'etat' => $etat,
            'ville_principale' => $ville_principale,
            'fondvert' => $fondvert,
            'sous_antenne' => $sous_antenne
        ];
        
        if($exportExcel) {
            $antennes = $this->Antennes->find('filtre', $customFinderOptions)->contain(['Etats', 'Users', 'SecteurGeographiques', 'DocumentsAntennes','LieuTypes','ParentAntennes','Payss'])->order(['Antennes.ville_principale' => 'ASC']);
            return $this->exportExcel($antennes);
        }
        
        $this->paginate = [
            'contain' => ['LieuTypes', 'Etats', 'Bornes' => ['ModelBornes'], 'Evenements', 'Responsables', 'Contacts', 'StockAntennes','ParentAntennes', 'Users'],
            'finder' => [
                'filtre' => $customFinderOptions
            ],
            'order' => ['ville_principale' => 'ASC']
        ];
        $antennes = $this->paginate($this->Antennes);
        $etats = $this->Antennes->Etats->find('list', ['valueField'=>'valeur']);
        //debug($fondvert);die;


        // ==== Synthese avec filtre 
        // ville principales + sous antennes = nombre total d'antennes
        $antennesList = $this->Antennes->find('filtre', $customFinderOptions)->where(['is_deleted' => 0]);
        $villePrincipalesList = $this->Antennes->find('filtre', $customFinderOptions)->where(['is_deleted' => '0', 'sous_antenne' => 0]);
        $sousAntennesList = $this->Antennes->find('filtre', $customFinderOptions)->where(['is_deleted' => 0, 'sous_antenne' => 1]);
        $antennesOuvert = $this->Antennes->find()->contain(['Etats'=> function ($q) { return $q->where(['Etats.id'=>1]);}])->where(['is_deleted' => 0]);
        $antennesAvenir = $this->Antennes->find()->contain(['Etats'=> function ($q) { return $q->where(['Etats.id'=>2]);}])->where(['is_deleted' => 0]);
        $antennesAvenir = $this->Antennes->find()->contain(['Etats'=> function ($q) { return $q->where(['Etats.id'=>2]);}])->where(['is_deleted' => 0]);

//        if(!empty($key)){
//            $antennesList->contain('Contacts', function ($q) use ($key){
//                return $q->where(['Contacts.nom LIKE' => '%'.$key.'%'])->orWhere(['Contacts.prenom LIKE' => '%'.$key.'%']);
//            });
//            $antennesList->where(['Antennes.ville_principale LIKE' => '%'.$key.'%'])->where(['Antennes.ville_excate LIKE' => '%'.$key.'%']);
//            
//            $villePrincipalesList->contain('Contacts', function ($q) use ($key){
//                return $q->where(['Contacts.nom LIKE' => '%'.$key.'%'])->orWhere(['Contacts.prenom LIKE' => '%'.$key.'%']);
//            });
//            $villePrincipalesList->where(['Antennes.ville_principale LIKE' => '%'.$key.'%'])->where(['Antennes.ville_excate LIKE' => '%'.$key.'%']);
//
//            $sousAntennesList->contain('Contacts', function ($q) use ($key){
//                return $q->where(['Contacts.nom LIKE' => '%'.$key.'%'])->orWhere(['Contacts.prenom LIKE' => '%'.$key.'%']);
//            });
//            $sousAntennesList->where(['Antennes.ville_principale LIKE' => '%'.$key.'%'])->where(['Antennes.ville_excate LIKE' => '%'.$key.'%']);
//
//            $antennesOuvert->contain('Contacts', function ($q) use ($key){
//                return $q->where(['Contacts.nom LIKE' => '%'.$key.'%'])->orWhere(['Contacts.prenom LIKE' => '%'.$key.'%']);
//            });
//            $antennesOuvert->where(['Antennes.ville_principale LIKE' => '%'.$key.'%'])->where(['Antennes.ville_excate LIKE' => '%'.$key.'%']);
//
//            $antennesAvenir->contain('Contacts', function ($q) use ($key){
//                return $q->where(['Contacts.nom LIKE' => '%'.$key.'%'])->orWhere(['Contacts.prenom LIKE' => '%'.$key.'%']);
//            });
//            $antennesAvenir->where(['Antennes.ville_principale LIKE' => '%'.$key.'%'])->where(['Antennes.ville_excate LIKE' => '%'.$key.'%']);
//        }
//        if(!empty($etat)){
//            $antennesList->where(['Antennes.etat_id' =>$etat]);
//            $villePrincipalesList->where(['Antennes.etat_id' =>$etat]);
//            $sousAntennesList->where(['Antennes.etat_id' =>$etat]);
//            $antennesOuvert->where(['Antennes.etat_id' =>$etat]);
//            $antennesAvenir->where(['Antennes.etat_id' =>$etat]);
//        }

//        if(!empty($fondvert)){
//            if($fondvert == "1"){
//                $fond_vert = NULL;
//            } else {
//                $fond_vert = true;
//            }
//            $antennesList->where(['Antennes.fond_vert IS' =>$fond_vert]);
//            $antennesOuvert->where(['Antennes.fond_vert IS' =>$fond_vert]);
//            $antennesAvenir->where(['Antennes.fond_vert IS' =>$fond_vert]);
//        }
        
        $nbrTotal = $antennesList->count();
        $nbrVillePrincipales = $villePrincipalesList->count();
        $nbrSousAntenne = $sousAntennesList->count();
        $nbrAntenneOuvert = $antennesOuvert->count();
        $nbrAntenneAvenir = $antennesAvenir->count();

        $ville_principales = $this->Antennes->find('list', ['keyField'=>'ville_principale','valueField'=>'ville_principale'])->distinct(['ville_principale'])->where(['Antennes.is_deleted' => '0'])->orderAsc('ville_principale');
        $this->loadModel('GammesBornes');
        $gammes = $this->GammesBornes->find('all')->toArray();
        $allGamme = $this->Antennes->Bornes->find('all')
                        ->select(['nombre' => 'count(Bornes.id)', 'gamme' => 'GammesBornes.id','antenne' => 'Antennes.id'])
                        ->where(['Bornes.parc_id' => 2])
                        ->contain(['ModelBornes' => 'GammesBornes', 'Antennes'])
                        ->group(['Antennes.id','GammesBornes.id',])
                        ->toArray();
                //debug($allGamme);die;
        
        $this->set(compact('antennes', 'etats', 'ville_principales','gammes','nbrVillePrincipales','customFinderOptions','sous_antenne'));
        $this->set(compact('etat', 'fondvert', 'key', 'ville_principale', 'nbrTotal', 'nbrAntenneOuvert', 'nbrAntenneAvenir','nbrSousAntenne'));
    }

    /**
     * View map
     *
     */
    public function map()
    {
        $etat = $this->request->getQuery('etat');
        $fondvert = $this->request->getQuery('fondvert');
        $key = $this->request->getQuery('key');
        $ville_principale = $this->request->getQuery('ville_principale');

        $customFinderOptions = [
            'key' => $key,
            'etat' => $etat,
            'ville_principale' => $ville_principale,
            'fondvert' => $fondvert
        ];
        
        $antennes = $this->Antennes->find('filtre', $customFinderOptions)
            ->contain(['LieuTypes', 'Etats', 'Bornes', 'Evenements', 'Responsables', 'Contacts'])
            ->toArray();
        
        //$antennes = $this->paginate($this->Antennes);
        $etats = $this->Antennes->Etats->find('list', ['valueField'=>'valeur']);
        //debug($fondvert);die;


        //==== Synthese avec filtre
        //===========================
        $antennesList = $this->Antennes->find('filtre', $customFinderOptions)->where(['is_deleted' => 0, 'sous_antenne' => 0]);
        $villePrincipalesList = $this->Antennes->find('filtre', $customFinderOptions)->distinct(['ville_principale'])->where(['is_deleted' => '0']);
        $sousAntennesList = $this->Antennes->find('filtre', $customFinderOptions)->where(['is_deleted' => 0, 'sous_antenne' => 1]);
        $antennesOuvert = $this->Antennes->find()->contain(['Etats'=> function ($q) { return $q->where(['Etats.id'=>1]);}])->where(['is_deleted' => 0]);
        $antennesAvenir = $this->Antennes->find()->contain(['Etats'=> function ($q) { return $q->where(['Etats.id'=>2]);}])->where(['is_deleted' => 0]);
        $antennesAvenir = $this->Antennes->find()->contain(['Etats'=> function ($q) { return $q->where(['Etats.id'=>2]);}])->where(['is_deleted' => 0]);
//
//        if(!empty($key)){
//            $antennesList->contain('Contacts', function ($q) use ($key){
//                return $q->where(['Contacts.nom LIKE' => '%'.$key.'%'])->orWhere(['Contacts.prenom LIKE' => '%'.$key.'%']);
//            });
//            $antennesList->where(['Antennes.ville_principale LIKE' => '%'.$key.'%'])->where(['Antennes.ville_excate LIKE' => '%'.$key.'%']);
//
//            $antennesOuvert->contain('Contacts', function ($q) use ($key){
//                return $q->where(['Contacts.nom LIKE' => '%'.$key.'%'])->orWhere(['Contacts.prenom LIKE' => '%'.$key.'%']);
//            });
//            $antennesOuvert->where(['Antennes.ville_principale LIKE' => '%'.$key.'%'])->where(['Antennes.ville_excate LIKE' => '%'.$key.'%']);
//
//            $antennesAvenir->contain('Contacts', function ($q) use ($key){
//                return $q->where(['Contacts.nom LIKE' => '%'.$key.'%'])->orWhere(['Contacts.prenom LIKE' => '%'.$key.'%']);
//            });
//            $antennesAvenir->where(['Antennes.ville_principale LIKE' => '%'.$key.'%'])->where(['Antennes.ville_excate LIKE' => '%'.$key.'%']);
//        }
//        if(!empty($etat)){
//            $antennesList->where(['Antennes.etat_id' =>$etat]);
//            $antennesOuvert->where(['Antennes.etat_id' =>$etat]);
//            $antennesAvenir->where(['Antennes.etat_id' =>$etat]);
//        }
//
//        if(!empty($fondvert)){
//            if($fondvert == "1"){
//                $fond_vert = NULL;
//            } else {
//                $fond_vert = true;
//            }
//            $antennesList->where(['Antennes.fond_vert IS' =>$fond_vert]);
//            $antennesOuvert->where(['Antennes.fond_vert IS' =>$fond_vert]);
//            $antennesAvenir->where(['Antennes.fond_vert IS' =>$fond_vert]);
//        }
        
        $nbrTotal = $antennesList->count();
        $nbrVillePrincipales = $villePrincipalesList->count();
        $nbrSousAntenne = $sousAntennesList->count();
        $nbrAntenneOuvert = $antennesOuvert->count();
        $nbrAntenneAvenir = $antennesAvenir->count();

        $ville_principales = $this->Antennes->find('list', ['keyField'=>'ville_principale','valueField'=>'ville_principale'])->distinct(['ville_principale'])->where(['Antennes.is_deleted' => '0'])->orderAsc('ville_principale');
        $customFinderOptions = array_filter($customFinderOptions);

        $this->set(compact('antennes', 'etats', 'ville_principales','gammes','nbrVillePrincipales','customFinderOptions'));
        $this->set(compact('etat', 'fondvert', 'key', 'ville_principale', 'nbrTotal', 'nbrAntenneOuvert', 'nbrAntenneAvenir','nbrSousAntenne'));
    }

    /**
     * View method
     *
     * @param string|null $id Antenne id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $antenne = $this->Antennes->get($id, [
            'contain' => [
                'Etats', 'StockAntennes', 'Fichiers', 'DocumentsAntennes','LieuTypes','ParentAntennes',
                'LotProduits' => ['TypeEquipements', 'Equipements'], 
                'Bornes' => ['ModelBornes' => 'GammesBornes']]
        ]);
        
        $lieuTypes = $this->Antennes->LieuTypes->find('list', ['valueField' => 'nom']);
        $etats = $this->Antennes->Etats->find('list', ['valueField' => 'valeur']);
        $statuts = $this->Antennes->Contacts->Statuts->find('list', ['valueField' => 'titre']);
        $situations = $this->Antennes->Contacts->Situations->find('list', ['valueField' => 'titre']);
        $debit_internets = $this->Antennes->DebitInternets->find('list', ['valueField' => 'valeur'])->toArray();
        $antennes = $this->Antennes->find('list',['valueField'=>'ville_principale'])->orderAsc('ville_principale');

        $parcs = $this->Antennes->Bornes->Parcs->find()->contain(['Bornes' => function ($q) use($id)
        {
            return $q->where(['Bornes.antenne_id' => $id])->contain(['ModelBornes' => 'GammesBornes']);
        }])->orderAsc('nom');


        $pays = $this->Antennes->Payss->find('list', ['valueField' => 'name_fr']);
        $secteur_geos = $this->Antennes->SecteurGeographiques->find('list', ['valueField' => 'nom'])->toArray();

        $this->set(compact('parcs', 'antenne', 'lieuTypes', 'etats', 'situations', 'statuts', 'debit_internets', 'secteur_geos', 'pays','antennes'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $antenne = $this->Antennes->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            if(empty($data['sous_antenne'])){
                $data['antenne_id'] = null;
            }
            
            if($data['tous_jours']){
                
                $horaire_accueil = [
                    'jours' => 'tous_jours',
                    'heurs' => [
                        'debut' => $data['debut'],
                        'fin' => $data['fin'],
                    ]
                ];
                $data['horaire_accueil'] = json_encode($horaire_accueil);
                
            }elseif($data['jours_specifique']){
                        
                $jours = ['lun','mar', 'mer', 'jeu', 'ven', 'sam','dim']; 
                
                $horaire_accueil = [
                    'jours' => 'jours_specifique',
                    'heurs' => [],
                ];
                foreach ($jours as $jour){
                    if($data[$jour] && $data['debut-1-'.$jour] && $data['fin-1-'.$jour]){
                        $horaire_accueil['heurs'][$jour]['debut-1-'.$jour] = $data['debut-1-'.$jour];
                        $horaire_accueil['heurs'][$jour]['fin-1-'.$jour] = $data['fin-1-'.$jour];
                    }
                    
                    if($data[$jour] && $data['debut-2-'.$jour] && $data['fin-2-'.$jour]){
                        $horaire_accueil['heurs'][$jour]['debut-2-'.$jour] = $data['debut-2-'.$jour];
                        $horaire_accueil['heurs'][$jour]['fin-2-'.$jour] = $data['fin-2-'.$jour];
                    }
                }
                $data['horaire_accueil'] = json_encode($horaire_accueil);
            }
            

            $antenne = $this->Antennes->patchEntity($antenne, $data,[
                'associated' => ['StockAntennes']
            ]);
            
            if ($this->Antennes->save($antenne)) {
                //======= Photos
                if (!empty($data['photoslieux'])) {
                    foreach ($data['photoslieux'] as $doc){
                        $filename = $doc['nom'];
                        if (copy(PATH_TMP . $filename, PATH_ANTENNES . $filename)) {
                            unlink(PATH_TMP . $filename);
                            $doc = $this->Antennes->Fichiers->newEntity();
                            $doc->nom_fichier = $filename;
                            $doc->chemin = PATH_ANTENNES . $filename ;
                            $doc->antenne_id = $antenne->id;
                            $this->Antennes->Fichiers->save($doc);
                        }
                    }
                }
                
                //======= Documents
                if (!empty($data['documents'])) {
                    foreach ($data['documents'] as $doc){
                        $filename = $doc['nom'];
                        if (copy(PATH_TMP . $filename, PATH_ANTENNES . $filename)) {
                            unlink(PATH_TMP . $filename);
                            $this->loadModel('DocumentsAntennes');
                            $doc = $this->DocumentsAntennes->newEntity();
                            $doc->nom_fichier = $filename;
                            $doc->chemin = PATH_ANTENNES . $filename ;
                            $doc->antenne_id = $antenne->id;
                            $this->DocumentsAntennes->save($doc);
                        }
                    }
                }
                
                if(!empty($data['borne'])){
                    $borne = TableRegistry::getTableLocator()->get('Bornes');
                    $query = $borne->query();
                    $query->update()
                        ->set([
                            'antenne_id' => $antenne->id,
                            'is_sous_louee' => 1
                        ])
                        ->where(['id' => $data['borne']])
                        ->execute();
                    
                        $this->Flash->success(__('The antenne has been saved.'));

                        return $this->redirect(['controller'=>'Bornes', 'action' => 'view', $data['borne']]);
                }

                $this->Flash->success(__('The antenne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{
                    @$this->set("contacts_errors", $data['contacts']);
                }

            $this->Flash->error(__('The antenne could not be saved. Please, try again.'));
        }
        
        $client = null;
        $borne_id = $this->request->getQuery('borne');
        $client_id = $this->request->getQuery('client');
        if($client_id){
                $this->loadModel('Clients');
                $client = $this->Clients->get($client_id, [
                    'contain' => ['ClientContacts']
                ]);
        }

        $lieuTypes = $this->Antennes->LieuTypes->find('list', ['valueField' => 'nom']);
        $etats = $this->Antennes->Etats->find('list', ['valueField' => 'valeur']);
        $antennes = $this->Antennes->find('list',['valueField'=>'ville_principale'])->orderAsc('ville_principale');

        $statuts = $this->Antennes->Contacts->Statuts->find('list', ['valueField' => 'titre']);
        $situations = $this->Antennes->Contacts->Situations->find('list', ['valueField' => 'titre']);
        $debit_internets = $this->Antennes->DebitInternets->find('list', ['valueField' => 'valeur']);

        $situations = $this->Antennes->Contacts->Situations->find('list', ['valueField' => 'titre']);
        $pays = $this->Antennes->Payss->find('list', ['valueField' => 'name_fr']);
        $secteur_geos = $this->Antennes->SecteurGeographiques->find('list', ['valueField' => 'nom']);

        $this->set(compact('antenne', 'lieuTypes', 'etats', 'situations', 'statuts', 'debit_internets', 'secteur_geos', 'pays','antennes','client','borne_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Antenne id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $antenne = $this->Antennes->get($id, [
            'contain' => ['Etats', 'StockAntennes', 'Fichiers', 'DocumentsAntennes']
        ]);//debug($antenne);die;
        if(!empty($antenne->stock_antennes)) {
            $stock_antenne_last[] = $antenne->stock_antennes[count($antenne->stock_antennes) - 1];
            $antenne->stock_antennes = $stock_antenne_last;
        }
        //debug($antenne);exit;
        $data = $this->request->getData();


        if ($this->request->is(['patch', 'post', 'put'])) {

            /*if(!empty($data['photo_lieu']['name'])){
                $fileName = $data['photo_lieu']['name'];
                $uploadPath = 'uploads/antenne/';
                //$uploadFile = $uploadPath.$fileName;
                $extension = pathinfo($data['photo_lieu']['name'], PATHINFO_EXTENSION);
                $newFilename = Text::uuid() . "." . $extension;
                $uploadFile = $uploadPath.$newFilename;
                if(move_uploaded_file($data['photo_lieu']['tmp_name'], $uploadFile)){
                    $data['photo_lieu'] = $newFilename;
                }
            }*/
            //debug($antenne->contacts[0]['date_naissance']->format('Y-m-d'));
            //exit;

            //$data_contacts = $data['contacts'];

            /*foreach($data_contacts as $key => $contact_item){
                if(!empty($contact_item['Tphoto_nom']['name'])){
                    $fileNameContact = $contact_item['Tphoto_nom']['name'];
                    $uploadPathContact = 'uploads/contact/';
                    $uploadFileContact = $uploadPathContact.$fileNameContact;
                    if(@move_uploaded_file($contact_item['Tphoto_nom']['tmp_name'], $uploadFileContact)){
                        $data['contacts'][$key]['photo_nom'] = $fileNameContact;
                    }else{
                        $data['contacts'][$key]['photo_nom'] = '';
                    }
                }else{
                    $data['contacts'][$key]['photo_nom'] = '';
                }

                if(!empty($contact_item['is_vehicule']))
                    $data['contacts'][$key]['is_vehicule'] = true;
                else
                    $data['contacts'][$key]['is_vehicule'] = false;
            }*/

            if(!$data['sous_antenne']){
                $data['antenne_id'] = null;
            }
            
            $antenne = $this->Antennes->patchEntity($antenne, $data,[
                'associated' => ['StockAntennes']
            ]);

            if ($this->Antennes->save($antenne)) {

                //======= Photos
                if (!empty($data['photoslieux'])) {
                    foreach ($data['photoslieux'] as $doc){
                        $filename = $doc['nom'];
                        if (copy(PATH_TMP . $filename, PATH_ANTENNES . $filename)) {
                            unlink(PATH_TMP . $filename);
                            $doc = $this->Antennes->Fichiers->newEntity();
                            $doc->nom_fichier = $filename;
                            $doc->chemin = PATH_ANTENNES . $filename ;
                            $doc->antenne_id = $antenne->id;
                            $this->Antennes->Fichiers->save($doc);
                        }
                    }
                }
                
                //======= Documents
                if (!empty($data['documents'])) {
                    foreach ($data['documents'] as $doc){
                        $filename = $doc['nom'];
                        if (copy(PATH_TMP . $filename, PATH_ANTENNES . $filename)) {
                            unlink(PATH_TMP . $filename);
                            $this->loadModel('DocumentsAntennes');
                            $doc = $this->DocumentsAntennes->newEntity();
                            $doc->nom_fichier = $filename;
                            $doc->chemin = PATH_ANTENNES . $filename ;
                            $doc->antenne_id = $antenne->id;
                            $this->DocumentsAntennes->save($doc);
                        }
                    }
                }
                $this->Flash->success(__('The antenne has been saved.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->set("contacts", $data['contacts']);
            }
            $this->Flash->error(__('The antenne could not be saved. Please, try again.'));
        }
        $lieuTypes = $this->Antennes->LieuTypes->find('list', ['valueField' => 'nom']);
        $etats = $this->Antennes->Etats->find('list', ['valueField' => 'valeur']);
        $statuts = $this->Antennes->Contacts->Statuts->find('list', ['valueField' => 'titre']);
        $situations = $this->Antennes->Contacts->Situations->find('list', ['valueField' => 'titre']);
        $debit_internets = $this->Antennes->DebitInternets->find('list', ['valueField' => 'valeur']);
        $antennes = $this->Antennes->find('list',['valueField'=>'ville_principale'])->orderAsc('ville_principale');

        $pays = $this->Antennes->Payss->find('list', ['valueField' => 'name_fr']);
        $secteur_geos = $this->Antennes->SecteurGeographiques->find('list', ['valueField' => 'nom']);

        $this->set(compact('antenne', 'lieuTypes', 'etats', 'situations', 'statuts', 'debit_internets', 'secteur_geos', 'pays','antennes'));
    }

    /**
     * ajax save heurs d'ouverture
     * @param type $param
     */
    public function saveHeurs($id = null) {
        
        $this->autoRender = false;
        $data = $this->request->getData();
        $data = $data['data'];
        $horaire_accueil = null;
        
        if($data['tous_jours']){

            $horaire_accueil = [
                'jours' => 'tous_jours',
                'heurs' => [
                    'debut' => $data['debut'],
                    'fin' => $data['fin'],
                ]
            ];

        }elseif($data['jours_specifique']){

            $jours = ['lun','mar', 'mer', 'jeu', 'ven', 'sam','dim']; 

            $horaire_accueil = [
                'jours' => 'jours_specifique',
                'heurs' => [],
            ];
            foreach ($jours as $jour){
                if($data[$jour] && $data['debut-1-'.$jour] && $data['fin-1-'.$jour]){
                    $horaire_accueil['heurs'][$jour]['debut-1-'.$jour] = $data['debut-1-'.$jour];
                    $horaire_accueil['heurs'][$jour]['fin-1-'.$jour] = $data['fin-1-'.$jour];
                }

                if($data[$jour] && $data['debut-2-'.$jour] && $data['fin-2-'.$jour]){
                    $horaire_accueil['heurs'][$jour]['debut-2-'.$jour] = $data['debut-2-'.$jour];
                    $horaire_accueil['heurs'][$jour]['fin-2-'.$jour] = $data['fin-2-'.$jour];
                }
            }
        }
        
        if($id != null){
                $borne = TableRegistry::getTableLocator()->get('Antennes');
                $query = $borne->query();
                $query->update()
                ->set([
                    'horaire_accueil' => json_encode($horaire_accueil),
                ])
                ->where(['id' => $id])
                ->execute();
        }
        
        echo json_encode($horaire_accueil);

    }




    /**
     * Delete method
     *
     * @param string|null $id Antenne id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $antenne = $this->Antennes->get($id);
        $antenne->is_deleted = true;
        if ($this->Antennes->save($antenne)) {
            $this->Flash->success(__('The antenne has been deleted.'));
        } else {
            $this->Flash->error(__('The antenne could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function uploadPhotos(){
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            //debug($data); die;
            $res["success"] = false;
            $res["type_upload"] = $data['type_upload'];
            //debug(count($data["file"]));die;
            if (!empty($data)) {
                $file = $data["file"];
                $fileName = $file['name'];
                $infoFile = pathinfo($fileName);
                $fileExtension = $infoFile["extension"];
                $extensionValide = array('doc', 'docx', 'pdf', 'png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');
                if (in_array($fileExtension, $extensionValide)) {
                    $newName = Text::uuid() . '.' . $fileExtension;
                    $tmpFilePath = $file['tmp_name'];
                    if (move_uploaded_file($tmpFilePath, PATH_TMP.$newName)) {
                        $res["success"] = true;
                        $res["name"] = $newName;
                    }
                } else {$res["error"] = "Fichier invalide format";}
            }
            echo json_encode($res);
        }
    }

    /**
     *
     * get documents uploaded to edit
     */
    public function getDocuments($id )
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        $res = [];
        $this->loadModel('DocumentsAntennes');
        $fichiers = $this->DocumentsAntennes->find('all')->where(['antenne_id'=>$id]);
        //debug($fichiers->toArray());die;
        if(!empty($fichiers)) {
            foreach ($fichiers as $fichier) {
                $fic['id'] = $fichier->id;
                $fic['name'] = $fichier->nom_fichier;
                $fic['url'] = $fichier->url;
                $fic['url_viewer'] = $fichier->url_viewer;
                $fic['size'] = filesize(PATH_ANTENNES . $fichier->nom_fichier);
                $infoFile = pathinfo($fichier->nom_fichier);
                $fileExtension = $infoFile["extension"];
                $fic['extension'] = $fileExtension;
                $res [] = $fic;
            }
        }
        echo json_encode($res);
    }
    
    /**
     *
     * get files uploaded to edit
     */
    public function getFichiers($id )
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        $res = [];
        $this->loadModel('Fichiers');
        $fichiers = $this->Fichiers->find('all')->where(['antenne_id'=>$id]);
        if(!empty($fichiers)) {
            foreach ($fichiers as $fichier) {
                $fic['id'] = $fichier->id;
                $fic['name'] = $fichier->nom_fichier;
                $fic['url'] = $fichier->url;
                $fic['url_viewer'] = $fichier->url_viewer;
                $fic['size'] = filesize(PATH_ANTENNES . $fichier->nom_fichier);
                $infoFile = pathinfo($fichier->nom_fichier);
                $fileExtension = $infoFile["extension"];
                $fic['extension'] = $fileExtension;
                $res [] = $fic;
            }
        }
        echo json_encode($res);
    }
    
    public function getAll(){
        $this->viewBuilder()->setLayout('ajax');
        //$this->autoRender = false;
        $antennes = $this->Antennes
            ->find('all')
//            ->contain(['Bornes' => function ($q)
//            {
//                $q->select(array_diff($this->Antennes->Bornes->getSchema()->columns(), ['teamviewer_password', 'teamviewer_remotecontrol_id', 'teamviewer_alias', 'teamviewer_device_id', 'teamviewer_group_id', 'teamviewer_online_state']));
//                return $q;
//            }])
                
            ->where([
                        'Antennes.is_deleted' => false,
                        'Antennes.longitude IS NOT NULL',
                        'Antennes.longitude <>' => '',
                        'Antennes.latitude IS NOT NULL',
                        'Antennes.latitude <>' => ''
                ])
            ->order(['Antennes.ville_principale' => 'ASC'])
            ->select(["Antennes.id", "Antennes.lieu_type_id", "Antennes.ville_principale", "Antennes.ville_excate", "Antennes.adresse", "Antennes.cp", "Antennes.email_commercial", "Antennes.telephone", "Antennes.longitude", "Antennes.latitude", "Antennes.pays_id", "Antennes.secteur_geographique_id", "Antennes.sous_antenne", "Antennes.antenne_id", "Antennes.id_wp"])
        ;
        $this->set(compact('antennes'));
        //$this->set('_serialize', ['antennes']);
    }
    
    public function getAntenne($id){
        $this->viewBuilder()->setLayout('ajax');
        //$this->autoRender = false;
        $antennes = $this->Antennes->find()
                                    ->where(['Antennes.is_deleted' => false])
                                    ->where(['Antennes.id' => $id]);
        
        $this->set(compact('antennes'));
        //$this->set('_serialize', ['antennes']);
    }

    public function getAntenneByVille($ville){
        $this->viewBuilder()->setLayout('ajax');
        //$this->autoRender = false;
        $antennes = $this->Antennes->find()
                                    ->where(['Antennes.is_deleted' => false])
                                    ->where(['Antennes.ville_excate' => $ville])->first();
        
        $this->set(compact('antennes'));
        //$this->set('_serialize', ['antennes']);
    }

    public function getAntenneByPays($pays){
        $this->viewBuilder()->setLayout('ajax');
        //$this->autoRender = false;
        $antennes = $this->Antennes->find()
                                    ->order(['ville_principale' => 'ASC'])
                                    ->where(['Antennes.is_deleted' => false])
                                    ->where(['Antennes.adresse LIKE' => '%, '.$pays]);
        //debug($antennes->toArray());die;
        $antennes = new Collection($antennes->toArray());
        $antennes = $antennes->chunk(6);
        $antennes = $antennes->toList();
        //debug($antennes->toList());die;
        $this->set(compact('antennes'));
        //$this->set('_serialize', ['antennes']);
    }

    public function getAntenneByPays2($pays_id){
        $this->viewBuilder()->setLayout('ajax');
        //$this->autoRender = false;
        $antennes = $this->Antennes->find()
                                    ->order(['ville_principale' => 'ASC'])
                                    ->where(['Antennes.is_deleted' => false, 'Antennes.pays_id' => $pays_id]);
        //debug($antennes->toArray());die;
        $antennes = new Collection($antennes->toArray());
        $antennes = $antennes->chunk(6);
        $antennes = $antennes->toList();
        //debug($antennes->toList());die;
        $this->set(compact('antennes'));
        //$this->set('_serialize', ['antennes']);
    }

    public function getAntenneLuxembourg(){
        $this->viewBuilder()->setLayout('ajax');
        //$this->autoRender = false;
        $antennes = $this->Antennes->find()
                                    ->where(['Antennes.is_deleted' => false])
                                    ->where(['Antennes.adresse LIKE' => '%Luxembourg']);
        $antennes = new Collection($antennes->toArray());
        $antennes = $antennes->chunk(5);
        $antennes = $antennes->toList();
        //debug($antennes->toArray());die;
        $this->set(compact('antennes'));
        //$this->set('_serialize', ['antennes']);
    }


    public function getAntenneBySecteurGeo(){
        $this->viewBuilder()->setLayout('ajax');
        //$this->autoRender = false;
        $antennes = $this->Antennes->find()
                                    ->contain(['SecteurGeographiques'])
                                    ->order(['secteur_geographique_id' => 'ASC', 'Antennes.ville_principale' => 'ASC'])
                                    ->where(['Antennes.is_deleted' => false, 'Antennes.secteur_geographique_id IS NOT' => NULL]);

        $collection = new Collection($antennes);
        $antennes = $collection->groupBy('secteur_geographique.nom')->toArray();
        //debug($antennes);die;

        $this->set(compact('antennes'));
        //$this->set('_serialize', ['antennes']);
    }

    public function getAntenneByCountry(){
        $this->viewBuilder()->setLayout('ajax');
        //$this->autoRender = false;
        $antennes = $this->Antennes->find()
                                    ->contain(['Payss'])
                                    ->order(['pays_id' => 'ASC'])
                                    ->where(['Antennes.is_deleted' => false, 'Antennes.pays_id IS NOT' => NULL]);
        //debug($antennes->toArray());die;

        $collection = new Collection($antennes);
        $antennes = $collection->groupBy('pays.name_fr')->toArray();
        //debug($antennes);die;

        $this->set(compact('antennes'));
        //$this->set('_serialize', ['antennes']);
    }
    
    
    public function exportExcel($antennes = []) {

        $spreadsheet = new Spreadsheet();
        $datas = [];
        $datas[] = ['Ville principale' ,'Ville exacte', 'Type', 'Type de lieu', 'Telephone', 'Email', 'Adresse', 'CP', 'Pays', 'Secteur Geographique', 'Latitude', 'Longitude',
                            'Nom de contact' ,'contact tel', 'contact mail', 'contact adress', 'contact cp', 'contact ville'];
        foreach ($antennes as  $antenne){
            $contacts = $antenne->users;
            if($contacts){
                foreach ($contacts as $contact) {
                    $ligne = [];
                    $ligne[] = $antenne->ville_principale;
                    $ligne[] = $antenne->ville_excate;
                    $ligne[] = $antenne->sous_antenne?"sous antenne":"antenne principale";
                    $ligne[] = $antenne->lieu_type?$antenne->lieu_type->nom:"";
                    $ligne[] = $antenne->telephone;
                    $ligne[] = $antenne->email_commercial;
                    $ligne[] = $antenne->adresse;
                    $ligne[] = $antenne->cp;
                    $ligne[] = $antenne->pays?$antenne->pays->name:"--";
                    $ligne[] = $antenne->secteur_geographique?$antenne->secteur_geographique->nom:"--";
                    $ligne[] = $antenne->latitude;
                    $ligne[] = $antenne->longitude;

                    $ligne[] = $contact->full_name;
                    $ligne[] = $contact->telephone_portable;
                    $ligne[] = $contact->email;
                    $ligne[] = $contact->adresse;
                    $ligne[] = $contact->cp;
                    $ligne[] = $contact->ville;
                    $datas [] =  $ligne;
                }
            } else {
                $ligne = [];
                $ligne[] = $antenne->ville_principale;
                $ligne[] = $antenne->ville_excate;
                $ligne[] = $antenne->sous_antenne?"sous antenne":"antenne principale";
                $ligne[] = $antenne->lieu_type?$antenne->lieu_type->nom:"";
                $ligne[] = $antenne->telephone;
                $ligne[] = $antenne->email_commercial;
                $ligne[] = $antenne->adresse;
                $ligne[] = $antenne->cp;
                $ligne[] = $antenne->pays?$antenne->pays->name:"--";
                $ligne[] = $antenne->secteur_geographique?$antenne->secteur_geographique->nom:"--";
                $ligne[] = $antenne->latitude;
                $ligne[] = $antenne->longitude;

                $ligne[] = "-";
                $ligne[] = "-";
                $ligne[] = "-";
                $ligne[] = "-";
                $ligne[] = "-";
                $ligne[] = "-";
                $datas [] =  $ligne;
            }
        }
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($datas, NULL, 'A1');
        $writer = new Xlsx($spreadsheet);
        if(!empty($datas)) {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Export Antennes.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        }
    }
}
