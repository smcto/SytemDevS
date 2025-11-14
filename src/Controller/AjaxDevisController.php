<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Stripe\Stripe;

class AjaxDevisController extends AppController
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
            $this->Flash->success('Adresse modifiÃ©');
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
            $this->Flash->success('Contact modifiÃ©');
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
    public function deleteLineDevisProduit($idProduit = null){

        $this->loadModel('DevisProduits');
        $response = [];
        $devisAntenne = $this->DevisProduits->get($idProduit);
        if ($this->DevisProduits->delete($devisAntenne)) {
            $response['status'] = 'success';
        } else {
            $response['status'] = 0;
        }

        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }


    public function getModelDevis()
    {
        $body = ['status' => 1];
        $this->loadModel('Devis');
        $cat = $this->request->getQuery('cat');
        $sousCat = $this->request->getQuery('sous-cat');
        $davis = $this->Devis->find('list',['valueField' => 'model_name'])->order(['model_name'=>'ASC'])->where(['is_model' => 1]);
        if($cat) {
            $davis->where(['modele_devis_categories_id' => $cat]);
        }
        if($sousCat) {
            $davis->where(['modele_devis_sous_categories_id' => $sousCat]);
        }
        $body['devis'] = $davis->toArray();

        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }
    
    public function editEtat($devis_id){

        $this->loadModel('Devis');
        $this->loadModel('StatutHistoriques');
        $devis_status = Configure::read('devis_status');
        $response = [];
        $devis = $this->Devis->findById($devis_id)->first();
        if ($devis) {
            $statut = $this->request->getData('status');
            $devis = $this->Devis->patchEntity($devis, $this->request->getData());
            if($this->Devis->save($devis)){
                // original => setStatutHistorique
                $dataStat['user_id'] = $this->Auth->user('id');
                $dataStat['devi_id'] = $devis_id;
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
    
}