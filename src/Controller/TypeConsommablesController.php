<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TypeConsommables Controller
 *
 * @property \App\Model\Table\TypeConsommablesTable $TypeConsommables
 *
 * @method \App\Model\Entity\TypeConsommable[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypeConsommablesController extends AppController
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

    public function index()
    {
        $typeConsommables = $this->paginate($this->TypeConsommables->find()->contain(['SousTypesConsommables']));
        $this->set(compact('typeConsommables'));
    }


    public function view($id = null)
    {
        $typeConsommable = $this->TypeConsommables->get($id, [
            'contain' => []
        ]);

        $this->set('typeConsommable', $typeConsommable);
    }

    public function add($id = null)
    {
        $typeConsommable = $this->TypeConsommables->newEntity();
        if ($id) {
            $typeConsommable = $this->TypeConsommables->findById($id)->first();
        }

        if ($this->request->is(['post', 'put'])) {
            $typeConsommable = $this->TypeConsommables->patchEntity($typeConsommable, $this->request->getData());
            if ($this->TypeConsommables->save($typeConsommable)) {
                $this->Flash->success(__('The type consommable has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type consommable could not be saved. Please, try again.'));
        }
        $this->set(compact('typeConsommable', 'id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Type Consommable id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $typeConsommable = $this->TypeConsommables->get($id);
        if ($this->TypeConsommables->delete($typeConsommable)) {
            $this->Flash->success(__('The type consommable has been deleted.'));
        } else {
            $this->Flash->error(__('The type consommable could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
