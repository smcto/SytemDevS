<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Reglements Controller
 *
 * @property \App\Model\Table\ReglementsTable $Reglements
 *
 * @method \App\Model\Entity\Reglement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReglementsController extends AppController
{

    public function isAuthorized($user)
    {
        $isRolePermis = (bool) array_intersect($user['profils_alias'] , ['admin', 'compta']);

        if (!$isRolePermis && in_array($this->action, ['dashboardEncaissements', 'dashboardCAAnnuel', 'dashboardCommercial'])) {
            return false;
        }

        $typeprofils = $user['typeprofils'];
        if(array_intersect(['admin', 'konitys'], $typeprofils)) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function majReglements()
    {
        $d = $this->Reglements->find();
        foreach ($d as $key => $reglement) {
            $mR = $this->Reglements->MoyenReglements->findByName(ucfirst($reglement->sellsy_moyen_reglement))->first();
            if ($mR) {
                $this->Reglements->updateAll(['moyen_reglement_id' => $mR->id], ['id' => $reglement->id]);
                debug($mR->id);
            }
        }
    }   

    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $new_reglement = $this->Reglements->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $rest = $data['montant'];
            $total_facture = 0;
            $data['user_id'] = $this->Auth->user('id');
            
            if(isset($data['devis_factures'])) {
                
                foreach ($data['devis_factures'] as $key => $devis_facture) {
                    
                    if (! isset($devis_facture['id'])) {
                        
                        unset($data['devis_factures'][$key]);
                    } elseif (isset($devis_facture['_joinData']['montant_lie']) && is_numeric($devis_facture['_joinData']['montant_lie'])) {
                        
                        $total_facture += $devis_facture['_joinData']['montant_lie'];
                    }
                }
            }
            
            $data['rest'] = $rest - $total_facture;
            
            $new_reglement = $this->Reglements->patchEntity($new_reglement, $data);

            if ($this->Reglements->save($new_reglement)) {
                
                if ($new_reglement->devis_factures) {
                    foreach($new_reglement->devis_factures as $facture){
                        if($facture->total_ttc == $facture->_joinData->montant_lie){
                            //Payer en totalié
                            $facture->status = "paid";

                        }else{
                            //Partielement payé
                            $facture->status = "partial-payment";

                        }
                        $this->Reglements->DevisFactures->save($facture);

                        $user_id = 84;
                        if($this->Auth->user('id')) {
                            $user_id = $this->Auth->user('id');
                        }
                        $this->loadModel('StatutHistoriques');
                        $dataStat['devis_facture_id'] = $facture->id;
                        $dataStat['time'] = time();
                        $dataStat['statut_document'] = $facture->status;
                        $dataStat['user_id'] = $user_id;
                        $statutHistorique = $this->StatutHistoriques->newEntity($dataStat);
                        $this->StatutHistoriques->save($statutHistorique);
                    }
                }
                $this->Flash->success(__('The reglement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reglement could not be saved. Please, try again.'));
        }
        
        $key = $this->request->getQuery('key');
        $user_id = $this->request->getQuery('user_id');
        $moyen_reglement_id = $this->request->getQuery('moyen_reglement_id');
        $periode = $this->request->getQuery('periode');
        $date_threshold = $this->request->getQuery('date_threshold');
        $info_bancaire_id = $this->request->getQuery('info_bancaire_id');
        $has_facture = $this->request->getQuery('has_facture');
        $type_doc_id = $this->request->getQuery('type_doc_id');
        $genre = $this->request->getQuery('genre');
        
        $customFinderOptions = [
            'key' => $key,
            'moyen_reglement_id' => $moyen_reglement_id,
            'user_id' => $user_id,
            'periode' => $periode,
            'date_threshold' => $date_threshold,
            'info_bancaire_id' => $info_bancaire_id,
            'has_facture' => $has_facture,
            'type_doc_id' => $type_doc_id,
            'genre' => $genre
        ];
        
        $reglements = $this->Reglements->find('complete')->find('filtre', $customFinderOptions)->limit(50)/*->order(['Reglements.created' => 'DESC'])*/;

        $reglements = $this->paginate($reglements, [
            'limit' => 50,
            'sortWhitelist' => ['contact_nom', 'MoyenReglements.name_court', 'Users.prenom', 'montant'],
            'order' => ['Reglements.created' => 'DESC'],
            'sortWhitelist' => ['Reglements.created', 'contact_nom', 'MoyenReglements.name_court', 'InfosBancaires.nom', 'Users.prenom', 'montant', 'etat', 'date', 'type'],
            'contain' => ['DevisFactures'=>['FactureReglements']]
        ]);

        // debug($reglements ->toArray());
        // die();
        
        $type_reglement = Configure::read('type_reglement');
        $periodes = Configure::read('periodes');
        $etat_reglement = Configure::read('etat_reglement');
        $genres = Configure::read('genres'); 
        $commercial = $this->Reglements->Users->findById(84)->first();
        $moyen_reglements = $this->Reglements->MoyenReglements->find('list');
        $commercials = $this->Reglements->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name']);
        $infosBancaires = $this->Reglements->InfosBancaires->find('list');
        $this->loadModel('DevisTypeDocs');
        $type_docs = $this->DevisTypeDocs->find('list')->orderAsc('nom');
                
        $this->set(compact('info_bancaire_id', 'genres', 'genre', 'type_doc_id', 'type_docs', 'has_facture', 'date_threshold', 'periode', 'periodes', 'reglements', 'infosBancaires', 'commercial', 'etat_reglement', 'type_reglement', 'new_reglement', 'moyen_reglements', 'key', 'moyen_reglement_id', 'user_id', 'commercials'));
    }

    /**
     * View method
     *
     * @param string|null $id Reglement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reglement = $this->Reglements->findById($id)->find('complete')->first();

        $type_reglement = Configure::read('type_reglement');
        $etat_reglement = Configure::read('etat_reglement');
        $facture_status = Configure::read('devis_factures_status');
        $devis_avoirs_status = Configure::read('devis_avoirs_status');
        $devis_status = Configure::read('devis_status');
        $moyen_reglements = $this->Reglements->MoyenReglements->find('list')->toArray();
        $this->set(compact('reglement', 'devis_avoirs_status', 'moyen_reglements', 'type_reglement', 'etat_reglement', 'facture_status', 'devis_status'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($type = null, $type_id = null) {
        
        $reglement = $this->Reglements->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['user_id'] = $this->Auth->user('id');
            $reglement = $this->Reglements->patchEntity($reglement, $data);
            if ($this->Reglements->save($reglement)) {
                $this->Flash->success(__('The reglement has been saved.'));
                
                if($reglement->devis_factures) {
                    foreach($reglement->devis_factures as $facture){
                        if($facture->total_ttc == $facture->_joinData->montant_lie){
                            //Payer en totalié
                            $facture->status = "paid";
                        }else{
                            //Partielement payé
                            $facture->status = "partial-payment";
                        }
                        $this->Reglements->DevisFactures->save($facture);
                        
                        $user_id = 84;
                        if($this->Auth->user('id')) {
                            $user_id = $this->Auth->user('id');
                        }
                        $this->loadModel('StatutHistoriques');
                        $dataStat['devis_facture_id'] = $facture->id;
                        $dataStat['time'] = time();
                        $dataStat['statut_document'] = $facture->status;
                        $dataStat['user_id'] = $user_id;
                        $statutHistorique = $this->StatutHistoriques->newEntity($dataStat);
                        $this->StatutHistoriques->save($statutHistorique);
                    }
                }
                
                if($type == 'client' && $type_id) {
                    return $this->redirect(['controller' => 'Clients', 'action' => 'fiche', $type_id]);
                }
                
                if($type == 'factures' && $type_id) {
                    return $this->redirect(['controller' => 'DevisFactures', 'action' => 'view', $type_id]);
                }
            }
            $this->Flash->error(__('The reglement could not be saved. Please, try again.'));
        }
        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string|null $id Reglement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reglement = $this->Reglements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reglement = $this->Reglements->patchEntity($reglement, $this->request->getData());
            if ($this->Reglements->save($reglement)) {
                $this->Flash->success(__('The reglement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reglement could not be saved. Please, try again.'));
        }
        
        $type_reglement = Configure::read('type_reglement');
        $etat_reglement = Configure::read('etat_reglement');
        $client = $this->Reglements->Clients->find('list')->where(['id' => $reglement->client_id]);
        $moyen_reglements = $this->Reglements->MoyenReglements->find('list');
        $infosBancaires = $this->Reglements->InfosBancaires->find('list');

        $this->set(compact('reglement', 'infosBancaires', 'client', 'moyen_reglements', 'type_reglement', 'etat_reglement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reglement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reglement = $this->Reglements->get($id);
        if ($this->Reglements->delete($reglement)) {
            $this->Flash->success(__('The reglement has been deleted.'));
        } else {
            $this->Flash->error(__('The reglement could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    
    
    public function solderFacture($reglement_id) {
        if($reglement_id) {
            if ($this->request->is('post')) {
                $data = $this->request->getData();
                
                $reglement = $this->Reglements->findById($reglement_id)->find('complete')->first();
                $reglement = $this->Reglements->patchEntity($reglement, $data);
                
                if($this->Reglements->save($reglement)) {
                    $this->Flash->success(__('Votre facture a été soldée avec succés.'));
                    //Changer le statut des factures 
                    foreach($reglement->devis_factures as $facture){
                        if($facture->total_ttc == $facture->_joinData->montant_lie){
                            //Payer en totalié
                            $facture->status = "paid";

                        }else{
                            //Partielement payé
                            $facture->status = "partial-payment";

                        }
                        $this->Reglements->DevisFactures->save($facture);
                        
                        $user_id = 84;
                        if($this->Auth->user('id')) {
                            $user_id = $this->Auth->user('id');
                        }
                        $this->loadModel('StatutHistoriques');
                        $dataStat['devis_facture_id'] = $facture->id;
                        $dataStat['time'] = time();
                        $dataStat['statut_document'] = $facture->status;
                        $dataStat['user_id'] = $user_id;
                        $statutHistorique = $this->StatutHistoriques->newEntity($dataStat);
                        $this->StatutHistoriques->save($statutHistorique);
                    }
                } else {
                    $this->Flash->error(__('Une erreur est survenue. Veuillez réessayer'));
                }
            }
        }
        return $this->redirect($this->referer());
    }
    
    
    public function solderAvoirs($reglement_id) {
        if($reglement_id) {
            if ($this->request->is('post')) {
                $data = $this->request->getData();
                
                $reglement = $this->Reglements->findById($reglement_id)->find('complete')->first();
                
                if(! $reglement->reference) {
                    $avoir_id = @$data['avoirs'][0]['id'];
                    if($avoir_id) {
                        $this->loadModel('Avoirs');
                        $avoir = $this->Avoirs->findById($avoir_id)->first();
                        if($avoir) {
                            $data['reference'] = $avoir->indent;
                        }
                    }
                }
                $reglement = $this->Reglements->patchEntity($reglement, $data);
                
                if($this->Reglements->save($reglement)) {
                    $this->Flash->success(__('Votre avoir a été soldée avec succés.'));
                    //Changer le statut des avoirs 
                    foreach($reglement->avoirs as $avoir){
                        if($avoir->total_ttc == $avoir->_joinData->montant_lie){
                            //Payer en totalié
                            $avoir->status = "paid";

                        }else{
                            //Partielement payé
                            $avoir->status = "partial-payment";
                        }
                        $this->Reglements->Avoirs->save($avoir);
                        
                        $user_id = 84;
                        if($this->Auth->user('id')) {
                            $user_id = $this->Auth->user('id');
                        }
                        $this->loadModel('StatutHistoriques');
                        $dataStat['avoir_id'] = $avoir->id;
                        $dataStat['time'] = time();
                        $dataStat['statut_document'] = $avoir->status;
                        $dataStat['user_id'] = $user_id;
                        $statutHistorique = $this->StatutHistoriques->newEntity($dataStat);
                        $this->StatutHistoriques->save($statutHistorique);
                    }
                } else {
                    $this->Flash->error(__('Une erreur est survenue. Veuillez réessayer'));
                }
            }
        }
        return $this->redirect($this->referer());
    }
    
    public function delieDocument($reglement_id, $type, $document_id) {
        if($reglement_id != null && $type!= null && $document_id!= null) {
            if($type == 'factures') {
                $data = ['reglements_id' => $reglement_id, 'devis_factures_id' => $document_id];
                $findedRelation = $this->Reglements->ReglementsHasDevisFactures->find()->where($data)->toArray();
                if(count($findedRelation)) {
                    foreach ($findedRelation as $relation) {
                        $reglement = $this->Reglements->findById($reglement_id)->first();
                        $montant = $reglement->montant - $relation->montant_lie;
                        $reglement = $this->Reglements->patchEntity($reglement, ['montant' => $montant], ['validate' => false]);
                        $this->Reglements->save($reglement);
                        $this->Reglements->ReglementsHasDevisFactures->deleteAll(['id IN ' => [$relation->id]]);
                        $this->requestAction('/fr/factures/generation-pdf/' . $document_id);
                    }
                }
            } elseif($type == 'devis') {
                $data = ['reglements_id' => $reglement_id, 'devis_id' => $document_id];
                $findedRelation = $this->Reglements->ReglementsHasDevis->find()->where($data)->toArray();
                if(count($findedRelation)) {
                    foreach ($findedRelation as $relation) {
                        $reglement = $this->Reglements->findById($reglement_id)->first();
                        $montant = $reglement->montant - $relation->montant_lie;
                        $reglement = $this->Reglements->patchEntity($reglement, ['montant' => $montant], ['validate' => false]);
                        $this->Reglements->save($reglement);
                        $this->Reglements->ReglementsHasDevis->deleteAll(['id IN ' => [$relation->id]]);
                        $this->requestAction('/fr/devis/generation-pdf/' . $document_id);
                    }
                }
            }
            
            return $this->redirect(['action' => 'view', $reglement_id]);
            
        } else {
            $this->Flash->error(__('Une erreur est survenue. Veuillez réessayer'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function queryReglementsEncaissements($conditions = []) {
        
        $reglements = $this->Reglements->find('ToDashboard', $conditions);
        $query = $reglements->select([
            'y' => $reglements->func()->sum('Reglements.montant'),
            'x' => 'DATE_FORMAT(date, "%Y-%m")',
        ]);
        
        return $query;
    }
    
    public function queryReglementsFacturesEncaissements($conditions = []) {
        
        $reglements = $this->Reglements->ReglementsHasDevisFactures->find('ToDashboardEncaissements', $conditions);
        $query = $reglements->select([
            'y' => $reglements->func()->sum('montant_lie'),
            'x' => 'DATE_FORMAT(date, "%Y-%m")',
        ]);
        
        return $query;
    }

    public function dashboardEncaissements() 
    {
        $this->viewBuilder()->setLayout('dashboard');
        $this->loadModel('Mois');

        $annee = $this->request->getQuery('annee') ?? date('Y');
        $with_decimal = $this->request->getQuery('with_decimal');
        $annee_mois = $this->request->getQuery('annee_mois') ?? date('Y-m');
        $extractedYear = !empty($this->request->getQuery('annee_mois')) ? explode('-', $annee_mois)[0] : false;

        $from = $this->request->getQuery('from') ?? null;
        $to = $this->request->getQuery('to') ?? null;
        $moisCourantId = (int) explode('-', $annee_mois)[1];
        $moisCourant = $this->Mois->findById($moisCourantId)->first();

        $typeFiltre = "annee";
        if ($this->request->getQuery('annee_mois')) {
            $typeFiltre = "annee_mois";
        } elseif($this->request->getQuery('annee')) {
            $typeFiltre = "annee";
        } elseif($this->request->getQuery('custom_range')) {
            $typeFiltre = "custom_range";
        }

        $reglements = $this->Reglements->find()->contain(['Clients', 'ReglementsHasDevisFactures'])->select(['annee' => 'DATE_FORMAT(date, "%Y")', 'annee_mois' => 'DATE_FORMAT(date, "%Y-%m")'])->enableAutoFields(true);
        $reglements->where(['Reglements.id in (SELECT reglements_id FROM reglements_has_devis_factures)']);

        if ($typeFiltre == 'annee') {
            $reglements->having(['annee' => $annee]);
        }
        elseif ($typeFiltre == 'custom_range') {
            $reglements->where(['date >=' => $from, 'date <=' => $to]);
        } else {
            $reglements->having(['annee_mois' => $annee_mois]);
        }

        // Total
        $blocReglementsPrincipal = $this->Reglements->find();
        $totalReglements = $reglements->sumOf('montant');
        $totalProfessionnels = $reglements->match(['client.client_type' => 'corporation'])->sumOf('montant');
        $totalParticuliers = $reglements->match(['client.client_type' => 'person'])->sumOf('montant');

        // Répartition par type de paiement, (round car JS formate auto les nombres)
        $montantCB = round($reglements->match(['moyen_reglement_id' => 5])->sumOf('montant'), 2);
        $nbCB = $reglements->match(['moyen_reglement_id' => 5])->count();
        $montantVirBanc = round($reglements->match(['moyen_reglement_id' => 2])->sumOf('montant'), 2);
        $nbVirBanc = $reglements->match(['moyen_reglement_id' => 2])->count();
        $montantCheque = round($reglements->match(['moyen_reglement_id' => 1])->sumOf('montant'), 2);
        $nbCheque = $reglements->match(['moyen_reglement_id' => 1])->count();

        // répartition par banque
        $montantBPO = round($reglements->match(['info_bancaire_id' => 3])->sumOf('montant'), 2);
        $montantCIC = round($reglements->match(['info_bancaire_id' => 2])->sumOf('montant'), 2);
        $montantCA = round($reglements->match(['info_bancaire_id' => 20])->sumOf('montant'), 2);

        // Répartition par type de facture
        $reglementsDevisFactures = $this->Reglements->ReglementsHasDevisFactures->find()->contain(['Reglements','DevisFactures'])->select(['annee' => 'DATE_FORMAT(Reglements.date, "%Y")', 'annee_mois' => 'DATE_FORMAT(Reglements.date, "%Y-%m")'])->enableAutoFields(true);
        if ($typeFiltre == 'custom_range') {
            $reglementsDevisFactures->where(['Reglements.date >=' => $from, 'Reglements.date <=' => $to]);
        } elseif ($typeFiltre == 'annee') {
            $reglementsDevisFactures->having(['annee' => $annee]);
        } else {
            $reglementsDevisFactures->having(['annee_mois' => $annee_mois]);
        }
        $montantFacturesPart = $reglementsDevisFactures->match(['devis_facture.type_doc_id' => 1])->sumOf('montant_lie');
        $nbFacturesPart = $reglementsDevisFactures->match(['devis_facture.type_doc_id' => 1])->count('montant_lie');
        $montantFacturesEvent = $reglementsDevisFactures->match(['devis_facture.type_doc_id' => 4])->sumOf('montant_lie');
        $nbFacturesEvent = $reglementsDevisFactures->match(['devis_facture.type_doc_id' => 4])->count('montant_lie');
        $montantFacturesLocFi = $reglementsDevisFactures->match(['devis_facture.type_doc_id' => 6])->sumOf('montant_lie');
        $nbFacturesLocFi = $reglementsDevisFactures->match(['devis_facture.type_doc_id' => 6])->count('montant_lie');
        $montantFacturesVente = $reglementsDevisFactures->match(['devis_facture.type_doc_id' => 5])->sumOf('montant_lie');
        $nbFacturesVente = $reglementsDevisFactures->match(['devis_facture.type_doc_id' => 5])->count('montant_lie');
        $montantFacturesBrandeet = $reglementsDevisFactures->match(['devis_facture.type_doc_id' => 3])->sumOf('montant_lie');
        $nbFacturesBrandeet = $reglementsDevisFactures->match(['devis_facture.type_doc_id' => 3])->count('montant_lie');
        $montantFacturesDigitea = $reglementsDevisFactures->match(['devis_facture.type_doc_id' => 2])->sumOf('montant_lie');
        $nbFacturesDigitea = $reglementsDevisFactures->match(['devis_facture.type_doc_id' => 2])->count('montant_lie');
        
        if ($typeFiltre != 'custom_range') {
            // Courbe d'évolution des reglements par banque
            $courbeBPO = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsParBanque', ['year' => $annee, 'info_bancaire_id' => 3]), $annee);
            $courbeCIC = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsParBanque', ['year' => $annee, 'info_bancaire_id' => 2]), $annee);
            $courbeCA  = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsParBanque', ['year' => $annee, 'info_bancaire_id' => 20]), $annee);

            // Courbe d'évolution des reglements par type de client
            $reglementsTotal = $this->Mois->find('ReglementsGeneral', ['year' => $annee]);
            $courbeTotal = $this->Utilities->buildJsonCurve($reglementsTotal, $annee);
            $courbePro = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsGeneral', ['year' => $annee, 'client_type' => 'corporation']), $annee);
            $courbePart = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsGeneral', ['year' => $annee, 'client_type' => 'person']), $annee);

            // Courbe d'évolution par type de paiement
            $courbeCB = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsParBanque', ['year' => $annee, 'moyen_reglement_id' => 5]), $annee); 
            $courbeVir = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsParBanque', ['year' => $annee, 'moyen_reglement_id' => 2]), $annee);
            $courbeCheque = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsParBanque', ['year' => $annee, 'moyen_reglement_id' => 1]), $annee);

            // Baton d'évolution par type de facture
            $batonRepartitionFactureSelfizeePro = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsParTypeFacture', ['year' => $annee, 'type_doc_id' => 4])->toArray(), $annee, 0);
            $batonRepartitionFactureSelfizeePart = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsParTypeFacture', ['year' => $annee, 'type_doc_id' => 1])->toArray(), $annee, 0);
            $batonRepartitionFactureLocFi = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsParTypeFacture', ['year' => $annee, 'type_doc_id' => 6])->toArray(), $annee, 0);
            $batonRepartitionFactureVente = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsParTypeFacture', ['year' => $annee, 'type_doc_id' => 5])->toArray(), $annee, 0);
            $batonRepartitionFactureBrandeet = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsParTypeFacture', ['year' => $annee, 'type_doc_id' => 3])->toArray(), $annee, 0);
            $batonRepartitionFactureDigitea = $this->Utilities->buildJsonCurve($this->Mois->find('ReglementsParTypeFacture', ['year' => $annee, 'type_doc_id' => 2])->toArray(), $annee, 0);

            //$listeMois = $this->Mois->find('MoisUntilNow');
        } else {
            
            $mois = $this->Utilities->monthInDate($from, $to);
            
            // Courbe d'évolution des reglements par banque
            $courbeBPO = $this->Utilities->buildJsonCurve($this->queryReglementsEncaissements(['date >=' => $from, 'date <=' => $to, 'info_bancaire_id' => 3]), null, null, $mois);
            $courbeCIC = $this->Utilities->buildJsonCurve($this->queryReglementsEncaissements(['date >=' => $from, 'date <=' => $to, 'info_bancaire_id' => 2]), null, null, $mois);
            $courbeCA  = $this->Utilities->buildJsonCurve($this->queryReglementsEncaissements(['date >=' => $from, 'date <=' => $to, 'info_bancaire_id' => 20]), null, null, $mois);

            // Courbe d'évolution des reglements par type de client
            $reglementsTotal = $this->queryReglementsEncaissements(['date >=' => $from, 'date <=' => $to]); 
            $courbeTotal = $this->Utilities->buildJsonCurve($this->queryReglementsEncaissements(['date >=' => $from, 'date <=' => $to]), null, null, $mois);
            $courbePro = $this->Utilities->buildJsonCurve($this->queryReglementsEncaissements(['date >=' => $from, 'date <=' => $to, 'client_type' => 'corporation']), null, null, $mois);
            $courbePart = $this->Utilities->buildJsonCurve($this->queryReglementsEncaissements(['date >=' => $from, 'date <=' => $to, 'client_type' => 'person']), null, null, $mois);

            // Courbe d'évolution par type de paiement
            $courbeCB = $this->Utilities->buildJsonCurve($this->queryReglementsEncaissements(['date >=' => $from, 'date <=' => $to, 'moyen_reglement_id' => 5]), null, null, $mois); 
            $courbeVir = $this->Utilities->buildJsonCurve($this->queryReglementsEncaissements(['date >=' => $from, 'date <=' => $to, 'moyen_reglement_id' => 2]), null, null, $mois);
            $courbeCheque = $this->Utilities->buildJsonCurve($this->queryReglementsEncaissements(['date >=' => $from, 'date <=' => $to, 'moyen_reglement_id' => 1]), null, null, $mois);

            // Baton d'évolution par type de facture
            $batonRepartitionFactureSelfizeePro = $this->Utilities->buildJsonCurve($this->queryReglementsFacturesEncaissements(['Reglements.date >=' => $from, 'Reglements.date <=' => $to, 'type_doc_id' => 4]), null, null, $mois);
            $batonRepartitionFactureSelfizeePart = $this->Utilities->buildJsonCurve($this->queryReglementsFacturesEncaissements(['Reglements.date >=' => $from, 'Reglements.date <=' => $to, 'type_doc_id' => 1]), null, null, $mois);
            $batonRepartitionFactureLocFi = $this->Utilities->buildJsonCurve($this->queryReglementsFacturesEncaissements(['Reglements.date >=' => $from, 'Reglements.date <=' => $to, 'type_doc_id' => 6]), null, null, $mois);
            $batonRepartitionFactureVente = $this->Utilities->buildJsonCurve($this->queryReglementsFacturesEncaissements(['Reglements.date >=' => $from, 'Reglements.date <=' => $to, 'type_doc_id' => 5]), null, null, $mois);
            $batonRepartitionFactureBrandeet = $this->Utilities->buildJsonCurve($this->queryReglementsFacturesEncaissements(['Reglements.date >=' => $from, 'Reglements.date <=' => $to, 'type_doc_id' => 3]), null, null, $mois);
            $batonRepartitionFactureDigitea = $this->Utilities->buildJsonCurve($this->queryReglementsFacturesEncaissements(['Reglements.date >=' => $from, 'Reglements.date <=' => $to, 'type_doc_id' => 2]), null, null, $mois);

            //$listeMois = $this->Mois->find('MoisUntilNow');
        }
        
        $listeMois = $this->Utilities->listMois();


        $this->set(compact('extractedYear', 'with_decimal', 'moisCourant', 'from', 'to', 'typeFiltre', 'annee_mois', 'listeMois', 'annee', 'batonRepartitionFactureSelfizeePro', 'batonRepartitionFactureLocFi', 'batonRepartitionFactureVente', 'batonRepartitionFactureBrandeet', 'batonRepartitionFactureDigitea', 'batonRepartitionFactureSelfizeePart', 'courbeCB', 'courbeVir', 'courbeCheque', 'reglementsTotal', 'courbeTotal', 'courbePro', 'courbePart', 'courbeBPO', 'courbeCIC', 'courbeCA', 'reglements', 'totalReglements', 'totalProfessionnels', 'totalParticuliers', 'montantCB', 'montantVirBanc', 'montantCheque', 'nbCB', 'nbVirBanc', 'nbCheque', 'montantBPO', 'montantCIC', 'montantCA', 'montantFacturesPart', 'montantFacturesEvent', 'montantFacturesLocFi', 'montantFacturesVente', 'montantFacturesBrandeet', 'montantFacturesDigitea', 'nbFacturesPart', 'nbFacturesEvent', 'nbFacturesLocFi', 'nbFacturesVente', 'nbFacturesBrandeet', 'nbFacturesDigitea'));
    }


    public function dashboardCAAnnuel() {

        $this->viewBuilder()->setLayout('dashboard');
    }

    public function dashboardCommercial() {

        $this->viewBuilder()->setLayout('dashboard');
    }

    public function tempListeDashboards() {

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
            if($data['reglement_id'] && $data['client_id']) {
                $reglementEntity = $this->Reglements->findById($data['reglement_id'])->first();
                $clientEntity = $this->Reglements->Clients->findById($data['client_id'])->first();
                $newData = [
                    'client_id' => $clientEntity->id,
                    'client_nom' => $clientEntity->nom,
                    'client_adresse' => $clientEntity->adresse,
                    'client_adresse_2' => $clientEntity->adresse_2,
                    'client_cp' => $clientEntity->cp,
                    'client_ville' => $clientEntity->ville,
                    'client_country' => $clientEntity->country
                ];
                $reglementEntity = $this->Reglements->patchEntity($reglementEntity, $newData, ['validate' => false]);
                
                if($this->Reglements->save($reglementEntity)) {
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


}
