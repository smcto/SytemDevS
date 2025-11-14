<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TypeInstallations Controller
 *
 * @property \App\Model\Table\TypeInstallationsTable $TypeInstallations
 *
 * @method \App\Model\Entity\TypeInstallation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypeInstallationsController extends AppController
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
        $typeInstallations = $this->paginate($this->TypeInstallations);
		
		$this->paginate = [
			'conditions' => [
				'TypeInstallations.type' => 1
			]
		];
		
		$installations = $this->paginate($this->TypeInstallations);
		
		$this->paginate = [
			'conditions' => [
				'TypeInstallations.type' => 0
			]
		];
		
		$desinstallations = $this->paginate($this->TypeInstallations);
		
        $this->set(compact('installations', 'desinstallations'));
    }

    /**
     * View method
     *
     * @param string|null $id Type Installation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $typeInstallation = $this->TypeInstallations->get($id, [
            'contain' => []
        ]);

        $this->set('typeInstallation', $typeInstallation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $typeInstallation = $this->TypeInstallations->newEntity();
        if ($this->request->is('post')) {
            $typeInstallation = $this->TypeInstallations->patchEntity($typeInstallation, $this->request->getData());
            if ($this->TypeInstallations->save($typeInstallation)) {
                $this->Flash->success(__('The type installation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type installation could not be saved. Please, try again.'));
        }
        $this->set(compact('typeInstallation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Type Installation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $typeInstallation = $this->TypeInstallations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $typeInstallation = $this->TypeInstallations->patchEntity($typeInstallation, $this->request->getData());
            if ($this->TypeInstallations->save($typeInstallation)) {
                $this->Flash->success(__('The type installation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type installation could not be saved. Please, try again.'));
        }
        $this->set(compact('typeInstallation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Type Installation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $typeInstallation = $this->TypeInstallations->get($id);
        if ($this->TypeInstallations->delete($typeInstallation)) {
            $this->Flash->success(__('The type installation has been deleted.'));
        } else {
            $this->Flash->error(__('The type installation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
