<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Filesystem\File;

/**
 * BonsLivraisons Controller
 *
 * @property \App\Model\Table\BonsLivraisonsTable $BonsLivraisons
 *
 * @method \App\Model\Entity\BonsLivraison[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BonsLivraisonsController extends AppController
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
        $this->paginate = [
            'contain' => ['Devis', 'BonsCommandes', 'Clients', 'Users']
        ];
        $bonsLivraisons = $this->paginate($this->BonsLivraisons);
        $commercials = $this->BonsLivraisons->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name'])->where(['toujours_present' => 1]); // profile Konitys Commercial

        $this->set(compact('bonsLivraisons', 'commercials'));
    }

    /**
     * View method
     *
     * @param string|null $id Bons Livraison id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bonsLivraison = $this->BonsLivraisons->get($id, [
            'contain' => ['Devis', 'Clients', 'Users', 'BonsLivraisonsProduits']
        ]);

        $this->set('bonsLivraison', $bonsLivraison);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bonsLivraison = $this->BonsLivraisons->newEntity();
        if ($this->request->is('post')) {
            $bonsLivraison = $this->BonsLivraisons->patchEntity($bonsLivraison, $this->request->getData());
            if ($this->BonsLivraisons->save($bonsLivraison)) {
                $this->Flash->success(__('The bons livraison has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bons livraison could not be saved. Please, try again.'));
        }
        $devis = $this->BonsLivraisons->Devis->find('list', ['limit' => 200]);
        $bonsCommandes = $this->BonsLivraisons->BonsCommandes->find('list', ['limit' => 200]);
        $clients = $this->BonsLivraisons->Clients->find('list', ['limit' => 200]);
        $users = $this->BonsLivraisons->Users->find('list', ['limit' => 200]);
        $this->set(compact('bonsLivraison', 'devis', 'bonsCommandes', 'clients', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bons Livraison id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bonsLivraison = $this->BonsLivraisons->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bonsLivraison = $this->BonsLivraisons->patchEntity($bonsLivraison, $this->request->getData());
            if ($this->BonsLivraisons->save($bonsLivraison)) {
                $this->Flash->success(__('The bons livraison has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bons livraison could not be saved. Please, try again.'));
        }
        $devis = $this->BonsLivraisons->Devis->find('list', ['limit' => 200]);
        $bonsCommandes = $this->BonsLivraisons->BonsCommandes->find('list', ['limit' => 200]);
        $clients = $this->BonsLivraisons->Clients->find('list', ['limit' => 200]);
        $users = $this->BonsLivraisons->Users->find('list', ['limit' => 200]);
        $this->set(compact('bonsLivraison', 'devis', 'bonsCommandes', 'clients', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bons Livraison id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bonsLivraison = $this->BonsLivraisons->get($id);
        if ($this->BonsLivraisons->delete($bonsLivraison)) {
            $this->Flash->success(__('The bons livraison has been deleted.'));
        } else {
            $this->Flash->error(__('The bons livraison could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function createBlFromBc($bp_id) {
        
        if ($bp_id) {
            
            //if ($this->request->is(['post'])) {
            
                    $bp = $this->BonsLivraisons->BonsCommandes->findById($bp_id)->contain(['BonsLivraisons'])->first();

                if ($bp->bons_livraisons) {
                    $this->Flash->error("Ce bons de commande est déjà convertir en bons de livraison");
                    return $this->redirect(['controller' => 'BonsCommandes', 'action' => 'view', $bp_id]);
                }
                
                $datas = $this->BonsLivraisons->BonsCommandes->findById($bp_id)->find('ToBonsLivraisons');
                
                if ($datas['statut'] == 'en_attente') {
                    
                    $this->Flash->error('Bons de préparation en attente de traitement');
                    return $this->redirect($this->referer());
                }
                
                $indent = $this->Utilities->incrementIndentByMonth($this->BonsLivraisons->find()->orderAsc('created')->last(), 'BLK-');
                $datas['indent'] = $indent;
                $datas['user_id'] = $this->currentUser()->id;
                $datas['bons_commande_id'] = $bp_id;
                $bl = $this->BonsLivraisons->newEntity($datas);

                if($this->BonsLivraisons->save($bl)) {
                    $this->Flash->success('Le bons de livraison ont été enregisté avec succés');
                    $this->redirect(['action' => 'generationPdf', $bl->id]);
                    
                     if ($datas['statut'] == 'en_prepa') {
                    
                         $datasClone =  $this->BonsLivraisons->BonsCommandes->findById($bp_id)->find('ToClone');
                         $cloneBp = $this->BonsLivraisons->BonsCommandes->newEntity($datasClone);
                         $this->BonsLivraisons->BonsCommandes->save($cloneBp);
                    }
                    
                    $bp = $this->BonsLivraisons->BonsCommandes->findById($bp_id)->first();
                    $bp = $this->BonsLivraisons->BonsCommandes->patchEntity($bp, ['statut' => 'expedie']);
                    $this->BonsLivraisons->BonsCommandes->save($bp);
                    
                } else {
                    debug($bl->getErrors());die;
                }
            //}
        }
        
        $this->redirect($this->referer());
    }
    
    
    /**
     * 
     * @param type $bl_id
     * @param type $downloadMode
     * @return type
     */
    public function generationPdf($bl_id)
    {
        
        $this->loadModel('DevisPreferences');

        $preferenceEntity = $this->DevisPreferences->find('complete')->first(); // préférence du doc par défaut

        $blEntity = $this->BonsLivraisons->get($bl_id, [
            'contain' => ['Clients', 'Users', 'BonsLivraisonsProduits']
        ]);
            
        if($blEntity->is_in_sellsy) {
            return ;
        }
            
        $currentUser = $this->BonsLivraisons->Users->get($blEntity->user_id, ['contain' => 'Payss']);

        $this->set(compact('preferenceEntity', 'currentUser','blEntity'));
        
        // GENERATION FICHIER
        $viewBuilder = $this->viewBuilder()->setClassName('Dompdf.Pdf')->setLayout('pdf/dompdf.default');
        $pdfOptions = Configure::read('DevisPdf');
        $viewBuilder->setOptions($pdfOptions);
        $content = $this->render('pdf/pdfversion');
        
        $file_name = PATH_DEVIS . $blEntity->indent.'.pdf';
        if(file_exists($file_name)) {
            unlink($file_name);
        }
        $file = new File($file_name, true, 0755);
        $file->write($content);
        
        $this->redirect(['action' => 'view', $bl_id]);
    }
    
    
    public function pdfversion($bl_id)
    {
        
        $blEntity = $this->BonsLivraisons->get($bl_id, [
            'contain' => []
        ]);
        $download = $this->request->getQuery('download');
            
        return $this->response->withFile(WWW_ROOT  . $blEntity->get('DocUrl'), ['download' => $download]);
    }
    
}
