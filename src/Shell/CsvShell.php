<?php
namespace App\Shell;

use Cake\Console\Shell;
use App\Controller\Component\SpreadSheetComponent;
use App\Controller\Component\UtilitiesComponent;
use Cake\Controller\ComponentRegistry;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Traits\AppTrait;
use \Cake\Core\Configure;
use DateTime;

class CsvShell extends Shell
{
    use AppTrait;
    public $Utilities;

    public function initialize(array $config = [])
    {
        ini_set('memory_limit', '16G');
        parent::initialize($config);
        $this->loadModel('Clients');
        $this->loadModel('Reglements');
        $this->loadModel('Devis');
        $this->loadModel('DevisFactures');
        $this->loadModel('ClientContacts');
        $this->loadModel('CommentairesClients');
        $this->loadModel('Avoirs');
        $this->SpreadSheet = new SpreadSheetComponent(new ComponentRegistry);
    }

    /**
     * Fichier Seb
     * @return [type] [description]
     */
    public function synchClient2($type = 'Clients')
    {
        $this->loadModel('Payss');
        $this->out('Lancement...');
        $clients = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/clients.csv');

        if ($type == 'Prospects') {
            $clients = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/prospects.csv');
        }

        $this->out('Chargement csv...');
        $all = count($clients);
        foreach ($clients as $i => $client) {

            $item = (object) $client;
            $idSellsy = $item->A;
            $insert = [];

            if ($i != 1 && $item->D != 'Helene RIVIÈRE' && !empty(trim($item->D))) { // Helene RIVIÈRE + de 20000 identique
                $progress = round($i/$all*100, 2);
                $insert['nom'] = $item->D;
                $insert['email'] = $item->F;
                $insert['telephone'] = $item->G;
                $insert['mobile'] =  $item->H;
                $insert['siren'] = $item->AH;
                $insert['siret'] = $item->AG;
                $insert['id_in_sellsy'] = intval($idSellsy);
                $insert['delete_in_sellsy'] = false;
                $insert['client_type'] = $item->C == 'Particulier' ? 'person' : ($item->C == 'Société' ? 'pro': '');
                $insert['type_commercial'] = $item->B;
                $insert["created"]  = DateTime::createFromFormat('d/m/Y', $item->AB)->getTimestamp();

                $clientEntity= $this->Clients->findByIdInSellsy(intval($idSellsy))->first();
                if($clientEntity !== null){
                    // $clientEntity = $this->Clients->patchEntity($clientEntity, $insert, ['validate' => false]);
                    // $clientEntity = $this->Clients->save($clientEntity);
                    $this->out($clientEntity->id_in_sellsy.', p = '.$progress);
                } else {
                    $clientEntity = $this->Clients->newEntity($insert, ['validate' => false]);
                    $clientEntity = $this->Clients->save($clientEntity);
                    $this->out($clientEntity->id_in_sellsy.', n = '.$progress);
                }
            }
        }
    }

    /**
     * fichier J.Y.R
     */
    public function synchClient($type = 'Client')
    {
        $this->loadModel('Payss');
        $this->out('Lancement...');
        $clients = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/export_clients_531931593780725.csv');

        if ($type == 'Prospects') {
            $clients = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/export_prospects_531931593780966.csv');
        }

        $this->out('Chargement csv...');
        $all = count($clients)-2;
        foreach ($clients as $i => $client) {
            $item = (object) $client;
            $idSellsy = $item->A;
            $insert = [];

            if ($i != 1) {
                $progress = round($i/$all*100, 2);
                $insert['telephone'] = $item->G;
                $insert['mobile'] = $item->H;
                $insert['email'] = $item->F;

                $clientEntity= $this->Clients->findByIdInSellsy(intval($idSellsy))->first();
                if($clientEntity !== null){
                    $clientEntity = $this->Clients->patchEntity($clientEntity, $insert, ['validate' => false]);
                    $clientEntity = $this->Clients->save($clientEntity);
                    $this->out($clientEntity->id_in_sellsy.', p = '.$progress.' %,'.' mobile: '.$insert['mobile'].', tel: '.$insert['telephone']);
                } else {
                    $this->out('pass..'.', p = '.$progress.' %');
                }
            }
        }
    }

    public function synchContacts()
    {
        $this->out('Lancement...');

        $this->out('Chargement csv...');
        $contacts = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/export_contacts_531931593779326.csv'); // clients et prospects mélangés
        $this->ClientContacts->setTable('client_contacts_majs');
        
        $clientContactsByClientsSellsy = $this->ClientContacts->find()->contain('Clients')->where([
            'Clients.id_in_sellsy >' => 0, // on ne prend que les contacts des clients sellsy
            'ClientContacts.id_in_sellsy >' => 0]) // si des contacts ont été ajoutés manuellement, on y touche pas
        ;

        $this->out('Reset contacts start...');
        foreach ($clientContactsByClientsSellsy as $key => $contactEntity) {
            $this->ClientContacts->delete($contactEntity);
        };
        $this->out('Reset contacts done...');

        // 11350681
        $all = count($contacts);

        foreach ($contacts as $i => $item) {

            if ($i != 1) {

                $progress = round($i/$all*100, 2);
                $item = (object) $item;

                $typeCommercial = $item->AP;
                $idSellsy = $item->A;
                $idClientSellsy = $item->AO;

                $clientEntity = $this->Clients->findByIdInSellsy(intval($idClientSellsy))->first();

                if ($clientEntity) {

                    $insert = [];
                    $insert["nom"] = $item->C ?? null;
                    $insert["prenom"] = $item->B ?? null;
                    $insert["position"] = $item->H ?? null;
                    $insert["email"] = $item->I ?? null;
                    $insert["tel"] = $item->J ?? null;
                    $insert["mobile"] = $item->K ?? null;
                    $insert["civilite"] = $item->D ?? null;
                    $insert["id_in_sellsy"] = $idSellsy; 
                    $insert["client_id"] = $clientEntity->id ?? null; 
                    $insert["deleted_in_sellsy"] = 0;
                    $insert['created'] = !empty(trim($item->E ?? '')) ? \DateTime::createFromFormat('d/m/Y', $item->E)->getTimestamp() : null ;

                    $contactEntity = $this->ClientContacts->findByIdInSellsy($idSellsy)->first();
                    if($contactEntity){
                        $insert["id"] = $contactEntity->id;
                        $contactEntity = $this->ClientContacts->patchEntity($contactEntity, $insert, ['validate' => false]);
                        $contactEntity = $this->ClientContacts->save($contactEntity);
                        $this->out($contactEntity->id_in_sellsy.', patch = '.$progress.' %');
                    } else {
                        $contactEntity = $this->ClientContacts->newEntity($insert, ['validate' => false]);
                        $contactEntity = $this->ClientContacts->save($contactEntity);
                        $this->out($contactEntity->id_in_sellsy.', new = '.$progress.' %');
                    }
                    
                    if (!$contactEntity) {
                        debug($contactEntity);
                        die();
                    }
                }

            }
        }
    }

    public function deleteTest()
    {
        $devis = $this->Devis->find()->where(['is_in_sellsy' => 0]);
        foreach ($devis as $key => $devi) {
            $this->Devis->delete($devi);
            $this->out($devi->id);
        }
        $this->out('fin');

    }

    public function synchAdresse($type = 'Client')
    {
        $this->loadModel('Payss');
        $this->loadModel('ClientsAdresses');
        $this->out('Lancement...');
        $clients = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/export_clients_531931593780725.csv');

        if ($type == 'Prospects') {
            $clients = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/export_prospects_531931593780966.csv');
        }

        // $this->ClientsAdresses->deleteAll(['is_in_sellsy' => 1]);
        
        $this->out('Chargement csv...');
        $all = count($clients);
        foreach ($clients as $i => $client) {
            $item = (object) $client;
            $idSellsy = $item->A;
            $insert = [];

            if ($i != 1) {
                $progress = round($i/$all*100, 2);
                $clientEntity = $this->Clients->findByIdInSellsy(intval($idSellsy))->first();
                $paysEntity = $this->Payss->findByIso($item->AP)->first() ;

                $insert['nom'] = $item->AH;
                $insert['ville'] = $item->AM;
                $insert['cp'] = $item->AN;
                $insert['adresse'] = $item->AI;
                $insert['adresse_2'] = $item->AJ;
                $insert['adresse_3'] = $item->AK;
                $insert['adresse_4'] = $item->AL;
                $insert['pays_id'] = $paysEntity->id ?? null;
                $insert['client_id'] = $clientEntity->id ?? null;
                $insert['id_in_sellsy'] = $idSellsy;
                $insert['is_in_sellsy'] = 1;


                $clientAdressEntity = $this->ClientsAdresses->newEntity($insert, ['validate' => false]);
                $clientAdressEntity = $this->ClientsAdresses->save($clientAdressEntity);
                $this->out('n: '.$progress.' %');
            }
        }
    }

    public function cleanAvoirsReglements()
    {
        $reglements = $this->Reglements->find('HasAvoirs');
        $i = 1;
        foreach ($reglements as $key => $reglement) {
            $i++;

            $r = $this->Reglements->delete($reglement);
            $this->out('n° : '.$i);

        }
        $this->out('fin');
    }

    public function synchReglements()
    {
        // $this->out('Reset...');
        // foreach ($this->Reglements->findByIsInSellsy(1) as $key => $reglementEntity) {
        //     $this->Reglements->delete($reglementEntity);
        // };

        $this->out('Lancement...');
        $items = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/payments-20200703145850.csv');

        $this->out('Chargement csv...');
        $all = count($items);

        foreach ($items as $i => $item) {
            $item = (object) $item;

            if ($i != 1 && strpos($item->L, 'AVR-') !== false) {

                $moyenReglementEntity = $this->Reglements->MoyenReglements->findByName(ucfirst($item->D))->first();

                $insert = [
                    'type' => $item->A,
                    'date' => \DateTime::createFromFormat('d/m/Y', $item->B)->getTimestamp(),
                    'created' => \DateTime::createFromFormat('d/m/Y', $item->B)->getTimestamp(),
                    'sellsy_client_name' => $item->C,
                    'moyen_reglement_id' => $moyenReglementEntity->id ?? null,
                    'reference' => $item->E,
                    'montant' => $item->H,
                    'montant_restant' => $item->I,
                    'is_in_sellsy' => 1,
                    'etat' => 'confirmed'
                ];

                $findedFacture = $this->DevisFactures->findByIndent($item->L);
                if ($existingFacture = !$findedFacture->isEmpty()) {
                    $insert['client_id'] = $findedFacture->first()->client_id;
                    $insert['devis_factures']['_ids'] = $findedFacture->extract('id')->toArray();
                }

                $findedDevis = $this->DevisFactures->Devis->findByIndent($item->L);
                if ($existingDevis = !$findedDevis->isEmpty()) {
                    $insert['client_id'] = $findedDevis->first()->client_id;
                    $insert['devis']['_ids'] = $findedDevis->extract('id')->toArray();
                }

                $findedAvoir = $this->Avoirs->findByIndent($item->L);
                if ($existingAvoir = !$findedAvoir->isEmpty()) {
                    $insert['client_id'] = $findedAvoir->first()->client_id;
                    $insert['avoirs']['_ids'] = $findedAvoir->extract('id')->toArray();
                }

                // // si seulement lié au :
                if ($existingAvoir) {
                    
                    $reglementEntity = $this->Reglements->newEntity($insert, ['validate' => false]);
                    $reglementEntity = $this->Reglements->save($reglementEntity);
                    $progress = round($i/$all*100, 2);
                    $this->out($progress.' %');
                }
            }
        }

    }
    
    
    public function updateReglements()
    {

        $this->out('Lancement...');
        $items = $this->SpreadSheet->read(WWW_ROOT.'uploads/import_csv/payments-20200703145850.csv');

        $this->out('Chargement csv...');
        $all = count($items);

        foreach ($items as $i => $item) {
            $item = (object) $item;
            if($i == 1) {
                continue;
            }
            
            $this->out('ligne : ' . $i);

            $dateR = \DateTime::createFromFormat('d/m/Y', $item->B)->format('Y-m-d');
            
            $montant = str_replace([" ", ","], ["", "."], $item->H);
            $montant_restant = str_replace([" ", ","], ["", "."], $item->I);
            
            $reglement = $this->Reglements->find('all')->where([
                'Reglements.type' => $item->A, 
                'Reglements.date' => $dateR, 
                'Reglements.sellsy_client_name' => $item->C,
                'Reglements.is_in_sellsy' => 1,
            ]);
            
            if(trim($item->E)) {
                $reglement->where(['reference' => $item->E]);
            }
            
            $newData = ['montant' => $montant, 'montant_restant' => $montant_restant];
            
            $moyenReglementEntity = $this->Reglements->MoyenReglements->findByName(ucfirst($item->D))->first();

            if ($moyenReglementEntity) {
                $reglement->where(['Reglements.moyen_reglement_id' => $moyenReglementEntity->id]);
            }

            $findedFacture = $this->DevisFactures->findByIndent($item->L)->first();
            if ($findedFacture) {
                $reglement->where(['Reglements.client_id' => $findedFacture->client_id])->matching('DevisFactures')->where(['DevisFactures.indent' => $item->L]);
                $reglements = $reglement->toArray();
                if(count($reglements) == 1) {
                    $reg = $reglements[0];
                    $reglementEntity = $this->Reglements->patchEntity($reg, $newData, ['validate' => false]);
                    $reglementEntity = $this->Reglements->save($reglementEntity);
                    $progress = round($i/$all*100, 2);
                    $this->out($progress.' %');
                } else {

                    $this->out(' --------- Plusieur reglement sur ce ligne');
                    $progress = round($i/$all*100, 2);
                    $this->out($progress.' %');
                }
                continue;
            }
            
            $findedDevis = $this->DevisFactures->Devis->findByIndent($item->L)->first();
            if ($findedDevis) {
                $reglement->where(['Reglements.client_id' => $findedDevis->client_id])->matching('Devis')->where(['Devis.indent' => $item->L]);
                $reglements = $reglement->toArray();
                if(count($reglements) == 1) {
                    $reg = $reglements[0];
                    $reglementEntity = $this->Reglements->patchEntity($reg, $newData, ['validate' => false]);
                    $reglementEntity = $this->Reglements->save($reglementEntity);
                    $progress = round($i/$all*100, 2);
                    $this->out($progress.' %');
                } else {

                    $this->out(' ---------  Plusieur reglement sur ce ligne');
                    $progress = round($i/$all*100, 2);
                    $this->out($progress.' %');
                }
                continue;
            }
            
            $findedAvoir = $this->Avoirs->findByIndent($item->L)->first();
            if ($findedAvoir) {
                $reglement->where(['Reglements.client_id' => $findedAvoir->client_id])->matching('Avoirs')->where(['Avoirs.indent' => $item->L]);
                $reglements = $reglement->toArray();
                if(count($reglements) == 1) {
                    $reg = $reglements[0];
                    $reglementEntity = $this->Reglements->patchEntity($reg, $newData, ['validate' => false]);
                    $reglementEntity = $this->Reglements->save($reglementEntity);
                    $progress = round($i/$all*100, 2);
                    $this->out($progress.' %');
                } else {

                    $this->out(' ---------  Plusieur reglement sur ce ligne');
                    $progress = round($i/$all*100, 2);
                    $this->out($progress.' %');
                }
                continue;
            }
            
            $reglements = $reglement->toArray();
            if(count($reglements) == 1) {
                $reg = $reglements[0];
                $reglementEntity = $this->Reglements->patchEntity($reg, $newData, ['validate' => false]);
                $reglementEntity = $this->Reglements->save($reglementEntity);
                $progress = round($i/$all*100, 2);
                $this->out($progress.' %');
            } else {

                $this->out(' --------- Plusieur reglement sur ce ligne\ pas de client');
                $progress = round($i/$all*100, 2);
                $this->out($progress.' %');
            }
            
        }
    }
    
    

    public function synchComments($type = 'client')
    {
        $this->out('Lancement...');

        $this->out('Chargement csv...');
        $items = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/commentaires_'.$type.'s.csv');
        
        $commentaires = $this->CommentairesClients->find()->contain('Clients')->where([
            'Clients.type_commercial >' => $type, // on ne prend que les commentaires des clients sellsy
            'Clients.id_in_sellsy >' => 0, // on ne prend que les commentaires des clients sellsy
            'CommentairesClients.id_in_sellsy >' => 0]) // si des commentaires ont été ajoutés manuellement, on y touche pas
        ;

        $this->out('Reset comments start...');
        foreach ($commentaires as $key => $commentaireEntity) {
            $this->CommentairesClients->delete($commentaireEntity);
        };
        $this->out('Reset comments done...');

        // 11350681
        $all = count($items);

        foreach ($items as $i => $item) {

            if ($i != 1) {

                $progress = round($i/$all*100, 2);
                $item = (object) $item;

                $idSellsy = $item->A;
                $idClientSellsy = $item->C;

                $clientEntity = $this->Clients->findByIdInSellsy(intval($idClientSellsy))->first();

                if ($clientEntity) {

                    $insert = [];
                    $insert["id_in_sellsy"] = $idSellsy; 
                    $insert["client_id"] = $clientEntity->id ?? null; 
                    $insert["content"] = $item->G ?? null; 
                    $insert['created'] = !empty(trim($item->F ?? '')) ? \DateTime::createFromFormat('d/m/Y H:i', $item->F)->getTimestamp() : null ;

                    $commentaireEntity = $this->CommentairesClients->findByIdInSellsy($idSellsy)->first();
                    if($commentaireEntity){
                        $commentaireEntity = $this->CommentairesClients->patchEntity($commentaireEntity, $insert, ['validate' => false]);
                        $commentaireEntity = $this->CommentairesClients->save($commentaireEntity);
                        $this->out($commentaireEntity->id_in_sellsy.', patch = '.$progress.' %');
                    } else {
                        $commentaireEntity = $this->CommentairesClients->newEntity($insert, ['validate' => false]);
                        $commentaireEntity = $this->CommentairesClients->save($commentaireEntity);
                        $this->out($commentaireEntity->id_in_sellsy.', new = '.$progress.' %');
                    }
                    
                    if (!$commentaireEntity) {
                        debug($commentaireEntity);
                        die();
                    }
                }

            }
        }
    }

    public function synchEstimates($fromDate = '2020-07-02')
    {
        $this->out('Lancement...');
        if (!$this->Utilities) {
            $this->Utilities = new UtilitiesComponent(new ComponentRegistry);
        }

        $listeDevisStatus = Configure::read('devis_status');

        $items = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/export_saleestimates_531931593885454.csv');
        $this->out('Chargement csv...');

        foreach ($items as $i => $item) {

            $item = (object) $item;

            $refCommercials[] = $ref_interne = $item->N;
            $devisStatus[] = $status = $item->C;
            $client_id = $item->AQ; // colonne AQ = clientId/prospectId
            $categorieTarifaires[] = $categorieTarifaire = $item->AW;

            if ($i != 1) {

                $idSellsy = $item->AP;
                $commercialEntity = $this->findLikeCommercial($ref_interne);
                $categorieTarifaire = $this->getCatTarifaire($categorieTarifaire);
                

                $clientEntity = $this->Devis->Clients->findByIdInSellsy($client_id)->first();
                $status = $this->Utilities->searchInArray($status, $listeDevisStatus);
                $allNames[] = $ref_interne;

                $insert = [
                    'indent' => $item->A,
                    'objet' => $item->Y,
                    'nom_societe' => 'KONITYS',
                    'date_crea' => DateTime::createFromFormat('d/m/Y', $item->AO)->format('Y-m-d'), // champ "en date du"
                    'created' => DateTime::createFromFormat('d/m/Y', $item->AO)->getTimestamp(),
                    'total_ht' => $item->I,
                    'total_ttc' => $item->J,
                    'total_remise' => $item->O,
                    'date_validite' => DateTime::createFromFormat('d/m/Y', $item->Q)->format('Y-m-d'),
                    'total_tva' => $item->S,
                    'ref_commercial_id' => $commercialEntity->id ?? '',
                    'client_id' => $clientEntity->id ?? '',
                    'sellsy_client_id' => $client_id,
                    'client_nom' => $item->E,
                    'client_email' => $item->AK,
                    'client_tel' => $item->AL,
                    'echeance_date' => [DateTime::createFromFormat('d/m/Y', $item->H)->format('Y-m-d')],
                    'sellsy_public_url' => $item->AT,
                    'sellsy_doc_id' => $idSellsy,
                    'categorie_tarifaire' => $this->getCatTarifaire($item->AW ?? null),
                    'status' => $status,
                    'is_in_sellsy' => true,
                ];

                if ($insert['date_crea'] >= $fromDate) {
                    
                    // die();
                    $devisEntity = $this->Devis->findBySellsyDocId($idSellsy)->first();
                    if($devisEntity){
                        $devisEntity = $this->Devis->patchEntity($devisEntity, $insert, ['validate' => false]);
                        $devisEntity = $this->Devis->save($devisEntity);
                        $this->out($devisEntity->sellsy_doc_id.', patch');
                    } else {
                        $devisEntity = $this->Devis->newEntity($insert, ['validate' => false]);
                        $devisEntity = $this->Devis->save($devisEntity);
                        $this->out($devisEntity->sellsy_doc_id.', new');
                    }
                } else {
                    $this->out('fin..');
                    return true;
                }

                // die();
                // pr($item->N);
            }
        }


        die;        
    }

    public function synchFactures()
    {
        $this->out('Lancement...');
        if (!$this->Utilities) {
            $this->Utilities = new UtilitiesComponent(new ComponentRegistry);
        }

        $listeDevisStatus = Configure::read('devis_status');

        $items = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/export_saleinvoices_531931593885575.csv');
        $this->out('Chargement csv...');

        foreach ($items as $i => $item) {

            $item = (object) $item;

            $refCommercials[] = $ref_interne = $item->N;
            $devisStatus[] = $status = $item->C;
            $client_id = $item->AY; // colonne AQ = clientId/prospectId
            $categorieTarifaires[] = $categorieTarifaire = $item->BF;

            if ($i != 1) {

                $idSellsy = $item->AW;
                $commercialEntity = $this->findLikeCommercial($ref_interne);
                $categorieTarifaire = $this->getCatTarifaire($categorieTarifaire);
                

                $clientEntity = $this->Devis->Clients->findByIdInSellsy($client_id)->first();
                $status = $this->Utilities->searchInArray($status, $listeDevisStatus);

                $insert['indent'] = $item->A ?? null;
                $insert['objet'] = $item->AC ?? null;
                $insert['nom_societe'] = 'KONITYS';
                $insert['date_crea'] = DateTime::createFromFormat('d/m/Y', $item->AV)->format('Y-m-d');
                $insert['created'] = DateTime::createFromFormat('d/m/Y', $item->AV)->getTimestamp();
                $insert['total_ht'] = $item->J ? str_replace([" ", ","], ["", "."], $item->J) : null;
                $insert['total_ttc'] = $item->K ? str_replace([" ", ","], ["", "."], $item->K) : null;
                $insert['total_remise'] = $item->R ?? null;
                // $insert['date_validite'] = null; // absent colonne
                $insert['total_tva'] = $item->Z ?? null;
                $insert['ref_commercial_id'] = $commercialEntity->id ?? null;
                $insert['client_id'] = $clientEntity->id ?? null;
                $insert['sellsy_client_id'] = $client_id ?? null;
                $insert['client_nom'] = $item->E ?? null;
                $insert['client_email'] = $item->AR ?? null;
                $insert['client_tel'] = $item->AS ?? null;
                $insert['echeance_date'] = $item->H ?? null;
                $insert['sellsy_doc_id'] = $idSellsy ?? null;
                $insert['categorie_tarifaire'] = $this->getCatTarifaire($item->BF ?? null);
                $insert['status'] = $status;
                $insert['is_in_sellsy'] = true;

                debug($insert);
                die();

                if ($insert['date_crea'] >= '2020-07-02') {
                    
                    // die();
                    $devisFacturesEntity = $this->DevisFactures->findBySellsyDocId($idSellsy)->first();
                    if($devisFacturesEntity){
                        $devisFacturesEntity = $this->DevisFactures->patchEntity($devisFacturesEntity, $insert, ['validate' => false]);
                        $devisFacturesEntity = $this->DevisFactures->save($devisFacturesEntity);
                        $this->out($devisFacturesEntity->id_in_sellsy.', patch');
                    } else {
                        $devisFacturesEntity = $this->DevisFactures->newEntity($insert, ['validate' => false]);
                        $devisFacturesEntity = $this->DevisFactures->save($devisFacturesEntity);
                        $this->out($devisFacturesEntity->id_in_sellsy.', new');
                    }
                } else {
                    $this->out('fin..');
                    return true;
                }

                // die();
                // pr($item->N);
            }
        }


        die;        
    }


    public function majRelationClient()
    {
        $devis = $this->Devis->find()->contain(['Clients']) ->notMatching('Clients') ->where(['sellsy_client_id >' => 0, 'client_id IS' => null])->select(['id', 'sellsy_client_id', 'client_id']);
        $all = $devis->count();

        foreach ($devis as $key => $devi) {
            $progress = round($key/$all*100, 2);

            $clientEntity = $this->Clients->findByIdInSellsy($devi->sellsy_client_id)->first();
            if ($clientEntity) {
                $this->Devis->updateAll(['client_id' => $clientEntity->id], ['id' => $devi->id]);
                $this->out('saved id: '.$devi->id.', '.$progress.' %');
            }
        }

        $this->out('fin.');
        return true;

    }

    public function synchAvoirs($fromDate = '2016-07-02')
    {
        $this->out('Lancement...');
        if (!$this->Utilities) {
            $this->Utilities = new UtilitiesComponent(new ComponentRegistry);
        }

        $listeAvoirsStatuts = Configure::read('devis_avoirs_status');

        $items = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/export_salecreditnotes_531931593852163.csv');
        $this->out('Chargement csv...');

        foreach ($items as $i => $item) {

            $item = (object) $item;

            $refCommercials[] = $ref_interne = $item->R;
            $devisStatus[] = $status = $item->C;
            $client_id = $item->AL; // colonne AQ = clientId/prospectId
            $categorieTarifaires[] = $categorieTarifaire = $item->AW;

            if ($i != 1) {

                $idSellsy = $item->AK;
                $commercialEntity = $this->findLikeCommercial($ref_interne);
                $categorieTarifaire = $this->getCatTarifaire($categorieTarifaire);
                

                $clientEntity = $this->Devis->Clients->findByIdInSellsy($client_id)->first();
                $devisFacturesEntity = $this->DevisFactures->findByIndent($item->AP)->first();
                $status = $this->Utilities->searchInArray($status, $listeAvoirsStatuts);
                $allNames[] = $ref_interne;

                $insert = [];
                $insert = [
                    'indent' => $item->A,
                    'objet' => $item->T,
                    'nom_societe' => 'KONITYS',
                    'date_crea' => DateTime::createFromFormat('d/m/Y', $item->B)->format('Y-m-d'), // champ "en date du"
                    'created' => DateTime::createFromFormat('d/m/Y', $item->B)->getTimestamp(),
                    'total_ht' => $item->H,
                    'total_ttc' => $item->I,
                    'total_tva' => $item->J,
                    'ref_commercial_id' => $commercialEntity->id ?? '',
                    'client_id' => $clientEntity->id ?? '',
                    'sellsy_client_id' => $client_id,
                    'client_nom' => $item->E,
                    'client_email' => $item->AF,
                    'client_tel' => $item->AG,
                    'sellsy_public_url' => $item->AO,
                    'sellsy_doc_id' => $idSellsy,
                    'status' => $status,
                    'is_in_sellsy' => true,
                    'devis_facture_id' => $devisFacturesEntity->id ?? null,
                    'sellsy_facture_parente' => $item->AP
                ];

                if ($insert['date_crea'] >= $fromDate) {
                    
                    // die();
                    $avoirEntity = $this->Avoirs->findBySellsyDocId($idSellsy)->first();
                    if($avoirEntity){
                        $avoirEntity = $this->Avoirs->patchEntity($avoirEntity, $insert, ['validate' => false]);
                        $avoirEntity = $this->Avoirs->save($avoirEntity);
                        $this->out($avoirEntity->sellsy_doc_id.', patch');
                    } else {
                        $avoirEntity = $this->Avoirs->newEntity($insert, ['validate' => false]);
                        $avoirEntity = $this->Avoirs->save($avoirEntity);
                        $this->out($avoirEntity->sellsy_doc_id.', new');
                    }
                } else {
                    $this->out('fin..');
                    return true;
                }

                // die();
                // pr($item->N);
            }
        }


        die;        
    }

    
    public function updateMontantFactures()
    {
        $this->out('Lancement...');
        if (!$this->Utilities) {
            $this->Utilities = new UtilitiesComponent(new ComponentRegistry);
        }

        $listeDevisStatus = Configure::read('devis_status');

        $items = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/export_saleinvoices_531931593885575.csv');
        $this->out('Chargement csv...');

        foreach ($items as $i => $item) {

            $item = (object) $item;

            if ($i != 1) {

                $indent = $item->A ?? null;
                $insert = [];
                $insert['total_ht'] = $item->J ? str_replace([" ", ","], ["", "."], $item->J) : null;
                $insert['total_ttc'] = $item->K ? str_replace([" ", ","], ["", "."], $item->K) : null;

                $devisFacturesEntity = $this->DevisFactures->findByIndent($indent)->first();
                if($devisFacturesEntity){
                    $devisFacturesEntity = $this->DevisFactures->patchEntity($devisFacturesEntity, $insert, ['validate' => false]);
                    $devisFacturesEntity = $this->DevisFactures->save($devisFacturesEntity);
                    $this->out($indent . ', patch');
                }
            }
        }  
    }

    /**
     * https://trello.com/c/mDFAPmbo/969-migrer-tous-les-devis-sellsy-vers-les-documents-selfizee
     */
    public function migrerDevisSellsy()
    {
        // devis de Gregory et benjamin et Alan :
        $devis1 = $this->Devis->find()->where(['is_in_sellsy' => 1, 'ref_commercial_id IN' => [34, 33 , 87]]);

        foreach ($devis1 as $key => $devi) {
            $total_ht = $devi->total_ht; // Attention, sommes exprimées en HT (pas TTC) :
            if ($total_ht <= 2000) { 
                $type_doc_id = 4; // Selfizee Event
            } elseif ($total_ht > 2000 && $total_ht <= 4000) {
                $type_doc_id = 6; // Loc Fi
            }elseif ($total_ht > 4000) {
                $type_doc_id = 5; // vente
            }

            if (isset($type_doc_id)) {
                $this->Devis->updateAll(['type_doc_id' => $type_doc_id], ['id' => $devi->id]);
                $this->out('maj id : '.$devi->id);
            }
                
        }

        die();
    }

    /**
     * devis de "Bertrand" , "Lucie" , "Commercial selfizee" et "Sébastien":
     * @return [type] [description]
     */
    public function migrerDevisSellsy2()
    {
        $devis2 = $this->Devis->find()->where(['is_in_sellsy' => 1, 'ref_commercial_id IN' => [86, 85 , 84, 1]])->contain(['Clients']);
        foreach ($devis2 as $key => $devi) {
            
            if ($devi->client_type == 'person') {
                $type_doc_id = 1; // Selfizee Part
            } elseif ($devi->client_type == 'corporation') {

                // on recherche dans l'objet du devis. si ça contient le mot clé "jeu" ou "digitea" ou "application" on affecte à Digitea
                if ($this->Devis->find()->where([
                    'id' => $devi->id,
                    'OR' => [
                        ['objet LIKE '=> "%jeu%"],
                        ['objet LIKE '=> "%digitea%"],
                        ['objet LIKE '=> "%application%"],
                    ]
                ])->first()) {
                    $type_doc_id = 2; // Digitea
                }

                // on recherche dans l'objet du devis. si ça contient le mot clé "brandeet" "téléphone" on affiche si on affecte le devis à "Brandeet"
                elseif ($this->Devis->find()->where([
                    'id' => $devi->id,
                    'OR' => [
                        ['objet LIKE '=> "%brandeet%"],
                        ['objet LIKE '=> "%téléphone%"],
                    ]
                ])->first()) {
                    $type_doc_id = 3; // Brandeet
                }

                // les autres sont affectés à Selfizee Event
                else {
                    $type_doc_id = 4; // Selfizee Event
                }

            }

            if (isset($type_doc_id)) {
                $this->Devis->updateAll(['type_doc_id' => $type_doc_id], ['id' => $devi->id]);
                $this->out('maj id : '.$devi->id);
            }
        }

        die();
    }

    /**
     * peut importe qui est le contact commercial, si devis part = type doc Selfizee Part
     * @return [type] [description]
     */
    public function migrerDevisSellsy3()
    {
        $devisParts = $this->Devis->find()->where(['is_in_sellsy' => 1, 'ref_commercial_id >' => 0])->contain(['Clients'])->where(['Clients.client_type' => 'person']);
        foreach ($devisParts as $key => $devi) {
            $type_doc_id = 1; // Selfizee Part
            $this->Devis->updateAll(['type_doc_id' => $type_doc_id], ['id' => $devi->id]);
            $this->out('maj id : '.$devi->id);
        }
        die();
    }


    /**
     * migrer les factures sellsy vers les types de documents (comme pour devis, avec qqes ajustements)
     * @return [type] [description]
     */
    public function migrerFacturesSellsy()
    {
        // devis de Gregory et benjamin et Alan :
        $devisFactures1 = $this->DevisFactures->find()->where(['is_in_sellsy' => 1, 'ref_commercial_id IN' => [34, 33 , 87]]);

        foreach ($devisFactures1 as $key => $devisFacture) {
            $total_ht = $devisFacture->total_ht; // Attention, sommes exprimées en HT (pas TTC) :
            if ($total_ht <= 2000) { 
                $type_doc_id = 4; // Selfizee Event
            } elseif ($total_ht > 2000 && $total_ht <= 4000) {
                $type_doc_id = 6; // Loc Fi
            }elseif ($total_ht > 4000) {
                $type_doc_id = 5; // vente
            }

            if (isset($type_doc_id)) {
                $this->DevisFactures->updateAll(['type_doc_id' => $type_doc_id], ['id' => $devisFacture->id]);
                $this->out('maj id : '.$devisFacture->id);
            }
                
        }

        // devis de "Bertrand" , "Lucie" , "Commercial selfizee" et "Sébastien":
        $devis2 = $this->DevisFactures->find()->where(['is_in_sellsy' => 1, 'ref_commercial_id IN' => [86, 85 , 84, 1]])->contain(['Clients']);
        foreach ($devisFactures2 as $key => $devisFacture) {
            
            if ($devisFacture->client_type == 'person') {
                $type_doc_id = 1; // Selfizee Part
            } elseif ($devisFacture->client_type == 'corporation') {

                // on recherche dans l'objet du devis. si ça contient le mot clé "jeu" ou "digitea" ou "application" on affecte à Digitea
                if ($this->DevisFactures->find()->where([
                    'id' => $devisFacture->id,
                    'OR' => [
                        ['objet LIKE '=> "%jeu%"],
                        ['objet LIKE '=> "%digitea%"],
                        ['objet LIKE '=> "%application%"],
                    ]
                ])->first()) {
                    $type_doc_id = 2; // Digitea
                }

                // on recherche dans l'objet du devis. si ça contient le mot clé "brandeet" "téléphone" on affiche si on affecte le devis à "Brandeet"
                elseif ($this->DevisFactures->find()->where([
                    'id' => $devisFacture->id,
                    'OR' => [
                        ['objet LIKE '=> "%brandeet%"],
                        ['objet LIKE '=> "%téléphone%"],
                    ]
                ])->first()) {
                    $type_doc_id = 3; // Brandeet
                }

                // les autres sont affectés à Selfizee Event
                else {
                    $type_doc_id = 4; // Selfizee Event
                }

            }

            if (isset($type_doc_id)) {
                $this->DevisFactures->updateAll(['type_doc_id' => $type_doc_id], ['id' => $devisFacture->id]);
                $this->out('maj2 id : '.$devisFacture->id);
            }
        }

        // peut importe qui est le contact commercial, si devis part = type doc Selfizee Part        
        $devisFacturesParts = $this->DevisFactures->find()->where(['is_in_sellsy' => 1, 'ref_commercial_id >' => 0])->contain(['Clients'])->where(['Clients.client_type' => 'person']);
        foreach ($devisFacturesParts as $key => $devisFacture) {
            $type_doc_id = 1; // Selfizee Part
            $this->Devis->updateAll(['type_doc_id' => $type_doc_id], ['id' => $devisFacture->id]);
            $this->out('maj3 id : '.$devisFacture->id);
        }

        die();
    }

    /**
     * migrer les factures sellsy vers les types de documents (comme pour devis, ++ avec qqes ajustements)
     * @return [type] [description]
     */
    public function migrerFacturesSellsy2()
    {
        // $cli = $this->Clients->find()->matching('Bornes', function ($q)
            // {
            //     return $q->where(['parc_id' => 4]);
            // });
            // $cli = $this->Clients->find()
            //     ->leftJoinWith('Bornes')
            //     ->leftJoinWith('Devis')
            //     ->where([
            //         'OR' => [
            //             'Bornes.parc_id' => 4,
            //             'Devis.type_doc_id' => 5,
            //         ]
            //     ])
            //     ->group('Clients.id');
            // debug($cli ->count());
        // die();

        $devisFactures = $this->DevisFactures->find()->where(['is_in_sellsy' => 1])->contain('Clients');
        foreach ($devisFactures as $key => $devisFacture) {

            $total_ht = $devisFacture->total_ht; // Attention, sommes exprimées en HT (pas TTC) :

            // si c'est un client qui est lié au commercial "Gregory le lievre" avec un montant > à 2000 € (hors le client "Grenke" cité + haut) : on met en "Selfizee vente"
            if ($devisFacture->ref_commercial_id == 34 && $total_ht > 2000 && $devisFacture->client_id != 1853) {
                $type_doc_id = 5; // Vente
            }

            elseif ($devisFacture->client_type == 'corporation') {

                // si c'est un client pro, et qui est lié à un client qui a une location financière, on affecte à "Selfizee Loc fi
                $clientHasBornesLocFi = $this->Clients->findById($devisFacture->client_id)->leftJoinWith('Bornes')->where(['Bornes.parc_id' => 4])->first();
                $clientDevisTypeLocFi = $this->Clients->findById($devisFacture->client_id)->leftJoinWith('Devis')->where(['Devis.type_doc_id' => 5])->first();

                if ($clientHasBornesLocFi || $clientDevisTypeLocFi) {
                    $type_doc_id = 6; // Loc Fi
                }

                // si la facture est liée au commercial "Lucie" ou "Bertrand" et que c'est un client pro : on passe sur "loc event" 
                // SAUF si dans l'objet on a "brandeet" => on affecte à brandeet, et pareil si y'a "digitea" => on affecte à digitea
                if ($devisFacture->ref_commercial_id == 85 || $devisFacture->ref_commercial_id == 86) {
                    $type_doc_id = 4; // Selfizee Event

                    if ($this->DevisFactures->find()->where(['id' => $devisFacture->id, 'objet LIKE'=> "%brandeet%"])->first()) {
                        $type_doc_id = 3; // brandeet
                    } elseif ($this->DevisFactures->find()->where(['id' => $devisFacture->id, 'objet LIKE'=> "%digitea%"])->first()) {
                        $type_doc_id = 2; // digitea
                    }
                }
            }

            if (isset($type_doc_id)) {
                $this->DevisFactures->updateAll(['type_doc_id' => $type_doc_id], ['id' => $devisFacture->id]);
                $this->out('maj id : '.$devisFacture->id.', type_doc_id :'.$type_doc_id);
            }
        }

        // si c'est lié au client https://crm.konitys.fr/fr/clients/fiche/1853 => on affecte "Loc'fi"
        $devisFactures2 = $this->DevisFactures->find()->where(['is_in_sellsy' => 1])->where(['Clients.id' => 1853])->contain('Clients');
        foreach ($devisFactures2 as $key => $facture) {
            $type_doc_id = 6; // Loc Fi
            $this->DevisFactures->updateAll(['type_doc_id' => $type_doc_id], ['id' => $facture->id]);
            $this->out('maj4 id : '.$facture->id.', type_doc_id :'.$type_doc_id);
        }

        $this->out('fin');

    }


    /**
     * peut importe qui est le contact commercial, si devis part = type doc Selfizee Part
     * @return [type] [description]
     */
    public function migrerFacturesSellsy3()
    {
        $devisParts = $this->DevisFactures->find()->where(['is_in_sellsy' => 1, 'ref_commercial_id >' => 0])->contain(['Clients'])->where(['Clients.client_type' => 'person']);
        foreach ($devisParts as $key => $devi) {
            $type_doc_id = 1; // Selfizee Part
            $this->DevisFactures->updateAll(['type_doc_id' => $type_doc_id], ['id' => $devi->id]);
            $this->out('maj id : '.$devi->id);
        }
        die();
    }


    public function majReglementClientsVide()
    {
        $reglements = $this->Reglements->find()->where(['client_id IS' => NULL])->contain('Devis');
        
        foreach ($reglements as $key => $reglement) {
            if (!empty($reglement->devis)) {
                $devi = $reglement->devis[0];
                $this->Reglements->updateAll(['client_id' => $devi->client_id], ['id' => $reglement->id]);
                $this->out('maj id : '.$reglement->id);
            }
        }

        $this->out('fin');
        die();
    }

    public function majVilleClientsSellsy()
    {
        $this->loadModel('VillesFrances');
        $clients = $this->Clients->find()->where(['ville >' => 0])->select(['id', 'ville']);
        foreach ($clients as $key => $client) {
            $findedVille = $this->VillesFrances->find()->where(['ville_nom LIKE' => "$client->ville"])->select(['ville_nom'])->first();
            if ($findedVille) {
                $clientSaved = $this->Clients->updateAll(['ville' => $findedVille->ville_nom], ['id' => $client->id]);
                if ($clientSaved) {
                    $this->out($client->id.' : '.$client->ville.' : '.$findedVille->ville_nom);
                }
            }
        }
    }

    /**
     * pour les clients (prospects) qui n'ont ni devis ni factures et tous ceux qui ont une opportunité dans le pipeline "Achats - "tout-venant"; il faut les affecter à "vente" dans la qualification client
     * @return [type] [description]
     */
    public function majClientsToVente()
    {
        $clients = $this->Clients
            ->find()
            ->select(['is_vente', 'id'])
            ->notMatching('Devis')
            ->leftJoinWith('Opportunites.Pipelines')
            ->where(['Pipelines.id' => 37023])
        ;
        foreach ($clients as $key => $client) {
            $this->Clients->updateAll(['is_vente' => 1], ['id' => $client->id]);
            $this->out('maj id: '.$client->id);
        }

    }
    
    
    public function synchDevisObjet()
    {
        $this->out('Lancement...');
        $this->loadModel('Devis');

        $items = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/export_saleestimates_update_objet.csv');
        $this->out('Chargement csv...');

        foreach ($items as $i => $item) {

            $item = (object) $item;

            $indent = $item->A ?? null;
            if ($indent) {
                $devis = $this->Devis->findByIndent($indent)->first();
                
                if ($devis && ! $devis->objet) {
                    
                    $devis = $this->Devis->patchEntity($devis, ['objet' => $item->B ?? null], ['validate' => false]);
                    $this->Devis->save($devis);
                    $this->out($indent);
                }
            }
        }

    }

}
