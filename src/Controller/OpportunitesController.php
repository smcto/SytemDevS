<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Console\ShellDispatcher;
use Cake\Core\Configure;
use Cake\ORM\Query;


/**
 * Opportunites Controller
 *
 * @property \App\Model\Table\OpportunitesTable $Opportunites
 *
 * @method \App\Model\Entity\Opportunite[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OpportunitesController extends AppController
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

    public function  getInfoOppInSellsy($id){
        //$this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        /*$this->loadComponent('SellsyCurl');
        $request = array(
            'method' => 'Opportunities.getOne',
            'params' => array(
                'id' => $id
            ),
        );
        $contact = $this->SellsyCurl->requestApi($request)->response;
        debug($contact);
        die;*/
        $shell = new ShellDispatcher();
        $output = $shell->run(['cake','sellsy', 'getOpportinuteSellsy',$id]);
        debug($output);
        die;
    }

    public function pipeline($idPipe = 37022){
        $this->viewBuilder()->setLayout('pipeline');
        $currentPipe = $this->Opportunites->Pipelines->get($idPipe);

        $countOpp = $this->Opportunites->find()
                            ->where(['pipeline_id' => $idPipe])
                            ->count();
        $countOppHot = $this->Opportunites->find()
                            ->where(['pipeline_id' => $idPipe,'opportunite_statut_id' => 7])
                            ->count();

        $etapes = $this->Opportunites->PipelineEtapes->find()
                            ->where(['PipelineEtapes.pipeline_id' => $idPipe])
                            ->order(['PipelineEtapes.rank' => 'ASC']);
        //$limite = $countEtape*50;

        /*$etapePipelines = $this->Opportunites->PipelineEtapes->find()
                                ->contain(['Opportunites' => [
                                        'Clients',
                                        'OpportuniteCommentaires']
                                ])
                                
                                ->order(['PipelineEtapes.rank' => 'ASC'])
                                ->where(['PipelineEtapes.pipeline_id' => $idPipe]);*/

        /**
         * Faire une boucle pour avoir le count et liste des 15 opportunités par Etape 
         * Et faire une pagiantion pour ne pas alourdir le premier chargement
         */
        $allEtapes = array();
        foreach($etapes as $etape){
            $oneEtape = $this->getOneEtape($etape);
            array_push($allEtapes, $oneEtape);
        }

        $pipelines = $this->Opportunites->Pipelines->find('all');
        $this->set(compact('idPipe','pipelines','currentPipe','countOpp','countOppHot','allEtapes'));
    }

    protected function getOneEtape($etape, $page = 1, $limit = 15){
        $oneAll = array();
            $oneAll['etape'] = $etape;
            $oneAll['opportunites'] = $this->Opportunites->find()
                                            ->contain(['Clients','OpportuniteCommentaires','OpportuniteStatuts','LinkedDocs'])
                                            ->where(['Opportunites.pipeline_etape_id' => $etape->id])
                                            ->order(['Opportunites.numero'=>'DESC'])
                                            ->limit($limit)
                                            ->page($page);
            $count = $this->Opportunites->find()
                        ->where(['pipeline_etape_id' => $etape->id])
                        ->count();
            $oneAll['count'] = $count;
            $oneAll['page'] = $page;
            $oneAll['nbr_page'] = ceil($count / $limit);
        return $oneAll;
    }

    public function listOppEtape($idEtape, $page ){
        $this->viewBuilder()->setLayout('ajax');
        $currentEtape = $this->Opportunites->PipelineEtapes->find()
                            ->where(['PipelineEtapes.id' => $idEtape])
                            ->first();
        $etape = null;
        if(!empty($currentEtape)){
            $etape = $this->getOneEtape($currentEtape, $page);
        }
        $this->set(compact('etape'));
    }

    public function update(){
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        $res['success'] = false;
        $opportunite = $this->Opportunites->newEntity();
        if ($this->request->is('post')) {
            $opportunite = $this->Opportunites->patchEntity($opportunite, $this->request->getData());
            if ($this->Opportunites->save($opportunite)) {
                $res['message'] = __('Opportunité mis à jour');
                $res['success'] = true;
            }
        }
        echo json_encode($res);
    }

    public function updateById($idOpp){
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        $res['success'] = false;
        $opportunite = $this->Opportunites->get($idOpp);
        if ($this->request->is('post')) {
            $opportunite = $this->Opportunites->patchEntity($opportunite, $this->request->getData());
            if ($this->Opportunites->save($opportunite)) {
                $res['message'] = __('Opportunité mis à jour');
                $res['success'] = true;
                if($this->request->getData('is_statutChange')){
                    $dTimeline['opportunite_id'] = $opportunite->id;
                    $dTimeline['time_action'] = time();
                    $dTimeline['opportunite_action_id'] = 9;
                    $dTimeline['opportunite_statut_id'] = $opportunite->opportunite_statut_id;
                    $dTimeline['user_id'] = $this->Auth->user('id');
                    $opportuniteTimeline = $this->Opportunites->OpportuniteTimelines->newEntity($dTimeline);
                    $this->Opportunites->OpportuniteTimelines->save($opportuniteTimeline);
                }else{
                    $dTimeline['opportunite_id'] = $opportunite->id;
                    $dTimeline['time_action'] = time();
                    $dTimeline['opportunite_action_id'] = 8;
                    $dTimeline['opportunite_statut_id'] = $opportunite->opportunite_statut_id;
                    $dTimeline['user_id'] = $this->Auth->user('id');
                    $opportuniteTimeline = $this->Opportunites->OpportuniteTimelines->newEntity($dTimeline);
                    $this->Opportunites->OpportuniteTimelines->save($opportuniteTimeline);
                }
            }
        }
        echo json_encode($res);
    }

    public function addTag($idOpp){
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        $res['success'] = false;
        //$opportunite = $this->Opportunites->get($idOpp);
        $tag = $this->Opportunites->OpportuniteTags->newEntity();
        if ($this->request->is('post')) {
            $data['nom'] = $this->request->getData('tag');
            $data['opportunite_id'] = $idOpp;
            $tag = $this->Opportunites->OpportuniteTags->patchEntity($tag, $data);
            if ($this->Opportunites->OpportuniteTags->save($tag)) {
                $res['message'] = __('Opportunité mis à jour');
                $res['success'] = true;
                $res['idTagAdded'] = $this->request->getData('idTagAdded');
                $res['id'] = $tag->id;

                //timeline
                $dTimeline['opportunite_id'] = $idOpp;
                $dTimeline['time_action'] = time();
                $dTimeline['opportunite_action_id'] = 2;
                $dTimeline['pipeline_etape_id'] = null;
                $dTimeline['user_id'] = $this->Auth->user('id');
                $opportuniteTimeline = $this->Opportunites->OpportuniteTimelines->newEntity($dTimeline);
                $this->Opportunites->OpportuniteTimelines->save($opportuniteTimeline);
            }
        }
        echo json_encode($res);
    }

    public function removeTag(){
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        $res['success'] = false;
        if ($this->request->is('post')) {
            $tag = $this->Opportunites->OpportuniteTags
                            ->find()
                            ->where(['id'=>$this->request->getData('idTag')])
                            ->first();
            $idOpp = $tag->opportunite_id;
            if(!empty($tag)){
                if ($this->Opportunites->OpportuniteTags->delete($tag)) {
                    $res['message'] = __('Opportunité mis à jour');
                    $res['success'] = true;

                    $dTimeline['opportunite_id'] = $idOpp;
                    $dTimeline['time_action'] = time();
                    $dTimeline['opportunite_action_id'] = 10;
                    $dTimeline['pipeline_etape_id'] = null;
                    $dTimeline['user_id'] = $this->Auth->user('id');
                    $opportuniteTimeline = $this->Opportunites->OpportuniteTimelines->newEntity($dTimeline);
                    $this->Opportunites->OpportuniteTimelines->save($opportuniteTimeline);

                }
            }
        }
        echo json_encode($res);
    }

    public function updateClient(){
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        $res['success'] = false;
        if ($this->request->is('post')){
            $client = $this->Opportunites->Clients->newEntity();
            $idClient = $this->request->getData('client_id');
            if(!empty($idClient)){
                $clientInBase = $this->Opportunites->Clients
                                        ->find()
                                        ->where(['id'=>$idClient])
                                        ->first();
                if(!empty($clientInBase)){
                    $client = $clientInBase;
                }
            }

            $client = $this->Opportunites->Clients->patchEntity($client, $this->request->getData());
            //debug($client);
            if ($this->Opportunites->Clients->save($client)) {
                $res['message'] = __('Evenement mis à jour');
                $res['success'] = true;
                $res['id'] = $client->id;

                //time line
                $dTimeline['opportunite_id'] = $this->request->getData('opportunite_id');
                $dTimeline['time_action'] = time();
                $dTimeline['opportunite_action_id'] = 6;
                $dTimeline['pipeline_etape_id'] = null;
                $dTimeline['user_id'] = $this->Auth->user('id');
                $opportuniteTimeline = $this->Opportunites->OpportuniteTimelines->newEntity($dTimeline);
                $this->Opportunites->OpportuniteTimelines->save($opportuniteTimeline);
            }
        }
        echo json_encode($res);
    }

    public function addCommentaire()
    {
        $this->viewBuilder()->setLayout('ajax');
        if ($this->request->is('post')){
            $commentaire = $this->Opportunites->OpportuniteCommentaires->newEntity();
            $data = $this->request->getData();
            $data['user_id'] = $this->Auth->user('id');
            $commentaire = $this->Opportunites->OpportuniteCommentaires->patchEntity($commentaire, $data);
            if ($this->Opportunites->OpportuniteCommentaires->save($commentaire)) {
                //Time line
                $dTimeline['opportunite_id'] = $commentaire->opportunite_id;
                $dTimeline['time_action'] = time();
                $dTimeline['opportunite_action_id'] = 4;
                $dTimeline['pipeline_etape_id'] = null;
                $dTimeline['user_id'] = $this->Auth->user('id');
                $opportuniteTimeline = $this->Opportunites->OpportuniteTimelines->newEntity($dTimeline);
                $this->Opportunites->OpportuniteTimelines->save($opportuniteTimeline);


                $commentaire = $this->Opportunites->OpportuniteCommentaires->get($commentaire->id,['contain'=>['Users']]);
                $this->set(compact('commentaire'));
            }else{
                //debug($commentaire); die;
            }
        }
    }

    public function addClientContact(){
        $this->viewBuilder()->setLayout('ajax');
        if ($this->request->is('post')){
            $clientContact = $this->Opportunites->Clients->ClientContacts->newEntity();

            $clientContact = $this->Opportunites->Clients->ClientContacts->patchEntity($clientContact, $this->request->getData());
            //debug($client);
            if ($this->Opportunites->Clients->ClientContacts->save($clientContact)) {
                //Time line
                $dTimeline['opportunite_id'] = $this->request->getData('opportunite_id');
                $dTimeline['time_action'] = time();
                $dTimeline['opportunite_action_id'] = 7;
                $dTimeline['pipeline_etape_id'] = null;
                $dTimeline['user_id'] = $this->Auth->user('id');
                $opportuniteTimeline = $this->Opportunites->OpportuniteTimelines->newEntity($dTimeline);
                $this->Opportunites->OpportuniteTimelines->save($opportuniteTimeline);

                $this->set(compact('clientContact'));
            }
        }

    }

    public function updateClientContact(){
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        $res['success'] = false;
        if ($this->request->is('post')){
            $contact = $this->Opportunites->Clients->ClientContacts->newEntity();
            $idClient = $this->request->getData('client_id');
            $idContact = $this->request->getData('client_contact_id');
            if(!empty($idContact)){
                $contactInBase = $this->Opportunites->Clients->ClientContacts
                                        ->find()
                                        ->where(['id'=>$idContact])
                                        ->first();
                if(!empty($contactInBase)){
                    $contact = $contactInBase;
                }
            }

            $contact = $this->Opportunites->Clients->ClientContacts->patchEntity($contact, $this->request->getData());
            //debug($client);
            if ($this->Opportunites->Clients->ClientContacts->save($contact)) {
                $res['message'] = __('Evenement mis à jour');
                $res['success'] = true;
                $res['id'] = $contact->id;
                $res['client_id'] = $contact->client_id;
            }
        }
        echo json_encode($res);
    }


    public function updateEvenement(){
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        $res['success'] = false;
        if ($this->request->is('post')){
            $evenement = $this->Opportunites->Evenements->newEntity();
            $idEvenement = $this->request->getData('id');
            if(!empty($idEvenement)){
                $evenementInBase = $this->Opportunites->Evenements
                                        ->find()
                                        ->where(['id'=>$idEvenement])
                                        ->first();
                if(!empty($evenementInBase)){
                    $evenement = $evenementInBase;
                }
            }

            $data = $this->request->getData();
            $dataEvenement = $this->request->getData('date_event');
            $arrD = explode('/', $dataEvenement);
            if(count($arrD) == 3){
                $data['date_event'] = $arrD[2].'-'.$arrD[1].'-'.$arrD[0];
            }else{
                $data['date_event'] = null;
            }
            

            $evenement = $this->Opportunites->Evenements->patchEntity($evenement, $data);
            if ($this->Opportunites->Evenements->save($evenement)) {
                $res['message'] = __('Evenement mis à jour');
                $res['success'] = true;
                $res['id'] = $evenement->id;
                if(empty($idEvenement)){
                    $opportunite = $this->Opportunites->get($this->request->getData('opportunite_id'));
                    $opportunite->evenement_id = $evenement->id;
                    $this->Opportunites->save($opportunite);
                }
                //Time line
                $dTimeline['opportunite_id'] = $this->request->getData('opportunite_id');
                $dTimeline['time_action'] = time();
                $dTimeline['opportunite_action_id'] = 5;
                $dTimeline['pipeline_etape_id'] = null;
                $dTimeline['user_id'] = $this->Auth->user('id');
                $opportuniteTimeline = $this->Opportunites->OpportuniteTimelines->newEntity($dTimeline);
                $this->Opportunites->OpportuniteTimelines->save($opportuniteTimeline);
            }
        }
        echo json_encode($res);
    }

    /*public function getListOppGroupByEtape($idPipe){

    }*/

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $option = [
            'keyword' => $this->request->getQuery('keyword'),
            'type_client_id' => $this->request->getQuery('type_client_id'),
            'opportunite_statut_id' => $this->request->getQuery('opportunite_statut_id'),
            'pipeline_id' => $this->request->getQuery('pipeline_id'),
            'pipeline_etape_id' => $this->request->getQuery('pipeline_etape_id'),
            'type_demande_id' => $this->request->getQuery('type_demande_id'),
            'type_evenement_id' => $this->request->getQuery('type_evenement_id'),
            'type_demande' => $this->request->getQuery('type_demande'),
            'staff_id' => $this->request->getQuery('staff_id'),
            'user_id' => $this->request->getQuery('user_id')
        ];

        $this->paginate = [
            'contain' => ['OpportuniteStatuts', 'Pipelines', 'PipelineEtapes', 'TypeClients', 'TypeEvenements','Users','Clients'],
            'order'=>[
                'Opportunites.numero'=>'DESC',
                //'Opportunites.id' => 'DESC'
            ],
            'finder' => [
                'filtre' => $option
            ]
        ];
        $opportunites = $this->paginate($this->Opportunites);

        $opportuniteStatuts = $this->Opportunites->OpportuniteStatuts->find('list', ['valueField' => 'nom']);
        $pipelines = $this->Opportunites->Pipelines->find('list', ['valueField' => 'nom']);
        $pipelineEtapes = $this->Opportunites->PipelineEtapes->find('list', ['valueField' => 'nom']);
        $typeClients = $this->Opportunites->TypeClients->find('list', ['valueField' => 'nom']);
        $sourceLeads = $this->Opportunites->SourceLeads->find('list', ['valueField' => 'nom']);
        $contactRaisons = $this->Opportunites->ContactRaisons->find('list', ['valueField' => 'nom']);
        $typeEvenements = $this->Opportunites->TypeEvenements->find('list', ['valueField' => 'nom']);
        $staffs = $this->Opportunites->Staffs->find('list', ['valueField' => 'full_name']);
        $users = $this->Opportunites->Users->find('list', ['valueField' => 'full_name']);

        $this->set(compact('opportunites', 'opportuniteStatuts', 'pipelines', 'pipelineEtapes', 'typeClients', 'sourceLeads', 'contactRaisons', 'typeEvenements','option','staffs','users'));
    }

    /**
     * View method
     *
     * @param string|null $id Opportunite id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $opportunite = $this->Opportunites->get($id, [
            'contain' => ['OpportuniteStatuts', 'Pipelines', 'PipelineEtapes', 'TypeClients', 'SourceLeads', 'ContactRaisons', 'TypeEvenements','Clients','LinkedDocs'=>['Devis','DevisFactures'],'OpportuniteCommentaires']
        ]);

        $devis_status = Configure::read('devis_status');
        $devis_factures_status = Configure::read('devis_factures_status');
     
        $this->set(compact('opportunite','devis_status','devis_factures_status'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $opportunite = $this->Opportunites->newEntity();
        if ($this->request->is('post')) {
            $opportunite = $this->Opportunites->patchEntity($opportunite, $this->request->getData());
            if ($this->Opportunites->save($opportunite)) {
                $this->Flash->success(__('The opportunite has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The opportunite could not be saved. Please, try again.'));
        }
        $opportuniteStatuts = $this->Opportunites->OpportuniteStatuts->find('list', ['limit' => 200]);
        $pipelines = $this->Opportunites->Pipelines->find('list', ['limit' => 200]);
        $pipelineEtapes = $this->Opportunites->PipelineEtapes->find('list', ['limit' => 200]);
        $typeClients = $this->Opportunites->TypeClients->find('list', ['limit' => 200]);
        $sourceLeads = $this->Opportunites->SourceLeads->find('list', ['limit' => 200]);
        $contactRaisons = $this->Opportunites->ContactRaisons->find('list', ['limit' => 200]);
        $typeEvenements = $this->Opportunites->TypeEvenements->find('list', ['limit' => 200]);
        $this->set(compact('opportunite', 'opportuniteStatuts', 'pipelines', 'pipelineEtapes', 'typeClients', 'sourceLeads', 'contactRaisons', 'typeEvenements'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Opportunite id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $opportunite = $this->Opportunites->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $opportunite = $this->Opportunites->patchEntity($opportunite, $this->request->getData());
            if ($this->Opportunites->save($opportunite)) {
                $this->Flash->success(__('The opportunite has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The opportunite could not be saved. Please, try again.'));
        }
        $opportuniteStatuts = $this->Opportunites->OpportuniteStatuts->find('list', ['limit' => 200]);
        $pipelines = $this->Opportunites->Pipelines->find('list', ['limit' => 200]);
        $pipelineEtapes = $this->Opportunites->PipelineEtapes->find('list', ['limit' => 200]);
        $typeClients = $this->Opportunites->TypeClients->find('list', ['limit' => 200]);
        $sourceLeads = $this->Opportunites->SourceLeads->find('list', ['limit' => 200]);
        $contactRaisons = $this->Opportunites->ContactRaisons->find('list', ['limit' => 200]);
        $typeEvenements = $this->Opportunites->TypeEvenements->find('list', ['limit' => 200]);
        $this->set(compact('opportunite', 'opportuniteStatuts', 'pipelines', 'pipelineEtapes', 'typeClients', 'sourceLeads', 'contactRaisons', 'typeEvenements'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Opportunite id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $opportunite = $this->Opportunites->get($id);
        if ($this->Opportunites->delete($opportunite)) {
            $this->Flash->success(__('The opportunite has been deleted.'));
        } else {
            $this->Flash->error(__('The opportunite could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function detail($idOpp){
        $opportunite = $this->Opportunites->get($idOpp, [
            'contain' => [
                'OpportuniteStatuts', 
                'Pipelines',
                'OpportuniteTypeBornes', 
                'PipelineEtapes', 
                'TypeClients', 
                'TypeEvenements',
                'Clients'=>['GroupeClients','ClientContacts','SourceLeads','SecteursActivites'],
                'OpportuniteCommentaires'=>['Users'], 
                'LinkedDocs'=>['Devis','DevisFactures'],
                'Evenements',
                'OptionFondVerts',
                'BesionBornes',
                'OpportuniteStatuts',
                'OpportuniteTags',
            ]
        ]);
        $evenement = null ;
        if(!empty($opportunite->evenement_id)){
            $evenement = $this->Opportunites->Evenements
                                ->get($opportunite->evenement_id,[
                                    'contain' => ['OptionFondVerts','BesionBornes','TypeEvenements','OpportuniteTypeBornes']
                                ]);

        }
        $opportuniteTypeBornes = $this->Opportunites->OpportuniteTypeBornes->find();
        $typeEvenements = $this->Opportunites->TypeEvenements->find();
        $optionFondVerts = $this->Opportunites->OptionFondVerts->find();
        $besionBornes = $this->Opportunites->BesionBornes->find();
        $opportuniteStatuts = $this->Opportunites->OpportuniteStatuts->find();
        $sourceLeads = $this->Opportunites->SourceLeads->find();
        $groupeClients = $this->Opportunites->Clients->GroupeClients->find();
        $secteurActivites = $this->Opportunites->Clients->SecteursActivites->find();


        $genres = Configure::read('genres');
        $devis_factures_status = Configure::read('devis_factures_status');
        $devis_status = Configure::read('devis_status');

        $timelines = $this->Opportunites->OpportuniteTimelines->find()
                                        ->contain([
                                            'OpportuniteActions',
                                            'Users',
                                            'PipelineEtapes',
                                            'OpportuniteStatuts'
                                        ])
                                        ->order(['OpportuniteTimelines.time_action'=>'DESC'])
                                        ->where(['OpportuniteTimelines.opportunite_id' => $opportunite->id]);

        $this->set(compact('opportunite','genres','opportuniteTypeBornes','optionFondVerts','besionBornes','typeEvenements','opportuniteStatuts','evenement','sourceLeads','groupeClients','secteurActivites','devis_factures_status','devis_status','timelines'));
    }


}
