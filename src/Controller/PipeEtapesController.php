<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PipeEtapes Controller
 *
 * @property \App\Model\Table\PipeEtapesTable $PipeEtapes
 *
 * @method \App\Model\Entity\PipeEtape[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PipeEtapesController extends AppController
{
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if(array_intersect(['admin', 'konitys'], $typeprofils)) {
            return true;
        }

        if($action == "getOrdre") {
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
        $pipe = $this->request->getQuery('pipe');

        $customFinderOptions = [
            'pipe' => $pipe,
        ];

        $this->paginate = [
            'contain' => ['Pipes'],
            'order'=>['ordre'=>'ASC'],
            'finder' => [
                'filtre' => $customFinderOptions
            ]
        ];
        $pipeEtapes = $this->paginate($this->PipeEtapes);
        $pipes = $this->PipeEtapes->Pipes->find('list', ['valueField'=>'nom']);

        $this->set(compact('pipeEtapes', 'pipes', 'pipe'));
    }

    /**
     * View method
     *
     * @param string|null $id Pipe Etape id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pipeEtape = $this->PipeEtapes->get($id, [
            'contain' => ['Pipes', 'EvenementPipeEtapes']
        ]);

        $this->set('pipeEtape', $pipeEtape);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pipeEtape = $this->PipeEtapes->newEntity();
       //debug($this->request->getData()); die;
        $lastOrdre = $this->PipeEtapes->find('list', [
            'valueField' => 'ordre',
            'order'=>['ordre'=>'ASC']
        ])->last();
        if ($this->request->is('post')) {
            
            $pipeEtape = $this->PipeEtapes->patchEntity($pipeEtape, $this->request->getData());
            $pipeEtape->ordre = $lastOrdre + 1;
            if ($this->PipeEtapes->save($pipeEtape)) {
                $this->Flash->success(__('The pipe etape has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pipe etape could not be saved. Please, try again.'));
        }
         
        $pipes = $this->PipeEtapes->Pipes->find('list', ['valueField' => "nom"]);
        $this->set(compact('pipeEtape', 'pipes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pipe Etape id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function save()
    {
        $pipeEtape = $this->PipeEtapes->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            //debug($this->request->getData());
            $pipeEtape = $this->PipeEtapes->patchEntity($pipeEtape, $this->request->getData(),['associated'=>['Evenements'],'validate'=>false]);
            //
            if ($this->PipeEtapes->save($pipeEtape)) {
                $this->Flash->success(__('Evénement ajouté dans l\'étape'));
            }else{
                //debug($pipeEtape); die;
                $this->Flash->error(__('Une erreur est survenue. Veuillez réessayer plus tard.'));
            }
            return $this->redirect(['controller'=>'Evenements', 'action' => 'pipeline', '?' => ['pipe'=>$pipeEtape->pipe_id] ]);
        }


    }

    /**
     * Edit method
     *
     * @param string|null $id Pipe Etape id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id)
    {
        $pipeEtape = $this->PipeEtapes->get($id, [
            'contain' => ['Pipes']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            //debug($this->request->getData());
            $pipeEtape = $this->PipeEtapes->patchEntity($pipeEtape, $this->request->getData(),['associated'=>['Evenements'],'validate'=>false]);
            //
            if ($this->PipeEtapes->save($pipeEtape)) {
                $this->Flash->success(__('The pipe etape has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pipe etape could not be saved. Please, try again.'));
        }
        $pipes = $this->PipeEtapes->Pipes->find('list', ['valueField' => "nom"]);
        $this->set(compact('pipeEtape', 'pipes'));
    }
    /**
     * Delete method
     *
     * @param string|null $id Pipe Etape id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pipeEtape = $this->PipeEtapes->get($id);
        if ($this->PipeEtapes->delete($pipeEtape)) {
            $this->Flash->success(__('The pipe etape has been deleted.'));
        } else {
            $this->Flash->error(__('The pipe etape could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getOrdre(){
        $this->viewBuilder()->setLayout('ajax');
        //$this->autoRender = false;
        $newList = $_POST['new_list'];
        //debug($this->request);die;
        foreach ($newList as $key => $pipe_etat){
            $pipe = $this->PipeEtapes->get($pipe_etat);
            $pipe->ordre = $key + 1;
            $this->PipeEtapes->save($pipe);
            $res["".$key] = $pipe_etat;
        }
        //echo json_encode($res);
        $pipeEtapes = $this->PipeEtapes->find('all',[
                'order'=>['ordre'=>'ASC']
            ]
        );
        $this->paginate = [
            'contain' => ['Pipes'],
            'order' => ['order'=> 'ASC'],
        ];
        $pipeEtapes = $this->paginate($pipeEtapes);
        $this->set('pipeEtapes', $pipeEtapes);
    }
}
