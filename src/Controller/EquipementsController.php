<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Equipements Controller
 *
 * @property \App\Model\Table\EquipementsTable $Equipements
 *
 * @method \App\Model\Entity\Equipement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EquipementsController extends AppController
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
        $type_equipement = $this->request->getQuery('type_equipement');
        $marque_equipement = $this->request->getQuery('marque_equipement');
        $doc = $this->request->getQuery('document');
        // debug($equipement);exit;
        $customFinderOptions = [
            'key' => $key,
            'type_equipement' => $type_equipement,
            'marque_equipement' => $marque_equipement,
            'document' => $doc
        ];
        $this->paginate = [
            'contain' => ['TypeEquipements','MarqueEquipements', 'Stock', 'Used','EquipementsDocuments'],
                'finder' => [
                'filtre' => $customFinderOptions
            ]
        ];
        $type_equipements = $this->Equipements->TypeEquipements->find('list',['valueField'=>'nom'])->order(['nom' => 'ASC']);
        $marque_equipements = $this->Equipements->MarqueEquipements->find('list',['valueField'=>'marque'])->order(['marque' => 'ASC']);
        $equipements = $this->paginate($this->Equipements);
        // debug($marque_equipements);die();
        
        $this->set(compact('equipements','type_equipements','marque_equipements'));
        $this->set(compact('key','type_equipement','marque_equipement', 'doc'));
    }

    /**
     * View method
     *
     * @param string|null $id Equipement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $equipement = $this->Equipements->get($id, [
            'contain' => ['TypeEquipements']
        ]);

        $this->set('equipement', $equipement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $equipement = $this->Equipements->newEntity();
        
        if ($this->request->is('post')) {
            
            $data = $this->request->getData();
            $equipement = $this->Equipements->patchEntity($equipement, $this->request->getData());
            if ($this->Equipements->save($equipement)) {
                
                //======= GESTION DOCUMENTS
                if (!empty($data['documents'])){
                    foreach ($data['documents'] as $key => $document){
                        if (!empty($document['file']['name'])) {
                            
                            $doc = $this->Equipements->EquipementsDocuments->newEntity();
                            if(isset($document['id']) && !empty($document['id'])){
                                $doc = $this->Equipements->EquipementsDocuments->get($document['id']);
                            }
                            
                            $extension = pathinfo($document['file']['name'], PATHINFO_EXTENSION);
                            $filename = Text::uuid() . "." . $extension;
                            if (move_uploaded_file($document['file']['tmp_name'], PATH_DOC_EQUIP . $filename)) {
                                
                                $doc = $this->Equipements->EquipementsDocuments->newEntity();
                                $doc->nom_fichier = $filename;
                                $doc->chemin = PATH_DOC_EQUIP . $filename;
                                $doc->equipement_id = $equipement->id;
                                $doc->titre = $document['titre'];
                                $doc->description = $document['description'];
                                $doc->nom_origine = $document['file']['name'];
                                $this->Equipements->EquipementsDocuments->save($doc);
                            }
                        }
                    }
                }
                
                $this->Flash->success(__('The equipement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The equipement could not be saved. Please, try again.'));
        }
        $typeEquipements = $this->Equipements->TypeEquipements->find('list', ['valueField' => 'nom'])->order(['nom' => 'ASC']);
        $marqueEquipements = $this->Equipements->MarqueEquipements->find('list', ['valueField' => 'marque'])->order(['marque' => 'ASC']);
        $this->set(compact('equipement', 'typeEquipements','marqueEquipements'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Equipement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $equipement = $this->Equipements->get($id, [
            'contain' => ['EquipementsDocuments']
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $data = $this->request->getData();
            
            $equipement = $this->Equipements->patchEntity($equipement, $this->request->getData());
            if ($this->Equipements->save($equipement)) {
                
                //======= GESTION DOCUMENTS
                if (!empty($data['documents'])){
                    foreach ($data['documents'] as $key => $document){
                        if (!empty($document['file']['name'])) {
                            
                            $doc = $this->Equipements->EquipementsDocuments->newEntity();
                            if(isset($document['id']) && !empty($document['id'])){
                                $doc = $this->Equipements->EquipementsDocuments->get($document['id']);
                            }
                            
                            $extension = pathinfo($document['file']['name'], PATHINFO_EXTENSION);
                            $filename = Text::uuid() . "." . $extension;
                            if (move_uploaded_file($document['file']['tmp_name'], PATH_DOC_EQUIP . $filename)) {
                                
                                if ($document['id']) {
                                    $doc = $this->Equipements->EquipementsDocuments->findById($document['id'])->first();

                                } else {
                                    $doc = $this->Equipements->EquipementsDocuments->newEntity();
                                }

                                $doc->nom_fichier = $filename;
                                $doc->chemin = PATH_DOC_EQUIP . $filename;
                                $doc->equipement_id = $equipement->id;
                                $doc->titre = $document['titre'];
                                $doc->description = $document['description'];
                                $doc->nom_origine = $document['file']['name'];
                                $this->Equipements->EquipementsDocuments->save($doc);
                            }
                        }
                    }
                }
                
                //== Suppression document
                if (isset($data['asuppr'])) {
                    
                    $docAsuppr = array_filter($data['asuppr']);
                    
                    if(count($docAsuppr)) {
                        $this->Equipements->EquipementsDocuments->deleteAll(['id IN' => $docAsuppr]);
                    }
                }
                
                $this->Flash->success(__('The equipement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The equipement could not be saved. Please, try again.'));
        }
        $typeEquipements = $this->Equipements->TypeEquipements->find('list', ['valueField' => 'nom'])->order(['nom' => 'ASC']);;
        $marqueEquipements = $this->Equipements->MarqueEquipements->find('list', ['valueField' => 'marque'])->order(['marque' => 'ASC']);
        $this->set(compact('equipement', 'typeEquipements','marqueEquipements'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Equipement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $equipement = $this->Equipements->get($id);
        $lotProduits = TableRegistry::getTableLocator()->get('LotProduits');
        $query = $lotProduits
            ->find()
            ->select(['id', 'equipement_id'])
            ->where(['equipement_id' => $equipement->id]);
        $i = 0;
        foreach ($query as  $q) {
            $i += 1;
        }

        if ($i != 0){
            $this->Flash->error(__('L\'équipement ne peut pas être supprimé. Veuillez réessayer.'));
        }else{
            if ($this->Equipements->delete($equipement)) {
                $this->Flash->success(__('L\'équipement a été supprimé.'));
            } else {
                $this->Flash->error(__('L\'équipement ne peut pas être supprimé. Veuillez réessayer.'));
            }
        }
        

        return $this->redirect(['action' => 'index']);
    }
}
