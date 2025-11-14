<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EvenementPipeEtapes Controller
 *
 * @property \App\Model\Table\EvenementPipeEtapesTable $EvenementPipeEtapes
 *
 * @method \App\Model\Entity\EvenementPipeEtape[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EvenementPipeEtapesController extends AppController
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
        $this->paginate = [
            'contain' => ['PipeEtapes', 'Evenements']
        ];
        $evenementPipeEtapes = $this->paginate($this->EvenementPipeEtapes);

        $this->set(compact('evenementPipeEtapes'));
    }

    /**
     * View method
     *
     * @param string|null $id Evenement Pipe Etape id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $evenementPipeEtape = $this->EvenementPipeEtapes->get($id, [
            'contain' => ['PipeEtapes', 'Evenements']
        ]);

        $this->set('evenementPipeEtape', $evenementPipeEtape);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($idPipeline)
    {
        $evenementPipeEtape = $this->EvenementPipeEtapes->newEntity();
        if ($this->request->is('post')) {
            $evenementPipeEtape = $this->EvenementPipeEtapes->patchEntity($evenementPipeEtape, $this->request->getData());
            if ($this->EvenementPipeEtapes->save($evenementPipeEtape)) {
                $this->Flash->success(__('The evenement pipe etape has been saved.'));

                
            }else{
                $this->Flash->error(__('The evenement pipe etape could not be saved. Please, try again.'));
            }
            
        }
        return $this->redirect(['controller'=>'Evenements','action' => 'pipeline', $idPipeline]);
        
    }
    
    public function deplace($idRelation){
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        $evenementPipeEtape = $this->EvenementPipeEtapes->get($idRelation, [
            'contain' => []
        ]);
        $res['success'] = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            //$data['pipe_etape_id'] = $idNouvelEtape;
            $evenementPipeEtape = $this->EvenementPipeEtapes->patchEntity($evenementPipeEtape, $this->request->getData());
            if ($this->EvenementPipeEtapes->save($evenementPipeEtape)) {
                $res['success'] = true;
            }else{
                debug($evenementPipeEtape);
            }
        }
        echo json_encode($res);
    }

    /**
     * Edit method
     *
     * @param string|null $id Evenement Pipe Etape id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $evenementPipeEtape = $this->EvenementPipeEtapes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $evenementPipeEtape = $this->EvenementPipeEtapes->patchEntity($evenementPipeEtape, $this->request->getData());
            if ($this->EvenementPipeEtapes->save($evenementPipeEtape)) {
                $this->Flash->success(__('The evenement pipe etape has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The evenement pipe etape could not be saved. Please, try again.'));
        }
        $pipeEtapes = $this->EvenementPipeEtapes->PipeEtapes->find('list', ['limit' => 200]);
        $evenements = $this->EvenementPipeEtapes->Evenements->find('list', ['limit' => 200]);
        $this->set(compact('evenementPipeEtape', 'pipeEtapes', 'evenements'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Evenement Pipe Etape id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $evenementPipeEtape = $this->EvenementPipeEtapes->get($id);
        if ($this->EvenementPipeEtapes->delete($evenementPipeEtape)) {
            $this->Flash->success(__('The evenement pipe etape has been deleted.'));
        } else {
            $this->Flash->error(__('The evenement pipe etape could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
