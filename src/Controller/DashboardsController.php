<?php

namespace App\Controller;

use Cake\Collection\Collection;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Core\Configure;

class DashboardsController extends AppController
{

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        $roles = Configure::read('roles');
        if($action == "index" || $action == "reglages" || $action == 'recherche'){
            if(array_intersect($user['profils_alias'], $roles)) {
                return true;
            }
        }

        if($action == "antennes"){
            if(in_array('antenne', $typeprofils)) {
                return true;
            }
        }
        return parent::isAuthorized($user);
    }
    
    public function index()
    {
        //==== Antennes
        $this->loadModel('Antennes');
        $nbAntennes = $this->Antennes->find()->count();

        //==== Bornes
        $this->loadModel('Bornes');
        $nbBornesParcVentes = $this->Bornes->find()->contain(['Parcs'])->where(['Parcs.id'=>1])->count();
        $nbBornesParcLocatifs = $this->Bornes->find()->contain(['Parcs'])->where(['Parcs.id'=>2])->count();

        //==== Evenements
        $this->loadModel('Evenements');
        $nbrEvenementsPro = $this->Evenements->find()->contain(['Clients'])->where(['Clients.client_type' => 'corporation'])->count();
        $nbrEvenementsParticulier = $this->Evenements->find()->contain(['Clients'])->where(['Clients.client_type' => 'person'])->count();

        //==== Factures
        $this->loadModel('Factures');
        $nbFactures = $this->Factures->find()->contain(['Users' => ['UserTypeProfils']])->count();

        //==== Contacts
        $this->loadModel('Users');
        $nbContacts = $this->Users->find()->where(['type_contact' => "1"])->count();
        $nbContactsKonitys = $this->Users->find()->where(['type_contact' => "2"])->count();
        $this->set(compact('nbFactures', 'nbAntennes', 'nbBornesParcLocatifs', 'nbBornesParcVentes', 'nbrEvenementsParticulier', 'nbrEvenementsPro', 'nbContacts', 'nbContactsKonitys'));
    }


    public function table(){
        
    }

    public function antennes(){
        $user_connected = $this->Auth->user();
        //debug($user_connected);die;
        $this->loadModel('Users');
        //$antenne = $user_connected['antenne_id'];

        //========== SYNTHESE FACTURES
        $this->loadModel('Factures');
        $factures = $this->Factures->find('all', [
            'contain' => ['Users'=>['UserTypeProfils', 'AntennesRattachees', 'UserHasAntennes', 'Profils', 'Antennes', 'Contacts'=>['Antennes']], 'EtatFactures', 'Evenements'], //'Antennes'
            'group' => 'Factures.id'
        ]);
        $antennes_rattachees = array_values($user_connected['antennes_rattachees']); //=== antenne(s) user connecté
        if(!empty($antennes_rattachees)){
            $factures->matching('Users.AntennesRattachees', function ($q) use ($antennes_rattachees){
                return $q->where(['AntennesRattachees.id IN'=>$antennes_rattachees]);
            });
        }
        $nbTotalEnAttente = 0; $nbTotalAregler = 0; $nbTotalRefuse = 0; $nbTotalRegle = 0;
        $montantTotalEnAttente = 0; $montantTotalAregler = 0; $montantTotalRefuse =0 ; $montantTotalRegle = 0;
        $facturesList = [];
        if(!empty($factures)){
            foreach ($factures as $facture){
                if(!in_array($facture->id, $facturesList)) {
                    if ($facture->etat_facture_id == 1) {
                        $montantTotalEnAttente = $montantTotalEnAttente + $facture->montant;
                        $nbTotalEnAttente = $nbTotalEnAttente + 1;
                    } elseif ($facture->etat_facture_id == 2) {
                        $montantTotalAregler = $montantTotalAregler + $facture->montant;
                        $nbTotalAregler = $nbTotalAregler + 1;
                    } elseif ($facture->etat_facture_id == 3) {
                        $montantTotalRefuse = $montantTotalRefuse + $facture->montant;
                        $nbTotalRefuse = $nbTotalRefuse + 1;
                    } elseif ($facture->etat_facture_id == 4) {
                        $montantTotalRegle = $montantTotalRegle + $facture->montant;
                        $nbTotalRegle = $nbTotalRegle + 1;
                    }
                    $facturesList [] = $facture->id;
                }
            }
        }
        $nbTotal = $nbTotalEnAttente + $nbTotalAregler + $nbTotalRefuse + $nbTotalRegle;
        $montantTotal = $montantTotalEnAttente + $montantTotalAregler + $montantTotalRefuse + $montantTotalRegle;

        //========== SYNTHESE BORNES
        $this->loadModel('Antennes');
        //$nbBorne = 0;
        $bornes = [];
        if(!empty($antennes_rattachees)){
            foreach ($antennes_rattachees as $antennes_rattachee){
                $antenne = $this->Antennes->get($antennes_rattachee, ['contain'=>['Bornes'=>['Antennes', 'ModelBornes', 'Couleurs']]]);
                //$nbBorne = $nbBorne + count($antenne->bornes);
                if(!empty($antenne->bornes)) {
                    foreach ($antenne->bornes as $borne){
                        $bornes [] = $borne;
                    }
                };
            }
            //debug($bornes);die;
        }

        //========== SYNTHESE CONTACTS
        $contacts = [];
        if(!empty($antennes_rattachees)){
            foreach ($antennes_rattachees as $antennes_rattachee){
                $antenne = $this->Antennes->get($antennes_rattachee, ['contain'=>['Users'=>['AntennesRattachees', 'Profils']]]);
                //debug($antenne);die;
                if(!empty($antenne->users)) {
                    foreach ($antenne->users as $contact){
                        $contacts [] = $contact;
                    }
                };
            }
            //debug($contacts);die;
        }

        //========== SYNTHESE EVENEMENTS
        $evenementsPro = [];
        $evenementsParticulier = [];
        $evenements = [];
        $evenementsPasses = [];
        $evenementsAvenir = [];

        //date_default_timezone_set('Indian/Antananarivo');
        date_default_timezone_set('Europe/Paris');
        $now = new Date(date("Y-m-d"));
        if(!empty($antennes_rattachees)){
            foreach ($antennes_rattachees as $antennes_rattachee){
                $antenne = $this->Antennes->get($antennes_rattachee, ['contain'=>['Evenements'=>['Clients', 'DateEvenements', 'TypeEvenements', 'Antennes']]]);
                //debug($antenne->evenements);
                if(!empty($antenne->evenements)) {
                    foreach ($antenne->evenements as $evenement){
                        $evenements [] = $evenement;
                        //debug($evenement->date_evenements);
                        if(!empty($evenement->date_evenements)) {
                            foreach ($evenement->date_evenements as $date_evenement) {
                                if($date_evenement->date_debut < $now ){
                                    if(!in_array($evenement, $evenementsPasses) && !in_array($evenement, $evenementsAvenir) ) $evenementsPasses [] = $evenement;
                                } elseif ($date_evenement->date_debut > $now ){
                                    if(!in_array($evenement, $evenementsAvenir) && !in_array($evenement, $evenementsPasses)) $evenementsAvenir [] = $evenement;
                                }
                            }
                        }
                    }
                }
            }
        }

        $collection = new Collection($evenements);
        $nbrEvenementsPro = $collection->sumOf(function ($evenement) {
            return $evenement->client->client_type == "corporation";
        });
        $nbrEvenementsParticulier = $collection->sumOf(function ($evenement) {
            return $evenement->client->client_type == "person";
        });

        $collection = new Collection($evenementsPasses);
        $nbrEvenementsPassesPro = $collection->sumOf(function ($evenement) {
            return $evenement->client->client_type == "corporation";
        });
        $nbrEvenementsPassesParticulier = $collection->sumOf(function ($evenement) {
            return $evenement->client->client_type == "person";
        });

        $collection = new Collection($evenementsAvenir);
        $nbrEvenementsAvenirPro = $collection->sumOf(function ($evenement) {
            return $evenement->client->client_type == "corporation";
        });
        $nbrEvenementsAvenirParticulier = $collection->sumOf(function ($evenement) {
            return $evenement->client->client_type == "person";
        });
        //debug($part);die;
        
        //===== Chiffre CA
        $total_CA_facture_pro = 0;
        $total_CA_facture_part = 0;
        $total_CA_accepte = 0;
        $total_CA = 0;
        if(!empty($antennes_rattachees)) {
            foreach ($antennes_rattachees as $antennes_rattachee) {
                $antenne = $this->Antennes->get($antennes_rattachee, [
                    'contain' => [
                        'Evenements' => [
                            'Clients' => function ($q) {
                                $q->contain('Documents', function ($q) {
                                    //$q->where(['Documents.step' => 'invoiced']);
                                    return $q->where(['Documents.deleted_in_sellsy IS' => false]);
                                });
                                return $q;
                            }
                        ]
                    ]
                ]);
                if (!empty($antenne->evenements)) {
                    foreach ($antenne->evenements as $evenement){
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
                        }
                    }
                }
            }
        }

        /*debug('total_CA_facture_pro : '.$total_CA_facture_pro);
        debug('total_CA_facture_part : '.$total_CA_facture_part);
        debug('total_CA_accepte : '.$total_CA_accepte);
        debug('total_CA : '.$total_CA);die;*/
        $this->set(compact('total_CA_facture_pro', 'total_CA_facture_part', 'total_CA_accepte', 'total_CA'));

        //===== STOCK
        $antennes = [];
        if(!empty($antennes_rattachees)){
            foreach ($antennes_rattachees as $antennes_rattachee){
                $antenne = $this->Antennes->get($antennes_rattachee, ['contain'=>['StockAntennes']]);
                $antennes [] = $antenne;
            }
        }
        //debug($antennes);die;

        //debug(count($evenementsPassesPro));die;
        $this->set('user_connected', $user_connected);
        $this->set(compact('facturesAll', 'facturesAregler', 'facturesEnAttente', 'facturesRefuse'));
        $this->set(compact('nbTotal', 'nbTotalEnAttente', 'nbTotalAregler', 'nbTotalRefuse', 'nbTotalRegle'));
        $this->set(compact('montantTotal', 'montantTotalEnAttente', 'montantTotalAregler', 'montantTotalRefuse', 'montantTotalRegle'));
        $this->set(compact('factures', 'bornes', 'contacts'));
        $this->set(compact('evenements', 'evenementsPro', 'evenementsParticulier'));
        $this->set(compact('evenementsAvenir', 'evenementsPasses'));
        $this->set(compact('nbrEvenementsAvenirPro', 'nbrEvenementsPassesPro', 'nbrEvenementsPassesParticulier', 'nbrEvenementsAvenirParticulier'));
        $this->set(compact('nbrEvenementsPro', 'nbrEvenementsParticulier', 'antennes'));
    }

    public function installateurs(){
        $user_connected = $this->Auth->user();
        //$this->viewBuilder()->setLayout('agent');
        $this->set('user_connected', $user_connected);
    }

    public function reglages(){
        $user_connected = $this->Auth->user();
        //$this->viewBuilder()->setLayout('agent');
        $this->set('user_connected', $user_connected);
    }
    
    public function recherche() {
        
        $data = $this->request->getData();
        if (isset($data['entity'])) {
            if ($data['entity'] == 'clients') {
                return $this->redirect(['controller' => 'Clients', 'action' => 'liste', 'key' => $data['key']]);
            }
            if ($data['entity'] == 'bornes') {
                return $this->redirect(['controller' => 'Bornes', 'action' => 'index', 'key' => $data['key']]);
            }
            if ($data['entity'] == 'devis') {
                return $this->redirect(['controller' => 'Devis', 'action' => 'index', 'keyword' => $data['key']]);
            }
            if ($data['entity'] == 'factures') {
                return $this->redirect(['controller' => 'DevisFactures', 'action' => 'index', 'keyword' => $data['key']]);
            }
        }
        $this->redirect($this->referer());
    }
}