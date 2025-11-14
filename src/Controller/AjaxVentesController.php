<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Client;
use Cake\Routing\Router;
use Cake\Utility\Hash;

class AjaxVentesController extends AppController
{

    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->loadModel('Clients');
        $this->loadModel('Ventes');
        $this->loadModel('ModelBornes');
        $this->loadModel('TypeEquipements');
        $this->viewBuilder()->setLayout(false);
    }
    public function isAuthorized($user)
    {
        return true;
    }

    public function getCustomersFromSellsy()
    {
        $this->loadComponent('SellsyApi');
        // $customersInSellsy = $this->SellsyApi->getAllCustomersList();
        // $filetemp = ROOT.DS.'webroot'.DS.'api'.DS.'sellsy'.DS.'clients.json'; 
        // file_put_contents($filetemp, json_encode($customersInSellsy));

        // $customersInSellsy = $this->SellsyApi->getAllDocumentsList();
        // $filetemp = ROOT.DS.'webroot'.DS.'api'.DS.'sellsy'.DS.'documents_estimate.json'; 
        // file_put_contents($filetemp, json_encode($customersInSellsy));
        
        $clientsSellsy = $this->SellsyApi->getAllCustomersList();

        $body = $clientsSellsy;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function getClientContact($client_id = null)
    {
        $clientContacts = $this->Clients->ClientContacts->findByClientId($client_id)->group('nom');
        if ($clientContacts->count() > 0) {
            $this->set(compact('clientContacts'));
        } else {
            $body = ['status' => 'empty'];
            return $this->response->withType('application/json')->withStringBody(json_encode($body));
        }
    }

    public function getClient($id = null)
    {
        if ($id) {
            $client = $this->Clients->findById($id)->contain(['ClientContacts', 'SecteursActivites'])->first(); // exemple client_id sans client_contacts : 152
        }
        $body = $client ?? false;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function venteClientsContact($client_id = null)
    {
        $contactTypes = $this->Clients->ClientContacts->ContactTypes->find('list')->toArray();
        $clientEntity = $this->Clients->findById($client_id)->contain('ClientContacts')->first(); // exemple client_id sans client_contacts : 152
        $this->set(compact('clientEntity', 'contactTypes'));
        $this->render('/Ventes/vente_clients_contact');
    }

    public function deleteContact($id, $session_id = null)
    {
        $this->loadModel('Clients');
        $entity = $this->Clients->ClientContacts->findById($id)->first();
        if ($entity) {
            $result = $this->Clients->ClientContacts->delete($entity);
        }

        if ($this->request->getSession()->read('vente_client.client.client_contacts.'.$session_id)) {
            $this->request->getSession()->delete('vente_client.client.client_contacts.'.$session_id);
        }
        
        if ($this->request->getSession()->read('vente_briefprojet.client.client_contacts.'.$session_id)) {
            $this->request->getSession()->delete('vente_briefprojet.client.client_contacts.'.$session_id);
        }

        $result = ['status' => 'empty'];
        if ($result) {
            $result = ['status' => 'success'];
        }

        $body = $result;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function getContactClient($client_id = null)
    {
        $client = $this->Clients->findById($client_id)->contain('MainContact')->first(); // exemple client_id sans client_contacts : 152

        if ($mainContact = $client->main_contact) {

            $contact = [
                'client_id' => $client->id,
                'client_contact_id' => $mainContact->id,
                'nom' => $mainContact->nom,
                'prenom' => $mainContact->prenom,
                'email' => $mainContact->email,
                'adresse' => $client->adresse,
                'cp' => $client->cp,
                'ville' => $client->ville,
                'tel' => $mainContact->tel,
                'addr_lat' => $client->addr_lat,
                'addr_lng' => $client->addr_lng
            ];
        } 

        $body = $contact ?? false;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function getClientContactInfos($contact_client_id = null)
    {
        $clientContact = $this->Clients->ClientContacts->findById($contact_client_id)->first();
        $body = $clientContact;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function getClientDocumentsDevis($client_id = null)
    {
        $documents_devis_clients = $this->Clients->Documents->findByClientIdAndTypeDocument($client_id, 'estimate');
        $this->set(compact('documents_devis_clients'));
    }

    public function uploadDevis()
    {
        $this->loadComponent('Upload');
        $result = $this->Upload->dropzone('uploads/ventes/devis/');
        $body = $result;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function loadModelBorneByGamme($gamme_borne_id)
    {
        $this->loadModel('ModelBornes');
        $modelBornes = $this->ModelBornes->findByGammeBorneId($gamme_borne_id)->find('list', ['valueField' => function ($item)
        {
            return $item->nom.' '.$item->version;
        }]);

        if ($this->request->getParam('_ext') == 'json') {
            $body = $modelBornes;
            return $this->response->withType('application/json')->withStringBody(json_encode($body));
        }
        $this->set(compact('modelBornes'));
    }

    public function loadEquipementFromGammeBorne($gamme_borne_id) // pied
    {
        $this->loadModel('TypeEquipements');
        $typeEquipements = $this->TypeEquipements->find('list', ['valueField' => 'nom'])->where(['TypeEquipements.id IN' => [6,9]]);

        $typeEquipements
            ->contain(['TypeEquipementsGammes'])
            ->matching('TypeEquipementsGammes')
            ->where(['TypeEquipementsGammes.gamme_borne_id' => $gamme_borne_id])
        ;

        $this->set(compact('typeEquipements'));

    }

    public function loadAppPhotosFromGamme()
    {
        $this->loadModel('TypeEquipements');
        $typeEquipements = $this->TypeEquipements->find('list', ['valueField' => 'nom'])->where(['TypeEquipements.id IN' => [2,8]]);

        $typeEquipements
            ->find('byGamme')
        ;

        $body = $typeEquipements;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));

        // $this->set(compact('typeEquipements'));
    }

    public function preloadDevisUploaded($vente_id)
    {
        $devisVentes = $this->Ventes->VentesDevisUploads->findByVenteId($vente_id);
        $body = $devisVentes;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function loadParcDurees($parc_id)
    {
        $nbMois = $this->Ventes->Parcs->ParcDurees->findByParcId($parc_id)->find('list', ['valueField' => 'valeur']);
        $body = $nbMois;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function loadAccessoiresByGammeBorneId($gamme_borne_id = null)
    {
        $this->loadModel('Accessoires');
        $accessoires = $this->Accessoires
            ->find()
            ->contain(['SousAccessoires' => 'SousAccessoiresGammes'])
            ->matching('SousAccessoires.SousAccessoiresGammes')
            ->where(['SousAccessoiresGammes.gamme_borne_id' => $gamme_borne_id])
            ->group('Accessoires.id')
        ;

        $this->set(compact('accessoires'));
    }

    public function preloadDevisUploadedInSession()
    {
        $dataClient = $this->request->getSession()->read('vente_client');
        $venteEntity = $this->Ventes->newEntity($dataClient);

        $result = [];
        if ($venteEntity->ventes_devis_uploads != null) {
            foreach ($venteEntity->ventes_devis_uploads as $key => $ventes_devis_uploads) {
                $file['name'] = $ventes_devis_uploads['filename'];
                $file['size'] = filesize(WWW_ROOT.$ventes_devis_uploads->get('FilePath'));
                $result[] = $file;
            }
        }
        $body = $result;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    function removeDevisUploaded($filename)
    {
        $dataClient = $this->request->getSession()->read('vente_client');
        if (isset($dataClient['ventes_devis_uploads'])) {
            foreach ($dataClient['ventes_devis_uploads'] as $key => $ventes_devis_uploads) {
                $ventes_devis_uploads['key'] = $key;
                $dataClient['ventes_devis_uploads'][$key] = $ventes_devis_uploads;
            }
        }
        $existingDevis = collection($dataClient['ventes_devis_uploads'])->firstMatch(compact('filename'));
        $this->request->getSession()->delete('vente_client.ventes_devis_uploads.'.$key);
        $body = ['status' => 'ok'];
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function removeAccessories($key)
    {
        $this->request->getSession()->delete("vente_materiel.ventes_accessoires.$key");
        $body = ['status' => 'ok', 'key' => $key];
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    public function checkIfVenteHasBorne($vente_id)
    {
        $ifVenteHasBorne = $this->Ventes->findById($vente_id)->contain(['Bornes'])->first()->has('borne');
        $body = ['status' => $ifVenteHasBorne];
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }


    public function loadFormByVenteConsommable($vente_consommable_id)
    {
        $this->loadModel('VentesConsommables');
        $ventesConsommable = $this->VentesConsommables->findById($vente_consommable_id)->find('WithSousCategories')->first();
        $this->set(compact('ventesConsommable'));
    }

    
    public function loadModelBorne($model_borne_id = null) // pied
    {
        
        $model_borne = $this->ModelBornes->findById($model_borne_id)->first();
        // $body = ['status' => 'ok', 'model_borne' => $model_borne];
        return $this->response->withType('application/json')->withStringBody(json_encode($model_borne));
    }
    
    
    public function equipementByGamme($gamme_id, $vente_id = null) {
        
        $this->viewBuilder()->setLayout('ajax');
        
        $this->loadModel('GammesBornes');
        $this->loadModel('Equipements');
        
        $gamme = $this->GammesBornes->find('all')->where(['GammesBornes.id' => $gamme_id])->contain([
            'TypeEquipements' => function ($q) {
                return $q->where(['TypeEquipements.is_structurel' => 1, 'TypeEquipements.is_vente' => 1]);
            }
        ])->first();
        // debug(collection($gamme->type_equipements)->extract('nom')->toArray());
        // die();
        
        $equipements = $this->Equipements->find('list',[
            'keyField' => 'id',
            'valueField'=>'valeur',
            'groupField' => 'type_equipement_id'
        ])->toArray();
        
        $old_equipements = [];
        if($vente_id) {
            $this->loadModel('EquipementVentes');
            $values = $this->EquipementVentes->find('all')->where(['vente_id' => $vente_id]);
            foreach ($values as $value) {
                $old_equipements[$value->type_equipement_id] = $value;
            }
        }
        
        $this->set(compact('gamme', 'old_equipements', 'equipements'));
    }
    
    public function equipementByModelBorne($model_borne_id = null) {
        
        $this->viewBuilder()->setLayout('ajax');
        
        $equipements = [];
        if($model_borne_id) {
            $this->loadModel('ModelBorneHasEquipements');
            $values = $this->ModelBorneHasEquipements->find('all')->where(['model_borne_id' => $model_borne_id]);
            foreach ($values as $value) {
                $equipements[$value->type_equipement_id] = $value->equipement_id;
            }
        }
        
        return $this->response->withType('application/json')->withStringBody(json_encode($equipements));
    }


    public function findTypeEquipementsAccessoires()
    {
        $keyword = $this->request->getQuery('keyword');
        $parc_id = $this->request->getQuery('parc_id');
        $typeEquipementsAccessoires = $this->TypeEquipements->findByIsAccessoire(1)->contain(['Equipements', 'EquipementBornes' => 'Bornes'])->find('filtre', [
            'keyword' => $keyword,
            'parc_id' => $parc_id,
        ]);

        $this->set(compact('typeEquipementsAccessoires'));
    }

    public function findTypeEquipementsProtections()
    {
        $keyword = $this->request->getQuery('keyword');
        $parc_id = $this->request->getQuery('parc_id');
        $typeEquipementsProtections = $this->TypeEquipements->findByIsProtections(1)->contain(['Equipements', 'EquipementBornes' => 'Bornes'])->find('filtre', [
            'keyword' => $keyword,
            'parc_id' => $parc_id,
        ]);

        $this->set(compact('typeEquipementsProtections'));
    }

}
