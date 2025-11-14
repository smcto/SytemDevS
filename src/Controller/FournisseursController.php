<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

/**
 * Fournisseurs Controller
 *
 * @property \App\Model\Table\FournisseursTable $Fournisseurs
 *
 * @method \App\Model\Entity\Fournisseur[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FournisseursController extends AppController
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
        $key = $this->request->getQuery('key');
        $type_fournisseur = $this->request->getQuery('type_fournisseur');
        $customFinderOptions = [
            'key' => $key,
            'type_fournisseur' => $type_fournisseur,
        ];
        $this->paginate = [
            'contain' => ['Antennes','TypeFournisseurs'],
                'finder' => [
                'filtre' => $customFinderOptions
            ]
        ];
        $type_fournisseurs = $this->Fournisseurs->TypeFournisseurs->find('list',['valueField'=>'nom']);
        $fournisseurs = $this->paginate($this->Fournisseurs);
        //Log::warning('test_log '.debug($fournisseurs), ['scope' => ['test_scope']]);

        $this->set(compact('type_fournisseur','key'));
        $this->set(compact('fournisseurs','type_fournisseurs'));
    }

    /**
     * View method
     *
     * @param string|null $id Fournisseur id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fournisseur = $this->Fournisseurs->get($id, [
            'contain' => ['Antennes', 'TypeFournisseurs', 'Users']
        ]);

        $this->set('fournisseur', $fournisseur);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fournisseur = $this->Fournisseurs->newEntity();
        if ($this->request->is('post')) {
            $fournisseur = $this->Fournisseurs->patchEntity($fournisseur, $this->request->getData());
            if ($this->Fournisseurs->save($fournisseur)) {
                $this->Flash->success(__('The fournisseur has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fournisseur could not be saved. Please, try again.'));
        }
        $antennes = $this->Fournisseurs->Antennes->find('list', ['valueField' => 'ville_excate']);
        $typeFournisseurs = $this->Fournisseurs->TypeFournisseurs->find('list', ['valueField' => 'nom']);
        $this->set(compact('fournisseur', 'antennes', 'typeFournisseurs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Fournisseur id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $fournisseur = $this->Fournisseurs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fournisseur = $this->Fournisseurs->patchEntity($fournisseur, $this->request->getData());
            if ($this->Fournisseurs->save($fournisseur)) {
                $this->Flash->success(__('The fournisseur has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fournisseur could not be saved. Please, try again.'));
        }
        $antennes = $this->Fournisseurs->Antennes->find('list' ,['valueField' => 'ville_excate']);
        $typeFournisseurs = $this->Fournisseurs->TypeFournisseurs->find('list', ['valueField' => 'nom']);
        $this->set(compact('fournisseur', 'antennes', 'typeFournisseurs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Fournisseur id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fournisseur = $this->Fournisseurs->get($id);
        if ($this->Fournisseurs->delete($fournisseur)) {
            $this->Flash->success(__('The fournisseur has been deleted.'));
        } else {
            $this->Flash->error(__('The fournisseur could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
