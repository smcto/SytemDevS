<?php
namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\Datasource\ModelAwareTrait;

class ImportComponent extends Component
{
    use ModelAwareTrait;

    public $components = ['SpreadSheet'];
    public $controller;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->loadModel('Devis');
        $this->controller = $this->getController();
    }

    public function import()
    {
        // $data = [
        //     'lol' => 45,
        //     'mdf' => 78
        // ];

        // debug(array_keys($data));

        // die();
        // $devis = $this->controller->request->getSession()->read('devis');
        // $devis['echeance_date'] = (['2020-07-16', '2020-07-17', '2020-07-18']);
        // $devis = $this->Devis->newEntity($devis);
        // // $devis = $this->Devis->save($devis);
        // debug(($this->Devis->find()->where(['Devis.id' => 1])->first()->echeance_date));
        // die();

        // $q = $this->Devis->find()
        //     ->select(['id', 'indent' => 'count(*)'])
        //     ->group(['indent'])
        //     ->having(['count(*) > ' => 1])
        //     ->combine('id', 'id')
        // ;
        // debug($q ->toArray());
        // die();

        $this->loadComponent('SpreadSheet');
        // $name = "Sebastien Mahé";
        $listeDevisStatus = Configure::read('devis_status');

        // $this->controller->request->getSession()->delete('ref_com');
        // die();
        // $refCom = array_values($this->controller->request->getSession()->read('ref_com'));
        // debug($refCom);
        // // die();
        // foreach ($refCom as $key => $name) {
        //     if (in_array($name, ['Bertrand Lecollinet', 'Bertrand Le Collinet'])) {
        //         $name = 'Le Collinet Bertrand';
        //     } elseif (in_array($name, ['Sebastien Mahé', 'M Sebastien Mahé'])) {
        //         $name = 'Mahé Sébastien';
        //     } elseif (in_array($name, ['M La Team Selfizee', 'La Team Selfizee'])) {
        //         $name = 'La Team Selfizee';
        //     }elseif (in_array($name, ["Lucie L'Hôtelier"])) {
        //         $name = "L'Hôtellier Lucie";
        //     }
        //     $names = explode(' ', $name);
        //     $name = end($names);
        //     if ($key == 5) {
        //         // debug($names);
        //     }

        //     $findedCommercial = $this->Devis->Commercial->find('LikeName', ['term' => $name])->first();
        //     if (!is_null($findedCommercial) && !in_array($findedCommercial->get('FullName'), ["Laura Kerzil", "Caroline Barraja"])) {
        //         $commercial[] = $this->Devis->Commercial->find('LikeName', ['term' => $name])->first()->get('FullName');
        //     } else {
        //         $commercial[] = '';
        //     }
        // }

        // // debug($this->Devis->Commercial->find('LikeName', ['term' => 'Mahé Sébastien'])->first());
        // debug($commercial);
        // die();

        $devisCsv = $this->SpreadSheet->read(ROOT.DS.'docs'.DS.'estimates.csv');
        // foreach ($devisCsv as $key => $devisCol) {
        //     $refCommercials[] = $ref_interne = $devisCol['N'];
        // }

        // debug(array_unique($refCommercials));
        // if (($refCom = $this->controller->request->getSession()->read('ref_com')) === null) {
        //     $refCom = array_unique($refCommercials);
        //     $this->controller->request->getSession()->write('ref_com', $refCom);
        // }
        // die();

        $this->Devis->deleteAll(['is_in_sellsy' => 1]);
        foreach ($devisCsv as $i => $devisCol) {
            $refCommercials[] = $ref_interne = $devisCol['N'];
            $devisStatus[] = $status = $devisCol['C'];
            $client_id = $devisCol['AQ']; // colonne AQ = clientId/prospectId
            $categorieTarifaires[] = $categorieTarifaire = $devisCol['AW'];
            // if ($i <= 10) {
            //     debug($devisCol);
            // }
            // if ($i <= 10 /*&& $i != 1*/) {
            if (true) {

                $commercialEntity = $this->findLikeCommercial($ref_interne);
                $categorieTarifaire = $this->getCatTarifaire($categorieTarifaire);
                

                $clientEntity = $this->Devis->Clients->findByIdInSellsy($client_id)->first();
                $status = $this->Utilities->searchInArray($status, $listeDevisStatus);
                $allNames[] = $ref_interne;

                if ($i != 1) { // echapper titre des colonnes
                    $data = [
                        'indent' => $devisCol['A'],
                        'objet' => $devisCol['Y'],
                        'nom_societe' => 'KONITYS',
                        'date_crea' => DateTime::createFromFormat('d/m/Y', $devisCol['AO'])->format('Y-m-d'), // champ "en date du"
                        'created' => FrozenTime::parse(DateTime::createFromFormat('d/m/Y', $devisCol['B'])->format('Y-m-d')),
                        'total_ht' => $devisCol['I'],
                        'total_ttc' => $devisCol['J'],
                        'total_remise' => $devisCol['O'],
                        'date_validite' => DateTime::createFromFormat('d/m/Y', $devisCol['Q'])->format('Y-m-d'),
                        'total_tva' => $devisCol['S'],
                        'ref_commercial_id' => $commercialEntity->id ?? '',
                        'client_id' => $clientEntity->id ?? '',
                        'sellsy_client_id' => $client_id,
                        'client_nom' => $devisCol['E'],
                        'client_email' => $devisCol['AK'],
                        'client_tel' => $devisCol['AL'],
                        'echeance_date' => [DateTime::createFromFormat('d/m/Y', $devisCol['H'])->format('Y-m-d')],
                        'sellsy_public_url' => $devisCol['AT'],
                        'sellsy_doc_id' => $devisCol['AP'],
                        'status' => $status,
                        'is_in_sellsy' => true,
                    ];

                    extract($data);
                    $fields = array_keys($data);
                    $this->Devis->query()->insert($fields)->values($data)->execute();
                }

                // die();
                // pr($devisCol['N']);
            }
        }


        // if (($refCom = Cache::read('ref_com')) === false) {
        //     $refCom = array_unique($refCommercials);
        //     Cache::write('ref_com', $refCom);
        // }
    
        // if (($allDevisStatus = Cache::read('devis_status')) === false) {
        //     $allDevisStatus = array_unique($devisStatus);
        //     Cache::write('devis_status', $allDevisStatus);
        // }

        // debug($allDevisStatus);

        die;        
    }

    public function synchClient()
    {
        $clients = $this->SpreadSheet->read(ROOT.DS.'docs'.DS.'export_clients_531931593780725.csv');

        foreach ($clients as $i => $client) {
            if ($i != 1) {
                debug($client);
                die();
            }
        }

    }
}
?>