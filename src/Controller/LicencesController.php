<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Licences Controller
 *
 * @property \App\Model\Table\LicencesTable $Licences
 *
 * @method \App\Model\Entity\Licence[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LicencesController extends AppController
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
        $type = $this->request->getQuery('type');
        $email = $this->request->getQuery('email');
        $numero_serie = $this->request->getQuery('numero_serie');
        $version = $this->request->getQuery('version');
        $borne = $this->request->getQuery('borne');
        $key = $this->request->getQuery('key');
        $dispo = $this->request->getQuery('dispo');


        $customFinderOptions = [
            'key' => $key,
            'type' => $type,
            'email'=> $email,
            'numero_serie' => $numero_serie,
            'version' => $version,
            'borne' => $borne,
            'dispo' => $dispo,
        ];

        $this->paginate = [
            'contain' => ['TypeLicences','Bornes' => ['ModelBornes' => 'GammesBornes']],
            'finder' => [
                'filtre' => $customFinderOptions
            ]
        ];
        $types = $this->Licences->TypeLicences->find('list', ['valueField'=>'nom']);
        $emails = $this->Licences->find('list', ['valueField'=>'email']);
        $versions = $this->Licences->find('list', ['valueField'=>'version']);

        $licences = $this->paginate($this->Licences);



        $this->set(compact('key','type','email','numero_serie','version','borne'));
        $this->set(compact('licences','types', 'dispo'));
    }

    /**
     * View method
     *
     * @param string|null $id Licence id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $licence = $this->Licences->get($id, [
            'contain' => ['TypeLicences', 'LicenceBornes', 'Bornes']
        ]);



        $bornes = $licence->bornes;



        $this->set(compact('licence', 'bornes'));
        $this->set('licence', $licence);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $licence = $this->Licences->newEntity();
        if ($this->request->is('post')) {
            $licence = $this->Licences->patchEntity($licence, $this->request->getData());
            if ($this->Licences->save($licence)) {
                $this->setDispo($licence->id);
                $this->Flash->success(__('The licence has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The licence could not be saved. Please, try again.'));
        }
        $bornes = $this->Licences->Bornes->find('list', ['valueField' => 'numero']);
        $typeLicences = $this->Licences->TypeLicences->find('list', ['valueField'=>'nom']);
        $this->set(compact('licence', 'typeLicences', 'bornes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Licence id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $licence = $this->Licences->get($id, [
            'contain' => ['Bornes']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $licence = $this->Licences->patchEntity($licence, $this->request->getData());
            if ($this->Licences->save($licence)) {
                $this->setDispo($id);
                $this->Flash->success(__('The licence has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The licence could not be saved. Please, try again.'));
        }
        $bornes = $this->Licences->Bornes->find('list', ['valueField' => 'numero']);
        $typeLicences = $this->Licences->TypeLicences->find('list', ['valueField'=>'nom']);
        $this->set(compact('licence', 'typeLicences', 'bornes'));
    }
    
    public function setDispo($licence_id) {
        
        $licenceBorne = $this->Licences->LicenceBornes->findByLicenceId($licence_id)->toArray();
        $licence = $this->Licences->findById($licence_id)->first();
        $nombre_utilisateur = $licence->nombre_utilisateur;
        if(count($licenceBorne) >= $nombre_utilisateur) {
            $data = ['dispo' => 0];
        } else {
            $data = ['dispo' => 1];
        }
        $licence = $this->Licences->patchEntity($licence, $data);
        $this->Licences->save($licence);
        return;
    }

    /**
     * Delete method
     *
     * @param string|null $id Licence id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $licence = $this->Licences->get($id);
        if ($this->Licences->delete($licence)) {
            $this->Flash->success(__('The licence has been deleted.'));
        } else {
            $this->Flash->error(__('The licence could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
