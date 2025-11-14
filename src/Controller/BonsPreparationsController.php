<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * BonsPreparations Controller
 *
 * @property \App\Model\Table\BonsPreparationsTable $BonsPreparations
 *
 * @method \App\Model\Entity\BonsPreparation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BonsPreparationsController extends AppController
{

    
    /**
     * 
     * @param type $user
     * @return boolean
     */
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if(in_array('konitys', $typeprofils) || in_array('admin', $typeprofils)) {
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
        $type_date = Configure::read('type_date');
        $bp_statut = Configure::read('bp_statut');
        $statut_couleurs = Configure::read('vente_statut_couleur');
        $customFinderOptions = $this->request->getQuery();
        $user_id = $this->request->getQuery('user_id');
        $type = $this->request->getQuery('type_date');
        $keyword = $this->request->getQuery('keyword');
        
        $bonsPrepa = $this->BonsPreparations->find('complete')->find('filtre', $customFinderOptions);
        
        $bonsPrepa = $this->paginate($bonsPrepa, ['limit' => 50]);
        $commercials = $this->BonsPreparations->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name'])->where(['toujours_present' => 1]); // profile Konitys Commercial

        $this->set(compact('bonsPrepa', 'type_date', 'commercials', 'keyword', 'type', 'user_id', 'bp_statut', 'statut_couleurs'));
    }

    /**
     * View method
     *
     * @param string|null $id Bons Preparation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bonsPrepa = $this->BonsPreparations->get($id, [
            'contain' => ['Clients', 'Users', 'CloneBp', 'BonsPreparationsProduits'=> function ($q) {
            return $q->order(['BonsPreparationsProduits.i_position'=>'ASC']);
        }]]);
        
        if ($bonsPrepa->clone_bp) {
            return $this->redirect(['action' => 'view', $bonsPrepa->clone_bp[0]->id]);
        }

        $type_date = Configure::read('type_date');
        $statut_ligne = Configure::read('statut_ligne');
        
        $this->set(compact('bonsPrepa', 'type_date', 'statut_ligne'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bonsPrepa = $this->BonsPreparations->newEntity();
        if ($this->request->is('post')) {
            $bonsPrepa = $this->BonsPreparations->patchEntity($bonsPrepa, $this->request->getData());
            if ($this->BonsPreparations->save($bonsPrepa)) {
                $this->Flash->success(__('The bons preparation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bons preparation could not be saved. Please, try again.'));
        }
        $devis = $this->BonsPreparations->Devis->find('list', ['limit' => 200]);
        $bonsPrepa = $this->BonsPreparations->BonsCommandes->find('list', ['limit' => 200]);
        $clients = $this->BonsPreparations->Clients->find('list', ['limit' => 200]);
        $users = $this->BonsPreparations->Users->find('list', ['limit' => 200]);
        $this->set(compact('bonsPreparation', 'devis', 'bonsCommandes', 'clients', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bons Preparation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('devis');
        
        $bonsPrepa = $this->BonsPreparations->get($id, [
            'contain' => ['Clients', 'CloneBp', 'BonsLivraisons' , 'BonsPreparationsProduits'=> function ($q) {
            return $q->order(['BonsPreparationsProduits.i_position'=>'ASC']);
        }]]);
        
        if ($bonsPrepa->clone_bp) {
            return $this->redirect(['action' => 'view', $bonsPrepa->clone_bp[0]->id]);
        }
        
        if ($bonsPrepa->bons_livraisons) {
            $this->Flash->error("Ce bons de preparation est déjà convertir en bons de livraison");
            return $this->redirect(['action' => 'view', $bonsPrepa->id]);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $datas = $this->request->getData();
            
            if ($datas['total_livre'] == 0) {
                $datas['statut'] = 'en_attente';
            }
            if ($datas['total_livre'] < $datas['total_commande']) {
                $datas['statut'] = 'en_prepa';
            }
            if ($datas['total_livre'] == $datas['total_commande']) {
                $datas['statut'] = 'pret_exp';
            }
            
            $bonsPrepa = $this->BonsPreparations->patchEntity($bonsPrepa, $datas);
            if ($this->BonsPreparations->save($bonsPrepa)) {
                $this->Flash->success(__('The bons preparation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bons preparation could not be saved. Please, try again.'));
        }
        
        $type_date = Configure::read('type_date');
        $statut_ligne = Configure::read('statut_ligne');
        
        $this->set(compact('bonsPrepa', 'type_date', 'statut_ligne'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bons Preparation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bonsPrepa = $this->BonsPreparations->get($id);
        if ($this->BonsPreparations->delete($bonsPrepa)) {
            $this->Flash->success(__('The bons preparation has been deleted.'));
        } else {
            $this->Flash->error(__('The bons preparation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    
    public function CreateBpFromBc($bc_id) {
        
        if ($bc_id) {
                            
            $datas = $this->BonsPreparations->BonsCommandes->findById($bc_id)->find('ToBonsPrepa');

            $indent = $this->Utilities->incrementIndentByMonth($this->BonsPreparations->find()->orderAsc('created')->last(), 'BPK-');
            $datas['indent'] = $indent;
            $datas['user_id'] = $this->currentUser()->id;
            $datas['bons_commande_id'] = $bc_id;
            $bp = $this->BonsPreparations->newEntity($datas);

            if($this->BonsPreparations->save($bp)) {

                $this->Flash->success('Le bons de preparation ont été créer avec succés');
                return $this->redirect(['action' => 'edit', $bp->id]);
            } else {
                debug($bp->getErrors());die;
            }
        }
        
        $this->redirect($this->referer());
    }
}
