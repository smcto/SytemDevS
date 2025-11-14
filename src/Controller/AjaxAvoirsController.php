<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

class AjaxAvoirsController extends AppController
{
    public function initialize(array $config = [])
    {
        parent::initialize($config);
    }

    public function isAuthorized($user)
    {
        return true;
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
    public function deleteLineAvoirsProduit($idProduit = null){

        $this->loadModel('AvoirsProduits');
        $response = [];
        $devisAntenne = $this->AvoirsProduits->get($idProduit);
        if ($this->AvoirsProduits->delete($devisAntenne)) {
            $response['status'] = 'success';
        } else {
            $response['status'] = 0;
        }

        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }

    public function editEtat($avoir_id){

        $this->loadModel('Avoirs');
        $this->loadModel('StatutHistoriques');
        $devis_avoirs_status = Configure::read('devis_avoirs_status');
        $response = [];
        $devis = $this->Avoirs->findById($avoir_id)->first();
        if ($devis) {
            $statut = $this->request->getData('status');
            $devis = $this->Avoirs->patchEntity($devis, $this->request->getData());
            if($this->Avoirs->save($devis)){
                // original => setStatutHistorique
                $dataStat['avoir_id'] = $avoir_id;
                $dataStat['time'] = time();
                $dataStat['statut_document'] = $statut;
                $statutHistorique = $this->StatutHistoriques->newEntity($dataStat);
                $this->StatutHistoriques->save($statutHistorique);
                $response['status'] = 1;
                $response['devis_status'] = $devis_avoirs_status[$statut];
                $response['value'] = $statut;
            } else {
                $response['status'] = 0;
            }
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }

    public function refreshList() {
        
        $this->loadModel('Avoirs');
        $this->viewBuilder()->setLayout('ajax');
        $indent = $this->request->getQuery('indent');
        $client_id = $this->request->getQuery('client_id');
        $checkbox = $this->request->getQuery('checkBox');
        $devis_avoirs_status = Configure::read('devis_avoirs_status');
        $montantReglement = $this->request->getQuery('montantReglement');
        
        $avoirs = $this->Avoirs->find('complete')->find('filtre',  compact('indent', 'client_id'))
                ->where(['Avoirs.status <>' => 'paid'])
                ->toArray();
        $this->set(compact('avoirs', 'devis_avoirs_status','checkbox','montantReglement'));
    }
    
}