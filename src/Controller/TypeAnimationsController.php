<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TypeAnimations Controller
 *
 * @property \App\Model\Table\TypeAnimationsTable $TypeAnimations
 *
 * @method \App\Model\Entity\TypeAnimation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypeAnimationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $typeAnimations = $this->paginate($this->TypeAnimations);

        $this->set(compact('typeAnimations'));
    }

    /**
     * View method
     *
     * @param string|null $id Type Animation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $typeAnimation = $this->TypeAnimations->get($id, [
            'contain' => ['Evenements']
        ]);

        $this->set('typeAnimation', $typeAnimation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $typeAnimation = $this->TypeAnimations->newEntity();
        if ($this->request->is('post')) {
            $typeAnimation = $this->TypeAnimations->patchEntity($typeAnimation, $this->request->getData());
            if ($this->TypeAnimations->save($typeAnimation)) {
                $this->Flash->success(__('The type animation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type animation could not be saved. Please, try again.'));
        }
        $this->set(compact('typeAnimation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Type Animation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $typeAnimation = $this->TypeAnimations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $typeAnimation = $this->TypeAnimations->patchEntity($typeAnimation, $this->request->getData());
            if ($this->TypeAnimations->save($typeAnimation)) {
                $this->Flash->success(__('The type animation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type animation could not be saved. Please, try again.'));
        }
        $this->set(compact('typeAnimation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Type Animation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $typeAnimation = $this->TypeAnimations->get($id);
        if ($this->TypeAnimations->delete($typeAnimation)) {
            $this->Flash->success(__('The type animation has been deleted.'));
        } else {
            $this->Flash->error(__('The type animation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
