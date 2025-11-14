<?php
namespace App\Controller;

use Cake\Utility\Text;
use DateTime;

/**
 * Factures Controller
 *
 * @property \App\Model\Table\FacturesTable $Factures
 *
 * @method \App\Model\Entity\Facture[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FacturesController extends AppController
{

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if($action == "index"){
            if(in_array('admin', $typeprofils) || in_array('antenne', $typeprofils)) {
                return true;
            }
        }

        if($action == "add" || $action == "edit" || $action == "delete"){
            if(in_array('antenne', $typeprofils)) {
                return true;
            }
        }

        if($action == "edition" || $action == "validate" || $action == "refuse" || $action == "fournisseurs" || $action == "ficheFactureFournisseur"){
            if(array_intersect(['admin', 'konitys'], $typeprofils)) {
                return true;
            }
        }

        if($action == "getListMessage" || $action == "getMessage" || $action == "loadEquipements" || $action == "deleteFacturesProduits"){
            return true;
        }

        return parent::isAuthorized($user);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $user_connected = $this->Auth->user();
        //debug($user_connected);die;
        $antenne = $this->request->getQuery('antenne');
        $key = $this->request->getQuery('key');
        $etat = $this->request->getQuery('etat');
        $date_debut = $this->request->getQuery('date_debut');
        $date_fin = $this->request->getQuery('date_fin');

        $customFinderOptions = [
            'typeprofil_ids' => $user_connected['typeprofilskeys'],
            'typeprofils' => $user_connected['typeprofils'],
            'antennes_rattachees' => $user_connected['antennes_rattachees'],
            'user_id' => $user_connected['id'],
            //'antenne_id' => $user_connected['antenne_id'],
            'key' => $key,
            'antenne' => $antenne,
            'etat' => $etat,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin
        ];

        $this->paginate = [
            'contain' => ['Users'=>['UserTypeProfils', 'AntennesRattachees', 'UserHasAntennes', 'Profils', 'Antennes', 'Contacts'=>['Antennes']], 'EtatFactures', 'Evenements'], //'Antennes'
            'finder' => [
                'filtre' => $customFinderOptions
            ],
            'group' =>'Factures.id',
            'limit' => 20
        ];
        $factures = $this->paginate($this->Factures);
        $antennes = $this->Factures->Antennes->find('list', ['valueField' => 'ville_principale']);
        //==== SYNTHESE
        /*$fact = $this->Factures->find();
        $facturesAll = $fact->select([ 'nbTotal'=>$fact->func()->count('*'), 'montantTotal'=> $fact->func()->sum('montant')]);
        $fact = $this->Factures->find();
        $facturesEnAttente = $fact->select(['nbTotalEnAttente'=>$fact->func()->count('*'), 'montantTotalEnAttente'=> $fact->func()->sum('montant')])
                                  ->contain(['EtatFactures'=> function ($q) { return $q->where(['EtatFactures.id'=> 1]);}]);
        $fact = $this->Factures->find();
        $facturesAregler = $fact->select(['nbTotalAregler'=>$fact->func()->count('*'), 'montantTotalAregler'=> $fact->func()->sum('montant')])
                                ->contain(['EtatFactures'=> function ($q) { return $q->where(['EtatFactures.id'=> 2]);}]);
        $fact = $this->Factures->find();
        $facturesRefuse = $fact->select(['nbTotalRefuse'=>$fact->func()->count('*'), 'montantTotalRefuse'=> $fact->func()->sum('montant')])
                               ->contain(['EtatFactures'=> function ($q) { return $q->where(['EtatFactures.id'=> 3]);}]);

        //===== SYNTHESE AVEC FILTRE
        if(!empty($key)){
            $facturesAll->where(['Factures.titre LIKE' => '%'.$key.'%']);
            $facturesEnAttente->where(['Factures.titre LIKE' => '%'.$key.'%']);
            $facturesAregler->where(['Factures.titre LIKE' => '%'.$key.'%']);
            $facturesRefuse->where(['Factures.titre LIKE' => '%'.$key.'%']);
        }

        if(!empty($antenne)){
            $facturesAll->matching('Users.AntennesRattachees', function ($q) use ($antenne){
                return $q->where(['AntennesRattachees.id IN'=>$antenne]);
            });
            $facturesEnAttente->matching('Users.AntennesRattachees', function ($q) use ($antenne){
                return $q->where(['AntennesRattachees.id IN'=>$antenne]);
            });
            $facturesAregler->matching('Users.AntennesRattachees', function ($q) use ($antenne){
                return $q->where(['AntennesRattachees.id IN'=>$antenne]);
            });
            $facturesRefuse->matching('Users.AntennesRattachees', function ($q) use ($antenne){
                return $q->where(['AntennesRattachees.id IN'=>$antenne]);
            });
        }

        $antennes_rattachees = array_values($user_connected['antennes_rattachees']); //=== antenne(s) user connecté
        if(!empty($antennes_rattachees)){
            $facturesAll->matching('Users.AntennesRattachees', function ($q) use ($antennes_rattachees){
                return $q->where(['AntennesRattachees.id IN'=>$antennes_rattachees]);
            });
            $facturesEnAttente->matching('Users.AntennesRattachees', function ($q) use ($antennes_rattachees){
                return $q->where(['AntennesRattachees.id IN'=>$antennes_rattachees]);
            });
            $facturesAregler->matching('Users.AntennesRattachees', function ($q) use ($antennes_rattachees){
                return $q->where(['AntennesRattachees.id IN'=>$antennes_rattachees]);
            });
            $facturesRefuse->matching('Users.AntennesRattachees', function ($q) use ($antennes_rattachees){
                return $q->where(['AntennesRattachees.id IN'=>$antennes_rattachees]);
            });
        }
        if(!empty($etat)){
            $facturesAll->contain(['EtatFactures'=> function ($q) use($etat) { return $q->where(['EtatFactures.id'=> $etat]);}]);
            $facturesEnAttente->contain(['EtatFactures'=> function ($q) use($etat) { return $q->where(['EtatFactures.id'=> $etat]);}]);
            $facturesAregler->contain(['EtatFactures'=> function ($q) use($etat) { return $q->where(['EtatFactures.id'=> $etat]);}]);
            $facturesRefuse->contain(['EtatFactures'=> function ($q) use($etat) { return $q->where(['EtatFactures.id'=> $etat]);}]);
        }

        if(!empty($date_debut) && !empty($date_fin)){
            $facturesAll->where(function ($q) use($date_fin, $date_debut) {
                return $q->between('Factures.created', $date_debut, $date_fin);
            });
            $facturesEnAttente->where(function ($q) use($date_fin, $date_debut) {
                return $q->between('Factures.created', $date_debut, $date_fin);
            });
            $facturesAregler->where(function ($q) use($date_fin, $date_debut) {
                return $q->between('Factures.created', $date_debut, $date_fin);
            });
            $facturesRefuse->where(function ($q) use($date_fin, $date_debut) {
                return $q->between('Factures.created', $date_debut, $date_fin);
            });
        }

        $facturesAll = $facturesAll->first();
        $facturesEnAttente = $facturesEnAttente->first();
        $facturesAregler = $facturesAregler->first();
        $facturesRefuse = $facturesRefuse->first();
        //==== TOTAT RECUES  (Ajuster le total )
        $facturesAll->nbTotal = $facturesEnAttente->nbTotalEnAttente + $facturesAregler->nbTotalAregler + $facturesRefuse->nbTotalRefuse;
        $facturesAll->montantTotal = $facturesEnAttente->montantTotalEnAttente + $facturesAregler->montantTotalAregler + $facturesRefuse->montantTotalRefuse;
        */

        //==== SYNTHESE
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
        /*debug($facturesEnAttente." => ".$nbTotalEnAttente);
        debug($facturesAregler." => ".$nbTotalAregler);
        debug($facturesRefuse." => ".$nbTotalRefuse);die;*/

        $etatFactures = $this->Factures->EtatFactures->find('list', ['valueField' => 'nom']);
        $this->set(compact('factures', 'user', 'user_connected', 'etat', 'antenne', 'antennes', 'key', 'date_debut', 'date_fin', 'etatFactures'));
        $this->set(compact('facturesAll', 'facturesAregler', 'facturesEnAttente', 'facturesRefuse'));
        $this->set(compact('nbTotal', 'nbTotalEnAttente', 'nbTotalAregler', 'nbTotalRefuse', 'nbTotalRegle'));
        $this->set(compact('montantTotal', 'montantTotalEnAttente', 'montantTotalAregler', 'montantTotalRefuse', 'montantTotalRegle'));
    }

    /**
     * View method
     *'
     * @param string|null $id Facture id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $facture = $this->Factures->get($id, [
            'contain' => ['Antennes']
        ]);

        $this->set('facture', $facture);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user_connected = $this->Auth->user();
        //debug($user_connected);die;
        $facture = $this->Factures->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            //debug($data);die;
            date_default_timezone_set('Europe/Paris');
            $now = date("Y-m-d H:i:s");
            $data['created'] = $now;
            $data['etat_facture_id'] = 1; // en attente
            //debug($data['created']);die;

            if (!empty($data['facture_file']['name'])) {
                $extension = pathinfo($data['facture_file']['name'], PATHINFO_EXTENSION);
                $newFilename = Text::uuid() . "." . $extension;
                $path = 'uploads/factures/';
                if (move_uploaded_file($data['facture_file']['tmp_name'], PATH_FACTURES . $newFilename)) {
                    $data['nom_fichier'] = $newFilename;
                    $data['nom_origine'] = $data['facture_file']['name'];
                }
            }

            $facture = $this->Factures->patchEntity($facture, $data);
            if ($this->Factures->save($facture)) {
                $this->Flash->success(__('The facture has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The facture could not be saved. Please, try again.'));
        }
        $antennes = $this->Factures->Antennes->find('list', ['valueField' => 'ville_excate']);
        //$installateurs = $this->Factures->Installateurs->find('list', ['limit' => 200]);
        $evenements = [];
        $antennes_rattachees = array_values($user_connected['antennes_rattachees']);
        if(!empty($antennes_rattachees)){
            foreach ($antennes_rattachees as $antennes_rattachee){
                $antenne = $this->Factures->Users->Antennes->get($antennes_rattachee, ['contain'=>['Evenements']]);
                if(!empty($antenne->evenements)) {
                    foreach ($antenne->evenements as $evenement){
                        $evenements [$evenement->id] = $evenement->nom_event;
                    }
                }
            }
            //debug($evenements);die;
        }

        $this->loadModel('TypeEquipements');
        $this->loadModel('Fournisseurs');
        $this->loadModel('Parcs');
        $typeEquipements = $this->TypeEquipements->find('list', ['valueField' => 'nom']);
        $fournisseurs = $this->Fournisseurs->find('list', ['valueField' => 'nom']);
        $parcs = $this->Parcs->find('list', ['valueField' => 'nom']);

        $this->set(compact('facture', 'antennes', 'user_connected', 'evenements', 'typeEquipements', 'fournisseurs', 'parcs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Facture id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user_connected = $this->Auth->user();
        $facture = $this->Factures->get($id, [
            'contain' => ['FacturesProduits', 'Users'=>['Contacts'=>['Antennes']], 'Antennes']
        ]);
        $facture_name_old = $facture->nom_fichier;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            date_default_timezone_set('Europe/Paris');
            $now = date("Y-m-d H:i:s");
            $data['modified'] = $now;
            //debug($data);die;
            if (!empty($data['facture_file']['name'])) {
                $extension = pathinfo($data['facture_file']['name'], PATHINFO_EXTENSION);
                $newFilename = Text::uuid() . "." . $extension;
                if (move_uploaded_file($data['facture_file']['tmp_name'], PATH_FACTURES . $newFilename)) {
                    $data['nom_fichier'] = $newFilename;
                    $data['nom_origine'] = $data['facture_file']['name'];
                    unlink(PATH_FACTURES.$facture_name_old);
                }
            }
            $facture = $this->Factures->patchEntity($facture, $data);

            if ($this->Factures->save($facture)) {
                $this->Flash->success(__('The facture has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The facture could not be saved. Please, try again.'));
        }
        $antennes = $this->Factures->Antennes->find('list', ['valueField' => 'ville_excate']);
        //$installateurs = $this->Factures->Installateurs->find('list', ['limit' => 200]);
        $evenements = [];
        $antennes_rattachees = array_values($user_connected['antennes_rattachees']);
        if(!empty($antennes_rattachees)){
            foreach ($antennes_rattachees as $antennes_rattachee){
                $antenne = $this->Factures->Users->Antennes->get($antennes_rattachee, ['contain'=>['Evenements']]);
                if(!empty($antenne->evenements)) {
                    foreach ($antenne->evenements as $evenement){
                        $evenements [$evenement->id] = $evenement->nom_event;
                    }
                }
            }
            //debug($evenements);die;
        }
        
        $this->loadModel('TypeEquipements');
        $this->loadModel('Fournisseurs');
        $this->loadModel('Parcs');
        $typeEquipements = $this->TypeEquipements->find('list', ['valueField' => 'nom']);
        $equipements = $this->TypeEquipements->Equipements->find('list', ['valueField' => 'valeur']);
        $parcs = $this->Parcs->find('list', ['valueField' => 'nom']);
        $fournisseurs = $this->Fournisseurs->find('list', ['valueField' => 'nom']);

        $this->set(compact('facture', 'antennes', 'user_connected', 'evenements', 'fournisseurs', 'typeEquipements', 'equipements', 'parcs'));
    }

    public function edition($id = null)
    {
        $user_connected = $this->Auth->user();
        $facture = $this->Factures->get($id, [
            'contain' => ['Users'=>['Antennes']], 'Antennes'
        ]);
        $facture_name_old = $facture->nom_fichier;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['modified'] = date("Y-m-d H:i:s");
            //debug($data);die;
            if (!empty($data['facture_file']['name'])) {
                $extension = pathinfo($data['facture_file']['name'], PATHINFO_EXTENSION);
                $newFilename = Text::uuid() . "." . $extension;
                if (move_uploaded_file($data['facture_file']['tmp_name'], PATH_FACTURES . $newFilename)) {
                    $data['nom_fichier'] = $newFilename;
                    $data['nom_origine'] = $data['facture_file']['name'];
                    unlink(PATH_FACTURES.$facture_name_old);
                }
            }
            $facture = $this->Factures->patchEntity($facture, $data);
            if ($this->Factures->save($facture)) {
                $this->Flash->success(__('The facture has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The facture could not be saved. Please, try again.'));
        }
        $etatFactures = $this->Factures->EtatFactures->find('list', ['valueField' => 'nom']);
        $messageTypeFactures = $this->Factures->MessageTypeFactures->find('list', ['valueField' => 'titre'])->where(['etat_facture_id'=>$facture->etat_facture_id]);
        $antennes = $this->Factures->Antennes->find('list', ['valueField' => 'ville_excate']);
        //$installateurs = $this->Factures->Installateurs->find('list', ['limit' => 200]);
        $this->set(compact('facture', 'antennes', 'user_connected', 'etatFactures', 'messageTypeFactures'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Facture id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $facture = $this->Factures->get($id);
        if ($this->Factures->delete($facture)) {
            $this->Flash->success(__('The facture has been deleted.'));
        } else {
            $this->Flash->error(__('The facture could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function validate($id){
        $facture = $this->Factures->get($id , ['contain'=>['Users']]);
        $facture->etat = 'accepte';
        if ($this->Factures->save($facture)) {
            return $this->redirect(['controller' => 'Factures', 'action' => 'index']);
            $this->Flash->success(__('Facture validé.'));
        }
    }

    public function refuse($id){
        $facture = $this->Factures->get($id , ['contain'=>['Users']]);
        $facture->etat = 'refuse';
        if ($this->Factures->save($facture)) {
            return $this->redirect(['controller' => 'Factures', 'action' => 'index']);
            $this->Flash->success(__('Facture refusé.'));
        }
    }

    public function getListMessage()
    {
        $data = $this->request->getData();
        //debug($data);die;
        $messages = $this->Factures->MessageTypeFactures->find('list', ['valueField' => 'titre'])
            ->where(['etat_facture_id =' => $data['etat_facture_id']]);
        //echo json_encode($clients);
        $this->set('messages', $messages);
    }

    public function getMessage()
    {
        $data = $this->request->getData();
        //debug($data);die;
        $message = $this->Factures->MessageTypeFactures->find('list', ['valueField' => 'message'])
            ->where(['id =' => $data['message_type_id']]);
        //echo json_encode($clients);
        $this->set('message', $message);
    }

    public function loadEquipements($type_equipement_id)
    {
        $this->loadModel('Equipements');
        $equipements = $this->Equipements->findByTypeEquipementId($type_equipement_id)->find('list', ['valueField' => 'valeur']);
        $body = $equipements;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function fournisseurs()
    {
        $factures = $this->Factures->find('fournisseurs');
        $titre = $this->request->getQuery('titre');
        $fournisseur_id = $this->request->getQuery('fournisseur_id');

        if ($titre) {
            $factures->where(['titre' => $titre]);
        }
        
        if ($fournisseur_id) {
            $factures->where(['fournisseur_id' => $fournisseur_id]);
        }

        $factures = $this->paginate($factures, ['limit' => 50]);
        $fournisseurs = $this->Factures->Fournisseurs->find('list', ['valueField' => 'nom']);

        $this->set(compact('factures', 'titre', 'fournisseur_id', 'fournisseurs'));
    }

    public function ficheFactureFournisseur($id)
    {
        $facture = $this->Factures->find()
            ->contain(['Fournisseurs'])
            ->where(['Factures.id' => $id])->first()
        ;

        // récap
        $groupedEquipements = $this->Factures->FacturesProduits
            ->findByFactureId($id)
            ->find('GroupByEquipements')
        ;
        // debug($groupedEquipements->toArray());
        // die();

        // détail
        $groupedTypeEquipements = $this->Factures->FacturesProduits
            ->findByFactureId($id)
            ->find('GroupByTypeEquipements')
        ;

        // debug($groupedTypeEquipements ->toArray());
        // die();

        $this->set(compact('facture', 'facturesProduits', 'groupedEquipements', 'groupedTypeEquipements'));
    }

    public function deleteFacturesProduits($id)
    {
        $this->loadModel('FacturesProduits'); // Plugin.TableRegistry
        $entity = $this->FacturesProduits->get($id);
        $result = $this->FacturesProduits->delete($entity);
        $body = ['status' => 'success'];
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }
}
