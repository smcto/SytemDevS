<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Materiels Controller
 *
 * @property \App\Model\Table\MaterielsTable $Materiels
 *
 * @method \App\Model\Entity\Materiel[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MaterielsController extends AppController
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
        $materiels = $this->paginate($this->Materiels);

        $this->set(compact('materiels'));
    }

    /**
     * View method
     *
     * @param string|null $id Materiel id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $materiel = $this->Materiels->get($id, [
            'contain' => []
        ]);

        $this->set('materiel', $materiel);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $materiel = $this->Materiels->newEntity();
        $data = $this->request->getData();
        if ($this->request->is('post')) {
            if(!empty($data['photos']['name'])){
                $fileName = $data['photos']['name'];
                $uploadPath = 'uploads/materiel/';
                $uploadFile = $uploadPath.$fileName;
                if(move_uploaded_file($data['photos']['tmp_name'], $uploadFile)){
                    $data['photos'] = $fileName;

                }
            }
            $materiel = $this->Materiels->patchEntity($materiel, $data);
            if ($this->Materiels->save($materiel)) {
                $this->Flash->success(__('The materiel has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The materiel could not be saved. Please, try again.'));
        }
        $this->set(compact('materiel'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Materiel id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $materiel = $this->Materiels->get($id, [
            'contain' => []
        ]);
        $data = $this->request->getData();
        if ($this->request->is(['patch', 'post', 'put'])) {
            if(!empty($data['photos']['name'])){
                $fileName = $data['photos']['name'];
                $uploadPath = 'uploads/materiel/';
                $uploadFile = $uploadPath.$fileName;
                if(move_uploaded_file($data['photos']['tmp_name'], $uploadFile)){
                    $data['photos'] = $fileName;

                }
            }
            $materiel = $this->Materiels->patchEntity($materiel, $data);
            if ($this->Materiels->save($materiel)) {
                $this->Flash->success(__('The materiel has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The materiel could not be saved. Please, try again.'));
        }
        $this->set(compact('materiel'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Materiel id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $materiel = $this->Materiels->get($id);
        if ($this->Materiels->delete($materiel)) {
            $this->Flash->success(__('The materiel has been deleted.'));
        } else {
            $this->Flash->error(__('The materiel could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
