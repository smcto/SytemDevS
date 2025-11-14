<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Core\Configure;

/**
 * Intervalles Controller
 *
 * @property \App\Model\Table\IntervallesTable $Intervalles
 *
 * @method \App\Model\Entity\Intervalle[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MailjetHooksController extends AppController
{

    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function event()
    {
        $devisStatus = array_keys(Configure::read('devis_status'));
        //debug($devisStatus);

        Log::info('Appel mailjet', ['scope' => ['webhooksmailjet']]);
        $this->loadModel('Devis');
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        $res['success'] = false;
        if ($this->request->is('post')) {
            $events = $this->request->getData(); 
            //debug($events);
            //Log::warning('Data postée '.debug($events), ['scope' => ['webhooksmailjet']]);
            $notInManager = array();
            $datas = array();
            foreach($events as $event){
                $allDevis = $this->Devis->find()
                            ->where(['message_id_in_mailjet' =>$event['MessageID'] ]);
                            //->first();
                if(!empty($allDevis)){
                    foreach($allDevis as $devis){
                        //echo 'je passe ici 1';
                        $keyOfDevis = array_search($devis->status, $devisStatus); 

                        $statuDoc = '';
                        switch ($event['event']) {
                            case "sent":
                                $statuDoc = 'sent';
                                break;
                            case "open":
                                $statuDoc = 'open';
                                break;
                            case "open":
                                $statuDoc = 'open';
                                break;
                            case "click":
                                $statuDoc = 'clicked';
                                break;
                            case "bounce":
                                $statuDoc = 'error';
                                break;
                            case "blocked":
                                $statuDoc = 'blocked';
                                break;
                            case "spam":
                                $statuDoc = 'spam';
                                break;
                        }

                        if(!empty($statuDoc)){
                            $keyOfNewStatut = array_search($statuDoc, $devisStatus); 
                            if($keyOfNewStatut > $keyOfDevis){
                                $devis->status = $statuDoc;
                                if($this->Devis->save($devis)){
                                    $this->loadModel('StatutHistoriques');
                                    $dataStat['devi_id'] = $devis->id;
                                    $dataStat['time'] = $event['time'];
                                    $dataStat['statut_document'] = $statuDoc;
                                    $statutHistorique = $this->StatutHistoriques->newEntity($dataStat);
                                    if($this->StatutHistoriques->save($statutHistorique)){
                                        $res['success'] = true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }else{
             Log::warning('Pas un post ', ['scope' => ['webhooksmailjet']]);
        }
        //return  $this->response->withStatus(200);
        echo json_encode($res);
    }
    
}