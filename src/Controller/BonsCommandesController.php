<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Filesystem\File;

/**
 * BonsCommandes Controller
 *
 * @property \App\Model\Table\BonsCommandesTable $BonsCommandes
 *
 * @method \App\Model\Entity\BonsCommande[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BonsCommandesController extends AppController
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
        
        $bp_statut = Configure::read('bp_statut');
        $statut_couleurs = Configure::read('vente_statut_couleur');
        $type_date = Configure::read('type_date');
        $customFinderOptions = $this->request->getQuery();
        $user_id = $this->request->getQuery('user_id');
        $type = $this->request->getQuery('type_date');
        $keyword = $this->request->getQuery('keyword');
        
        $bonsCommandes = $this->BonsCommandes->find('complete')->find('filtre', $customFinderOptions);
        
        $bonsCommandes = $this->paginate($bonsCommandes, ['limit' => 50]);
        $commercials = $this->BonsCommandes->Users->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name'])->where(['toujours_present' => 1]); // profile Konitys Commercial

        $this->set(compact('bonsCommandes', 'type_date', 'commercials', 'keyword', 'type', 'user_id', 'bp_statut', 'statut_couleurs'));
    }

    /**
     * View method
     *
     * @param string|null $id Bons Commande id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $type_date = Configure::read('type_date');
        
        $bonsCommande = $this->BonsCommandes->get($id, [
            'contain' => ['Users', 'BonsCommandesProduits', 'Clients', 'CloneBc', 'Devis']
        ]);
        
        if ($bonsCommande->clone_bc) {
            return $this->redirect(['action' => 'view', $bonsCommande->clone_bc[0]->id]);
        }
        $this->set(compact('bonsCommande', 'type_date'));
        if ($bonsCommande->is_prepa) {
            $this->render('view_prepa');
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Bons Commande id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('devis');
        
        $bonsPrepa = $this->BonsCommandes->get($id, [
            'contain' => ['Clients', 'CloneBc', 'BonsLivraisons' , 'BonsCommandesProduits'=> function ($q) {
            return $q->order(['BonsCommandesProduits.i_position'=>'ASC']);
        }]]);
        
        if ($bonsPrepa->clone_bc) {
            return $this->redirect(['action' => 'view', $bonsPrepa->clone_bc[0]->id]);
        }
        
        if ($bonsPrepa->bons_livraisons) {
            $this->Flash->error("Ce bons de commande est déjà convertir en bons de livraison");
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
            
            $bonsPrepa = $this->BonsCommandes->patchEntity($bonsPrepa, $datas);
            if ($this->BonsCommandes->save($bonsPrepa)) {
                $this->Flash->success(__('The bons commande has been saved.'));

                if ($datas['action'] == 'print') {
                    $this->generationPdf($id);
                    return $this->redirect(['action' => 'pdfversion', $id]);
                }
                if ($datas['action'] == 'quit') {
                    return $this->redirect(['action' => 'index']);
                }
                return $this->redirect(['action' => 'edit', $id]);
            }
            $this->Flash->error(__('The bons commande could not be saved. Please, try again.'));
        }
        
        $type_date = Configure::read('type_date');
        $statut_ligne = Configure::read('statut_ligne');
        
        $this->set(compact('bonsPrepa', 'type_date', 'statut_ligne'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bons Commande id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bonsCommande = $this->BonsCommandes->get($id);
        if ($this->BonsCommandes->delete($bonsCommande)) {
            $this->Flash->success(__('The bons commande has been deleted.'));
        } else {
            $this->Flash->error(__('The bons commande could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    
    /**
     * version pdf document devis
     * @param type $devis_id
     * @param type $downloadMode
     * @return type
     */
    public function pdfversion($bc_id, $downloadMode = null, $print = false)
    {
        $forceGenerate = $this->request->getQuery('forceGenerate');
        $testMode = $this->request->getQuery('test'); // pour faire un debug en rendu html
        $download = $this->request->getQuery('download');
        $bcEntity = $this->BonsCommandes->get($bc_id, [
            'contain' => ['Users', 'BonsCommandesProduits', 'Clients']
        ]);

        if ($forceGenerate) {
            $this->generationPdf($bc_id);
            return $this->response->withFile(WWW_ROOT  . $bcEntity->get('DocUrl'), ['download' => $download?$download:$downloadMode,]);
        }

        if (! is_file(WWW_ROOT  . $bcEntity->get('DocUrl'))) {
            $this->generationPdf($bc_id);
        }
        return $this->response->withFile(WWW_ROOT  . $bcEntity->get('DocUrl'), ['download' => $download?$download:$downloadMode,]);

    }
    
    
    /**
     * 
     * @param type $devis_id
     * @param type $downloadMode
     * @return type
     */
    public function generationPdf($bc_id)
    {
        $this->loadModel('DevisPreferences');
        $preferenceEntity = $this->DevisPreferences->find('complete')->first(); // préférence du doc par défaut

        $type_date = Configure::read('type_date');

        
        $bonsCommande = $this->BonsCommandes->get($bc_id, [
            'contain' => ['Users', 'BonsCommandesProduits', 'Clients']
        ]);

        $this->set(compact('bonsCommande', 'type_date', 'preferenceEntity'));
        // GENERATION FICHIER
        $viewBuilder = $this->viewBuilder()->setClassName('Dompdf.Pdf')->setLayout('pdf/dompdf.default');
        $pdfOptions = Configure::read('DevisPdf');
        $viewBuilder->setOptions($pdfOptions);
        $content = $this->render('pdf/pdfversion');
        $file_name = PATH_BC . $bonsCommande->indent.'.pdf';
        if(file_exists($file_name)) {
            unlink($file_name);
        }
        $file = new File($file_name, true, 0755);
        $file->write($content);
    }
    
    
    public function CreateBcByDevis($devi_id) {
        
        if ($devi_id) {
            
            if ($this->request->is(['post'])) {
                
                $type_date = Configure::read('type_date');

                $datas = $this->BonsCommandes->Devis->findById($devi_id)->find('ToBonsCommande');
                $datas = array_merge($datas, $this->request->getData());
                $indent = $this->Utilities->incrementIndentByMonth($this->BonsCommandes->find()->orderAsc('created')->last());
                $datas['indent'] = $indent;
                $datas['user_id'] = $this->currentUser()->id;
                $bc = $this->BonsCommandes->newEntity($datas);

                if($this->BonsCommandes->save($bc)) {

                    $devis = $this->BonsCommandes->Devis->findById($devi_id)->first();
                    $devis = $this->BonsCommandes->Devis->patchEntity($devis, ['status' => 'accepted']);
                    $this->BonsCommandes->Devis->save($devis);

                    $bc = $this->BonsCommandes->get($bc->id, [
                        'contain' => ['Users', 'Clients']
                    ]);

                    $this->loadModel('Emails');
                    $options = [
                        'test' => false,
                        'from' => 'Konitys',
                        'fromEmail' => 's.mahe@konitys.fr',
                        'subject' => 'Fiche  bons de commande créé',
                        'template' => 'creation_bc',
                    ];

                    $host = $this->request->getEnv('HTTP_HOST');
                    if ($host != '127.0.0.1' && $host != 'localhost') { 
                        $email = $this->Emails->sendTo([
                            //'email' => 'manoarazafindrabe@gmail.com', 
                            'email' => 'logistique@konitys.fr', 
                            'bcc' => ['m.constantin@konitys.fr', 's.mahe@konitys.fr'], 
                            'bc' => $bc,
                            'type_date' => $type_date
                        ], 
                        $options);
                    }
                    
                    $this->Flash->success('Le bons de commande ont été enregisté avec succés');
                } else {
                    debug($bc->getErrors());die;
                }
            }
        }
        
        $this->redirect($this->referer());
    }
    
    public function prepareCommande($id) {
        
        $command = $this->BonsCommandes->findById($id)->first();
        $command = $this->BonsCommandes->patchEntity($command, ['is_prepa' => 1]);
        if ($this->BonsCommandes->save($command)) {
            $this->redirect(['action' => 'edit', $id]);
        }
        $this->redirect($this->referer());
    }
}
