<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Date;
use Cake\Utility\Text;
use Cake\Core\Configure;
use \Cake\Chronos\Chronos;
use App\Traits\AppTrait;
use Cake\Filesystem\File;

/**
 * Bornes Controller
 *
 * @property \App\Model\Table\BornesTable $Bornes
 *
 * @method \App\Model\Entity\Borne[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BornesController extends AppController
{
    use AppTrait;

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
        // debug($user);
        // die();
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
    public function index($parc_type = null, $export = null)
    {
        $model = $this->request->getQuery('model');
        $couleur = $this->request->getQuery('couleur');
        $parc = $this->request->getQuery('parc');
        $antenne = $this->request->getQuery('antenne');
        $key = $this->request->getQuery('key');
        $equipement = $this->request->getQuery('equipement');
        $connexion = $this->request->getQuery('connexion');
        $contrat = $this->request->getQuery('contrat');
        $gamme = $this->request->getQuery('gamme');
        $more_filter = $this->request->getQuery('more_filter');
        $is_sous_louee = $this->request->getQuery('is_sous_louee');
        $groupe_clients = $this->request->getQuery('groupe_clients');
        $user_id = $this->request->getQuery('user_id');
        
        $customFinderOptions = [
            'key' => $key,
            'user_id' => $user_id,
            'model' => $model,
            'couleur'=> $couleur,
            'parc' => $parc,
            'antenne' => $antenne,
            'equipement' => $equipement,
            'connexion' => $connexion,
            'parc_type' => $parc_type,
            'contrat' => $contrat,
            'gamme' => $gamme,
            'is_sous_louee' => $is_sous_louee,
            'groupe_clients' => $groupe_clients,
            'more_filter' => $more_filter
        ];
        
        
        $borneEntities = $this->Bornes->find('filtre', $customFinderOptions)->distinct('Bornes.id')->matching('EquipementBornes')->where(['EquipementBornes.numero_serie_id is not null'])
                ->contain(['Ventes'  => ['ParcDurees'], 'ParcDurees', 'Operateur', 'Parcs', 'Users', 'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients'=> 'GroupeClients','Couleurs','Logiciels','TypeContrats','EtatBornes']);
                
        
        if ($export == 'pdf') {
            return $this->exportPdf($borneEntities);
        }
        
        $bornes = $this->paginate($borneEntities, [
            'order' => ['sortie_atelier' => 'DESC'],
            'sortWhitelist' => ['numero', 'numero_serie', 'Parcs.nom','Clients.nom','GroupeClients.nom','Antennes.ville_principale','GammesBornes.name','ModelBornes.nom','sortie_atelier','Users.nom','Clients.ville','is_sous_louee','EtatBornes.etat_general','Couleurs.couleur','gravure'],
        ]);

//        if($this->request->getQuery('sort')) {
//            $this->paginate = [
//                'contain' => ['Ventes'  => ['ParcDurees'], 'ParcDurees', 'Parcs', 'Users', 'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients'=> 'GroupeClients','Couleurs','Logiciels','TypeContrats','EtatBornes'],
//                'finder' => ['filtre' => $customFinderOptions,],
//                'sortWhitelist' => ['numero', 'numero_serie', 'Parcs.nom','Clients.nom','GroupeClients.nom','Antennes.ville_principale','GammesBornes.name','ModelBornes.nom','sortie_atelier','Users.nom','Clients.ville','is_sous_louee','EtatBornes.etat_general','Couleurs.couleur','gravure']
//                //'order' => ['numero' => 'ASC']
//            ];
//        } else {
//            $this->paginate = [
//                'contain' => ['Ventes' => ['ParcDurees'], 'ParcDurees', 'Parcs', 'Users', 'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients'=> 'GroupeClients','Couleurs','Logiciels','TypeContrats','EtatBornes'],
//                'finder' => ['filtre' => $customFinderOptions,],
//                'sortWhitelist' => ['numero', 'numero_serie', 'Parcs.nom','Clients.nom','GroupeClients.nom','Antennes.ville_principale','GammesBornes.name','ModelBornes.nom','sortie_atelier','Users.nom','Clients.ville','is_sous_louee','EtatBornes.etat_general','Couleurs.couleur','gravure'],
//                'order' => ['numero' => 'ASC']
//            ];
//        }

//        if (in_array($parc_type, [2, 4, 9]) || $parc_type == null) {
//            $this->paginate['order'] = ['sortie_atelier' => 'DESC'];
//        }

//        $bornes = $this->paginate($this->Bornes);

        $models = [];        
        if ($gamme) {
            $models = $this->Bornes->ModelBornes->findByGammeBorneId($gamme)->find('list',['valueField'=>'nom']);
        }
        $couleurs = $this->Bornes->Couleurs->find('list',['valueField'=>'couleur']);
        $contrats = $this->Bornes->TypeContrats->find('list',['valueField'=>'name']);
        if(!empty($model)){
            /*$couleurs = $this->Bornes->CouleurPossibles->find('list',['valueField'=>'couleur'])
                                    ->where(['CouleurPossibles.model_borne_id' =>$model ]);*/
            $couleurs =  $this->Bornes->Couleurs->find('list',['valueField'=>'couleur'])
                ->matching('ModelBornes', function ($q) use($model){
                    return $q->where(['ModelBornes.id' => $model]);
                });
        }
        
        $parcEntity = null;
        if ($parc_type != null) {
                $parcEntity = $this->Bornes->Parcs->findById($parc_type)->first();
        }
        $parcs = $this->Bornes->Parcs->find('list',['valueField'=>'nom']);
        $gammeBornes = $this->Bornes->GammesBornes->find('list');
        $antennes = $this->Bornes->Antennes->find('list',['keyField'=>'ville_principale','valueField'=>'ville_principale'])->distinct(['ville_principale'])->where(['is_deleted' => '0'])->orderAsc('ville_principale');
        $equipements = $this->Bornes->Equipements->find('list',[
                                                            'keyField' => 'id',
                                                            'valueField' => 'valeur',
                                                            'groupField' => 'type_equipement.nom',
                                                            'conditions' => ['TypeEquipements.is_filtrable' => true]
                                                            ])
                                                    ->contain('TypeEquipements', function ($q) {
                                                        return $q
                                                            ->where(['TypeEquipements.is_filtrable' => true]);
                                                    });
                                                    
        $groupeClients = $this->Bornes->Clients->GroupeClients->find('list',['valueField' => 'nom']);
                                                    
        $miniDashboard = [];
        $countBorneByGamme = '';
        $allGamme = $this->Bornes->find('filtre', $customFinderOptions)
                ->select(['nombre' => 'count(Bornes.id)', 'name' => 'GammesBornes.name'])
                ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients'=>'GroupeClients','Couleurs','Logiciels'])
                ->group(['GammesBornes.name'])
                ->toArray();
        foreach ($allGamme as $game){
                $countBorneByGamme .= $game->name .' : '. $game->nombre . ' - ';
        }
        
        if($parc_type == null){
                $allGamme = $this->Bornes->GammesBornes->find()->toArray();
                $parcBorne = $this->Bornes->Parcs->find()->toArray();
                foreach ($allGamme as $valueGamme){
                    $total = 0;
                    foreach ($parcBorne as $parc){
                        $borneParc = $this->Bornes->find('filtre',['parc' => $parc->id,'gamme' => $valueGamme->id])->contain(['Parcs',  'ModelBornes' => 'GammesBornes'])->toArray();
                        if(count($borneParc)){
                            $miniDashboard[$valueGamme->name][$parc->ariane_titre] = [
                                    'value' => count($borneParc),
                                    'link' => '/bornes/index/'.$parc->id.'?gamme='.$valueGamme->id,
                            ];
                            $total += count($borneParc);
                        }
                    }
                    if($total){
                        $miniDashboard[$valueGamme->name]['total'] = $total;
                    }
                }
        }
        $customFinderOptions = array_filter($customFinderOptions);
        if(isset($customFinderOptions['parc_type'])){
            unset($customFinderOptions['parc_type']);
        }
        $filtre_user = [
            'typeProfil' => 10,
            'group_user' => 2
        ];
        
        $users = $this->Bornes->Users->find('commercial');
        $connexions = ["0"=>"Déconnecté", ""=>"Déconnecté", "1"=>"Connecté"];
        $this->set(compact('model','couleur','parc', 'parcEntity', 'antenne','is_sous_louee','key','equipement','connexion', 'parc_type','contrat','countBorneByGamme','miniDashboard','customFinderOptions'));
        $this->set(compact('gamme', 'bornes','models','couleurs','parcs','antennes','equipements','connexions','contrats', 'gammeBornes', 'more_filter','groupeClients','groupe_clients','allGamme', 'user_id', 'users'));

    }
    
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function listeMateriaux($export = null)
    {
        $model = $this->request->getQuery('model');
        $couleur = $this->request->getQuery('couleur');
        $parc = $this->request->getQuery('parc');
        $antenne = $this->request->getQuery('antenne');
        $key = $this->request->getQuery('key');
        $equipement = $this->request->getQuery('equipement');
        $connexion = $this->request->getQuery('connexion');
        $contrat = $this->request->getQuery('contrat');
        $gamme = $this->request->getQuery('gamme');
        $more_filter = $this->request->getQuery('more_filter');
        $is_sous_louee = $this->request->getQuery('is_sous_louee');
        $groupe_clients = $this->request->getQuery('groupe_clients');
        $user_id = $this->request->getQuery('user_id');
        $parc_type = $this->request->getQuery('parc_type');
        
        $customFinderOptions = [
            'key' => $key,
            'user_id' => $user_id,
            'model' => $model,
            'couleur'=> $couleur,
            'parc' => $parc,
            'antenne' => $antenne,
            'equipement' => $equipement,
            'connexion' => $connexion,
            'parc_type' => $parc_type,
            'contrat' => $contrat,
            'gamme' => $gamme,
            'is_sous_louee' => $is_sous_louee,
            'groupe_clients' => $groupe_clients,
            'more_filter' => $more_filter
        ];
        
        $borneEntities = $this->Bornes->find('filtre', $customFinderOptions)->distinct('Bornes.id')->matching('EquipementBornes')->where(['EquipementBornes.numero_serie_id is not null'])
                ->contain(['Ventes'  => ['ParcDurees'], 'ParcDurees', 'Parcs', 'Users', 'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients'=> 'GroupeClients','Couleurs','Logiciels','TypeContrats','EtatBornes',
                                    'EquipementBornes' => ['Equipements', 'TypeEquipements', 'NumeroSeries' => 'LotProduits']]);
        
        $models = [];        
        if ($gamme) {
            $models = $this->Bornes->ModelBornes->findByGammeBorneId($gamme)->find('list',['valueField'=>'nom']);
        }
        $couleurs = $this->Bornes->Couleurs->find('list',['valueField'=>'couleur']);
        $contrats = $this->Bornes->TypeContrats->find('list',['valueField'=>'name']);
        if(!empty($model)){
            
            $couleurs =  $this->Bornes->Couleurs->find('list',['valueField'=>'couleur'])
                ->matching('ModelBornes', function ($q) use($model){
                    return $q->where(['ModelBornes.id' => $model]);
                });
        }
        
        $parcEntity = null;
        if ($parc_type != null) {
                $parcEntity = $this->Bornes->Parcs->findById($parc_type)->first();
        }
        $parcs = $this->Bornes->Parcs->find('list',['valueField'=>'nom']);
        $gammeBornes = $this->Bornes->GammesBornes->find('list');
        $antennes = $this->Bornes->Antennes->find('list',['keyField'=>'ville_principale','valueField'=>'ville_principale'])->distinct(['ville_principale'])->where(['is_deleted' => '0'])->orderAsc('ville_principale');
        $equipements = $this->Bornes->Equipements->find('list',[
                                                            'keyField' => 'id',
                                                            'valueField' => 'valeur',
                                                            'groupField' => 'type_equipement.nom',
                                                            'conditions' => ['TypeEquipements.is_filtrable' => true]
                                                            ])
                                                    ->contain('TypeEquipements', function ($q) {
                                                        return $q
                                                            ->where(['TypeEquipements.is_filtrable' => true]);
                                                    });
                                                    
        $groupeClients = $this->Bornes->Clients->GroupeClients->find('list',['valueField' => 'nom']);
                                                    
        $miniDashboard = [];
        $countBorneByGamme = '';
        $allGamme = $this->Bornes->find('filtre', $customFinderOptions)
                ->select(['nombre' => 'count(Bornes.id)', 'name' => 'GammesBornes.name'])
                ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients'=>'GroupeClients','Couleurs','Logiciels'])
                ->group(['GammesBornes.name'])
                ->toArray();
        foreach ($allGamme as $game){
                $countBorneByGamme .= $game->name .' : '. $game->nombre . ' - ';
        }
        
        $customFinderOptions = array_filter($customFinderOptions);
        if(isset($customFinderOptions['parc_type'])){
            unset($customFinderOptions['parc_type']);
        }
        $filtre_user = [
            'typeProfil' => 10,
            'group_user' => 2
        ];

        if ($export == 'pdf') {
            $this->exportPdfMateriaux($borneEntities);
            return $this->response->withFile('uploads/factures_vente/Export-Materiaux.pdf', ['download' => true]);
        }
        
        $bornes = $this->paginate($borneEntities, [
                'sortWhitelist' => ['numero', 'numero_serie', 'Parcs.nom','Clients.nom','GroupeClients.nom','Antennes.ville_principale','GammesBornes.name','ModelBornes.nom','sortie_atelier','Users.nom','Clients.ville','is_sous_louee','EtatBornes.etat_general','Couleurs.couleur','gravure']
        ]);
        $users = $this->Bornes->Users->find('commercial');
        $connexions = ["0"=>"Déconnecté", ""=>"Déconnecté", "1"=>"Connecté"];
        $this->set(compact('model','couleur','parc', 'parcEntity', 'antenne','is_sous_louee','key','equipement','connexion', 'parc_type','contrat','countBorneByGamme','miniDashboard','customFinderOptions'));
        $this->set(compact('gamme', 'bornes','models','couleurs','parcs','antennes','equipements','connexions','contrats', 'gammeBornes', 'more_filter','groupeClients','groupe_clients','allGamme', 'user_id', 'users'));

    }

    
    public function exportPdf($bornes) {
        
        $this->set(compact('bornes'));            
        // RENDU FICHIER
        $viewBuilder = $this->viewBuilder()->setClassName('Dompdf.Pdf')->setLayout('pdf/dompdf.default');
        $pdfOptions = Configure::read('DevisPdf');
        $pdfOptions['config']['orientation'] = 'landscape';
        $this->response->type('pdf');
        $viewBuilder->setOptions($pdfOptions);
        $this->render('pdf/pdfversion');
                    
    }
    
    
    public function exporterEquipements($borne_id) {
        
        $borneEntity = $this->Bornes->get($borne_id, [
            'contain' => ['ParcDurees', 'Users', 'Parcs', 'Operateur', 'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients', 'ActuBornes' => 'CategorieActus', 'EtatBornes', 'Couleurs', 'NumeroSeries','TypeContrats','Licences','Equipements','Ventes'=>'Users', 'BornesAccessoires', 'Users', 
                'EquipementBornes' => ['Equipements', 'TypeEquipements', 'NumeroSeries' => 'LotProduits'] , 
                'LicencesBornes' => 'TypeLicences',
                'EquipementsProtectionsBornes' => ['Equipements', 'TypeEquipements', 'NumeroSeries' => 'LotProduits']
            ]
        ]);
        $contact = null;
        
        if($borneEntity->client_id != null) {
                $borneEntity = $this->Bornes->get($borne_id, [
                    'contain' => ['ParcDurees', 'Users', 'Parcs','Operateur', 'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients'=>['Ventes'=>'Users','GroupeClients'], 'ActuBornes' => 'CategorieActus', 'EtatBornes', 'Couleurs', 'NumeroSeries' => 'LotProduits','TypeContrats','Licences','Equipements','Ventes'=>['Users','ParcDurees'], 'BornesAccessoires', 'Users',
                        'EquipementBornes' => ['Equipements', 'TypeEquipements', 'NumeroSeries' => 'LotProduits'], 'LicencesBornes' => 'TypeLicences',
                        'EquipementsProtectionsBornes' => ['Equipements', 'TypeEquipements', 'NumeroSeries' => 'LotProduits']
                    ]
                ]);
                $this->loadModel('ClientContacts');
                $contact = $this->ClientContacts->find()->where(['ClientContacts.client_id' => $borneEntity->client_id])->toArray();
        }else if($borneEntity->antenne_id != null && $borneEntity->parc_id == 2) {
                $borneEntity = $this->Bornes->get($borne_id, [
                    'contain' => ['ParcDurees', 'Users', 'Parcs', 'Operateur', 'ModelBornes' =>'GammesBornes', 'Antennes'=>['Etats', 'Payss','SecteurGeographiques','LieuTypes'], 'Clients', 'ActuBornes'  => 'CategorieActus', 'EtatBornes', 'Couleurs', 'NumeroSeries' => 'LotProduits','TypeContrats','Licences','Equipements','Ventes'=>['Users','ParcDurees'], 'BornesAccessoires', 'Users',
                        'EquipementBornes' => ['Equipements', 'TypeEquipements', 'NumeroSeries' => 'LotProduits'], 'LicencesBornes' => 'TypeLicences', 
                        'EquipementsProtectionsBornes' => ['Equipements', 'TypeEquipements', 'NumeroSeries' => 'LotProduits']
                    ]
                ]);
        }
        
        $now = Chronos::now()->format('d/m/y');
                    
        $totalComposant = collection($borneEntity->equipement_bornes)->sumOf('numero_series.lot_produit.tarif_achat_ht');   
        $totalProtection = collection($borneEntity->equipements_protections_bornes)->sumOf('numero_series.lot_produit.tarif_achat_ht');   
        $this->set(compact('borneEntity' , 'totalComposant', 'now', 'totalProtection'));
        
        // RENDU FICHIER
        $viewBuilder = $this->viewBuilder()->setClassName('Dompdf.Pdf')->setLayout('pdf/dompdf.default');
        $pdfOptions = Configure::read('DevisPdf');
        $this->response->type('pdf');
        $viewBuilder->setOptions($pdfOptions);
        $this->render('pdf/export_equipements_borne');
            
    }
    
    
    /**
     * map view
     *
     */

    public function map($parc_type = null)
    {
        $model = $this->request->getQuery('model');
        $couleur = $this->request->getQuery('couleur');
        $parc = $this->request->getQuery('parc');
        $antenne = $this->request->getQuery('antenne');
        $key = $this->request->getQuery('key');
        $equipement = $this->request->getQuery('equipement');
        $connexion = $this->request->getQuery('connexion');
        $contrat = $this->request->getQuery('contrat');
        $gamme = $this->request->getQuery('gamme');
        $more_filter = $this->request->getQuery('more_filter');
        $is_sous_louee = $this->request->getQuery('is_sous_louee');
        $groupe_clients = $this->request->getQuery('groupe_clients');
        // debug($equipement);exit;
        $customFinderOptions = [
            'key' => $key,
            'model' => $model,
            'couleur'=> $couleur,
            'parc' => $parc,
            'antenne' => $antenne,
            'equipement' => $equipement,
            'connexion' => $connexion,
            'parc_type' => $parc_type,
            'contrat' => $contrat,
            'gamme' => $gamme,
            'is_sous_louee' => $is_sous_louee,
            'groupe_clients' => $groupe_clients,
            'more_filter' => $more_filter
        ];

        $bornes = $this->Bornes->find('filtre', $customFinderOptions)->where(['parc_id <>' => 2])
            ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients'=>'GroupeClients','Couleurs','Logiciels'])
            ->toArray();
        $borne_antennes = [];
        if($parc_type == 2 || $parc_type == null){
                $customFinder = $customFinderOptions;
                $customFinder['parc_type'] = 2;
                $borne_antennes = $this->Bornes->Antennes->find('all')
                        ->where(['Antennes.is_deleted'=>0])
                        ->contain(['Bornes' => ['Parcs',  'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients'=>'GroupeClients','Couleurs','Logiciels']])
                        ->contain('Bornes',function ($q) use ($customFinder) {
                            return $q->find('filtre', $customFinder);
                        })
                        ->toArray();
        }
        
        $models = [];        
        if ($gamme) {
                $models = $this->Bornes->ModelBornes->findByGammeBorneId($gamme)->find('list',['valueField'=>'nom']);
        }
        $couleurs = $this->Bornes->Couleurs->find('list',['valueField'=>'couleur']);
        $contrats = $this->Bornes->TypeContrats->find('list',['valueField'=>'name']);

        $parcs = $this->Bornes->Parcs->find('list',['valueField'=>'nom']);
        $gammeBornes = $this->Bornes->GammesBornes->find('list');
        $parcEntity = $this->Bornes->Parcs->findById($parc_type)->first();
        $antennes = $this->Bornes->Antennes->find('list',['keyField'=>'ville_principale','valueField'=>'ville_principale'])->distinct(['ville_principale'])->where(['is_deleted' => '0'])->orderAsc('ville_principale');
        $equipements = $this->Bornes->Equipements->find('list',[
                                                            'keyField' => 'id',
                                                            'valueField' => 'valeur',
                                                            'groupField' => 'type_equipement.nom',
                                                            'conditions' => ['TypeEquipements.is_filtrable' => true]
                                                            ])
                                                    //->contain(['TypeEquipements'])
                                                    ->contain('TypeEquipements', function ($q) {
                                                        return $q
                                                            ->where(['TypeEquipements.is_filtrable' => true]);
                                                    });
                                                
        $groupeClients = $this->Bornes->Clients->GroupeClients->find('list',['valueField' => 'nom']);
                                                       
        $miniDashboard = [];
        $countBorneByGamme = '';
        $totalBorne = 0;
        $allGamme = $this->Bornes->find('filtre', $customFinderOptions)
                ->select(['nombre' => 'count(Bornes.id)', 'name' => 'GammesBornes.name'])
                ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients'=>'GroupeClients','Couleurs','Logiciels'])
                ->group(['GammesBornes.name'])
                ->toArray();
        foreach ($allGamme as $game){
                $countBorneByGamme .= $game->name .' : '. $game->nombre . ' - ';
                $totalBorne += $game->nombre;
        }
        
        if($parc_type == null){
                $allGamme = $this->Bornes->GammesBornes->find()->toArray();
                $parcBorne = $this->Bornes->Parcs->find()->toArray();
                foreach ($allGamme as $valueGamme){
                    $total = 0;
                    foreach ($parcBorne as $parc){
                        $borneParc = $this->Bornes->find('filtre',['parc' => $parc->id,'gamme' => $valueGamme->id])->contain(['Parcs',  'ModelBornes' => 'GammesBornes'])->toArray();
                        if(count($borneParc)){
                            $miniDashboard[$valueGamme->name][$parc->ariane_titre] = [
                                    'value' => count($borneParc),
                                    'link' => '/bornes/index/'.$parc->id.'?gamme='.$valueGamme->id,
                            ];
                            $total += count($borneParc);
                        }
                    }
                    if($total){
                        $miniDashboard[$valueGamme->name]['total'] = $total;
                    }
                }
        }
        $customFinderOptions = array_filter($customFinderOptions);
        if(isset($customFinderOptions['parc_type'])){
            unset($customFinderOptions['parc_type']);
        }
        $connexions = ["0"=>"Déconnecté", ""=>"Déconnecté", "1"=>"Connecté"];
        $this->set(compact('model','couleur','parc', 'parcEntity', 'antenne','is_sous_louee','key','equipement','connexion', 'parc_type','contrat','countBorneByGamme','miniDashboard','borne_antennes','customFinderOptions'));
        $this->set(compact('gamme', 'bornes','models','couleurs','parcs','antennes','equipements','connexions','contrats', 'gammeBornes', 'more_filter','groupeClients','groupe_clients','allGamme','totalBorne'));
    }

    /**
     * mapfullscreen view
     *
     */
    public function mapfullscreen()
    {        

        $bornesClassik = $this->Bornes->find('all')->where(['is_sous_louee' => 1,'ModelBornes.gamme_borne_id' => 2, 'OR' => ['Bornes.not_in_cart is null', 'Bornes.not_in_cart' => 0]])
            ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Clients', 'Antennes'])
            ->toArray();

        $bornesSpherik = $this->Bornes->find('all')->where(['is_sous_louee' => 1,'ModelBornes.gamme_borne_id' => 3, 'OR' => ['Bornes.not_in_cart is null', 'Bornes.not_in_cart' => 0]])
            ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Clients', 'Antennes'])
            ->toArray();

//        $bornes = $this->Bornes->find('all')->where(['is_sous_louee' => 1])
//            ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Clients', 'Antennes'])
//            ->toArray();
        $antennes = $this->Bornes->Antennes->find('all')
                ->where(['Antennes.is_deleted'=>0])
                ->contain(['Bornes' => ['Parcs',  'ModelBornes' => 'GammesBornes']])
                ->contain(['Bornes' => function  ($q) {return $q->where(['OR' => ['Bornes.not_in_cart is null', 'Bornes.not_in_cart' => 0]]);}])
                ->toArray();
        
        $key = $this->request->getQuery('key');
        $is_agence = $this->request->getQuery('is_agence');
        $sous_loc_classik = $this->request->getQuery('sous_loc_classik');
        $sous_loc_spherik = $this->request->getQuery('sous_loc_spherik');
        $gammeBornes = $this->Bornes->GammesBornes->find('list');
        
        if($key || $is_agence || $sous_loc_classik || $sous_loc_spherik){

                if($key){

                        $bornes = $this->Bornes->find('all')->where(
                                [
                                    'Bornes.not_in_cart <>' => 1,
                                    'OR' => ['is_sous_louee' => 1, 'parc_id' => 2],
                                    ['OR' => [
                                        ['CAST(numero as CHAR) LIKE' => '%'.$key.'%'],
                                        ['Clients.nom LIKE' => '%'.$key.'%'],
                                        ['Clients.prenom LIKE' => '%'.$key.'%']
                                    ]]
                                ])
                            ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Clients', 'Antennes'])
                            ->toArray();
                }else{

                        $bornes = [];
                        $antennes = [];

                        if($is_agence){
                                $antennes = $this->Bornes->Antennes->find('all')->where(['Antennes.is_deleted'=>0])->contain(['Bornes' => ['ModelBornes']])->toArray();
                        }
                        if($sous_loc_classik) {
                                $bornesClassik = $this->Bornes->find('all')->where(['is_sous_louee' => 1,'ModelBornes.gamme_borne_id' => 2, 'Bornes.not_in_cart <>' => 1])
                                    ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Clients', 'Antennes'])
                                    ->toArray();
                                $bornes = array_merge($bornes,$bornesClassik);
                        }
                        if($sous_loc_spherik) {
                                $bornesSpherik = $this->Bornes->find('all')->where(['is_sous_louee' => 1,'ModelBornes.gamme_borne_id' => 3, 'Bornes.not_in_cart <>' => 1])
                                    ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Clients', 'Antennes'])
                                    ->toArray();
                                $bornes = array_merge($bornes,$bornesSpherik);
                        }
                }
        }
        $this->set(compact('bornesClassik','bornesSpherik','antennes','gammeBornes'));
    }

    public function refreshList(){
        $this->viewBuilder()->setLayout('ajax');
        
        $key = $this->request->getQuery('key');
        $is_agence = $this->request->getQuery('is_agence');
        $sous_loc_classik = $this->request->getQuery('sous_loc_classik');
        $sous_loc_spherik = $this->request->getQuery('sous_loc_spherik');
        
        if($key){

                $bornes = $this->Bornes->find('all')->where(
                        [
                            'OR' => ['is_sous_louee' => 1, 'parc_id' => 2],
                            ['OR' => [
                                ['CAST(numero as CHAR) LIKE' => '%'.$key.'%'],
                                ['Clients.nom LIKE' => '%'.$key.'%'],
                                ['Clients.prenom LIKE' => '%'.$key.'%']
                            ]]
                        ])
                    ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Clients', 'Antennes'])
                    ->toArray();
                $antennes = $this->Bornes->Antennes->find('all')
                ->where(['Antennes.is_deleted'=>0])
                ->contain(['Bornes' => ['Parcs',  'ModelBornes' => 'GammesBornes', 'Antennes', 'Clients'=>'GroupeClients','Couleurs','Logiciels']])
                ->contain('Bornes',function ($q) use ($key) {
                    return $q->find('filtre', ['key' => $key,'parc_id' => 2]);
                })
                ->toArray();
        }else{

                $bornes = [];
                $antennes = [];

                if($is_agence){
                        $antennes = $this->Bornes->Antennes->find('all')->where(['Antennes.is_deleted'=>0])->contain(['Bornes' => ['ModelBornes']])->toArray();
                }
                if($sous_loc_classik) {
                        $bornesClassik = $this->Bornes->find('all')->where(['is_sous_louee' => 1,'ModelBornes.gamme_borne_id' => 2])
                            ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Clients', 'Antennes'])
                            ->toArray();
                        $bornes = array_merge($bornes,$bornesClassik);
                }
                if($sous_loc_spherik) {
                        $bornesSpherik = $this->Bornes->find('all')->where(['is_sous_louee' => 1,'ModelBornes.gamme_borne_id' => 3])
                            ->contain(['Parcs',  'ModelBornes' => 'GammesBornes', 'Clients', 'Antennes'])
                            ->toArray();
                        $bornes = array_merge($bornes,$bornesSpherik);
                }
        }
        
        $this->set(compact('bornes','antennes','gammeBornes'));
    }

    /**
     * View method
     *
     * @param string|null $id Borne id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if($this->request->is(['patch', 'post', 'put'])){
                $data = $this->request->getData();
                $borneEntity = TableRegistry::getTableLocator()->get('Bornes');
                $query = $borneEntity->query();
                $query->update()
                ->set([
                    'antenne_id' => $data['antenne_id']
                ])
                ->where(['id' => $id])
                ->execute();
                $this->Flash->success(__('Enregistrement réussi.'));
                return $this->redirect(['action' => 'view', $id]);
        }
        
        $borneEntity = $this->Bornes->get($id, [
            'contain' => ['ParcDurees', 'Users', 'Parcs', 'ModelBornes' => 'GammesBornes', 
                'EquipementsProtectionsBornes' => ['Equipements', 'TypeEquipements' => 'Equipements', 'NumeroSeries' => 'LotProduits'],
                'Antennes', 'Clients' => 'GroupeClients', 'ActuBornes' => 'CategorieActus', 'EtatBornes', 'Couleurs',
                'NumeroSeries','TypeContrats','Licences','Equipements','Ventes'=>'Users', 'BornesAccessoires', 'Users', 
                'EquipementBornes' => ['Equipements', 'TypeEquipements', 'NumeroSeries' => 'LotProduits'] , 
                'LicencesBornes' => 'TypeLicences'
            ]
        ]);

        $contact = null;
        
        if($borneEntity->client_id != null) {
                $borneEntity = $this->Bornes->get($id, [
                    'contain' => ['ParcDurees', 'Users', 'Parcs', 'ModelBornes' => 'GammesBornes', 'Antennes', 'EquipementsProtectionsBornes' => ['Equipements', 'TypeEquipements' => 'Equipements', 'NumeroSeries' => 'LotProduits'], 'Clients'=>['Ventes'=>'Users','GroupeClients'], 'ActuBornes' => 'CategorieActus', 'EtatBornes', 'Couleurs', 'NumeroSeries' => 'LotProduits','TypeContrats','Licences','Equipements','Ventes'=>['Users','ParcDurees'], 'BornesAccessoires', 'Users',
                        'EquipementBornes' => ['Equipements', 'TypeEquipements', 'NumeroSeries' => 'LotProduits'], 'LicencesBornes' => 'TypeLicences']
                ]);
                $this->loadModel('ClientContacts');
                $contact = $this->ClientContacts->find()->where(['ClientContacts.client_id' => $borneEntity->client_id])->toArray();
        }else if($borneEntity->antenne_id != null && $borneEntity->parc_id == 2) {
                $borneEntity = $this->Bornes->get($id, [
                    'contain' => ['ParcDurees', 'Users', 'Parcs', 'ModelBornes' =>'GammesBornes', 'EquipementsProtectionsBornes' => ['Equipements', 'TypeEquipements' => 'Equipements', 'NumeroSeries' => 'LotProduits'], 'Antennes'=>['Etats', 'Payss','SecteurGeographiques','LieuTypes'], 'Clients' => 'GroupeClients', 'ActuBornes'  => 'CategorieActus', 'EtatBornes', 'Couleurs', 'NumeroSeries' => 'LotProduits','TypeContrats','Licences','Equipements','Ventes'=>['Users','ParcDurees'], 'BornesAccessoires', 'Users',
                        'EquipementBornes' => ['Equipements', 'TypeEquipements', 'NumeroSeries' => 'LotProduits'], 'LicencesBornes' => 'TypeLicences']
                ]);
        }

        $evenements = $this->Bornes->Antennes->Evenements->find('all')
        ->where(['antenne_id = '=> $borneEntity->antenne_id])->order(['id' => 'DESC'])->limit(5);

        $etat_bornes = $this->Bornes->EtatBornes->find('list',['valueField'=>'etat_general']);
        
        $borneEntity->numero_series = $this->Bornes->NumeroSeries->find()
                ->where(['NumeroSeries.borne_id' => $borneEntity->id])
                ->contain(['Equipements' => ['TypeEquipements','MarqueEquipements']])
                ->toArray();
        
        $antennes = $this->Bornes->Antennes->find('list', ['valueField' => 'ville_principale'])->where(['is_deleted' => '0'])->orderAsc('ville_principale');
        $categorietickets = $this->Bornes->ActuBornes->CategorieActus->find('list');
        $actuBorne = $this->Bornes->ActuBornes->newEntity();
        $this->loadModel('Accessoires');
        $sousAccessoires = $this->Accessoires->SousAccessoires->find()->indexBy('id')->toArray();
        $commercials = $this->Bornes->Users->find('commercial');
        $parc_durees = $this->Bornes->Parcs->ParcDurees->findByParcId($borneEntity->parc_id)->find('list', ['valueField' => 'valeur']);
        $garantie_durees = Configure::read('garantie_durees');
        $genres = Configure::read('genres'); 
        $type_commercials = Configure::read('type_commercials');
        $connaissance_selfizee = Configure::read('connaissance_selfizee');
        $filtres_contrats = Configure::read('filtres_contrats');

        $this->loadModel('VillesCodePostals');
        $villesCodePostals = $this->VillesCodePostals->find('list')->group('ville_cp_fk_code_postal');
        $groupeClients = $this->Bornes->Clients->GroupeClients->find('list')->order(['nom' => 'asc']);
        $secteursActivites = $this->Bornes->Clients->SecteursActivites->find('list')->order(['name' => 'asc']);
        if (!$borneEntity->is_contrat_modified && count($borneEntity->ventes)) {
            $vente = $borneEntity->ventes[0];
            $borneEntity->parc_duree_id = $vente->parc_duree?$vente->parc_duree->id:0;
            $borneEntity->contrat_debut = $vente->contrat_debut;
            $borneEntity->user_id = $vente->user->id;
        }
        $clientEntity = $this->Bornes->Clients->findById($borneEntity->client_id)->first();
        $payss = $this->Bornes->Clients->Payss->find('listAsc');
        $isVilleClientInVilleFrances = false;
        $totalMontantAchat = collection($borneEntity->equipement_bornes)->sumOf('numero_series.lot_produit.tarif_achat_ht') + collection($borneEntity->equipements_protections_bornes)->sumOf('numero_series.lot_produit.tarif_achat_ht');   
        
        if ($clientEntity) {
            $isVilleClientInVilleFrances = (bool) $this->VillesCodePostals->VillesFrances->find()->where(['ville_code_postal LIKE' => "%$clientEntity->cp%", 'ville_nom' => $clientEntity->ville])->count();        
        }
        $villesFrances = [];
        if ($clientEntity && $clientEntity->cp) {
            $villesFrances = $this->VillesCodePostals->VillesFrances->find()->where(['ville_code_postal LIKE' => "%$clientEntity->cp%"])->find('list', [
                'keyField' => 'ville_nom',
                'valueField' => 'ville_nom'
            ]);
        }
        
        $this->set(compact('filtres_contrats', 'genres', 'type_commercials','connaissance_selfizee','villesCodePostals','groupeClients','secteursActivites', 'clientEntity', 'payss', 'isVilleClientInVilleFrances', 'villesFrances'));
        $this->set(compact('totalMontantAchat', 'borneEntity','evenements','etat_bornes','contact','antennes','categorietickets', 'actuBorne', 'sousAccessoires', 'commercials', 'parc_durees', 'garantie_durees'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $borne = $this->Bornes->newEntity();
        $onlineStates = ['Online'=>1, 'Offline'=>0];

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            if(isset($data['equipement_bornes']) && count($data['equipement_bornes'])) {
                foreach ($data['equipement_bornes'] as $key => $equipement_bornes) {
                    if($equipement_bornes['equipement_id'] == null || $equipement_bornes['type_equipement_id'] == null) {
                        unset($data['equipement_bornes'][$key]);
                    }
                }
            }
            if(in_array($data['parc_id'],[1,4,9])){
                $data['antenne_id'] = null;
            }elseif($data['parc_id'] == 2){
                $data['client_id'] = null;
            }else{
                $data['client_id'] = null;
                $data['antenne_id'] = null;
            }
            
            if($data['is_sous_louee']){
                $data['antenne_id'] = $data['antenne_loc'];
            }
             //debug($data);die;
            

            // on réinitialise les types de client en checkbox sur sa fiche (ie idem que types parcs) qu'on crée la vente borne
            $client_id = $data['client_id'];
            $clientEntity = $this->Bornes->Clients->findById($client_id)->first();
            if ($clientEntity) {

                $dataClient = $this->setParcTypeOnClient($data);
                $data['client']['id'] = $client_id;
                $data['client'] = array_merge($data['client'], $dataClient);
            }

            $borne = $this->Bornes->patchEntity($borne, $data);

            if ($this->Bornes->save($borne)) {


                if(isset($data['equipement_bornes']) && count($data['equipement_bornes'])) {
                    foreach ($data['equipement_bornes'] as $key => $equipement_bornes) {
                        if($equipement_bornes['numero_serie_id'] != null) {
                            $this->updateNumSerie($equipement_bornes['numero_serie_id'],$borne->id);
                        }
                    }
                }
                
                if(!empty($data['autre_materiels']['_ids'])){
                    foreach ($data['autre_materiels']['_ids'] as $value) {
                        $this->updateNumSerie($value,$borne->id);
                    }
                }
                
                $this->Flash->success(__('La borne a été ajoutée avec succé.'));
                return $this->redirect(['action' => 'index', $borne->parc_id]);
            }
            $this->Flash->error(__('The borne could not be saved. Please, try again.' . json_encode($borne->getErrors())));
        }
        
        $contrats = $this->Bornes->TypeContrats->find('list', ['valueField' => 'name']);

        $modelBornes = $this->Bornes->ModelBornes->find('list', [
                'keyField' => 'id',
                'valueField' => function ($e) {
                    return $e->nom . '-' . $e->version;
                },
                'groupField' => 'gamme_borne_id',
        ]);
            
        $logiciels = $this->Bornes->Logiciels->find('list', ['valueField' => 'nom']);
        $antennes = $this->Bornes->Antennes->find('list', ['valueField' => 'ville_principale'])->where(['is_deleted' => '0'])->orderAsc('ville_principale');;
        $clients = $this->Bornes->Clients->find('list', ['valueField' => 'nom']);
        $groupeClients = $this->Bornes->Clients->GroupeClients->find('list', ['valueField' => 'nom']);
        $couleurPossible =  $this->Bornes->Couleurs->find('list',['valueField'=>'couleur']);
        $equipements = $this->Bornes->Equipements->find('list',['valueField'=>'valeur']);
        $etat_bornes = $this->Bornes->EtatBornes->find('list',['valueField'=>'etat_general']);
        $filtre_user = [
            'typeProfil' => 10,
            'group_user' => 2
        ];
        $users = $this->Bornes->Users->find('list')->find('filtre', $filtre_user);

        $gammeBornes = $this->Bornes->GammesBornes->find('list');
        $statuts = array('Dispo', 'SAV', 'HS');
        $marques = array('Selfizee', 'Marque blanche');
        $parcs = $this->Bornes->Parcs->find('list',['keyField' => 'id','valueField'=>'nom']);

        $typeLicences = $this->Bornes->Licences->TypeLicences->find('all');
        
        $numeroSeriesLicences = $this->Bornes->Licences->find('list',[
            'keyField' => 'id',
            'valueField'=> 'numero_serie',
            'groupField' => 'type_licence_id',
            'conditions' => ['dispo' => 1]
        ])->toArray();
        
        $equipements = $this->Bornes->Equipements->find('list',[
            'keyField' => 'id',
            'valueField'=>'valeur',
            'groupField' => 'type_equipement_id'
        ])->toArray();
        
        $numeroSeriesEquip = $this->Bornes->NumeroSeries->find('list',[
            'keyField' => 'id',
            'valueField'=>'serial_nb',
            'groupField' => ['equipement.id'],
            'conditions' => ['NumeroSeries.borne_id is' => NULL, 'is_event <>' => 1]
            ])
        ->contain(['Equipements'])->toArray();
        $typeEquipementsProtections = $this->Bornes->Equipements->TypeEquipements->findByIsProtection(1)->contain(['Equipements']);

        
        $this->set(compact('typeEquipementsProtections', 'typeLicences', 'users', 'numeroSeriesLicences', 'equipements', 'numeroSeriesEquip', 'borne', 'parcs', 'gammeBornes', 'modelBornes', 'antennes', 'clients','logiciels', 'couleurPossible', 'equipements', 'etat_bornes', 'contrats', 'statuts', 'marques','groupeClients'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Borne id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $borne = $this->Bornes->get($id, [
            'contain' => ['ParcDurees', 'Users', 'Logiciels','Antennes','Clients','Parcs', 'EquipementsProtectionsBornes' => ['Equipements', 'TypeEquipements' => 'Equipements'], 'LicencesBornes', 'Couleurs','ActuBornes','EquipementBornes', 'Equipements','TypeContrats','NumeroSeries','ModelBornes' => 'GammesBornes' , 'BornesAccessoires','Ventes' => ['Users','ParcDurees']]
        ]);

        // debug($borne);
        // die();
        
        $teamviewer_remotecontrol_id_old = $borne->teamviewer_remotecontrol_id;
        $teamviewer_device_id_old = $borne->teamviewer_device_id;
        $teamviewer_password_old = $borne->teamviewer_password;
        $teamviewer_group_id_old = $borne->teamviewer_group_id;
        $teamviewer_alias_old = $borne->teamviewer_alias;
        $teamviewer_online_state_old = $borne->teamviewer_online_state;
        
        $onlineStates = ['Online'=>1, 'Offline'=>0];
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $now = new Date(date("Y-m-d"));
            $user_id = $this->Auth->user('id');
            if(empty($data['etat_borne_id'])){
                $data['etat_borne_id'] = 0;
            }
            
            if(in_array($data['parc_id'],[1,4,9])){
                $data['antenne_id'] = null;
            }elseif($data['parc_id'] == 2){
                $data['client_id'] = null;
            }
            
            $this->loadModel('LotProduits');
            $this->loadModel('NumeroSeries');
            
            
            // add dans la stock
            if(isset($data['equipement_bornes']) && count($data['equipement_bornes'])) {
                foreach ($data['equipement_bornes'] as $key => $equipement_bornes) {
                    
                    if($equipement_bornes['aucun']){
                        $data['equipement_bornes'][$key]['numero_serie_id'] = null;
                        $data['equipement_bornes'][$key]['equipement_id'] = null;
                    }else{
                        $data['equipement_bornes'][$key]['precisions'] = null;
                    }

                    if($equipement_bornes['new_stock'] && $equipement_bornes['new_numero_series']){
                        $numeroSerie = $this->Bornes->NumeroSeries->find()->where(['NumeroSeries.serial_nb LIKE'=> trim($equipement_bornes['new_numero_series'])])->first();

                        if($numeroSerie){
                            $data['equipement_bornes'][$key]['numero_serie_id'] = $numeroSerie->id;
                        }else {
                            $dataLotProduit = [
                                'type_equipement_id' => $equipement_bornes['type_equipement_id'],
                                'equipement_id' => $equipement_bornes['equipement_id'],
                                'fournisseur_id' => $equipement_bornes['fournisseur'],
                                'serial_nb' => $equipement_bornes['new_numero_series'],
                                'date_stock' => $now,
                                'quantite' => 1,
                                'user_id' => $user_id,
                                'lot' => Text::uuid()
                            ];
                            $newProduit = $this->LotProduits->newEntity();
                            $newProduit = $this->LotProduits->patchEntity($newProduit,$dataLotProduit, ['validate' => false]);
                            $lotProduit = $this->LotProduits->save($newProduit);

                            $dataNumeroSerieBornier = [
                                'equipement_id' => $equipement_bornes['equipement_id'],
                                'serial_nb' => $equipement_bornes['new_numero_series'],
                                'borne_id' => $id,
                                'lot_produit_id' => $lotProduit?$lotProduit->id:null
                            ];
                            $newNumeroSerieBornier = $this->NumeroSeries->newEntity();
                            $newNumeroSerieBornier = $this->NumeroSeries->patchEntity($newNumeroSerieBornier, $dataNumeroSerieBornier, ['validate' => false]);
                            $numeroSerieBornier = $this->NumeroSeries->save($newNumeroSerieBornier);
                            $data['equipement_bornes'][$key]['numero_serie_id'] = $numeroSerieBornier?$numeroSerieBornier->id:null;
                        }
                    }
                }
            }
            
            if($data['couleur_id'] == null){
                $data['couleur_id'] = 0;
            }
            
            if($data['is_sous_louee']){
                $data['antenne_id'] = $data['antenne_loc'];
            }

            // on réinitialise les types de client en checkbox sur sa fiche (ie idem que types parcs) qu'on crée la vente borne
            $client_id = $data['client_id'];
            $clientEntity = $this->Bornes->Clients->findById($client_id)->first();
            if ($clientEntity) {
                
                $dataClient = $this->setParcTypeOnClient($data);
                $data['client']['id'] = $client_id;
                $data['client'] = array_merge($data['client'], $dataClient);
            }
            
            $data['teamviewer_remotecontrol_id'] = "r".$data['teamviewer_remotecontrol_id'];
            $borne = $this->Bornes->patchEntity($borne, $data);
            // debug($data);
            // debug($borne);
            // die();
            if ($this->Bornes->save($borne)) {
                
                if(isset($data['equipement_bornes']) && count($data['equipement_bornes'])) {
                    foreach ($data['equipement_bornes'] as $key => $equipement_bornes) {
                        if($equipement_bornes['old_numero_serie_id'] != null) {
                            $this->updateNumSerie($equipement_bornes['old_numero_serie_id']);
                        }
                        if($equipement_bornes['numero_serie_id'] != null) {
                            $this->updateNumSerie($equipement_bornes['numero_serie_id'],$borne->id);
                        }
                    }
                }

                if(!empty($data['autre_materiels']['_ids'])){
                    foreach ($data['autre_materiels']['_ids'] as $value) {
                        $this->updateNumSerie($value,$borne->id);
                    }
                }
                
                $info_teamviewer = "";
                    if($teamviewer_remotecontrol_id_old != $data['teamviewer_remotecontrol_id']) {
                        $teamviewer_id = $data['teamviewer_remotecontrol_id'];
                        $teamviewer_pwd = $data['teamviewer_password'];
                        $teamviewer_alias = $data['teamviewer_alias'];
                        $this->loadComponent('TeamviewerAPI');
                        $result = $this->TeamviewerAPI->addDevice($teamviewer_id, $teamviewer_pwd, $teamviewer_alias);
                        if(!$result && gettype($result) == "array" && array_key_exists("error", $result)){
                            $info_teamviewer = $result['error_description'];
                            //=== Revert
                            $borne->teamviewer_remotecontrol_id = $teamviewer_remotecontrol_id_old;
                            $borne->teamviewer_password = $teamviewer_password_old;
                            $borne->teamviewer_alias = $teamviewer_alias_old;
                            $borne->teamviewer_device_id = $teamviewer_device_id_old;
                            $borne->teamviewer_group_id = $teamviewer_group_id_old;
                            $borne->teamviewer_online_state = $teamviewer_online_state_old;
                            $this->Bornes->save($borne);
                         }else {
                            $borne->teamviewer_remotecontrol_id = !empty($result['remotecontrol_id'])? "r".$result['remotecontrol_id'] : null;
                            $borne->teamviewer_password = $teamviewer_pwd;
                            $borne->teamviewer_alias = !empty($result['alias'])? $result['alias'] : null;
                            $borne->teamviewer_device_id = !empty($result['device_id'])? "d".$result['device_id'] : null;
                            $borne->teamviewer_group_id = !empty($result['groupid'])? "g".$result['groupid'] : null;
                            $borne->teamviewer_online_state = !empty($result['online_state'])?$onlineStates[$result['online_state']]:null;
                            if($this->Bornes->save($borne)) {
                                $info_teamviewer = "Infos Teamviewer saved";
                            }
                        }
                    } else { //!empty($borne->teamviewer_device_id))
                        $teamviewer_remotecontrol_id = "r".$data['teamviewer_remotecontrol_id'];
                        $teamviewer_pwd = $data['teamviewer_password'];
                        $teamviewer_alias = $data['teamviewer_alias'];
                        //debug($borne->teamviewer_device_id);die;
                        if(($teamviewer_pwd != $teamviewer_password_old) || ($teamviewer_alias != $teamviewer_alias_old)) {
                            $this->loadComponent('TeamviewerAPI');
                            $result = $this->TeamviewerAPI->updateDevice($borne->teamviewer_device_id, $teamviewer_pwd, $teamviewer_alias);
                            //debug($result); die;
                            if ($result == null) { // OK
                                $info_teamviewer = "Infos Teamviewer saved.";
                            } else if ($result != null && gettype($result) == "array" && array_key_exists("error", $result)) {
                                if(isset($result['error_description'])) {
                                    $info_teamviewer = $result['error_description'];
                                } else  if(isset($result['error'])) {
                                    $info_teamviewer = "Infos Teamviewer not saved (Internal error).";
                                }

                                //debug($result['error_description']);die;
                                //=== Revert
                                $borne->teamviewer_remotecontrol_id = $teamviewer_remotecontrol_id_old;
                                $borne->teamviewer_password = $teamviewer_password_old;
                                $borne->teamviewer_alias = $teamviewer_alias_old;
                                $borne->teamviewer_device_id = $teamviewer_device_id_old;
                                $borne->teamviewer_group_id = $teamviewer_group_id_old;
                                $borne->teamviewer_online_state = $teamviewer_online_state_old;
                                $this->Bornes->save($borne);
                            }
                        }
                    }
                $this->Flash->success(__('The borne has been saved. '.$info_teamviewer));

                return $this->redirect(['action' => 'view', $borne->id]);
            }
            $this->Flash->error(__('The borne could not be saved. Please, try again.' . $borne->getErrors()));
        }
        
        $contrats = $this->Bornes->TypeContrats->find('list', ['valueField' => 'name']);
		
        $gammeBornes = $this->Bornes->ModelBornes->GammesBornes->find('list')->toArray();
        $modelBornes = $this->Bornes->ModelBornes->find('list', [
            'keyField' => 'id',
            'valueField' => function ($e) {
                return $e->nom . '-' . $e->version;
            },
            'groupField' => 'gamme_borne_id',
        ]);
        $logiciels = $this->Bornes->Logiciels->find('list', ['valueField' => 'nom']);
        $antennes = $this->Bornes->Antennes->find('list', ['valueField' => 'ville_principale'])->where(['is_deleted' => '0'])->orderAsc('ville_principale');;
        $clients = $this->Bornes->Clients->find('NomEnseigne')->where(['id' => $borne->client_id])->toArray();
        $couleurPossible =  $this->Bornes->Couleurs->find('list',['valueField'=>'couleur']);
        $etat_bornes = $this->Bornes->EtatBornes->find('list',['valueField'=>'etat_general']);

        $statuts = array('Dispo', 'SAV', 'HS');
        $marques = array('Selfizee', 'Marque blanche');
        $parcs = $this->Bornes->Parcs->find('list',['keyField' => 'id','valueField'=>'nom']);
        $filtre_user = [
            'typeProfil' => 10,
            'group_user' => 2
        ];
        $users = $this->Bornes->Users->find('list')->find('filtre', $filtre_user);
        
        $typeLicences = $this->Bornes->Licences->TypeLicences->find('all');
        
        $numeroSeriesLicences = $this->Bornes->Licences->find('list',[
            'keyField' => 'id',
            'valueField'=> 'numero_serie',
            'groupField' => 'type_licence_id',
            'conditions' => ['OR' => ['dispo' => 1, 'BornesLicences.borne_id' => $id]]
        ])
        ->contain(['BornesLicences'])->toArray();
        
        $this->loadModel('Fournisseurs');
        $fournisseur = $this->Fournisseurs->find('list',[
            'keyField' => 'id',
            'valueField'=> 'nom',]
        );
        
        $equipements = $this->Bornes->Equipements->find('list',[
            'keyField' => 'id',
            'valueField'=>'valeur',
            'groupField' => 'type_equipement_id'
        ])->toArray();
        
        $numeroSeriesEquip = $this->Bornes->NumeroSeries->find('list',[
            'keyField' => 'id',
            'valueField'=>'serial_nb',
            'groupField' => ['equipement.id'],
            'conditions' => ['OR' => ['NumeroSeries.borne_id is' => NULL, 'NumeroSeries.borne_id' => $id]]
            ])
        ->contain(['Equipements'])->toArray();
        
        $bornesAccessoires = $this->Bornes->BornesAccessoires->findByBorneId($id);

        $this->loadModel('Accessoires');
        $accessoires = $this->Accessoires
            ->find()
            ->contain(['SousAccessoires' => 'SousAccessoiresGammes'])
            ->matching('SousAccessoires.SousAccessoiresGammes')
            ->where(['SousAccessoiresGammes.gamme_borne_id' => $borne->model_borne->gamme_borne_id])
            ->group('Accessoires.id');
        ;
        
        $actuBornes =  $borne->actu_bornes;
        $typeEquipementsProtections = $this->Bornes->Equipements->TypeEquipements->findByIsProtection(1)->contain(['Equipements']);

        $this->set(compact('users', 'numeroSeriesEquip', 'actuBornes', 'borne', 'parcs', 'modelBornes', 'antennes', 'clients','logiciels', 'gammeBornes','couleurPossible', 'equipements', 'etat_bornes', 'contrats', 'statuts','marques','fournisseur', 'bornesAccessoires'));
        $this->set(compact('typeEquipementsProtections', 'numeroSeriesLicences', 'typeLicences', 'accessoires'));

    }
    
    public function updateNumSerie($numSerieId, $borneId = null) {

        $this->autoRender = false;
        $serials = TableRegistry::getTableLocator()->get('NumeroSeries');
        $query_serials = $serials->query();
        $query_serials->update()
            ->set(['borne_id' => $borneId])
            ->where(['id' => $numSerieId])
            ->execute();
    }
    public function getListNumSerie($type_equipement, $borne_id) {
        
        if(!is_array($type_equipement)){
            $type_equipement = [$type_equipement];
        }

        return $this->Bornes->NumeroSeries->find('list',[
            'keyField' => 'id',
            'valueField'=>'serial_nb',
            'groupField' => 'equipement.id',
            'conditions' => ['Equipements.type_equipement_id in' => $type_equipement, 'OR' => ['NumeroSeries.borne_id' => $borne_id, 'NumeroSeries.borne_id is' => NULL]]
            ])
        ->contain(['Equipements'])->toArray();
    }
    public function getListEquipement($type_equipement, $groupBy = false) {
        
        if(!is_array($type_equipement)){
            $type_equipement = [$type_equipement];
        }

        return $this->Bornes->Equipements->find('list',[
            'keyField' => 'id',
            'valueField'=>'valeur',
            'groupField' => $groupBy?'type_equipement_id':'',
            'conditions' => ['type_equipement_id IN' => $type_equipement]
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Borne id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $borne = $this->Bornes->get($id);
        if ($this->Bornes->delete($borne)) {
            $this->Flash->success(__('The borne has been deleted.'));
        } else {
            $this->Flash->error(__('The borne could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function editClient($id = null) {
        if($this->request->is(['post', 'put'])) {
            $borne = $this->Bornes->get($id);
            $borne = $this->Bornes->patchEntity($borne, $this->request->getData(), ['validate' => false]);
            if($this->Bornes->save($borne)) {
                $this->Flash->success(__('The borne has been saved.'));
            } else {
                $this->Flash->error(__('The borne could not be saved. Please, try again.' . $borne->getErrors()));
            }
        }
        return $this->redirect(['action' => 'view', $id]);
    }

    public function liste()
    {
        $data = $this->request->getData();
        if($data) {
            $id_Modelborne = $data['id_ModelBorne'];
        }else{
            $id_Modelborne ='';
        }
        $couleurs = $this->Bornes->Couleurs->find('list',['valueField' => 'couleur'])
            
            ->matching('ModelBornes', function ($q) use($id_Modelborne){
                return $q->where(['ModelBornes.id' => $id_Modelborne]);
            });
        $this->set('couleurPossibles', $couleurs);
    }


    //================ TEST
    public function addDevice($teamviewer_id = null, $teamviewer_pwd = null, $alias = null)
    {
        $borne = $this->Bornes->newEntity();
        $this->loadComponent('TeamviewerAPI');
        $result = $this->TeamviewerAPI->addDevice($teamviewer_id, $teamviewer_pwd, $alias);
        /*if(!$creationDevice){
            $borne->teamviewer_remotecontrol_id = null;
            $borne->teamviewer_password = null;
            $borne->teamviewer_alias = null;
            $this->Bornes->save($borne);
        }*/
        debug($result);die;
    }

    public function updateDevice($device_id = null,  $teamviewer_pwd = null, $alias = null){
        $this->loadComponent('TeamviewerAPI');
        $result = $this->TeamviewerAPI->updateDevice($device_id, $teamviewer_pwd, $alias);
        debug($result);die;
        /*if($result){
          $res = $this->TeamviewerAPI->getDevice($teamviewer_id);
          debug($res['devices'][0]);die;
        }*/
    }

    public function deleteDevice($device_id = null){
        $this->loadComponent('TeamviewerAPI');
        $result = $this->TeamviewerAPI->deleteDevice($device_id);
        debug($result);die;
    }

    public function getDevice($remotecontrol_id = null){
        $this->loadComponent('TeamviewerAPI');
        $result = $this->TeamviewerAPI->getDevice($remotecontrol_id);
        debug($result);die;
    }

    public function addActuborne($idborne, $parc_type){
        //$parc_type = 1;
        $actuBorne = $this->Bornes->ActuBornes->newEntity();
        $data = $this->request->getData();

        if ($this->request->is('get')) {
            $actuBorne->borne_id = $idborne;
        }
        if ($this->request->is('post')) {
            $actuBorne = $this->Bornes->ActuBornes->patchEntity($actuBorne, $data);
            $actuBorne->borne_id = $idborne;
            if ($this->Bornes->ActuBornes->save($actuBorne)) {

                if (!empty($data['documents'])) {
                    foreach ($data['documents'] as $doc){
                        $filename = $doc['nom'];
                        if (copy(PATH_TMP . $filename, PATH_ACTU_BORNES . $filename)) {
                            unlink(PATH_TMP . $filename);
                            $doc = $this->Bornes->ActuBornes->Fichiers->newEntity();
                            $doc->nom_fichier = $filename;
                            $doc->chemin = PATH_ACTU_BORNES . $filename ;
                            $doc->actu_borne_id = $actuBorne->id;
                            $this->Bornes->ActuBornes->Fichiers->save($doc);
                        }
                    }
                }

                $this->Flash->success(__('The actu borne has been saved.'));

                return $this->redirect(['action' => 'index/'.$parc_type]);
            }
            $this->Flash->error(__('The actu borne could not be saved. Please, try again.'));
        }
        $borne = $this->Bornes->find('all', ['conditions' => ['Bornes.id = ' =>$idborne ]])->contain(['ModelBornes' => 'GammesBornes'])->first();
        $categorietickets = $this->Bornes->ActuBornes->CategorieActus->find('all');
        $this->set(compact('actuBorne', 'borne','categorietickets'));

    }

    public function editActuborne($id = null)
    {
        $actuBorne = $this->Bornes->ActuBornes->get($id, [
            'contain' => ['Fichiers']
        ]);
        $data = $this->request->getData();
        if ($this->request->is(['patch', 'post', 'put'])) {

            $actuBorne = $this->Bornes->ActuBornes->patchEntity($actuBorne, $data);
            if ($this->Bornes->ActuBornes->save($actuBorne)) {
                if (!empty($data['documents'])) {
                    foreach ($data['documents'] as $doc){
                        $filename = $doc['nom'];
                        if (copy(PATH_TMP . $filename, PATH_ACTU_BORNES . $filename)) {
                            unlink(PATH_TMP . $filename);
                            $doc = $this->Bornes->ActuBornes->Fichiers->newEntity();
                            $doc->nom_fichier = $filename;
                            $doc->chemin = PATH_ACTU_BORNES . $filename ;
                            $doc->actu_borne_id = $actuBorne->id;
                            $this->Bornes->ActuBornes->Fichiers->save($doc);
                        }
                    }
                }
                $this->Flash->success(__('The actu borne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The actu borne could not be saved. Please, try again.'));
        }
        $categorietickets = $this->Bornes->ActuBornes->CategorieActus->find('all');
        $this->set(compact('actuBorne','categorietickets'));
    }


    public function deleteActuborne($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $actuBorne = $this->Bornes->ActuBornes->get($id);
        if ($this->Bornes->ActuBornes->delete($actuBorne)) {
            $this->Flash->success(__('The actu borne has been deleted.'));
        } else {
            $this->Flash->error(__('The actu borne could not be deleted. Please, try again.'));
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
            //debug(count($data["file"]));die;
            if (!empty($data)) {
                $file = $data["file"];
                $fileName = $file['name'];
                $infoFile = pathinfo($fileName);
                $fileExtension = $infoFile["extension"];
                $extensionValide = array('doc', 'docx', 'pdf', 'png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');
                if (in_array($fileExtension, $extensionValide)) {
                    $newName = Text::uuid() . '.' . $fileExtension;
                    $path_tmp = 'uploads/tmp/';
                    $destinationFileName = $path_tmp . $newName;
                    $tmpFilePath = $file['tmp_name'];
                    if (move_uploaded_file($tmpFilePath, $destinationFileName)) {
                        $res["success"] = true;
                        $res["name"] = $newName;
                    }
                } else {$res["error"] = "Fichier invalide format";}
            }
            echo json_encode($res);
        }
    }
    
    
    public function getAntenne($antenne_id = null)
    {
        $this->loadModel('Antennes');
        $client = $this->Antennes->findById($antenne_id)->first();
        $body = $client;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }
    
    
    public function updateNumSerieBorne() {
        
        $this->loadModel('EquipementBornes');
        $bornes = $this->Bornes->find('all');
        
        foreach ($bornes as $borne) {

            // BORNIER 
            if($borne->numero_series_bornier) {
                $i_te_Bornier = $this->Bornes->Equipements->TypeEquipements->find()->where(['TypeEquipements.nom' => 'Bornier'])->first();

                $numSeriesBornier = $this->Bornes->NumeroSeries->findById($borne->numero_series_bornier)->first();

                $data = [
                    'equipement_id' => $numSeriesBornier->equipement_id,
                    'borne_id' => $borne->id,
                    'type_equipement_id' => $i_te_Bornier->id,
                    'numero_serie_id' => $borne->numero_series_bornier,
                    'precisions' => $borne->precision_pc,
                ];
                $equipBorne = $this->EquipementBornes->newEntity($data, ['validate' => false]);
                $this->EquipementBornes->save($equipBorne);
                debug('bornier');
                debug($data);
            }

            // PC
            $i_te_PC = $this->Bornes->Equipements->TypeEquipements->find()->where(['TypeEquipements.nom =' => 'Ordinateur'])->first();

            if($borne->aucun_pc) {
                if($borne->precision_pc) {

                    $data = [
                        'equipement_id' => null,
                        'borne_id' => $borne->id,
                        'type_equipement_id' => $i_te_PC->id,
                        'numero_serie_id' => null,
                        'precisions' => $borne->precision_pc,
                    ];

                    $equipBorne = $this->EquipementBornes->newEntity($data, ['validate' => false]);
                    $this->EquipementBornes->save($equipBorne);
                    debug('pc');
                    debug($data);
                }
            } else if($borne->type_pc) {

                $data = [
                    'equipement_id' => $borne->type_pc,
                    'borne_id' => $borne->id,
                    'type_equipement_id' => $i_te_PC->id,
                    'numero_serie_id' => $borne->numero_series_pc,
                    'precisions' => null,
                ];

                $equipBorne = $this->EquipementBornes->newEntity($data, ['validate' => false]);
                $this->EquipementBornes->save($equipBorne);
                debug('pc');
                debug($data);
            }

            // APPAREIL PHOTO
            if($borne->type_aphoto) {

                $data = [
                    'equipement_id' => $borne->model_appareil,
                    'borne_id' => $borne->id,
                    'type_equipement_id' => $borne->type_aphoto,
                    'numero_serie_id' => $borne->numero_series_aphoto,
                    'precisions' => null,
                ];
                
                $equipBorne = $this->EquipementBornes->newEntity($data, ['validate' => false]);
                $this->EquipementBornes->save($equipBorne);
                debug('photo');
                debug($data);
            }



            // IMPRIMANTE
            $i_te_Print = $this->Bornes->Equipements->TypeEquipements->find()->where(['TypeEquipements.nom' => 'Imprimante'])->first();
            if($borne->aucun_imprimante) {
                if($borne->precision_imprimante) {

                    $data = [
                        'equipement_id' => null,
                        'borne_id' => $borne->id,
                        'type_equipement_id' => $i_te_Print->id,
                        'numero_serie_id' => null,
                        'precisions' => $borne->precision_imprimante,
                    ];

                    $equipBorne = $this->EquipementBornes->newEntity($data, ['validate' => false]);
                    $this->EquipementBornes->save($equipBorne);
                    debug('print');
                    debug($data);
                }
            } else if($borne->type_print) {

                $data = [
                    'equipement_id' => $borne->type_print,
                    'borne_id' => $borne->id,
                    'type_equipement_id' => $i_te_Print->id,
                    'numero_serie_id' => $borne->numero_series_print,
                    'precisions' => null,
                ];

                $equipBorne = $this->EquipementBornes->newEntity($data, ['validate' => false]);
                $this->EquipementBornes->save($equipBorne);
                debug('print');
                debug($data);
            }


            // ECRAN
            $query_ecran = $this->Bornes->Equipements->TypeEquipements->find()->where(['TypeEquipements.nom' => 'Ecran'])->first();
            if($borne->aucun_ecran) {
                if($borne->precision_ecran) {

                    $data = [
                        'equipement_id' => null,
                        'borne_id' => $borne->id,
                        'type_equipement_id' => $query_ecran->id,
                        'numero_serie_id' => null,
                        'precisions' => $borne->precision_ecran,
                    ];

                    $equipBorne = $this->EquipementBornes->newEntity($data, ['validate' => false]);
                    $this->EquipementBornes->save($equipBorne);
                    debug('ecran');
                    debug($data);
                }
            } else if($borne->type_ecran) {

                $data = [
                    'equipement_id' => $borne->type_ecran,
                    'borne_id' => $borne->id,
                    'type_equipement_id' => $query_ecran->id,
                    'numero_serie_id' => $borne->numero_series_ecran,
                    'precisions' => null,
                ];

                $equipBorne = $this->EquipementBornes->newEntity($data, ['validate' => false]);
                $this->EquipementBornes->save($equipBorne);
                debug('ecran');
                debug($data);
            }
        }

        die;
    }
    
    
    public function updateLicenceBorne() {
        
        $this->loadModel('Licences');
        $this->loadModel('LicenceBornes');
        $bornes = $this->Bornes->find('all');
        
        foreach ($bornes as $borne) {

            // BORNIER 
            if($borne->numero_series_win_licence) {
                
                $licence_win = $this->Licences->findById($borne->numero_series_win_licence)->first();
                debug($licence_win);
                if($licence_win) {
                    $data = [
                        'licence_id' => $licence_win->id,
                        'borne_id' => $borne->id
                    ];
                    $licenceBorne = $this->LicenceBornes->newEntity($data);
                    $this->LicenceBornes->save($licenceBorne);
                }
            }
            if($borne->numero_series_sb_licence) {
                $licence_sb = $this->Licences->findById($borne->numero_series_sb_licence)->first();
                if($licence_sb) {
                    $data = [
                        'licence_id' => $licence_sb->id,
                        'borne_id' => $borne->id
                    ];
                    $licenceBorne = $this->LicenceBornes->newEntity($data);
                    $this->LicenceBornes->save($licenceBorne);
                }
            }
        }

        die;
    }
    
    
    
    
    public function import(){
        
        if($this->request->is('post')){
                
                $gamme = $this -> request -> getData("gamme");
                if($gamme == 3){
                        
                        if($this -> request -> getData("csv")){
                                $csv = $this -> request -> getData("csv");
                                if(isset($csv['size']) && $csv['size'] && trim($csv['name'])){

                                        $fileCsv = $csv['tmp_name'];
                                        $fileName = trim($csv['name']);
                                        $extension = explode('.', $fileName);

                                        if($extension[1] == 'csv'){
                                                $handle = fopen($fileCsv, "r");
                                                $numLigne = 0;
                                                $data = [];
                                                while(($row = fgetcsv($handle)) !== FALSE){
                                                        $rows = explode(";", $row[0]);
                                                        $numLigne++;
                                                        
                                                        if($numLigne != 1){
                                                                $borneId = 0;
                                                                $borne = $this->Bornes->newEntity();
                                                                $numBorn = $rows[0];
                                                                
                                                                $querryBornes = $this->Bornes->find()->where(['numero' => $numBorn, 'model_borne_id' => 23])->toArray();
                                                                if(count($querryBornes)){
                                                                    $borne = $querryBornes[0];
                                                                    $borneId = $borne->id;
                                                                }

                                                                $modelBorneId = 23;
                                                                
                                                                $parc_status = trim($rows[2])?trim($rows[2]):'Stock tampon';
                                                                $parcs = $this->Bornes->Parcs->find()->where(['Parcs.nom LIKE' =>  $parc_status])->toArray();

                                                                if(empty($parcs)){
                                                                        $this->Flash->error(__("Born numero $numBorn : le parc ne doit pas etre null."));
                                                                        continue;
                                                                }

                                                                $antennes = $this->Bornes->Antennes->find()->where(['Antennes.ville_principale' => trim($rows[3])])->toArray();

                                                                $client = $this->Bornes->Clients->find()->where(['Clients.nom' => trim($rows[3])])->toArray();

                                                                if(empty($antennes) && empty($client) && trim($rows[3]) != '' && trim($rows[2]) != 'Location'){

                                                                        // add client in data base
                                                                        $this->loadModel('Clients');
                                                                        $dataClient = [
                                                                            'nom' => trim($rows[3]),
                                                                        ];
                                                                        $newClient          = $this-> Clients-> newEntity();
                                                                        $newClient          = $this-> Clients-> patchEntity($newClient, $dataClient);
                                                                        $newClientSave   = $this-> Clients-> save($newClient);
                                                                        $client = $newClientSave?[$newClientSave]:[];
                                                                }                                                                  
                                                                
//                                                                $numeroSeriesBornier = $this->Bornes->NumeroSeries->find()->where(['NumeroSeries.serial_nb LIKE'=> trim($rows[4])])->toArray();
//                                                                
//                                                                $typeBornier = $this->Bornes->Equipements->TypeEquipements->find('all',['conditions' => ['TypeEquipements.nom =' => 'Bornier']])->toArray();
//
//                                                                $equipementBornier = $this->Bornes->Equipements->find()->where([
//                                                                        'Equipements.valeur LIKE '=> 'Import Bornier',
//                                                                        'Equipements.type_equipement_id =' => $typeBornier[0]->id
//                                                                ])->toArray();
//
//                                                                if(empty($equipementBornier)){
//                                                                        $this->loadModel('Equipements');
//                                                                        $dataEquipBornier = [
//                                                                                'type_equipement_id' => $typeBornier[0]->id,
//                                                                                'valeur' => 'Import Bornier',
//                                                                        ];
//                                                                        $newEquipBornier = $this-> Equipements-> newEntity();
//                                                                        $newEquipBornier = $this-> Equipements-> patchEntity($newEquipBornier, $dataEquipBornier);
//                                                                        $equipementBornierSave = $this-> Equipements-> save($newEquipBornier);
//                                                                        $equipementBornier = $equipementBornierSave?[$equipementBornierSave]:[];
//                                                                }
//
//                                                                if(empty($numeroSeriesBornier) && !empty($equipementBornierSave) && trim($rows[4]) != ''){
//                                                                        // add serial number
//                                                                        $this->loadModel('NumeroSeries');
//                                                                        $dataNumeroSerieBornier = [
//                                                                            'equipement_id' => $equipementBornier[0]->id,
//                                                                            'serial_nb' => trim($rows[4]),
//                                                                            'borne_id' => $borneId != 0? $borneId:null,
//                                                                        ];
//                                                                        $newNumeroSerieBornier = $this-> NumeroSeries-> newEntity();
//                                                                        $newNumeroSerieBornier = $this-> NumeroSeries-> patchEntity($newNumeroSerieBornier, $dataNumeroSerieBornier);
//                                                                        $numeroSerieBornierSave = $this-> NumeroSeries-> save($newNumeroSerieBornier);
//                                                                        $numeroSeriesBornier = $numeroSerieBornierSave?[$numeroSerieBornierSave]:[];
//                                                                }elseif(!empty($numeroSeriesBornier)){
//                                                                        $this->loadModel('NumeroSeries');
//                                                                        $dataNumeroSerieBornier = [
//                                                                                'borne_id' => $borneId != 0? $borneId:null,
//                                                                        ];
//                                                                        $newNumeroSerieBornier = $numeroSeriesBornier[0];
//                                                                        $newNumeroSerieBornier = $this-> NumeroSeries-> patchEntity($newNumeroSerieBornier, $dataNumeroSerieBornier);
//                                                                        $this->NumeroSeries-> save($newNumeroSerieBornier);
//                                                                }             
                                                                
                                                                // PC(Tablet)
                                                                $query_pc = $this->Bornes->Equipements->TypeEquipements->find('all',['conditions' => ['TypeEquipements.nom =' => 'Ordinateur']]);
                                                                $i_te_PC = NULL;
                                                                foreach ($query_pc as $te) {
                                                                    $i_te_PC = $te;
                                                                }
//                                                                $this->loadModel('MarqueEquipements');
//                                                                $marquePc = $this->MarqueEquipements -> find()-> where(['MarqueEquipements.marque LIKE' => trim($rows[13])])->toArray();
//
//                                                                if(count($marquePc) == 0 && trim($rows[13]) != ''){
//                                                                        // add marque
//                                                                        $dataMarqueEquip = [
//                                                                                'marque' => trim($rows[13]),
//                                                                        ];
//                                                                        $newMarque = $this->MarqueEquipements-> newEntity();
//                                                                        $newMarque = $this->MarqueEquipements->patchEntity($newMarque, $dataMarqueEquip);
//                                                                        $marquePcSave = $this->MarqueEquipements->save($newMarque);
//                                                                        $marquePc = $marquePcSave?[$marquePcSave]:[];
//                                                                }

                                                                $typePC = $this->Bornes->Equipements->find()->where([
                                                                        'Equipements.valeur LIKE '=> trim($rows[1]),
                                                                        'Equipements.type_equipement_id =' => $i_te_PC->id
                                                                ])->toArray();

                                                                //debug($typePC);
                                                                if(count($typePC) == 0 && trim($rows[1]) != ''){
                                                                        // add type pc
                                                                        $this->loadModel('Equipements');
                                                                        $dataTypePc = [
                                                                            'type_equipement_id' => $i_te_PC->id,
                                                                            'valeur' => trim($rows[1]),
                                                                        ];
                                                                        $newTypePc = $this-> Equipements-> newEntity();
                                                                        $newTypePc = $this-> Equipements-> patchEntity($newTypePc, $dataTypePc);
                                                                        $typePcSave = $this-> Equipements-> save($newTypePc);
                                                                        $typePC = $typePcSave?[$typePcSave]:[];
                                                                }
                                                                
                                                                $numeroSeriesPC = $this->Bornes->NumeroSeries->find()->where(['NumeroSeries.serial_nb LIKE'=> trim($rows[4])])->toArray();

//                                                                $numeroSeriesPC = $this->Bornes->NumeroSeries->find()
//                                                                        ->contain(['Equipements'])
//                                                                        ->where([
//                                                                        'NumeroSeries.serial_nb'=>  trim($rows[14]),
//                                                                        'Equipements.type_equipement_id' => $i_te_PC->id
//                                                                ])->toArray();

                                                                //debug($numeroSeriesPC);
                                                                if(empty($numeroSeriesPC) && !empty($typePC) && trim($rows[4]) != ''){
                                                                        // add serial number
                                                                        $this->loadModel('NumeroSeries');
                                                                        $dataNumeroSeriePC = [
                                                                            'equipement_id' => $typePC[0]->id,
                                                                            'serial_nb' => trim($rows[4]),
                                                                            'borne_id' => $borneId != 0? $borneId:null,
                                                                        ];
                                                                        $newNumeroSeriePC = $this-> NumeroSeries-> newEntity();
                                                                        $newNumeroSeriePC = $this-> NumeroSeries-> patchEntity($newNumeroSeriePC, $dataNumeroSeriePC);
                                                                        $numeroSeriePCSave = $this-> NumeroSeries-> save($newNumeroSeriePC);
                                                                        $numeroSeriesPC = $numeroSeriePCSave?[$numeroSeriePCSave]:[];

                                                                }elseif(!empty($numeroSeriesPC)){
                                                                        $this->loadModel('NumeroSeries');
                                                                        $dataNumeroSeriePC = [
                                                                                'borne_id' => $borneId != 0? $borneId:null,
                                                                                'equipement_id' => $typePC[0]->id,
                                                                        ];
                                                                        $newNumeroSeriePC = $numeroSeriesPC[0];
                                                                        $newNumeroSeriePC = $this-> NumeroSeries-> patchEntity($newNumeroSeriePC, $dataNumeroSeriePC);
                                                                        $this->NumeroSeries-> save($newNumeroSeriePC);
                                                                }

                                                                
                                                                // IMPRIMANTE
                                                                $query_Print = $this->Bornes->Equipements->TypeEquipements->find('all',[
                                                                        'conditions' => ['TypeEquipements.nom =' => 'Imprimante']
                                                                ])->toArray();

                                                                $i_te_Print = NULL;
                                                                foreach ($query_Print as $te) {
                                                                    $i_te_Print = $te;
                                                                }
                                                                
                                                                $this->loadModel('MarqueEquipements');
                                                                $marquePrint = $this->MarqueEquipements -> find()-> where(['MarqueEquipements.marque LIKE' => trim($rows[5])])->toArray();
                                                                
                                                                $typePrint = $this->Bornes->Equipements->find()->where([
                                                                        'Equipements.valeur'=>$rows[6],
                                                                        'Equipements.type_equipement_id =' => $i_te_Print->id
                                                                ])->toArray();

                                                                if(count($typePrint) == 0 && count($marquePrint) && trim($rows[6]) != ''){
                                                                        // add type print
                                                                        $this->loadModel('Equipements');
                                                                        $dataTypePrint = [
                                                                            'type_equipement_id' => $i_te_Print->id,
                                                                            'valeur' => trim($rows[6]),
                                                                            'marque_equipement_id' => $marquePrint[0]->id,
                                                                        ];
                                                                        $newTypePrint = $this-> Equipements-> newEntity();
                                                                        $newTypePrint = $this-> Equipements-> patchEntity($newTypePrint, $dataTypePrint);
                                                                        $typePrintSave = $this-> Equipements-> save($newTypePrint);
                                                                        $typePrint = $typePrintSave?[$typePrintSave]:[];
                                                                }

                                                                $numeroSeriesPrint = $this->Bornes->NumeroSeries->find()
                                                                        ->contain(['Equipements'])
                                                                        ->where([
                                                                        'NumeroSeries.serial_nb'=>trim($rows[7]),
                                                                        'Equipements.type_equipement_id' => $i_te_Print->id
                                                                ])->toArray();
                                                                //debug($numeroSeriesPrint);
                                                                if(empty($numeroSeriesPrint) && !empty($typePrint) && trim($rows[7]) != ''){
                                                                        // add serial number
                                                                        $this->loadModel('NumeroSeries');
                                                                        $dataNumeroSeriePrint = [
                                                                            'equipement_id' => $typePrint[0]->id,
                                                                            'serial_nb' => trim($rows[7]),
                                                                            'borne_id' => $borneId != 0? $borneId:null,
                                                                        ];
                                                                        $newNumeroSeriePrint = $this-> NumeroSeries-> newEntity();
                                                                        $newNumeroSeriePrint = $this-> NumeroSeries-> patchEntity($newNumeroSeriePrint, $dataNumeroSeriePrint);
                                                                        $numeroSeriePrintSave = $this-> NumeroSeries-> save($newNumeroSeriePrint);
                                                                        $numeroSeriesPrint = $numeroSeriePrintSave?[$numeroSeriePrintSave]:[];

                                                                }elseif(!empty($numeroSeriesPrint)){
                                                                        $this->loadModel('NumeroSeries');
                                                                        $dataNumeroSeriePrint = [
                                                                                'borne_id' => $borneId != 0? $borneId:null,
                                                                        ];
                                                                        $newNumeroSeriePrint = $numeroSeriesPrint[0];
                                                                        $newNumeroSeriePrint = $this-> NumeroSeries-> patchEntity($newNumeroSeriePrint, $dataNumeroSeriePrint);
                                                                        $this->NumeroSeries-> save($newNumeroSeriePrint);
                                                                }
                                                                

                                                                // LICENCE SB
                                                                $numeroSeriesLicenceSB = $this->Bornes->Licences->find()->where(['Licences.numero_serie'=> trim($rows[8])])->toArray();

                                                                if(count($numeroSeriesLicenceSB) == 0 && trim($rows[8]) != ''){
                                                                        $socialBooths =  $this->Bornes->Licences->TypeLicences->find()->where(['TypeLicences.nom LIKE' => 'Social booth'])->toArray();
                                                                        $this->loadModel('Licences');
                                                                        $dataSocialBooths = [
                                                                                'numero_serie' => trim($rows[8]),
                                                                                'type_licence_id' => is_array($socialBooths)?$socialBooths[0]->id:1,
                                                                                'date_achat'=>trim($rows[10]),
                                                                                'email' => trim($rows[9]),
                                                                        ];
                                                                        //debug($dataSocialBooths);
                                                                        $licenceSocialBooths = $this -> Licences -> newEntity();
                                                                        $licenceSocialBooths = $this -> Licences -> patchEntity($licenceSocialBooths, $dataSocialBooths);
                                                                        $numeroSeriesLicenceSBSave = $this->Licences -> save($licenceSocialBooths);
                                                                        $numeroSeriesLicenceSB = $numeroSeriesLicenceSBSave?[$numeroSeriesLicenceSBSave]:[];
                                                                        if(!$numeroSeriesLicenceSBSave){
                                                                            debug($dataSocialBooths);die;
                                                                        }
                                                                }
                                                                

                                                                $data = [
                                                                        'numero' => $numBorn,
                                                                        'parc_id' => !empty($parcs)?$parcs[0]->id:null,
                                                                        'model_borne_id' => $modelBorneId,
                                                                        'antenne_id' => !empty($antennes)?$antennes[0]->id:null,
                                                                        'client_id' => !empty($client)?$client[0]->id:null,
                                                                        'couleur_id' => 0,
                                                                        'adresse' => 0,
                                                                        'is_prette' => 1,
                                                                        'adresse' => ' ',
                                                                        'numero_series_bornier' => null,
                                                                        'aucun_pc' => !empty($typePC)?false:true,
                                                                        'type_pc' => !empty($typePC)?$typePC[0]->id:null,
                                                                        'numero_series_pc' => !empty($numeroSeriesPC)?$numeroSeriesPC[0]->id:null,
                                                                        'precision_pc' => null,
                                                                        'aucun_pc' => false,
                                                                        'aucun_ecran' => true,
                                                                        'aucun_appareil_photo' => true,
                                                                        'aucun_imprimante' => !empty($typePrint)?false:true,
                                                                        'type_print' => !empty($typePrint)?$typePrint[0]->id:null,
                                                                        'numero_series_print' => !empty($numeroSeriesPrint)?$numeroSeriesPrint[0]->id:null,
                                                                        'numero_series_sb_licence' => !empty($numeroSeriesLicenceSB)?$numeroSeriesLicenceSB[0]->id:null,
                                                                ];

                                                                $borne = $this->Bornes->patchEntity($borne, $data);
                                                                if($this->Bornes->save($borne)){
                                                                        $this->Flash->success(__("La borne numero $numBorn a été ajoutée avec succés."));
                                                                        if(!empty($client)){
                                                                                $this->Flash->success(__("Borne numero $numBorn : client id : " . $client[0]->id));
                                                                        }
                                                                        if(empty($client) && empty($antennes)){
                                                                                $this->Flash->success(__("Borne numero $numBorn : pas de client, pas d'antenne."));
                                                                        }
                                                                }else{
                                                                        $this->Flash->error(__("The borne num $numBorn could not be saved. Please, try again."));
                                                                }

                                                        }
                                                }
                                        }
                                }
                        }
                    
                }else{

                        // Remplissage data + structure via csv
                        if($this -> request -> getData("csv")){
                                $csv = $this -> request -> getData("csv");
                                if(isset($csv['size']) && $csv['size'] && trim($csv['name'])){

                                        $fileCsv = $csv['tmp_name'];
                                        $fileName = trim($csv['name']);
                                        $extension = explode('.', $fileName);

                                        if($extension[1] == 'csv'){
                                                $handle = fopen($fileCsv, "r");
                                                $numLigne = 0;
                                                $data = [];
                                                while(($row = fgetcsv($handle)) !== FALSE){
                                                        $rows = explode(";", $row[0]);
                                                        $numLigne++;
                                                        if($numLigne == 1){
                                                            continue;
                                                        }
                                                        $borneId = 0;
                                                        $borne = $this->Bornes->newEntity();
                                                        $numBorn = $rows[0];
                                                        if($numBorn == '' || $numBorn == null){
                                                                $this->Flash->error(__("Borne pas de numero."));
                                                                continue;
                                                        }
                                                        $querryBornes = $this->Bornes->find()->where(['Bornes.numero' => $numBorn])->toArray();
                                                        if(count($querryBornes)){
                                                            $borne = $querryBornes[0];
                                                            $borneId = $borne->id;
                                                        }

                                                        //debug('$numBorn : ' . $numBorn);
                                                        $modelBornes = [];
                                                        if(preg_match('#proto#i', trim($rows[11]))){
                                                                $modelBornes = $this->Bornes->ModelBornes->find()->where(['ModelBornes.nom LIKE' => trim($rows[1]), 'ModelBornes.version LIKE' => 'proto'])->toArray();
                                                        }else{
                                                                $modelBornes = $this->Bornes->ModelBornes->find()->where(['ModelBornes.nom LIKE' => trim($rows[1]), 'ModelBornes.version <>' => 'proto'])->toArray();
                                                        }
                                                        //debug($modelBornes);
                                                        if(empty($modelBornes)){
                                                                $this->Flash->error(__("Borne numero $numBorn : la modele borne ne doit pas etre null."));
                                                                continue;
                                                        }
                                                        $parc_status = trim($rows[2])?trim($rows[2]):'Stock tampon';
                                                        $parcs = $this->Bornes->Parcs->find()->where(['Parcs.nom LIKE' =>  $parc_status])->toArray();
                                                        //debug($parcs);

                                                        if(empty($parcs)){
                                                                $this->Flash->error(__("Born numero $numBorn : le parc ne doit pas etre null."));
                                                                continue;
                                                        }

                                                        $antennes = $this->Bornes->Antennes->find()->where(['Antennes.ville_principale' => trim($rows[3])])->toArray();
                                                        //debug($antennes);
                                                        // si $antennes = 0, on ne peut pas ajouter car plusieur info sont manqué

                                                        $client = $this->Bornes->Clients->find()->where(['Clients.nom' => trim($rows[3])])->toArray();
                                                        $status = 1;
                                                        if(empty($antennes) && empty($client)){
                                                            $status =0;
                                                        }

                                                        if(empty($antennes) && empty($client) && trim($rows[3]) != '' && preg_match('#Financiere#i', trim($rows[2]))){

                                                                // add client in data base
                                                                $this->loadModel('Clients');
                                                                $info = [];//explode("/", $rows[40]);
                                                                $adress = isset($info[0])?trim($info[0]):null;
                                                                $cp = isset($info[1])?trim($info[1]):null;
                                                                $ville = isset($info[2])?trim($info[2]):null;
                                                                $country = isset($info[3])?trim($info[3]):'France';

        //                                                        $positions = $geocoder->geocode($adress . ',' . trim($rows[3]) . ', ' . $cp . ',' . $ville . ', ' . $country);
        //                                                        
        //                                                        $lat  = isset($positions['results'][0]['geometry']['lat'])?$positions['results'][0]['geometry']['lat']:null;
        //                                                        $lng  = isset($positions['results'][0]['geometry']['lng'])?$positions['results'][0]['geometry']['lng']:null;

                                                                $dataClient = [
                                                                    'nom' => trim($rows[3]),
//                                                                    'telephone' => str_replace(' ' ,'' ,$rows[39]),
//                                                                    'mobile' => trim($rows[39]),
//                                                                    'adresse' => $adress,
//                                                                    'cp' => $cp,
//                                                                    'ville' => $ville,
        //                                                            'country' => $country,
        //                                                            'addr_lat' => $lat,
        //                                                            'addr_lng' => $lng,
                                                                ];
                                                                $newClient          = $this-> Clients-> newEntity();
                                                                $newClient          = $this-> Clients-> patchEntity($newClient, $dataClient);
                                                                $newClientSave   = $this-> Clients-> save($newClient);
                                                                $client = $newClientSave?[$newClientSave]:[];
                                                        }
//                                                        elseif(!empty ($client) && trim($rows[40]) != ''){
//
//                                                                $this->loadModel('Clients');
//                                                                $info = explode("/", $rows[40]);
//                                                                $adress = isset($info[0])?trim($info[0]):null;
//                                                                $cp = isset($info[1])?trim($info[1]):null;
//                                                                $ville = isset($info[2])?trim($info[2]):null;
//                                                                $country = isset($info[3])?trim($info[3]):'France';
//
//
//        //                                                        $positions = $geocoder->geocode($adress . ',' . trim($rows[3]) . ', ' . $cp . ', ' . $ville . ', ' . $country);
//        //                                                        
//        //                                                        $lat  = isset($positions['results'][0]['geometry']['lat'])?$positions['results'][0]['geometry']['lat']:null;
//        //                                                        $lng  = isset($positions['results'][0]['geometry']['lng'])?$positions['results'][0]['geometry']['lng']:null;
//
//
//                                                                $dataClient = [
//                                                                    'telephone' => str_replace(' ' ,'' ,$rows[39]),
//                                                                    'mobile' => trim($rows[39]),
//                                                                    'adresse' => $adress,
//                                                                    'cp' => $cp,
//                                                                    'ville' => $ville,
//                                                                    'country' => $country,
//        //                                                            'addr_lat' => $lat,
//        //                                                            'addr_lng' => $lng,
//                                                                ];
//                                                                $newClient = $client[0];
//                                                                $newClient = $this-> Clients-> patchEntity($newClient, $dataClient);
//                                                                if(!$this->Clients-> save($newClient)){
//                                                                    debug($dataClient);
//                                                                }
//                                                        }
//
//                                                        if(!empty ($client) && trim($rows[41]) != ''){
//
//                                                                $this->loadModel('ClientContacts');
//                                                                $contact = $this->ClientContacts->find()->where(['ClientContacts.nom LIKE' => '%'.trim($rows[41]).'%'])->toArray();
//                                                                if(trim($rows[42])){
//                                                                        $contact = $this->ClientContacts->find()->where(['ClientContacts.nom LIKE' => '%'.trim($rows[41]).'%', 'ClientContacts.prenom LIKE' => '%'.trim($rows[42]).'%', ])->toArray();
//                                                                }
//                                                                if(!empty($contact)){
//                                                                        $serials = TableRegistry::getTableLocator()->get('ClientContacts');
//                                                                        $query = $serials->query();
//                                                                        $query->update()
//                                                                            ->set([
//                                                                                'client_id' => $client[0]->id
//                                                                            ])
//                                                                            ->where(['id' => $contact[0]->id])
//                                                                            ->execute();
//                                                                }else{
//
//                                                                        $dataContact = [
//                                                                                'nom' => trim($rows[41]),
//                                                                                'prenom' => trim($rows[42]),
//                                                                                'tel' => str_replace(' ' ,'' ,$rows[39]),
//                                                                                'id_in_sellsy' => 0,
//                                                                                'client_id' => $client[0]->id
//                                                                        ];
//                                                                        $newContact          = $this-> ClientContacts-> newEntity();
//                                                                        $newContact          = $this-> ClientContacts-> patchEntity($newClient, $dataContact);
//                                                                        $this-> ClientContacts-> save($newContact);
//                                                                }
//                                                        }
                                                        $etatBornes = $this->Bornes->EtatBornes->find()->where(['EtatBornes.etat_general LIKE'=>trim($rows[4])])->toArray();
                                                        //debug($etatBornes);
                                                        if(count($etatBornes) == 0 && trim($rows[4]) != ''){
                                                                // add etat borne
                                                                $this->loadModel('EtatBornes');
                                                                $dataEtatBorne = [
                                                                        'etat_general' => trim($rows[4]),
                                                                ];
                                                                $etatBorne = $this -> EtatBornes -> newEntity();
                                                                $etatBorne = $this -> EtatBornes -> patchEntity($etatBorne, $dataEtatBorne);
                                                                $etatBorneSave = $this-> EtatBornes -> save($etatBorne);
                                                                $etatBornes = $etatBorneSave?[$etatBornes]:[];
                                                        }
                                                        // il faut ajuster le nom du couleur dans le csv. car dans la base "Noir" dans csv "Noire"
                                                        $couleurs =  $this->Bornes->Couleurs->find()->where(['Couleurs.couleur LIKE'=>  trim($rows[5]) . ' - ' . trim($rows[6])])->toArray();
                                                        //debug($couleurs);
                                                        if(count($couleurs) == 0 && trim($rows[5]) != ''){
                                                                // add colors
                                                                $this->loadModel('Couleurs');
                                                                $dataCouleur = [
                                                                        'couleur' => trim($rows[5]) . ' - ' . trim($rows[6]),
                                                                ];
                                                                $couleur = $this -> Couleurs -> newEntity();
                                                                $couleur = $this -> Couleurs -> patchEntity($couleur, $dataCouleur);
                                                                $couleurSave = $this->Couleurs -> save($couleur);
                                                                $couleurs = $couleurSave?[$couleurSave]:[];
                                                        }

                                                        $marque = trim($rows[7]);
                                                        $date = $rows[8];
                                                        $numBon = trim($rows[9]);
                                                        $retrofitBornier = preg_match('#oui#i', $rows[10])?true:false;
                                                        $numeroSeriesBornier = $this->Bornes->NumeroSeries->find()->where(['NumeroSeries.serial_nb LIKE'=> trim($rows[11])])->toArray();
                                                        //debug($numeroSeriesBornier);
                                                        $typeBornier = $this->Bornes->Equipements->TypeEquipements->find('all',['conditions' => ['TypeEquipements.nom =' => 'Bornier']])->toArray();

                                                        $equipementBornier = $this->Bornes->Equipements->find()->where([
                                                                'Equipements.valeur LIKE '=> 'Import Bornier',
                                                                'Equipements.type_equipement_id =' => $typeBornier[0]->id
                                                        ])->toArray();

                                                        if(empty($equipementBornier)){
                                                                $this->loadModel('Equipements');
                                                                $dataEquipBornier = [
                                                                        'type_equipement_id' => $typeBornier[0]->id,
                                                                        'valeur' => 'Import Bornier',
                                                                ];
                                                                $newEquipBornier = $this-> Equipements-> newEntity();
                                                                $newEquipBornier = $this-> Equipements-> patchEntity($newEquipBornier, $dataEquipBornier);
                                                                $equipementBornierSave = $this-> Equipements-> save($newEquipBornier);
                                                                $equipementBornier = $equipementBornierSave?[$equipementBornierSave]:[];
                                                        }

                                                        if(empty($numeroSeriesBornier) && !empty($equipementBornier) && trim($rows[11]) != '' && trim($rows[11]) != 'Proto'){
                                                                // add serial number
                                                                $this->loadModel('NumeroSeries');
                                                                $dataNumeroSerieBornier = [
                                                                    'equipement_id' => $equipementBornier[0]->id,
                                                                    'serial_nb' => trim($rows[11]),
                                                                    'borne_id' => $borneId != 0? $borneId:null,
                                                                ];
                                                                $newNumeroSerieBornier = $this-> NumeroSeries-> newEntity();
                                                                $newNumeroSerieBornier = $this-> NumeroSeries-> patchEntity($newNumeroSerieBornier, $dataNumeroSerieBornier);
                                                                $numeroSerieBornierSave = $this-> NumeroSeries-> save($newNumeroSerieBornier);
                                                                if($numeroSerieBornierSave){
                                                                        $numeroSeriesBornier = [$numeroSerieBornierSave];
                                                                }else{
                                                                    debug($dataNumeroSerieBornier);die;
                                                                }
                                                                
                                                        }elseif(!empty($numeroSeriesBornier)){
                                                                $this->loadModel('NumeroSeries');
                                                                $dataNumeroSerieBornier = [
                                                                        'borne_id' => $borneId != 0? $borneId:null,
                                                                ];
                                                                $newNumeroSerieBornier = $numeroSeriesBornier[0];
                                                                $newNumeroSerieBornier = $this-> NumeroSeries-> patchEntity($newNumeroSerieBornier, $dataNumeroSerieBornier);
                                                                $this->NumeroSeries-> save($newNumeroSerieBornier);
                                                        }

                                                        // PC
                                                        $query_pc = $this->Bornes->Equipements->TypeEquipements->find('all',['conditions' => ['TypeEquipements.nom =' => 'Ordinateur']]);
                                                        $i_te_PC = NULL;
                                                        foreach ($query_pc as $te) {
                                                            $i_te_PC = $te;
                                                        }
                                                        //debug($i_te_PC);
                                                        $this->loadModel('MarqueEquipements');
                                                        $marquePc = $this->MarqueEquipements -> find()-> where(['MarqueEquipements.marque LIKE' => trim($rows[13])])->toArray();

                                                        if(count($marquePc) == 0 && trim($rows[13]) != ''){
                                                                // add marque
                                                                $dataMarqueEquip = [
                                                                        'marque' => trim($rows[13]),
                                                                ];
                                                                $newMarque = $this->MarqueEquipements-> newEntity();
                                                                $newMarque = $this->MarqueEquipements->patchEntity($newMarque, $dataMarqueEquip);
                                                                $marquePcSave = $this->MarqueEquipements->save($newMarque);
                                                                $marquePc = $marquePcSave?[$marquePcSave]:[];
                                                        }

                                                        $typePC = $this->Bornes->Equipements->find()->where([
                                                                'Equipements.valeur LIKE '=> trim($rows[12]),
                                                                'Equipements.type_equipement_id =' => $i_te_PC->id
                                                        ])->toArray();

                                                        //debug($typePC);
                                                        if(count($typePC) == 0 && count($marquePc) && trim($rows[12]) != ''){
                                                                // add type pc
                                                                $this->loadModel('Equipements');
                                                                $dataTypePc = [
                                                                    'type_equipement_id' => $i_te_PC->id,
                                                                    'valeur' => trim($rows[12]),
                                                                    'marque_equipement_id' => $marquePc[0]->id,
                                                                ];
                                                                $newTypePc = $this-> Equipements-> newEntity();
                                                                $newTypePc = $this-> Equipements-> patchEntity($newTypePc, $dataTypePc);
                                                                $typePcSave = $this-> Equipements-> save($newTypePc);
                                                                $typePC = $typePcSave?[$typePcSave]:[];
                                                        }

                                                        $numeroSeriesPC = $this->Bornes->NumeroSeries->find()
                                                                ->contain(['Equipements'])
                                                                ->where([
                                                                'NumeroSeries.serial_nb'=>  trim($rows[14]),
                                                                'Equipements.type_equipement_id' => $i_te_PC->id
                                                        ])->toArray();

                                                        //debug($numeroSeriesPC);
                                                        if(empty($numeroSeriesPC) && !empty($typePC) && trim($rows[14]) != ''){
                                                                // add serial number
                                                                $this->loadModel('NumeroSeries');
                                                                $dataNumeroSeriePC = [
                                                                    'equipement_id' => $typePC[0]->id,
                                                                    'serial_nb' => trim($rows[14]),
                                                                    'borne_id' => $borneId != 0? $borneId:null,
                                                                ];
                                                                $newNumeroSeriePC = $this-> NumeroSeries-> newEntity();
                                                                $newNumeroSeriePC = $this-> NumeroSeries-> patchEntity($newNumeroSeriePC, $dataNumeroSeriePC);
                                                                $numeroSeriePCSave = $this-> NumeroSeries-> save($newNumeroSeriePC);
                                                                $numeroSeriesPC = $numeroSeriePCSave?[$numeroSeriePCSave]:[];

                                                        }elseif(!empty($numeroSeriesPC)){
                                                                $this->loadModel('NumeroSeries');
                                                                $dataNumeroSeriePC = [
                                                                        'borne_id' => $borneId != 0? $borneId:null,
                                                                ];
                                                                $newNumeroSeriePC = $numeroSeriesPC[0];
                                                                $newNumeroSeriePC = $this-> NumeroSeries-> patchEntity($newNumeroSeriePC, $dataNumeroSeriePC);
                                                                $this->NumeroSeries-> save($newNumeroSeriePC);
                                                        }

                                                        // ECRAN
                                                        $query_ecran = $this->Bornes->Equipements->TypeEquipements->find('all',['conditions' => ['TypeEquipements.nom =' => 'Ecran']]);

                                                        $i_te_Ecran = NULL;
                                                        foreach ($query_ecran as $te) {
                                                                $i_te_Ecran = $te;
                                                        }

                                                        $marqueEcran = $this->MarqueEquipements -> find()-> where(['MarqueEquipements.marque LIKE' => trim($rows[18])])->toArray();
                                                        if(count($marqueEcran) == 0 && trim($rows[18]) != ''){
                                                                // add marque
                                                                $dataMarqueEquip = [
                                                                        'marque' => trim($rows[18]),
                                                                ];
                                                                $newMarque = $this->MarqueEquipements-> newEntity();
                                                                $newMarque = $this->MarqueEquipements->patchEntity($newMarque, $dataMarqueEquip);
                                                                $marqueEcranSave = $this->MarqueEquipements->save($newMarque);
                                                                $marqueEcran = $marqueEcranSave?[$marqueEcranSave]:[];
                                                        }

                                                        $typeEcran = $this->Bornes->Equipements->find()->where([
                                                                'Equipements.valeur'=>  trim($rows[17]),
                                                                'Equipements.type_equipement_id =' => $i_te_Ecran->id
                                                        ])->toArray();

                                                        //debug($typeEcran);
                                                        if(count($typeEcran) == 0 && count($marqueEcran) && trim($rows[17]) != ''){
                                                                // add type ecran
                                                                $this->loadModel('Equipements');
                                                                $dataTypeEcran = [
                                                                    'type_equipement_id' => $i_te_Ecran->id,
                                                                    'valeur' => trim($rows[17]),
                                                                    'marque_equipement_id' => $marqueEcran[0]->id,
                                                                ];
                                                                $newTypeEcran = $this-> Equipements-> newEntity();
                                                                $newTypeEcran = $this-> Equipements-> patchEntity($newTypeEcran, $dataTypeEcran);
                                                                $typeEcranSave = $this-> Equipements-> save($newTypeEcran);
                                                                $typeEcran = $typeEcranSave? [$typeEcranSave]:[];
                                                        }

                                                        $numeroSeriesEcran = $this->Bornes->NumeroSeries->find()
                                                                ->contain(['Equipements'])
                                                                ->where([
                                                                        'NumeroSeries.serial_nb'=> trim($rows[20]),
                                                                        'Equipements.type_equipement_id' => $i_te_Ecran->id
                                                        ])->toArray();
                                                        //debug($numeroSeriesEcran);
                                                        if(empty($numeroSeriesEcran) && !empty($typeEcran) && trim($rows[20]) != ''){
                                                                // add serial number
                                                                $this->loadModel('NumeroSeries');
                                                                $dataNumeroSerieEcran = [
                                                                    'equipement_id' => $typeEcran[0]->id,
                                                                    'serial_nb' => trim($rows[20]),
                                                                    'borne_id' => $borneId != 0? $borneId:null,
                                                                ];
                                                                $newNumeroSerieEcran = $this-> NumeroSeries-> newEntity();
                                                                $newNumeroSerieEcran = $this-> NumeroSeries-> patchEntity($newNumeroSerieEcran, $dataNumeroSerieEcran);
                                                                $numeroSerieEcranSave = $this-> NumeroSeries-> save($newNumeroSerieEcran);
                                                                $numeroSeriesEcran = $numeroSerieEcranSave?[$numeroSerieEcranSave]:[];

                                                        }elseif(!empty($numeroSeriesEcran)){
                                                                $this->loadModel('NumeroSeries');
                                                                $dataNumeroSerieEcran = [
                                                                        'borne_id' => $borneId != 0? $borneId:null,
                                                                ];
                                                                $newNumeroSerieEcran = $numeroSeriesEcran[0];
                                                                $newNumeroSerieEcran = $this-> NumeroSeries-> patchEntity($newNumeroSerieEcran, $dataNumeroSerieEcran);
                                                                $this->NumeroSeries-> save($newNumeroSerieEcran);
                                                        }

                                                        // APPAREIL PHOTO
                                                        $app = trim($rows[22]) == 'Logitech'?'Webcam':'Appareil photo';
                                                        $i_te_APhoto = $this->Bornes->Equipements->TypeEquipements->find()->where(['TypeEquipements.nom' => $app])->toArray();

                                                        $marqueAppPhoto = $this->MarqueEquipements -> find()-> where(['MarqueEquipements.marque LIKE' => trim($rows[22])])->toArray();
                                                        if(count($marqueAppPhoto) == 0 && trim($rows[22])){
                                                                // add marque
                                                                $dataMarqueEquip = [
                                                                        'marque' => trim($rows[22]),
                                                                ];
                                                                $newMarque = $this->MarqueEquipements-> newEntity();
                                                                $newMarque = $this->MarqueEquipements->patchEntity($newMarque, $dataMarqueEquip);
                                                                $marqueAppPhotoSave = $this->MarqueEquipements->save($newMarque);
                                                                $marqueAppPhoto = $marqueAppPhotoSave?[$marqueAppPhotoSave]:[];
                                                        }


                                                        //debug($i_te_APhoto);
                                                        $typeAPhoto = $this->Bornes->Equipements->find()
                                                                ->where([
                                                                'Equipements.valeur'=>$rows[21],
                                                                'Equipements.type_equipement_id in' => $i_te_APhoto[0]->id
                                                        ])->toArray();

                                                        //debug($typeAPhoto);
                                                        if(count($typeAPhoto) == 0 && count($marqueAppPhoto) && trim($rows[21]) != ''){
                                                                // add type app photo
                                                                $this->loadModel('Equipements');
                                                                $dataTypeAppPhoto = [
                                                                    'type_equipement_id' => $i_te_APhoto[0]->id,
                                                                    'valeur' => trim($rows[21]),
                                                                    'marque_equipement_id' => $marqueAppPhoto[0]->id,
                                                                ];
                                                                $newTypeAppPhoto = $this-> Equipements-> newEntity();
                                                                $newTypeAppPhoto = $this-> Equipements-> patchEntity($newTypeAppPhoto, $dataTypeAppPhoto);
                                                                $typeAPhotoSave = $this-> Equipements-> save($newTypeAppPhoto);
                                                                $typeAPhoto = $typeAPhotoSave?[$typeAPhotoSave]:[];
                                                        }

                                                        $numeroSeriesAPhoto = $this->Bornes->NumeroSeries->find()
                                                                ->contain(['Equipements'])
                                                                ->where([
                                                                'NumeroSeries.serial_nb'=>$rows[23],
                                                                'Equipements.type_equipement_id' => $i_te_APhoto[0]->id
                                                        ])->toArray();
                                                        //debug($numeroSeriesAPhoto);

                                                        if(empty($numeroSeriesAPhoto) && !empty($typeAPhoto) && trim($rows[23]) != ''){
                                                                // add serial number
                                                                $this->loadModel('NumeroSeries');
                                                                $dataNumeroSerieAPhoto = [
                                                                    'equipement_id' => $typeAPhoto[0]->id,
                                                                    'serial_nb' => trim($rows[23]),
                                                                    'borne_id' => $borneId != 0? $borneId:null,
                                                                ];
                                                                $newNumeroSerieAPhoto = $this-> NumeroSeries-> newEntity();
                                                                $newNumeroSerieAPhoto = $this-> NumeroSeries-> patchEntity($newNumeroSerieAPhoto, $dataNumeroSerieAPhoto);
                                                                $numeroSerieAPhotoSave = $this-> NumeroSeries-> save($newNumeroSerieAPhoto);
                                                                $numeroSeriesAPhoto = $numeroSerieAPhotoSave?[$numeroSerieAPhotoSave]:[];

                                                        }elseif(!empty($numeroSeriesAPhoto)){
                                                                $this->loadModel('NumeroSeries');
                                                                $dataNumeroSerieAPhoto = [
                                                                        'borne_id' => $borneId != 0? $borneId:null,
                                                                ];
                                                                $newNumeroSerieAPhoto = $numeroSeriesAPhoto[0];
                                                                $newNumeroSerieAPhoto = $this-> NumeroSeries-> patchEntity($newNumeroSerieAPhoto, $dataNumeroSerieAPhoto);
                                                                $this->NumeroSeries-> save($newNumeroSerieAPhoto);
                                                        }


                                                        // IMPRIMANTE
                                                        $query_Print = $this->Bornes->Equipements->TypeEquipements->find('all',[
                                                                'conditions' => ['TypeEquipements.nom =' => 'Imprimante']
                                                        ])->toArray();

                                                        $i_te_Print = NULL;
                                                        foreach ($query_Print as $te) {
                                                            $i_te_Print = $te;
                                                        }

                                                        $marquePrint = $this->MarqueEquipements -> find()-> where(['MarqueEquipements.marque LIKE' => trim($rows[25])])->toArray();
                                                        if(count($marquePrint) == 0 && trim($rows[25]) != ''){
                                                                // add marque
                                                                $dataMarqueEquip = [
                                                                        'marque' => trim($rows[25]),
                                                                ];
                                                                $newMarque = $this->MarqueEquipements-> newEntity();
                                                                $newMarque = $this->MarqueEquipements->patchEntity($newMarque, $dataMarqueEquip);
                                                                $marquePrintSave = $this->MarqueEquipements->save($newMarque);
                                                                $marquePrint = $marquePrintSave?[$marquePrintSave]:[];
                                                        }

                                                        $typePrint = $this->Bornes->Equipements->find()->where([
                                                                'Equipements.valeur'=>$rows[24],
                                                                'Equipements.type_equipement_id =' => $i_te_Print->id
                                                        ])->toArray();
                                                        //debug($typePrint);

                                                        if(count($typePrint) == 0 && count($marquePrint) && trim($rows[24]) != ''){
                                                                // add type print
                                                                $this->loadModel('Equipements');
                                                                $dataTypePrint = [
                                                                    'type_equipement_id' => $i_te_Print->id,
                                                                    'valeur' => trim($rows[24]),
                                                                    'marque_equipement_id' => $marquePrint[0]->id,
                                                                ];
                                                                $newTypePrint = $this-> Equipements-> newEntity();
                                                                $newTypePrint = $this-> Equipements-> patchEntity($newTypePrint, $dataTypePrint);
                                                                $typePrintSave = $this-> Equipements-> save($newTypePrint);
                                                                $typePrint = $typePrintSave?[$typePrintSave]:[];
                                                        }

                                                        $numeroSeriesPrint = $this->Bornes->NumeroSeries->find()
                                                                ->contain(['Equipements'])
                                                                ->where([
                                                                'NumeroSeries.serial_nb'=>trim($rows[26]),
                                                                'Equipements.type_equipement_id' => $i_te_Print->id
                                                        ])->toArray();
                                                        //debug($numeroSeriesPrint);
                                                        if(empty($numeroSeriesPrint) && !empty($typePrint) && trim($rows[26]) != ''){
                                                                // add serial number
                                                                $this->loadModel('NumeroSeries');
                                                                $dataNumeroSeriePrint = [
                                                                    'equipement_id' => $typePrint[0]->id,
                                                                    'serial_nb' => trim($rows[26]),
                                                                    'borne_id' => $borneId != 0? $borneId:null,
                                                                ];
                                                                $newNumeroSeriePrint = $this-> NumeroSeries-> newEntity();
                                                                $newNumeroSeriePrint = $this-> NumeroSeries-> patchEntity($newNumeroSeriePrint, $dataNumeroSeriePrint);
                                                                $numeroSeriePrintSave = $this-> NumeroSeries-> save($newNumeroSeriePrint);
                                                                $numeroSeriesPrint = $numeroSeriePrintSave?[$numeroSeriePrintSave]:[];

                                                        }elseif(!empty($numeroSeriesPrint)){
                                                                $this->loadModel('NumeroSeries');
                                                                $dataNumeroSeriePrint = [
                                                                        'borne_id' => $borneId != 0? $borneId:null,
                                                                ];
                                                                $newNumeroSeriePrint = $numeroSeriesPrint[0];
                                                                $newNumeroSeriePrint = $this-> NumeroSeries-> patchEntity($newNumeroSeriePrint, $dataNumeroSeriePrint);
                                                                $this->NumeroSeries-> save($newNumeroSeriePrint);
                                                        }

                                                        // LICENCE WINDOW
                                                        $query_Li_win = $this->Bornes->Licences->TypeLicences->find()->where(['TypeLicences.nom LIKE' => trim($rows[28])])->toArray();

                                                        if(count($query_Li_win) == 0 && trim($rows[28]) != ''){
                                                                $this->loadModel('TypeLicences');
                                                                $dataTypeLiWin = [
                                                                    'nom' => trim($rows[28])
                                                                ];
                                                                $typeLiWin = $this -> TypeLicences -> newEntity();
                                                                $typeLiWin = $this -> TypeLicences -> patchEntity($typeLiWin, $dataTypeLiWin);
                                                                $query_Li_win_save = $this->TypeLicences -> save($typeLiWin);
                                                                $query_Li_win = $query_Li_win_save?[$query_Li_win_save]:[];
                                                        }

                                                        $numeroSeriesLicenceWin = $this->Bornes->Licences->find()->where(['Licences.numero_serie LIKE'=> trim($rows[27])])->toArray();

                                                        if(count($numeroSeriesLicenceWin) == 0 && count($query_Li_win) != 0 && trim($rows[27]) != ''){
                                                                $this->loadModel('Licences');
                                                                $dataNumeroSeriesLicenceWin = [
                                                                        'numero_serie' => trim($rows[27]),
                                                                        'type_licence_id' => $query_Li_win[0]->id,
                                                                        'date_achat'=>trim($rows[29]),
                                                                        'email' => trim($rows[32]),
                                                                ];
                                                                //debug($dataNumeroSeriesLicenceWin);
                                                                $licenceWin = $this ->Licences-> newEntity();
                                                                $licenceWin = $this ->Licences-> patchEntity($licenceWin, $dataNumeroSeriesLicenceWin);                                                    
                                                                $numeroSeriesLicenceWinSave = $this->Licences->save($licenceWin);
                                                                $numeroSeriesLicenceWin = $numeroSeriesLicenceWinSave?[$numeroSeriesLicenceWinSave]:[];
                                                                if(!$numeroSeriesLicenceWinSave){
                                                                    debug($dataNumeroSeriesLicenceWin);
                                                                }
                                                        }

                                                        // LICENCE SB
                                                        $numeroSeriesLicenceSB = $this->Bornes->Licences->find()->where(['Licences.numero_serie'=> trim($rows[30])])->toArray();

                                                        if(count($numeroSeriesLicenceSB) == 0 && trim($rows[30]) != ''){
                                                                $socialBooths =  $this->Bornes->Licences->TypeLicences->find()->where(['TypeLicences.nom LIKE' => 'Social booth'])->toArray();
                                                                //debug($socialBooths);
                                                                $this->loadModel('Licences');
                                                                $dataSocialBooths = [
                                                                        'numero_serie' => trim($rows[30]),
                                                                        'type_licence_id' => is_array($socialBooths)?$socialBooths[0]->id:1,
                                                                        'date_achat'=>trim($rows[33]),
                                                                        'email' => trim($rows[32]),
                                                                        'version' => trim($rows[31]),
                                                                ];
                                                                //debug($dataSocialBooths);
                                                                $licenceSocialBooths = $this -> Licences -> newEntity();
                                                                $licenceSocialBooths = $this -> Licences -> patchEntity($licenceSocialBooths, $dataSocialBooths);
                                                                $numeroSeriesLicenceSBSave = $this->Licences -> save($licenceSocialBooths);
                                                                $numeroSeriesLicenceSB = $numeroSeriesLicenceSBSave?[$numeroSeriesLicenceSBSave]:[];
                                                                if(!$numeroSeriesLicenceSBSave){
                                                                    debug($dataSocialBooths);
                                                                }
                                                        }
                                                        //debug($numeroSeriesLicenceSB);

                                                        $idTeamViewer = str_replace(' ','',$rows[34]);
                                                        $version = trim($rows[31]);
                                                        $contrats = $this->Bornes->TypeContrats->find()->where(['TypeContrats.name LIKE'=>  trim($rows[37])])->toArray();
                                                        $commentaire = $rows[36];

                                                        $data = [
                                                                'numero' => $numBorn,
                                                                'parc_id' => !empty($parcs)?$parcs[0]->id:null,
                                                                'model_borne_id' => !empty($modelBornes)?$modelBornes[0]-> id:null,
                                                                'antenne_id' => !empty($antennes)?$antennes[0]->id:null,
                                                                'client_id' => !empty($client)?$client[0]->id:null,
                                                                'couleur_id' => !empty($couleurs)?$couleurs[0]->id:0,
                                                                'teamviewer_remotecontrol_id' => $idTeamViewer!=""?"r".$idTeamViewer:null,
                                                                'type_contrat_id' => !empty($contrats)? $contrats[0]->id:1,
                                                                'etat_borne_id' => !empty($etatBornes)?$etatBornes[0]->id:0,
                                                                'is_prette' => 1,
                                                                'adresse' => ' ',
                                                                'statut' => $status,
                                                                'marque' => $marque,
                                                                'sortie_atelier' => $date,
                                                                'numero_bl' => $numBon,
                                                                'retrofit_bornier' => $retrofitBornier,
                                                                'numero_series_bornier' => !empty($numeroSeriesBornier)?$numeroSeriesBornier[0]->id:null,
                                                                'aucun_pc' => !empty($typePC)?false:true,
                                                                'type_pc' => !empty($typePC)?$typePC[0]->id:null,
                                                                'numero_series_pc' => !empty($numeroSeriesPC)?$numeroSeriesPC[0]->id:null,
                                                                'precision_pc' => null,
                                                                'aucun_ecran' => !empty($typeEcran)?false:true,
                                                                'type_ecran' => !empty($typeEcran)?$typeEcran[0]->id:null,
                                                                'numero_series_ecran' => !empty($numeroSeriesEcran)?$numeroSeriesEcran[0]->id:null,
                                                                'precision_ecran' => null,
                                                                'aucun_appareil_photo' => !empty($typeAPhoto)?false:true,
                                                                'type_aphoto' => !empty($i_te_APhoto)?$i_te_APhoto[0]->id:null,
                                                                'model_appareil' => !empty($typeAPhoto)?$typeAPhoto[0]->id:null,
                                                                'numero_series_aphoto' => !empty($numeroSeriesAPhoto)?$numeroSeriesAPhoto[0]->id:null,
                                                                'precision_aphoto' => null,
                                                                'aucun_imprimante' => !empty($typePrint)?false:true,
                                                                'type_print' => !empty($typePrint)?$typePrint[0]->id:null,
                                                                'numero_series_print' => !empty($numeroSeriesPrint)?$numeroSeriesPrint[0]->id:null,
                                                                'type_win_licence' => !empty($query_Li_win)?$query_Li_win[0]->id:null,
                                                                'numero_series_win_licence' => !empty($numeroSeriesLicenceWin)?$numeroSeriesLicenceWin[0]->id:null,
                                                                'numero_series_sb_licence' => !empty($numeroSeriesLicenceSB)?$numeroSeriesLicenceSB[0]->id:null,
                                                                'version_installee'=> $version!=''?$version:null,
                                                                'commentaire' => $commentaire,
                                                        ];
                                                        //debug($data);

                                                        $borne = $this->Bornes->patchEntity($borne, $data);
                                                        if($this->Bornes->save($borne)){
                                                                $this->Flash->success(__("La borne numero $numBorn a été ajoutée avec succés."));
                                                                if(!empty($client)){
                                                                        $this->Flash->success(__("Borne numero $numBorn : client id : " . $client[0]->id));
                                                                }
                                                                if(empty($client) && empty($antennes)){
                                                                        $this->Flash->success(__("Borne numero $numBorn : pas de client, pas d'antenne."));
                                                                }
                                                        }else{
                                                                $this->Flash->error(__("The borne num $numBorn could not be saved. Please, try again."));
                                                        }
                                                }
                                        }
                                }
                        }
                }
        }
        
        $this->loadModel('GammesBornes');
        $gamme = $this->GammesBornes->find('list');
        $borne = $this->Bornes->newEntity();
        $this->set(compact('borne','gamme'));
    }

    public function editContrat($borneId)
    {
        $borneEntity = $this->Bornes->findById($borneId)->contain([
            'Logiciels','Antennes','Clients','Parcs','NumeroSeries','ModelBornes' => 'GammesBornes' , 'BornesAccessoires', 'Ventes', 'ParcDurees'
        ])->first();


        $parc_durees = $this->Bornes->Parcs->ParcDurees->findByParcId($borneEntity->parc_id)->find('list', ['valueField' => 'valeur']);
        $commercials = $this->Bornes->Users->find('commercial');

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $this->loadModel('ParcDurees');
            $parcDureeEntity = $this->ParcDurees->findById($data['parc_duree_id'])->first();
            $data['is_contrat_modified'] = 1; // pour distinguer les bornes qui ont un contrat modifié dans la fiche et liste
            
            if (!empty($data['contrat_debut']) && $parcDureeEntity) {
                $data['contrat_fin'] = Chronos::parse($data['contrat_debut'])->modify('+'.$parcDureeEntity->get('Duree'))->format('Y-m-d');
            }

            $borneEntity = $this->Bornes->patchEntity($borneEntity, $data, ['validate' => false]);
            if(!$borneEntity->getErrors()) {
                $this->Bornes->save($borneEntity);
                $this->Flash->success("La modification du contrat a bien été enregistrée");
                return $this->redirect(['action' => 'view', $borneId]);
            }
            
            return $this->redirect($this->referer());
        }

        if ($borneEntity->is_contrat_modified == 0 && !empty($borneEntity->ventes)) {
            $venteEntity = current($borneEntity->ventes);
            $venteInfoContrat = [
                'contrat_debut' => $venteEntity->contrat_debut,
                'parc_duree_id' => $venteEntity->parc_duree_id
            ];
            $borneEntity = $this->Bornes->patchEntity($borneEntity, $venteInfoContrat, ['validate' => false]);
        }
        $this->set(compact('borneEntity', 'parc_durees', 'borneId','commercials'));
    }

    public function editGarantie($borneId)
    {

        $garantie_durees = Configure::read('garantie_durees');
        $borneEntity = $this->Bornes->findById($borneId)->contain([
            'Logiciels','Antennes','Clients','Parcs','NumeroSeries','ModelBornes' => 'GammesBornes' , 'BornesAccessoires', 'Ventes', 'ParcDurees'
        ])->first();


        $parc_durees = $this->Bornes->Parcs->ParcDurees->findByParcId($borneEntity->parc_id)->find('list', ['valueField' => 'valeur']);
        $commercials = $this->Bornes->Users->find('commercial');

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $data['is_contrat_modified'] = 1; // pour distinguer les bornes qui ont un contrat modifié dans la fiche et liste
            $data['is_parc_vente'] = 1; // pour distinguer les bornes qui ont un contrat type vente modifié dans la fiche et liste
            
            if (!empty($data['contrat_debut'])) {
                $mois = str_replace('_mois', '', $data['garantie_duree']);
                $data['contrat_fin'] = Chronos::parse($data['contrat_debut'])->addMonth($mois)->format('Y-m-d');
            }

            $borneEntity = $this->Bornes->patchEntity($borneEntity, $data, ['validate' => false]);
            if(!$borneEntity->getErrors()) {
                $this->Bornes->save($borneEntity);
                $this->Flash->success("La modification de la garantie a bien été enregistrée");
                return $this->redirect(['action' => 'view', $borneId]);
            }
            
            return $this->redirect($this->referer());
        }

        if ($borneEntity->is_contrat_modified == 0 && !empty($borneEntity->ventes)) {
            $venteEntity = current($borneEntity->ventes);
            $venteInfoContrat = [
                'contrat_debut' => $venteEntity->contrat_debut,
                'parc_duree_id' => $venteEntity->parc_duree_id
            ];
            $borneEntity = $this->Bornes->patchEntity($borneEntity, $venteInfoContrat, ['validate' => false]);
        }
        $this->set(compact('borneEntity', 'parc_durees', 'borneId','commercials', 'garantie_durees'));
    }

    public function findWithNotations()
    {
        $bornes = $this->Bornes->find('ListForVentes')->toArray();
        // debug($bornes);
        // die();
        $body = $bornes;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }
}
