<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * TypeEquipements Controller
 *
 * @property \App\Model\Table\TypeEquipementsTable $TypeEquipements
 *
 * @method \App\Model\Entity\TypeEquipement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypeEquipementsController extends AppController
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
        $gamme_borne_id = $this->request->getQuery('gamme_borne_id');
        $type = $this->request->getQuery('type');
        $is_vente = $this->request->getQuery('is_vente') != '' ? (int) $this->request->getQuery('is_vente') : null;
        $typeEquipements = $this->TypeEquipements->find()->contain(['Equipements', 'GammesBornes']);

        if ($gamme_borne_id) {
            $typeEquipements->contain(['TypeEquipementsGammes'])->matching('TypeEquipementsGammes')->where(['TypeEquipementsGammes.gamme_borne_id' => $gamme_borne_id]);
        }
        if ($is_vente !== null) {
            $typeEquipements->where(['TypeEquipements.is_vente' => $is_vente]);
        }
        if ($type) {
            $typeEquipements->where(["TypeEquipements.$type" => 1]);
        }
        $typeEquipements = $this->paginate($typeEquipements);

        $gammesBornes = $this->TypeEquipements->GammesBornes->find('list');
        $yes_or_no = Configure::read('yes_or_no');

        $this->set(compact('typeEquipements', 'yes_or_no', 'is_vente', 'gammesBornes', 'gamme_borne_id', 'type'));
    }

    /**
     * View method
     *
     * @param string|null $id Type Equipement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $typeEquipement = $this->TypeEquipements->get($id, [
            'contain' => ['Equipements']
        ]);

        $this->set('typeEquipement', $typeEquipement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $typeEquipement = $this->TypeEquipements->newEntity();
        
        if($id) {

            $typeEquipement = $this->TypeEquipements->get($id, [
                'contain' => ['GammesBornes']
            ]);
        }
        
        if ($this->request->is(['post', 'put'])) {

            $data = $this->request->getData();
            $data['is_structurel'] = $data['is_accessoire'] = $data['is_protection'] = 0;
            
            foreach ($data['types'] as $type) {
                $data[$type] = 1;
            }
            
            $typeEquipement = $this->TypeEquipements->patchEntity($typeEquipement, $data);
            if ($this->TypeEquipements->save($typeEquipement)) {
                $this->Flash->success(__('The type equipement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type equipement could not be saved. Please, try again.'));
        }
        
        $type_value = [];
        if($typeEquipement->is_structurel) {
            $type_value[] = 'is_structurel';
        }
        if($typeEquipement->is_accessoire) {
            $type_value[] = 'is_accessoire';
        }
        if($typeEquipement->is_protection) {
            $type_value[] = 'is_protection';
        }
                
        $gammesBornes = $this->TypeEquipements->GammesBornes->find('list');
        $this->set(compact('typeEquipement', 'gammesBornes', 'type_value'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Type Equipement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $typeEquipement = $this->TypeEquipements->get($id, [
            'contain' => ['GammesBornes']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $typeEquipement = $this->TypeEquipements->patchEntity($typeEquipement, $this->request->getData());
            
            if ($this->TypeEquipements->save($typeEquipement)) {
                $this->Flash->success(__('The type equipement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type equipement could not be saved. Please, try again.'));
        }

        $gammesBornes = $this->TypeEquipements->GammesBornes->find('list');
        $this->set(compact('typeEquipement', 'gammesBornes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Type Equipement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $typeEquipement = $this->TypeEquipements->get($id);
        if ($this->TypeEquipements->delete($typeEquipement)) {
            $this->Flash->success(__('The type equipement has been deleted.'));
        } else {
            $this->Flash->error(__('The type equipement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
