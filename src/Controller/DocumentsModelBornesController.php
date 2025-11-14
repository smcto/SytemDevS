<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DocumentsModelBornes Controller
 *
 * @property \App\Model\Table\DocumentsModelBornesTable $DocumentsModelBornes
 *
 * @method \App\Model\Entity\DocumentsModelBorne[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentsModelBornesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ModelBornes']
        ];
        $documentsModelBornes = $this->paginate($this->DocumentsModelBornes);

        $this->set(compact('documentsModelBornes'));
    }

    /**
     * View method
     *
     * @param string|null $id Documents Model Borne id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $documentsModelBorne = $this->DocumentsModelBornes->get($id, [
            'contain' => ['ModelBornes']
        ]);

        $this->set('documentsModelBorne', $documentsModelBorne);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $documentsModelBorne = $this->DocumentsModelBornes->newEntity();
        if ($this->request->is('post')) {
            $documentsModelBorne = $this->DocumentsModelBornes->patchEntity($documentsModelBorne, $this->request->getData());
            if ($this->DocumentsModelBornes->save($documentsModelBorne)) {
                $this->Flash->success(__('The documents model borne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The documents model borne could not be saved. Please, try again.'));
        }
        $modelBornes = $this->DocumentsModelBornes->ModelBornes->find('list', ['limit' => 200]);
        $this->set(compact('documentsModelBorne', 'modelBornes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Documents Model Borne id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $documentsModelBorne = $this->DocumentsModelBornes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documentsModelBorne = $this->DocumentsModelBornes->patchEntity($documentsModelBorne, $this->request->getData());
            if ($this->DocumentsModelBornes->save($documentsModelBorne)) {
                $this->Flash->success(__('The documents model borne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The documents model borne could not be saved. Please, try again.'));
        }
        $modelBornes = $this->DocumentsModelBornes->ModelBornes->find('list', ['limit' => 200]);
        $this->set(compact('documentsModelBorne', 'modelBornes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Documents Model Borne id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $documentsModelBorne = $this->DocumentsModelBornes->get($id);
        if ($this->DocumentsModelBornes->delete($documentsModelBorne)) {
            $this->Flash->success(__('The documents model borne has been deleted.'));
        } else {
            $this->Flash->error(__('The documents model borne could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
