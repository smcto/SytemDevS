<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;

/**
 * FactureSituations Controller
 *
 * @property \App\Model\Table\FactureSituationsTable $FactureSituations
 *
 * @method \App\Model\Entity\FactureSituation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FactureSituationsController extends AppController
{

    public $defaultTva = false;
    
    public function initialize(array $config = [])
    {
        parent::initialize($config);

        $this->loadComponent('Utilities');
        $this->Utilities->loadModels(['Users', 'Tvas']);
        $tvas = $this->Tvas->find('list', ['keyField' => 'valeur']);

        if (!$this->defaultTva) {
            $this->defaultTva = $defaultTva = $this->Tvas->findByIsDefault(1)->first();
        }
        $this->set(compact('tvas', 'defaultTva'));
    }

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
        $this->paginate = [
            'contain' => ['Devis', 'RefCommercials', 'Clients']
        ];
        $factureSituations = $this->paginate($this->FactureSituations);

        $this->set(compact('factureSituations'));
    }

    /**
     * View method
     *
     * @param string|null $id Facture Situation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        
        $this->viewBuilder()->setLayout('devis');
        if ($id) {
            $factureSituationEntity = $this->FactureSituations->findById($id)->find('complete')->first();
            $currentUser = $this->Users->get($factureSituationEntity->ref_commercial_id, ['contain' => 'Payss']);
        }
        
        $facture_situations_status = Configure::read('facture_situations_status');
        $commercials = $this->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name'])->where(['toujours_present' => 1]); // profile Konitys Commercial
        $this->set(compact('id', 'factureSituationEntity', 'commercials', 'facture_situations_status', 'currentUser'));

    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $data = $this->request->getData();
            if($id) {
                $factureSituationEntity = $this->FactureSituations->findById($id)->find('complete')->first();
            } else {
                $factureSituationEntity = $this->FactureSituations->newEntity();
            }
            
            $factureSituationEntity = $this->FactureSituations->patchEntity($factureSituationEntity, $data);
            if ($this->FactureSituations->save($factureSituationEntity)) {
                $this->Flash->success('La facture de situation a été enregistré');
                if($data['is_continue']) {
                    $this->redirect(['action' => 'add', $factureSituationEntity->id]);
                } else {
                    $this->redirect(['action' => 'index']);
                }
            } else {
                debug($factureSituationEntity->getErrors());
                $this->Flash->error("La facture de situation n'a pas pu être enregistré");
            }
        }
        
        $this->viewBuilder()->setLayout('devis');
        $devi_id = $this->request->getQuery('devi_id');
        // creation new
        if($devi_id) {
            
            $indent = $this->Utilities->incrementIndent($this->FactureSituations->find()->orderAsc('indent')->last(), 'FS-');
            $newDatas = [
                'indent' => $indent,
                'date_crea' => Chronos::now(),
            ];
            
            $data = $this->FactureSituations->Devis->findById($devi_id)->contain(['FactureSituations'])->find('asModele', ['removed_client' => 0])->toArray();
            
            if(count($data['facture_situations'])) {
                $lastFactureSituation = $data['facture_situations'][count($data['facture_situations']) - 1];
                $lastData = $this->FactureSituations->findById($lastFactureSituation['id'])->find('asModel')->toArray();
                $data = array_merge($lastData, $newDatas);
                $data['numero'] = $data['numero'] + 1;
            } else {
                $data = array_merge($data, $newDatas);
                $data['numero'] = count($data['facture_situations']) + 1;
                $data['facture_situations_produits'] = $data['devis_produits'];
            }
            
            if($data) {
                
                $factureSituationEntity = $this->FactureSituations->newEntity($data);
                $currentUser = $this->Users->get($this->currentUser()->id, ['contain' => 'Payss']);
            }
        } elseif ($id) {
            $factureSituationEntity = $this->FactureSituations->findById($id)->find('complete')->first();
            $currentUser = $this->Users->get($factureSituationEntity->ref_commercial_id, ['contain' => 'Payss']);
        }
        
        $facture_situations_status = Configure::read('facture_situations_status');
        $commercials = $this->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name'])->where(['toujours_present' => 1]); // profile Konitys Commercial
        $this->set(compact('id', 'devi_id', 'factureSituationEntity', 'commercials', 'facture_situations_status', 'currentUser'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Facture Situation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $factureSituation = $this->FactureSituations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $factureSituation = $this->FactureSituations->patchEntity($factureSituation, $this->request->getData());
            if ($this->FactureSituations->save($factureSituation)) {
                $this->Flash->success(__('The facture situation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The facture situation could not be saved. Please, try again.'));
        }
        $devis = $this->FactureSituations->Devis->find('list', ['limit' => 200]);
        $refCommercials = $this->FactureSituations->RefCommercials->find('list', ['limit' => 200]);
        $clients = $this->FactureSituations->Clients->find('list', ['limit' => 200]);
        $this->set(compact('factureSituation', 'devis', 'refCommercials', 'clients'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Facture Situation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $factureSituation = $this->FactureSituations->get($id);
        if ($this->FactureSituations->delete($factureSituation)) {
            $this->Flash->success(__('The facture situation has been deleted.'));
        } else {
            $this->Flash->error(__('The facture situation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
