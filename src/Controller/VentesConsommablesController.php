<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

class VentesConsommablesController extends AppController
{
    public function isAuthorized($user)
    {
        $isRolePermis = (bool) array_intersect($user['profils_alias'] , ['admin', 'compta']);
        
        if (!$isRolePermis && in_array($this->action, ['dashboard'])) {
            return false;
        }

        $typeprofils = $user['typeprofils'];
        if(in_array('konitys', $typeprofils) || in_array('admin', $typeprofils)) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function facturations($isArchive = null)
    {
        $vente_etat_consommables = Configure::read('vente_etat_consommable');
        $vente_consommable_couleurs = Configure::read('vente_etat_consommable_couleur');
        $vente_consommable_etat_facturations = Configure::read('vente_consommable_etat_facturation');
        $ventesConsommables = $this->VentesConsommables->find('complete')->find('FactureNonTraitees');

        // liste les ventes traités en accompte réglé ou facture envoyée
        if ($isArchive == true) {
            $ventesConsommables = $this->VentesConsommables->find('complete')->find('FactureTraitees');
        } 

        $this->set(compact('isArchive', 'ventesConsommables', 'vente_consommable_etat_facturations', 'vente_etat_consommables', 'vente_consommable_couleurs'));   
    }

    public function index($consommable_statut = null)
    {
        $client_id = $this->request->getQuery('client');
        $groupe_client_id = $this->request->getQuery('groupe_client');
        $user_id = $this->request->getQuery('user');
        $statut_consommable = $this->request->getQuery('consommable_statut');
        
        $customFinderOptions = [
            'client_id' => $client_id,
            'groupe_client_id' => $groupe_client_id,
            'user_id' => $user_id,
            'consommable_statut' => $statut_consommable
        ];
        
        $vente_etat_consommables = Configure::read('vente_etat_consommable');
        $vente_consommable_couleurs = Configure::read('vente_etat_consommable_couleur');
        if ($consommable_statut == null) {
            $conditions = ['OR' => [['consommable_statut !=' => 'expedie'], ['consommable_statut is' => NULL]]];
            $ventesConsommables = $this->VentesConsommables->find('complete', $customFinderOptions)->contain(['VentesHasDevisProduits' => ['DevisProduits' => 'CatalogProduits']])->where($conditions);
        } else {
            $conditions = ['consommable_statut' => $consommable_statut];
            $ventesConsommables = $this->VentesConsommables->find('complete', $customFinderOptions)->contain(['VentesHasDevisProduits' => ['DevisProduits' => 'CatalogProduits']])->where($conditions);
        }
        
        if($client_id){
            $ventesConsommables->where(['VentesConsommables.client_id' => $client_id]);
        }
        
        $groupeClients = $this->VentesConsommables->Clients->GroupeClients->find('list',['valueField' => 'nom']);
        $clientsCorporations = $this->VentesConsommables->Clients->findByClientType('corporation') ->find('list', ['valueField' => 'nom']);
        $users = $this->VentesConsommables->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name']);
        
        $countVentes = [];
        foreach ($vente_etat_consommables as $vente_statut_key => $vente_statu_value){
            $conditions = ['consommable_statut' => $vente_statut_key];
            $countVentes[$vente_statut_key] = count($this->VentesConsommables->find('complete',$customFinderOptions)->where($conditions)->toArray());
        }
        
        $this->set(compact('consommable_statut', 'ventesConsommables', 'vente_etat_consommables','vente_consommable_couleurs'));
        $this->set(compact('clientsCorporations','client_id','users','user_id','groupeClients','groupe_client_id','statut_consommable','countVentes'));
    }

    public function view($id = null)
    {
        $vente_etat_consommables = Configure::read('vente_etat_consommable');
        $this->viewBuilder()->setLayout('vente');
        $ventesConsommable = $this->VentesConsommables->findById($id)->find('complete')->find('WithSousCategories')->first();
        $this->set(compact('devisProduitsAccessoires', 'devisProduitsConsomables', 'vente_etat_consommables', 'ventesConsommable', 'ventesHasSousConsommables', 'ventesHasSousAccessoires'));
    }

    public function add($id = null)
    {
        $this->loadModel('TypeConsommables');
        $this->loadModel('Accessoires');

        $ventesConsommable = $this->VentesConsommables->newEntity();
        $typeConsommables = $this->TypeConsommables->find()->contain(['SousTypesConsommables'])->toArray();

        $accessoires = $this->Accessoires
            ->find()
            ->contain(['SousAccessoires' => 'SousAccessoiresGammes'])
            ->matching('SousAccessoires.SousAccessoiresGammes')
            ->group('Accessoires.id')
        ;

        if ($id) {

            $ventesConsommable = $this->VentesConsommables->get($id, [
                'contain' => [
                    'VentesHasDevisProduits',
                    'Clients', 'Users', 'Parcs',
                    'VentesHasSousAccessoires' => function ($q) {
                        return $q->order(['VentesHasSousAccessoires.id' => 'ASC']);
                    },
                    'VentesHasSousConsommables' => function ($q) {
                        return $q->order(['VentesHasSousConsommables.id' => 'ASC']);
                    }
                ]
            ]);


            $typeConsommablesList = $this->TypeConsommables->find('list')->toArray();
            $ventesHasSousConsommables = $this->VentesConsommables->VentesHasSousConsommables->findByVentesConsommableId($id);
            $ventesHasSousAccessoires = $this->VentesConsommables->VentesHasSousAccessoires->findByVentesConsommableId($id);
            $clients = $this->VentesConsommables->Clients->find('corporationList')->where(['id' => $ventesConsommable->client_id]);
            $devis = $this->VentesConsommables->Clients->Devis->findByClientId($ventesConsommable->client_id)->find('list', ['valueField' => 'indent']);
            $devisEntityWithAccessoires = $this->VentesConsommables->Clients->Devis->findById($ventesConsommable->devis_id)->find("WithProduitsBySouscategorie", ['catalog_sous_category_id' => 2])->first();
            $devisEntityWithConsommables = $this->VentesConsommables->Clients->Devis->findById($ventesConsommable->devis_id)->find("WithProduitsBySouscategorie", ['catalog_sous_category_id' => 16])->first();

            $this->set(compact('devisEntityWithAccessoires', 'devisEntityWithConsommables', 'devis', 'devisWithConsommables', 'ventesHasSousConsommables', 'ventesHasSousAccessoires', 'typeConsommablesList', 'clients'));
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            // debug($data);
            // die();
            $ventesConsommable = $this->VentesConsommables->patchEntity($ventesConsommable, $data, ['validate' => false]);

            if ($this->VentesConsommables->save($ventesConsommable)) {
                $this->Flash->success(__('The consumable sale has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The consumable sale could not be saved. Please, try again.'));
        }

        $users = $this->VentesConsommables->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name']); // profile Konitys Commercial
        $parcs = $this->VentesConsommables->Parcs->find('vente')->find('list', ['valueField' => 'nom2']);

        $this->set(compact('ventesConsommable', 'users', 'id', 'parcs', 'typeConsommables', 'accessoires'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ventesConsommable = $this->VentesConsommables->get($id);
        if ($this->VentesConsommables->delete($ventesConsommable)) {
            $this->Flash->success(__('The consumable sale has been deleted.'));
        } else {
            $this->Flash->error(__('The consumable sale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function majState($vente_consommable_id)
    {
        $venteConsommableEntity = $this->VentesConsommables->findById($vente_consommable_id)->contain(['VentesHasDevisProduits'])->first();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $venteConsommableEntity = $this->VentesConsommables->patchEntity($venteConsommableEntity, $data, ['validate' => false]);
            $this->VentesConsommables->save($venteConsommableEntity);
            $this->Flash->success("Mise à jour réussie");


            return $this->redirect($this->referer());
        }
    }

    public function majStateBilling($vente_consommable_id, $isArchive = null)
    {
        $venteConsommableEntity = $this->VentesConsommables->findById($vente_consommable_id)->first();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $venteConsommableEntity = $this->VentesConsommables->patchEntity($venteConsommableEntity, $data, ['validate' => false]);

            if(!$venteConsommableEntity->getErrors()) {
                $this->VentesConsommables->save($venteConsommableEntity);
                $this->Flash->success("Mise à jour réussie");
                return $this->redirect(['action' => 'facturations', $isArchive]);
            }
            return $this->redirect($this->referer());
        }
    }

    public function dashboard() {

        $this->viewBuilder()->setLayout('dashboard');
    }

}
