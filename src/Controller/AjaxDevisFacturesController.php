<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

class AjaxDevisFacturesController extends AppController
{
    public function initialize(array $config = [])
    {
        parent::initialize($config);
    }

    public function isAuthorized($user)
    {
        return true;
    }

    public function saveCurrentAdress()
    {
        $body = ['status' => 'error'];
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $this->request->getSession()->write('devis_adress', $data);
            $this->Flash->success('Adresse modifié');
            return $this->redirect($this->referer());
            // $body = ['status' => 'ok', json_encode($data)];
        }

        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    
    public function saveCurrentContact()
    {
        $body = ['status' => 'error'];
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $this->request->getSession()->write('devis_client_contact_id', $data['devis_client_contact_id']);
            $this->Flash->success('Contact modifié');
            return $this->redirect($this->referer());
            // $body = ['status' => 'ok', json_encode($data)];
        }

        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    // Ajax pour changer adresse et information commercial 
    public function changeAddInfo(){
        $idCommercial = $this->request->getData('idCommercial');
        $this->loadModel('Users');
        $this->loadModel('Payss');
        $user = $this->Users->get($idCommercial, ['contain' => 'Payss']);
        $response = [
            'status' => 1,
            'user' => $user,
        ];
        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }
    
    // Ajax pour changer adresse et information commercial 
    public function deleteLineDevisFacturesProduit($idProduit = null){

        $this->loadModel('DevisFacturesProduits');
        $response = [];
        $devisAntenne = $this->DevisFacturesProduits->get($idProduit);
        if ($this->DevisFacturesProduits->delete($devisAntenne)) {
            $response['status'] = 'success';
        } else {
            $response['status'] = 0;
        }

        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }


    public function getModelDevisFactures()
    {
        $body = ['status' => 1];
        $this->loadModel('DevisFactures');
        $cat = $this->request->getQuery('cat');
        $sousCat = $this->request->getQuery('sous-cat');
        $davis = $this->DevisFactures->find('list',['valueField' => 'model_name'])->where(['is_model' => 1]);
        if($cat) {
            $davis->where(['modele_devis_categories_id' => $cat]);
        }
        if($sousCat) {
            $davis->where(['modele_devis_sous_categories_id' => $sousCat]);
        }
        $body['devis'] = $davis->toArray();

        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }
    
    
    public function refreshListFactures() {
        
        $this->loadModel('DevisFactures');
        $this->viewBuilder()->setLayout('ajax');
        $indent = $this->request->getQuery('indent');
        $client_id = $this->request->getQuery('client_id');
        $checkbox = $this->request->getQuery('checkBox');
        $devis_factures_status = Configure::read('devis_factures_status');
        $montantReglement = $this->request->getQuery('montantReglement');
        
        $factures = $this->DevisFactures->find('complete')->find('filtre',  compact('indent', 'client_id'))
                ->where(['DevisFactures.status <>' => 'paid'])
                ->toArray();
        $this->set(compact('factures', 'devis_factures_status','checkbox','montantReglement'));
    }
    
    
    public function editEtat($devis_id){

        $this->loadModel('DevisFactures');
        $this->loadModel('StatutHistoriques');
        $devis_status = Configure::read('devis_factures_status');
        $response = [];
        $devis = $this->DevisFactures->findById($devis_id)->first();
        if ($devis) {
            $statut = $this->request->getData('status');
            $devis = $this->DevisFactures->patchEntity($devis, $this->request->getData());
            if($this->DevisFactures->save($devis)){
                // original => setStatutHistorique
                $dataStat['user_id'] = $this->Auth->user('id');
                $dataStat['devis_facture_id'] = $devis_id;
                $dataStat['time'] = time();
                $dataStat['statut_document'] = $statut;
                $statutHistorique = $this->StatutHistoriques->newEntity($dataStat);
                $this->StatutHistoriques->save($statutHistorique);
                $response['status'] = 1;
                $response['devis_status'] = $devis_status[$statut];
                $response['value'] = $statut;
            } else {
                $response['status'] = 0;
            }
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }

    
    public function getDatasClientFacture($facture_id) {
        
        if ($facture_id) {
            
            $this->loadModel('DevisFactures');
            $this->loadModel('Users');
            $factureEntity = $this->DevisFactures->findById($facture_id)
                    ->contain([
                        'Clients' => ['Devis' => 'Commercial', 'DevisFactures' => 'Commercial', 'Avoirs' => 'Commercial', 'ClientContacts'],
                        'Devis', 'FactureReglements' => ['Users'], 'Client2', 'CommentairesFactures' => 'Users', 'StatutHistoriques' => 'Users', 'Commercial'
                    ])
                    -> first();
            $currentUser = $this->currentUser()->id;
            $facture_status = Configure::read('devis_factures_status');
            $devis_status = Configure::read('devis_status');
            $progression = Configure::read('devis_factures_progression');
            $commercial = $this->Users->findById(84)->first();
            
            $this->set(compact('factureEntity', 'commercial', 'facture_status', 'progression', 'devis_status', 'currentUser'));
        }
        
        $this->render('popup_late_payment');

    }
    
    public function updateProgression($facture_id) {
        
        $response = ['succes' => 0];
        if ($facture_id) {
            
            $progression = $this->request->getData('progression');
            $this->loadModel('DevisFactures');
            $factureEntity = $this->DevisFactures->findById($facture_id)->first();
            $factureEntity = $this->DevisFactures->patchEntity($factureEntity, ['progression' => $progression], ['validation' => false]);
            
            if ($this->DevisFactures->save($factureEntity)) {
                
                // add dans statut historique 
                $user_id = 84;
                if($this->Auth->user('id')) {
                    $user_id = $this->Auth->user('id');
                }
                $this->loadModel('StatutHistoriques');
                $dataStat = [];
                $dataStat['devis_facture_id'] = $facture_id;
                $dataStat['time'] = time();
                $dataStat['statut_document'] = $progression;
                $dataStat['user_id'] = $user_id;
                $statutHistorique = $this->StatutHistoriques->newEntity($dataStat);
                $this->StatutHistoriques->save($statutHistorique);
                $response = ['succes' => 1];
            }
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }
    
    public function updateDescriptionRetard($facture_id) {
        
        $response = ['succes' => 0];
        if ($facture_id) {
            
            $description_retard = $this->request->getData('description_retard');
            $this->loadModel('DevisFactures');
            $factureEntity = $this->DevisFactures->findById($facture_id)->first();
            $factureEntity = $this->DevisFactures->patchEntity($factureEntity, ['description_retard' => $description_retard], ['validation' => false]);
            
            if ($this->DevisFactures->save($factureEntity)) {
                
                $response = ['succes' => 1];
            }
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }
    
    
    public function getFactureCommentaire($commentaire_id) {
        
        $this->loadModel('CommentairesFactures');
        $commentaire = $this->CommentairesFactures->findById($commentaire_id)->first();
                
        return $this->response->withType('application/json')->withStringBody(json_encode($commentaire));
    }

    public function ajoutCommentaire($facture_id, $commentaire_id = null) {

        $this->viewBuilder()->setLayout('ajax');
        $this->loadModel('CommentairesFactures');
        $response = ['succes' => 0];
        
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $currentUser = $this->currentUser();
            $data['user_id'] = $currentUser->id;
            $data['facture_id'] = $facture_id;
            
            $commentaireEntity = $this->CommentairesFactures->newEntity($data, ['validate' => false]);

            if ($commentaire_id != null) {
                $commentaireEntity = $this->CommentairesFactures->findById($commentaire_id)->first();
            }
            
            $commentaireEntity = $this->CommentairesFactures->patchEntity($commentaireEntity, $data, ['validate' => false]);

            if(!$commentaireEntity->getErrors()) {
                $this->CommentairesFactures->save($commentaireEntity);
                
                // add dans statut historique 
                $user_id = 84;
                if($this->Auth->user('id')) {
                    $user_id = $this->Auth->user('id');
                }
                $this->loadModel('StatutHistoriques');
                $dataStat = [];
                $dataStat['devis_facture_id'] = $facture_id;
                $dataStat['time'] = time();
                $dataStat['statut_document'] = 'add_comment';
                $dataStat['commentaires_facture_id'] = $commentaireEntity->id;
                $dataStat['user_id'] = $user_id;
                $statutHistorique = $this->StatutHistoriques->newEntity($dataStat);
                $this->StatutHistoriques->save($statutHistorique);

                $response = ['succes' => 1];
            }
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }
    
    
    public function deleteCommentaire($facture_id,$commentaire_id) {

        $this->viewBuilder()->setLayout('ajax');
        $this->loadModel('CommentairesFactures');
        $response = ['succes' => 0];
        
        $this->request->allowMethod(['post', 'delete']);
        $commentaire = $this->CommentairesFactures->get($commentaire_id);
        
        if ($this->CommentairesFactures->delete($commentaire)) {
            
            // add dans statut historique 
            $user_id = 84;
            if($this->Auth->user('id')) {
                $user_id = $this->Auth->user('id');
            }
            $this->loadModel('StatutHistoriques');
            $dataStat = [];
            $dataStat['devis_facture_id'] = $facture_id;
            $dataStat['time'] = time();
            $dataStat['statut_document'] = 'delete_comment';
            $dataStat['commentaires_facture_id'] = $commentaire_id;
            $dataStat['user_id'] = $user_id;
            $statutHistorique = $this->StatutHistoriques->newEntity($dataStat);
            $this->StatutHistoriques->save($statutHistorique);
            $response = ['succes' => 1];
        }
        
        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }
    
    
    public function getContactClient($contact_id = null) {
        
        $this->loadModel('ClientContacts');
        if ($contact_id) {
            
            $contactEntity = $this->ClientContacts->findById($contact_id)-> first();
        }else {
            
            $contactEntity = $this->ClientContacts->newEntity();
        }
        
        $this->set(compact('contactEntity'));
        $this->render('popup_contact');

    }
    
    public function addContact() {
        
        $this->viewBuilder()->setLayout('ajax');
        $response = ['succes' => 0];
        $this->loadModel('ClientContacts');
        if ($this->request->is(['post', 'put'])) {
            
            $contact_id = $this->request->getData('id');
            if ($contact_id) {
                
                $contactEntity = $this->ClientContacts->findById($contact_id)-> first();
            }else {
                
                $contactEntity = $this->ClientContacts->newEntity();
            }
            
            $contactEntity = $this->ClientContacts->patchEntity($contactEntity, $this->request->getData(), ['validate' => false]);
            $this->ClientContacts->save($contactEntity);
            
            $response = ['succes' => 0];
        }
        
        return $this->response->withType('application/json')->withStringBody(json_encode($response));

    }
    
}