<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Fichiers Controller
 *
 * @property \App\Model\Table\FichiersTable $Fichiers
 *
 * @method \App\Model\Entity\Fichier[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FichiersController extends AppController
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
            'contain' => ['Antennes', 'Posts', 'ActuBornes', 'ModelBornes']
        ];
        $fichiers = $this->paginate($this->Fichiers);

        $this->set(compact('fichiers'));
    }

    /**
     * View method
     *
     * @param string|null $id Fichier id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fichier = $this->Fichiers->get($id, [
            'contain' => ['Antennes', 'Posts', 'ActuBornes', 'ModelBornes']
        ]);

        $this->set('fichier', $fichier);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fichier = $this->Fichiers->newEntity();
        if ($this->request->is('post')) {
            $fichier = $this->Fichiers->patchEntity($fichier, $this->request->getData());
            if ($this->Fichiers->save($fichier)) {
                $this->Flash->success(__('The fichier has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fichier could not be saved. Please, try again.'));
        }
        $antennes = $this->Fichiers->Antennes->find('list', ['limit' => 200]);
        $posts = $this->Fichiers->Posts->find('list', ['limit' => 200]);
        $actuBornes = $this->Fichiers->ActuBornes->find('list', ['limit' => 200]);
        $modelBornes = $this->Fichiers->ModelBornes->find('list', ['limit' => 200]);
        $this->set(compact('fichier', 'antennes', 'posts', 'actuBornes', 'modelBornes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Fichier id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $fichier = $this->Fichiers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fichier = $this->Fichiers->patchEntity($fichier, $this->request->getData());
            if ($this->Fichiers->save($fichier)) {
                $this->Flash->success(__('The fichier has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fichier could not be saved. Please, try again.'));
        }
        $antennes = $this->Fichiers->Antennes->find('list', ['limit' => 200]);
        $posts = $this->Fichiers->Posts->find('list', ['limit' => 200]);
        $actuBornes = $this->Fichiers->ActuBornes->find('list', ['limit' => 200]);
        $modelBornes = $this->Fichiers->ModelBornes->find('list', ['limit' => 200]);
        $this->set(compact('fichier', 'antennes', 'posts', 'actuBornes', 'modelBornes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Fichier id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fichier = $this->Fichiers->get($id);
        if ($this->Fichiers->delete($fichier)) {
            $this->Flash->success(__('The fichier has been deleted.'));
        } else {
            $this->Flash->error(__('The fichier could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function viewFile($idFichier = null, $download = true)
    {
        $fichier = $this->Fichiers->get($idFichier);
        $path = $fichier->chemin;

        $extension = explode('.', $fichier->nom_fichier)[1];
        $this->response->header([
            'Content-Type' => 'application/' . $extension
            //'Content-Type', 'application/' . $extension
        ]);
        $this->response->withFile($path, [
            'download' => $download,
            'name' => $fichier->nom_origine]);

        return $this->response;
    }
}
