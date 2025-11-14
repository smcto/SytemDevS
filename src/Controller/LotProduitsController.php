<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Fichier;
use Cake\Utility\Text;
use Cake\Log\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\I18n\Date;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Chronos\Chronos;

/**
 * LotProduits Controller
 *
 * @property \App\Model\Table\LotProduitsTable $LotProduits
 *
 * @method \App\Model\Entity\LotProduit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LotProduitsController extends AppController
{

    public function isAuthorized($user)
    {
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
    public function index($type = 'stock-composants', $is_has = null)
    {
        $key = $this->request->getQuery('key');
        $is_destock = $is_has == 'destock' ? 1 : 0;
        $export_csv = $this->request->getQuery('export');
        $is_event = $type == 'stock-event' ? 1:0;
        $type_equipement = $this->request->getQuery('type_equipement');
        $marque_equipement = $this->request->getQuery('marque_equipement');
        $etat = $this->request->getQuery('etat');
        $customFinderOptions = [
            'key' => $key,
            'type_equipement' => $type_equipement,
            'marque_equipement' => $marque_equipement,
            'etat' => $etat,
            'is_event' => $is_event,
            'is_destock' => $is_destock
        ];
        
        $contain = ['Antennes', 'TypeDocs', 'Equipements' => ['TypeEquipements','MarqueEquipements'],'Fournisseurs','Users'];
        if( ! $is_event) {
            $contain[] = $is_destock ? 'StockHs' : 'Stock';
        }
        
        if($export_csv == 'csv') {
            $titres = "Export vue synthetique stock";
            $filename = 'exportCsv-' . date('d-m-Y');
            $lotProduits = $this->LotProduits->find('all',['fields' => [
                        'id' => 'LotProduits.id',
                        'equipement_nom' => 'Equipements.valeur',
                        'marque' => 'MarqueEquipements.marque',
                        'type_equipement_nom'   => 'TypeEquipements.nom',
                        'etat' => 'LotProduits.etat',
                        'date_stock' => 'MAX(date_stock)',
                        'quantite' => 'SUM(LotProduits.quantite)',
                        'tarif_ht' => 'SUM(LotProduits.tarif_achat_ht)'
                    ]])
                    ->find('filtre',$customFinderOptions)
                    ->contain($contain)
                    ->group(['Equipements.type_equipement_id','Equipements.valeur','MarqueEquipements.marque','etat'])
                    ->order(['equipement_nom']);
            return $this->exportCsv($type = 'synthetique', $lotProduits, $titres, $filename);
        }
        
        
        $totalHt = $this->LotProduits->find('all',['fields' => ['sum' => 'SUM(LotProduits.tarif_achat_ht)']])
                ->find('filtre',$customFinderOptions)
                ->contain($contain)->first();
        
        $this->paginate = [
            'limit' => 40,
            'contain' => $contain,
            'fields' => [
                'id' => 'LotProduits.id',
                'equipement_nom' => 'Equipements.valeur',
                'marque' => 'MarqueEquipements.marque',
                'type_equipement_nom'   => 'TypeEquipements.nom',
                'date_stock' => 'MAX(date_stock)',
                'quantite' => 'SUM(LotProduits.quantite)',
                // 'etat' => 'LotProduits.etat',
                'tarif_ht' => 'SUM(LotProduits.tarif_achat_ht)'
            ],
            'finder' => [
                'filtre' => $customFinderOptions,
            ],
            'group' => ['Equipements.type_equipement_id','Equipements.valeur','MarqueEquipements.marque'],
            'sortWhitelist' => [
                'id',
                'equipement_nom',
                'marque',
                'type_equipement_nom',
                'etat',
                'date_stock',
                'quantite',
                'tarif_ht'
            ],
        ];
        
        if(! $this->request->getQuery('sort')) {
            $this->paginate['order'] = ['equipement_nom' => 'asc'];
        }

        $type_equipements = $this->LotProduits->Equipements->TypeEquipements->find('list',['valueField'=>'nom'])->order(['nom' => 'asc']);
        $marque_equipements = $this->LotProduits->Equipements->MarqueEquipements->find('list',['valueField'=>'marque'])->order(['marque' => 'asc']);

        $lotProduits = $this->paginate($this->LotProduits);
        // debug($lotProduits ->toArray());
        // die();
        $etatHsRebus = ['Hs' => 'Hs', 'rebus' => 'Rebus'];

        $this->set(compact('etatHsRebus', 'is_destock', 'is_event', 'lotProduits','key','type_equipement','marque_equipement', 'etat', 'type_equipements','marque_equipements','customFinderOptions','totalHt'));
    }

    /**
     * detail method
     *
     * @return \Cake\Http\Response|void
     */
    public function detail($type = 'stock-composants', $is_has = null)
    {
        
        $key = $this->request->getQuery('key');
        $export_csv = $this->request->getQuery('export');
        $is_event = $type == 'stock-event' ? 1:0;
        $is_destock = $is_has=='destock'? 1:0;
        $antenne_id = $this->request->getQuery('antenne_id');
        $univers_ids = $this->request->getQuery('type_docs._ids');
        
        $type_equipement = $this->request->getQuery('type_equipement');
        $marque_equipement = $this->request->getQuery('marque_equipement');
        $etat = $this->request->getQuery('etat');
        $customFinderOptions = [
            'key' => $key,
            'type_equipement' => $type_equipement,
            'marque_equipement' => $marque_equipement,
            'etat' => $etat,
            'is_event' => $is_event,
            'antenne_id' => $antenne_id,
            'type_doc_ids' => $univers_ids,
            'is_destock' => $is_destock
        ];
        
        $contain = ['Antennes', 'TypeDocs', 'Equipements' => ['TypeEquipements','MarqueEquipements'],'Fournisseurs','Users'];
        if( ! $is_event) {
            $contain[] = $is_destock ? 'StockHs' : 'Stock';;
        }
        
        if($export_csv == 'csv') {
            $titres = "Export detail stock";
            $filename = 'exportCsv-' . date('d-m-Y');
            $lotProduits = $this->LotProduits->find('all')
                    ->find('filtre',$customFinderOptions)
                    ->contain($contain)
                    ->order(['LotProduits.equipement_id', 'LotProduits.etat']);
            return $this->exportCsv($type = 'detail', $lotProduits, $titres, $filename);
        }
        
        
        $totalHt = $this->LotProduits->find('all',['fields' => ['sum' => 'SUM(LotProduits.tarif_achat_ht)']])
                ->find('filtre',$customFinderOptions)
                ->contain($contain)->first();
                
        $this->paginate = [
            'contain' => $contain,
            'finder' => [
                'filtre' => $customFinderOptions
            ],
            'sortWhitelist' => [
                'Equipements.valeur','MarqueEquipements.marque','TypeEquipements.nom', 'Fournisseurs.nom', 'Users.nom', 'serial_nb', 'tarif_achat_ht', 'date_stock','etat'
            ],
        ];
        
        if(! $this->request->getQuery('sort')) {
            $this->paginate['order'] = ['LotProduits.equipement_id', 'LotProduits.etat' => 'asc'];
        }

        $type_equipements = $this->LotProduits->Equipements->TypeEquipements->find('list',['valueField'=>'nom'])->order(['nom' => 'asc']);
        $marque_equipements = $this->LotProduits->Equipements->MarqueEquipements->find('list',['valueField'=>'marque'])->order(['marque' => 'asc']);
        $antennes = $this->LotProduits->Antennes->find('list')->where(['is_deleted <>' => 1])->order(['ville_principale' => 'ASC']);
        $univers = $this->LotProduits->TypeDocs->find('list');
        $lotProduits = $this->paginate($this->LotProduits);
        $isFilter = array_filter($customFinderOptions);
        $fournisseurs = $this->LotProduits->Fournisseurs->find('list', ['valueField'=>'nom','limit' => 200])->order(['nom' => 'asc']);
        $equipements = $this->LotProduits->Equipements->find('list',[
                'keyField' => 'id',
                'valueField' => 'valeur',
                'groupField' => 'type_equipement.id'
        ])
        ->contain('TypeEquipements');
        
        $this->set(compact('equipements', 'fournisseurs', 'is_destock', 'univers', 'univers_ids', 'antennes', 'antenne_id', 'lotProduits','key','type_equipement','marque_equipement', 'etat', 'type_equipements','marque_equipements','isFilter','customFinderOptions','totalHt', 'is_event'));
    }
    
    public function exportCsv($type = 'synthetique', $lotProduits = [], $titres = "", $filename = 'exportCsv') {
        
            $this->viewBuilder()->setLayout('ajax');
            
            $datas = [];
            $datas [] =  [$titres];
            if($type == 'synthetique') {
                $datas [] = ['Equipement', 'Type équipement', 'Marque', 'Etat', 'Derniere entrée', 'Quantité', 'Total HT'];
                foreach ($lotProduits as $lotProduit){
                    $ligne = [];
                    $ligne[] = $lotProduit->equipement_nom;
                    $ligne[] = $lotProduit->type_equipement_nom;
                    $ligne[] = $lotProduit->marque;
                    $ligne[] = $lotProduit->etat;
                    $ligne[] = @$lotProduit->date_stock ? $lotProduit->date_stock->format('d-m-Y') : '-';
                    $ligne[] = $lotProduit->quantite;
                    $ligne[] = str_replace('.00', '', $lotProduit->tarif_ht);

                    $datas [] =  $ligne;
                }
            }else {
                $datas [] = ['Equipement', 'Marque', 'Type équipement', 'Fournisseur', 'Numeros de serie', 'Entrée stock', 'Tarif HT', 'Etat', 'Num facture', 'Ajouté par'];
                foreach ($lotProduits as $lotProduit) {

                    if ($lotProduit->equipement_id) {
                        $ligne = [];
                        $ligne[] = $lotProduit->equipement->valeur;
                        $ligne[] = $lotProduit->equipement->marque_equipement? $lotProduit->equipement->marque_equipement->marque :'-';
                        $ligne[] = $lotProduit->equipement->type_equipement->nom;
                        $ligne[] = $lotProduit->fournisseur?$lotProduit->fournisseur->nom:'-';
                        $ligne[] = str_replace(",",", ",$lotProduit->serial_nb);
                        $ligne[] = $lotProduit->date_stock->format('d-m-Y');
                        $ligne[] = $lotProduit->tarif_achat_ht;
                        $ligne[] = $lotProduit->etat;
                        $ligne[] = $lotProduit->numero_facture ? $lotProduit->numero_facture: '-';
                        $ligne[] = $lotProduit->user ? $lotProduit->user->full_name : '-';

                        $datas [] =  $ligne;
                    }
                }
            }
            
            $datas = mb_convert_encoding($datas, 'UTF-16LE', 'UTF-8');
            $this->set(compact('datas'));
            $this->render('export_csv');
            $repons = $this->response->withDownload($filename.".csv");
            return $repons;
    }
    
    /*
     * View method
     *
     * @param string|null $id Lot Produit id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lotProduit = $this->LotProduits->get($id, [
            'contain' => ['Equipements' => ['TypeEquipements', 'EquipementsDocuments'], 'Fournisseurs', 'Users', 'Antennes', 'TypeDocs']
        ]);

        $typeEquipements = $this->LotProduits->TypeEquipements->find('list', ['limit' => 200]);

        $fournisseurs = $this->LotProduits->Fournisseurs->find('list', ['valueField'=>'nom','limit' => 200])->order(['nom' => 'asc']);

        $users = $this->LotProduits->Users->find('list', ['valueField'=>'full_name','limit' => 200]);

        $num_fact = $lotProduit->numero_facture;

        $tableLotProduits = TableRegistry::getTableLocator()->get('LotProduits');
        
        $query = $tableLotProduits
                        ->find()
                        ->select(['id', 'numero_facture','equipement_id','serial_nb'])
                        ->where(['lot' => $lotProduit->lot, 'lot <>' => '']);
        if($num_fact != null || $num_fact != ""){
            $query = $tableLotProduits
                        ->find()
                        ->select(['id', 'numero_facture','equipement_id','serial_nb'])
                        ->where(['numero_facture' => $num_fact, 'numero_facture <>' => '']);
        }

        $numeroSeries = TableRegistry::getTableLocator()->get('NumeroSeries');
        $serialquery = $numeroSeries
            ->find()
            ->select(['id', 'serial_nb','lot_produit_id','borne_id'])
            ->where(['lot_produit_id' => $lotProduit->id]);

       


        // debug($borne_ns);exit;


        $equipements = $this->LotProduits->Equipements->find('list',[
                'keyField' => 'id',
                'valueField' => 'valeur',
                'groupField' => 'type_equipement.nom'
        ])
        ->contain('TypeEquipements');
        $this->set(compact('lotProduit', 'typeEquipements', 'equipements', 'fournisseurs', 'users','query','serialquery'));

        // $this->set('lotProduit', $lotProduit);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $now = new Date(date("Y-m-d"));
        $lotProduit = $this->LotProduits->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $lot = Text::uuid();
            $d = $data['serial_nb'];
            $tarif_unique = $data['tarif_ht']?$data['tarif_ht']:0;
            $tarif = $data['tarif_nb'];
            $fname = '';
            $dossier = str_replace(WWW_ROOT, '', PATH_DOCUMENTATIONS);
            $dossier = '/'.str_replace(DS, '/', $dossier).'factures';
            
            foreach ($d as $key => $serial) {

                $lotProduit = $this->LotProduits->newEntity();

                $data['serial_nb'] = $serial;
                $data['tarif_achat_ht'] = $tarif_unique?$tarif_unique:$tarif[$key];
                // $data['date_stock'] = $now;
                $data['quantite'] = 1;
                $data['lot'] = $lot;
                $lotProduit = $this->LotProduits->patchEntity($lotProduit, $data);
                if ($this->LotProduits->save($lotProduit)) {
                    
                    if (!empty($data['facture_file']) && ! trim($fname)) {
                        
                        if (!is_dir(PATH_DOCUMENTATIONS.'factures'.DS.$lotProduit->id.DS)) {
                            $dir = new Folder(PATH_DOCUMENTATIONS.'factures'.DS.$lotProduit->id.DS, true, 0755);
                        }
                        $newFilename_array = [];

                        foreach ($data['facture_file'] as $key => $value) {
                            $extension = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));
                            $newFilename =  Text::uuid() . "." . $extension;
                            if (move_uploaded_file($value['tmp_name'], PATH_DOCUMENTATIONS.'factures'.DS.$lotProduit->id.DS. $newFilename)) {
                                $newFilename_array[] = $newFilename;
                            }
                        }
                        $fname = implode(',', $newFilename_array);
                        $dossier = $dossier.'/'.$lotProduit->id;
                    }
                    $lotProduit->dossier = $dossier;
                    $lotProduit->facture_file_name = $fname;
                    $this->LotProduits->save($lotProduit);
                    
                    $serials = TableRegistry::getTableLocator()->get('NumeroSeries');
                    $query = $serials->query();

                    $query->insert(['serial_nb', 'lot_produit_id','equipement_id', 'is_event', 'borne_id'])
                        ->values([
                            'serial_nb' => $serial,
                            'lot_produit_id' => $lotProduit->id,
                            'equipement_id' => $lotProduit->equipement_id,
                            'is_event' => $lotProduit->is_event,
                            'borne_id' => $lotProduit->etat == 'Hs' ? 0 : null, // quand un produit bascule en état "HS", il faut le sortir du stock
                        ])
                        ->execute();
                }

                
            }
            $this->Flash->success(__('Le produit a bien été ajouté au stock.'));
            return $this->redirect(['action' => 'detail', $data['is_event']? "stock-event" : "stock-composants"]);
        }

        $typeEquipements = $this->LotProduits->TypeEquipements->find('list', ['valueField'=>'nom','limit' => 200])->order(['nom' => 'asc']);
        $equipements = $this->LotProduits->Equipements->find('list',[
                'keyField' => 'id',
                'valueField' => 'valeur',
                'groupField' => 'type_equipement.id'
                ])
        ->contain('TypeEquipements');

        $fournisseurs = $this->LotProduits->Fournisseurs->find('list', ['valueField'=>'nom','limit' => 200])->order(['nom' => 'asc']);
        $etat_options = ['Neuf','Occasion','A réparer','Hs'];
        $filtre_user = [
            'typeProfil' => 10,
            'group_user' => 2
        ];
        
        $antennes = $this->LotProduits->Antennes->find('list')->where(['is_deleted <>' => 1])->order(['ville_principale' => 'ASC']);
        $univers = $this->LotProduits->TypeDocs->find('list');
        $user_id = $this->currentUser()->id;
        $date_stock = Chronos::now()->format('Y-m-d');
        $users = $this->LotProduits->Users->find('list')->find('filtre', $filtre_user);
        $etat_stocks = Configure::read('etat_stock');
        $this->set(compact('etat_stocks', 'lotProduit', 'typeEquipements', 'equipements', 'fournisseurs','etat_options', 'users', 'user_id', 'date_stock', 'univers', 'antennes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lot Produit id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $now = new Date(date("Y-m-d"));
        $lotProduit = $this->LotProduits->get($id, ['contain' => ['Fichiers', 'TypeDocs']]);
        $date_facture = $lotProduit->date_facture;
        $facture_file_name = $lotProduit->facture_file_name;
        $dossier = $lotProduit->dossier;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if (empty($data['date_facture'])){
                $data['date_facture'] = $date_facture;
            }
            if (!empty($data['facture_file'])) {
                
                if (!is_dir(PATH_DOCUMENTATIONS.'factures'.DS.$lotProduit->id.DS)) {
                    $dir = new Folder(PATH_DOCUMENTATIONS.'factures'.DS.$lotProduit->id.DS, true, 0755);
                }
                $newFilename_array = [];
                foreach ($data['facture_file'] as $key => $value) {
                    $extension = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));
                    $newFilename =  Text::uuid() . "." . $extension;
                    if (move_uploaded_file($value['tmp_name'], PATH_DOCUMENTATIONS.'factures'.DS.$lotProduit->id.DS. $newFilename)) {
                        $newFilename_array[] = $newFilename;
                    }
                }
                if(count($newFilename_array)){
                        $facture_file_name = implode(',', $newFilename_array);
                        $dossier = str_replace(WWW_ROOT, '', PATH_DOCUMENTATIONS);
                        $dossier = '/'.str_replace(DS, '/', $dossier).'factures/'.$lotProduit->id;
                }
            }
            
            if ($data['is_event'] == 0) {
                $data['antenne_id'] = null;
            }
            
            $lotProduit = $this->LotProduits->patchEntity($lotProduit, $data);
            if ($this->LotProduits->save($lotProduit)) {
                
                if($data['old_numero_facture'] != "" && $data['old_numero_facture'] == $data['numero_facture']){
                        $lotProduits = TableRegistry::getTableLocator()->get('LotProduits');
                        $queryProduit = $lotProduits->query();
                        $queryProduit->update()
                        ->set([
                                'facture_file_name' => $facture_file_name,
                                'date_facture' => $data['date_facture'],
                                'fournisseur_id' => $data['fournisseur_id'],
                                'dossier' => $dossier
                            ])
                        ->where(['numero_facture' => $data['numero_facture']])
                        ->execute();
                }elseif($lotProduit->lot != null){
                        $lotProduits = TableRegistry::getTableLocator()->get('LotProduits');
                        $queryProduit = $lotProduits->query();
                        $queryProduit->update()
                        ->set([
                                'numero_facture' => $data['numero_facture'],
                                'facture_file_name' => $facture_file_name,
                                'date_facture' => $data['date_facture'],
                                'fournisseur_id' => $data['fournisseur_id'],
                                'dossier' => $dossier
                            ])
                        ->where(['lot' => $lotProduit->lot])
                        ->execute();
                        
                }
                
                $serials = TableRegistry::getTableLocator()->get('NumeroSeries');
                $query = $serials->query();
                $query->update()
                    ->set([
                            'serial_nb' => $data['serial_nb'],
                            'equipement_id' => $data['equipement_id'],
                            'is_event' => $lotProduit->is_event,
                            'borne_id' => $lotProduit->etat == 'Hs' ? 0 : null, // quand un produit bascule en état "HS", il faut le sortir du stock
                    ])
                    ->where(['lot_produit_id' => $id])
                    ->execute();
                    
                $this->Flash->success(__('Le produit a été mis à jour.'));
                return $this->redirect(['action' => 'view',$id]);
            }
            
            $this->Flash->error(__('Le produit n\'a pas été modifié. Veuillez réessayer.'));
        }

        $typeEquipements = $this->LotProduits->TypeEquipements->find('list', ['valueField'=>'nom','limit' => 200])->order(['nom' => 'asc']);
        $equipements = $this->LotProduits->Equipements->find('list',[
                'keyField' => 'id',
                'valueField' => 'valeur',
                'groupField' => 'type_equipement.id'
                ])
        ->contain('TypeEquipements');

        $fournisseurs = $this->LotProduits->Fournisseurs->find('list', ['valueField'=>'nom','limit' => 200])->order(['nom' => 'asc']);
        $etat_options = ['Neuf','Occasion','A réparer','Hs'];
        $filtre_user = [
            'typeProfil' => 10,
            'group_user' => 2
        ];
        
        $antennes = $this->LotProduits->Antennes->find('list')->where(['is_deleted <>' => 1])->order(['ville_principale' => 'ASC']);
        $univers = $this->LotProduits->TypeDocs->find('list');
        $date_stock = $lotProduit->date_stock?$lotProduit->date_stock->format('Y-m-d') :Chronos::now()->format('Y-m-d');
        $users = $this->LotProduits->Users->find('list')->find('filtre', $filtre_user);
        $etat_stocks = Configure::read('etat_stock');

        $this->set(compact('etat_stocks', 'antennes', 'univers', 'lotProduit', 'typeEquipements', 'equipements', 'fournisseurs','etat_options','date_facture', 'users', 'date_stock'));
    }
       

    /**
     * Delete method
     *
     * @param string|null $id Lot Produit id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        // $this->request->allowMethod(['post', 'delete']);
        $lotProduit = $this->LotProduits->get($id);
        
        $serials = TableRegistry::getTableLocator()->get('NumeroSeries');
        $query = $serials->query();
        $query->delete()->where(['lot_produit_id' => $id])->execute();

        if ($this->LotProduits->delete($lotProduit)) {
            $this->Flash->success(__('The lot produit has been deleted.'));
        } else {
            $this->Flash->error(__('The lot produit could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
    
    
    public function multipleAction()
    {
        if ($this->request->is(['post'])) {

            $data = $this->request->getData();

            if ($data['action'] == 'type_stock' && $data['is_event'] != '') {

                $lotProduit = array_filter($data['lot_produit']);
                $lotProduit = array_keys($lotProduit);
                $this->LotProduits->updateAll(["is_event" => $data['is_event']], ["id IN" => $lotProduit]);
                $this->Flash->success(__('Les produits ont été mis à jour.'));
                
            } if ($data['action'] == 'date_stock' && $data['date_stock']) {

                $lotProduit = array_filter($data['lot_produit']);
                $lotProduit = array_keys($lotProduit);
                $this->LotProduits->updateAll(["date_stock" => $data['date_stock']], ["id IN" => $lotProduit]);
                $this->Flash->success(__('Les produits ont été mis à jour.'));
                
            } elseif ($data['action'] == 'fournisseur' && $data['fournisseur_id']) {
                
                $lotProduit = array_filter($data['lot_produit']);
                $lotProduit = array_keys($lotProduit);
                $this->LotProduits->updateAll(["fournisseur_id" => $data['fournisseur_id']], ["id IN" => $lotProduit]);
                $this->Flash->success(__('Les produits ont été mis à jour.'));
                
            } elseif ($data['action'] == 'tarif_achat' && $data['tarif_achat_ht']) {
                
                $lotProduit = array_filter($data['lot_produit']);
                $lotProduit = array_keys($lotProduit);
                $this->LotProduits->updateAll(["tarif_achat_ht" => $data['tarif_achat_ht']], ["id IN" => $lotProduit]);
                $this->Flash->success(__('Les produits ont été mis à jour.'));
                
            } elseif ($data['action'] == 'type_produit' && $data['type_equipement_id'] && $data['equipement_id']) {
                
                $lotProduit = array_filter($data['lot_produit']);
                $lotProduit = array_keys($lotProduit);
                $this->LotProduits->updateAll(["type_equipement_id" => $data['type_equipement_id'], "equipement_id" => $data['equipement_id']], ["id IN" => $lotProduit]);
                $this->Flash->success(__('Les produits ont été mis à jour.'));
            }
            
            return $this->redirect($this->referer());
        }

        return $this->redirect(['action' => 'index']);
    }
    
}
