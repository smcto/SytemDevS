<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * TypeLicences Controller
 *
 * @property \App\Model\Table\TypeLicencesTable $TypeLicences
 *
 * @method \App\Model\Entity\TypeLicence[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypeLicencesController extends AppController
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
        $typeLicences = $this->paginate($this->TypeLicences);

        $this->set(compact('typeLicences'));
    }

    /**
     * View method
     *
     * @param string|null $id Type Licence id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $typeLicence = $this->TypeLicences->get($id, [
            'contain' => []
        ]);

        $this->set('typeLicence', $typeLicence);
    }

    
    
    public function updateLicences($type_licence, $nombre = null) {

        $this->autoRender = false;
        $licences = TableRegistry::getTableLocator()->get('Licences');
        $query_licences = $licences->query();
        $query_licences->update()
            ->set(['nombre_utilisateur' => $nombre])
            ->where(['type_licence_id' => $type_licence])
            ->execute();
        
        $this->loadModel('Licences');
        
        $licencesEntities = $this->Licences->find('all')->where(['type_licence_id' => $type_licence]);
        foreach ($licencesEntities as $licenceEntity) {
            // $this->requestAction('/fr/licences/set-dispo/' . $licenceEntity->id);
            
            $licenceBorne = $this->Licences->LicenceBornes->findByLicenceId($licenceEntity->id)->toArray();
            if(count($licenceBorne) >= $nombre) {
                $data = ['dispo' => 0];
            } else {
                $data = ['dispo' => 1];
            }
            $licence = $this->Licences->patchEntity($licenceEntity, $data);
            $this->Licences->save($licence);
        }
    }
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $typeLicence = $this->TypeLicences->newEntity();
        if ($this->request->is('post')) {
            $typeLicence = $this->TypeLicences->patchEntity($typeLicence, $this->request->getData());
            if ($this->TypeLicences->save($typeLicence)) {
                // $this->updateLicences($typeLicence->id, $this->request->getData('nombre_utilisation'));
                $this->Flash->success(__('The type licence has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type licence could not be saved. Please, try again.'));
        }
        $this->set(compact('typeLicence'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Type Licence id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $typeLicence = $this->TypeLicences->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $typeLicence = $this->TypeLicences->patchEntity($typeLicence, $this->request->getData());
            if ($this->TypeLicences->save($typeLicence)) {
                $this->updateLicences($typeLicence->id, $this->request->getData('nombre_utilisation'));
                $this->Flash->success(__('The type licence has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type licence could not be saved. Please, try again.'));
        }
        $this->set(compact('typeLicence'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Type Licence id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $typeLicence = $this->TypeLicences->get($id);
        if ($this->TypeLicences->delete($typeLicence)) {
            $this->Flash->success(__('The type licence has been deleted.'));
        } else {
            $this->Flash->error(__('The type licence could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    
    public function getNombreUtilisation($type_licence_id = null) {
        $return = ['status' => 0];
        $type_licence = $this->TypeLicences->findById($type_licence_id)->first();
        if($type_licence) {
            $return = ['status' => 1, 'nombre' => $type_licence->nombre_utilisation];
        } else if($type_licence_id == null) {
            $return = ['status' => 1, 'nombre' => null];
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($return));
    }
    
}
