<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\SellsyCurlComponent;

/**
 * Documents Controller
 *
 * @property \App\Model\Table\DocumentsTable $Documents
 *
 * @method \App\Model\Entity\Document[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentsController extends AppController
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

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $typeDocument = $this->request->getQuery('typeDocument');
        if(empty($typeDocument)){
            $typeDocument = 'invoice';
        }
        $key = $this->request->getQuery('key');
        $type = $this->request->getQuery('type');
        $customFinderOptions = [
            'typeDocument' => $typeDocument,
            'key' => $key,
            'type' => $type
        ];
        
        
        $this->paginate = [
            'contain' => ['Clients'],
            'finder' => [
                'filtre' => $customFinderOptions
            ]
        ];
        $documents = $this->paginate($this->Documents);

        $this->set(compact('documents','typeDocument','key','type'));
    }
    
    public function devis($idClient){
        $this->viewBuilder()->setLayout('ajax');
        $devis = $this->Documents->find('all')->where(['client_id' => $idClient,'type_document'=>'estimate']);
        $this->set(compact('devis'));

    }

    public function document( $type = 'invoice'){ // OR Estimate

        $this->loadModel('Documents');
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Document.getList',
            'params' => array(
                'doctype' => $type
            )
        );

        if($type == 'invoice'){
            //$request['params']['search']['steps'] = array('');
        }else{ //estimate
            //$request['params']['search']['steps'] = array('accepted','invoiced');
        }

        $documents = $this->sellsyCurlComponent->requestApi($request);
        //debug($documents);die;

        $nbrPageResponses = $documents->response;
        $infos = isset($nbrPageResponses->infos) ? $nbrPageResponses->infos : null;
        $nbrPage = isset($infos->nbpages) ? $infos->nbpages : 0;

        //Mettre � jour tous les clients. Marquer suprimer depuis sellsy
        if(!empty($nbrPageResponses)){
            $this->Documents->updateAll(
                ['deleted_in_sellsy' => true],
                ['id >'=>0]);
        }


        //$this->out('Lancement...');
        for ($i = 1; $i <= $nbrPage; $i++) {
            $requestDoc = array(
                'method' => 'Document.getList',
                'params' => array(
                    'doctype' => $type,
                    'pagination' => array(
                        'pagenum' => $i,
                        'nbperpage' => 100
                    )
                )
            );
            if($type == 'invoice'){
                //$requestDoc['params']['search']['steps'] = array('');
            }else{ //estimate
                $requestDoc['params']['search']['steps'] = array('accepted','invoiced');
            }

            $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
            $documents = $this->sellsyCurlComponent->requestApi($requestDoc);
            //debug($documents);die;

            if(!empty($documents)){


                $documentsResponses = $documents->response;
                $documentsResult = isset($documentsResponses->result) ? $documentsResponses->result : null;

                //debug($documentsResponses); die;

                if ($documentsResult != null) {
                    foreach ($documentsResult as $idSellsy => $item) {
                        $documentsInsert['objet'] = isset($item->subject) ? $item->subject : null;
                        $documentsInsert['date'] = isset($item->displayedDate) ? $item->displayedDate : null;
                        $documentsInsert['montant_ttc'] = isset($item->totalAmount) ? floatval($item->totalAmount) : null;
                        $documentsInsert['montant_ht'] = $item->totalAmountTaxesFree;
                        $documentsInsert['id_in_sellsy'] = $idSellsy;
                        $documentsInsert['deleted_in_sellsy'] = false;
                        $documentsInsert['type_document'] = $type;
                        $documentsInsert['step'] = isset($item->step) ? $item->step : null;

                        //get public link
                        $requestLink = array(
                            'method' => 'Document.getPublicLink',
                            'params' => array(
                                'doctype' => $type,
                                'docid' => $idSellsy,
                            )
                        );
                        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
                        $link = $this->sellsyCurlComponent->requestApi($requestLink);
                        //debug($link);
                        $linkReponse = "";
                        if($link){
                            $linkReponse = $link->response;
                        }

                        //debug($linkReponse);
                        $documentsInsert['url_sellsy'] = "https://www.sellsy.fr/".$linkReponse;

                        $idClient = isset($item->thirdid) ? $item->thirdid : null;

                        $clientFind = $this->Documents->Clients->find()->where(["id_in_sellsy" => intval($idClient)])->first();
                        if ($clientFind) {
                            $clientId = $clientFind->id;
                            $documentsInsert['client_id'] = $clientId;

                            $document = $this->Documents->newEntity();
                            $docFind = $this->Documents->find('all')->where(["id_in_sellsy" => intval($idSellsy)])->first();
                            if ($docFind) {
                                $document = $docFind;
                            }
                            $document = $this->Documents->patchEntity($document, $documentsInsert, ['validate' => false]);


                            if ($this->Documents->save($document)) {
                                // $this->out('sauver .'.$document->id);
                            }
                        }

                    }

                }
            }

        }
        // $this->out('Terminer...');
        die();
    }
}
