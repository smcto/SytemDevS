<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Text;

/**
 * ModelBornes Controller
 *
 * @property \App\Model\Table\ModelBornesTable $ModelBornes
 *
 * @method \App\Model\Entity\ModelBorne[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ModelBornesController extends AppController
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
        
        $modelBornes = $this->ModelBornes->find()->contain(['Bornes'=> ['ParcsLocatif', 'ParcsVente'], 'GammesBornes']);
        
        $gamme = $this->request->getQuery('gamme');
        if($gamme){
                $modelBornes->where(['GammesBornes.id' => $gamme]);
        }
        $modelBornes = $this->paginate($modelBornes, ['limit' => 20, 'sortWhitelist' => ['GammesBornes.name']]);

        $gammeBornes = $this->ModelBornes->GammesBornes->find('list');
        $this->set(compact('modelBornes','gammeBornes','gamme'));
    }

    /**
     * View method
     *
     * @param string|null $id Model Borne id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $modelBorne = $this->ModelBornes->get($id, [
            'contain' => ['Bornes']
        ]);

        $this->set('modelBorne', $modelBorne);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $modelBorne = $this->ModelBornes->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $modelBorne = $this->ModelBornes->patchEntity($modelBorne, $data);
            //debug($data);die;
            if ($this->ModelBornes->save($modelBorne)) {

                //======= photos illustrations
                if (!is_dir(PATH_MODEL_BORNES)) {
                    mkdir(PATH_MODEL_BORNES, 0777);
                }
                if (!empty($data['photo_illustrations'])) {
                    foreach ($data['photo_illustrations'] as $key => $photo){
                        if(isset($photo['nom']) && !empty($photo['nom'])) {
                            $filename = $photo['nom'];
                            if (copy(PATH_TMP . $filename, PATH_MODEL_BORNES . $filename)) {
                                unlink(PATH_TMP . $filename);
                                $doc = $this->ModelBornes->Fichiers->newEntity();
                                $doc->nom_fichier = $filename;
                                $doc->nom_origine = $photo['nom_origine'];
                                $doc->chemin = PATH_MODEL_BORNES . $filename ;
                                $doc->model_borne_id = $modelBorne->id;
                                $this->ModelBornes->Fichiers->save($doc);
                            }
                        }
                    }
                }

                //======= GESTION DOCUMENTS
                if (!empty($data['documents'])){
                    foreach ($data['documents'] as $key => $document){
                        if (!empty($document['file']['name'])) {
                            $extension = pathinfo($document['file']['name'], PATHINFO_EXTENSION);
                            $filename = Text::uuid() . "." . $extension;
                            if (move_uploaded_file($document['file']['tmp_name'], PATH_MODEL_BORNES . $filename)) {
                                $doc = $this->ModelBornes->Documents->newEntity();
                                $doc->nom_fichier = $filename;
                                $doc->nom_origine = $document['file']['name'];
                                $doc->chemin = PATH_MODEL_BORNES . $filename ;
                                $doc->titre = $document['titre'];
                                $doc->description = $document['description'];
                                $doc->model_borne_id = $modelBorne->id;
                                $this->ModelBornes->Documents->save($doc);
                            }
                        }
                    }
                }


                $this->Flash->success(__('The model borne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The model borne could not be saved. Please, try again.'));
        }
        $this->loadModel('Parties');
        $parties = $this->Parties->find('list',['valueField'=>'nom']);
        $gammesBornes = $this->ModelBornes->GammesBornes->find('list');
        
        $type_imprimante = $this->ModelBornes->Equipements->find('list', ['valueField'=>'valeur'])->where(['type_equipement_id' => 1]);
        $type_appareil_photo = $this->ModelBornes->TypeEquipements->find('list', ['valueField'=>'nom'])->where(['id IN' => [2,8]]);
        $type_equipement_pied = $this->ModelBornes->TypeEquipements->find('list', ['valueField' => 'nom'])
                ->where(['TypeEquipements.id IN' => [6,9], 'TypeEquipementsGammes.gamme_borne_id' => $modelBorne->gamme_borne_id])
                ->matching('TypeEquipementsGammes')
        ;
        $couleurs = $this->ModelBornes->Couleurs->find('list',['valueField' => 'couleur']);
        $this->set(compact('gammesBornes', 'modelBorne','parties','couleurs', 'type_imprimante', 'type_appareil_photo', 'type_equipement_pied'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Model Borne id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $modelBorne = $this->ModelBornes->get($id, [
            'contain' => ['Dimensions','Couleurs', 'Documents', 'Fichiers', 'ModelBorneHasEquipements']
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            $modelBorne = $this->ModelBornes->patchEntity($modelBorne, $data);
            if ($this->ModelBornes->save($modelBorne)) {
                //=== photo illustration
                if (!is_dir(PATH_MODEL_BORNES)) {
                    mkdir(PATH_MODEL_BORNES, 0777);
                }
                if (!empty($data['photo_illustrations'])) {
                    foreach ($data['photo_illustrations'] as $key => $photo){
                        if(isset($photo['nom']) && !empty($photo['nom'])) {
                            $filename = $photo['nom'];
                            if (copy(PATH_TMP . $filename, PATH_MODEL_BORNES . $filename)) {
                                unlink(PATH_TMP . $filename);
                                $doc = $this->ModelBornes->Fichiers->newEntity();
                                $doc->nom_fichier = $filename;
                                $doc->nom_origine = $photo['nom_origine'];
                                $doc->chemin = PATH_MODEL_BORNES . $filename ;
                                $doc->model_borne_id = $modelBorne->id;
                                $this->ModelBornes->Fichiers->save($doc);
                            }
                        }
                    }
                }

                //======= dophoto illustration à suppr
                if (!empty($data['photo_illustrations_a_suppr'])) {
                    foreach ($data['photo_illustrations_a_suppr'] as $key => $doc){
                        $filename = $doc['nom'];
                        $fichier = $this->ModelBornes->Fichiers->find('all')->where(['nom_fichier'=>$filename ])->first();
                        if($fichier) {
                            $this->ModelBornes->Fichiers->delete($this->ModelBornes->Fichiers->get($fichier->id));
                            if (file_exists(PATH_MODEL_BORNES . $filename)) {
                                unlink(PATH_MODEL_BORNES . $filename);
                            }
                        }
                    }
                }

                //======= GESTION DOCUMENTS
                if (!empty($data['documents'])){
                    foreach ($data['documents'] as $key => $document){
                        if (!empty($document['file']['name'])) {
                            $doc = $this->ModelBornes->Documents->newEntity();
                            if(isset($document['id']) && !empty($document['id'])){
                                $doc = $this->ModelBornes->Documents->get($document['id']);
                            }
                            $extension = pathinfo($document['file']['name'], PATHINFO_EXTENSION);
                            $filename = Text::uuid() . "." . $extension;
                            if (move_uploaded_file($document['file']['tmp_name'], PATH_MODEL_BORNES . $filename)) {
                                $doc->nom_fichier = $filename;
                                $doc->nom_origine = $document['file']['name'];
                                $doc->chemin = PATH_MODEL_BORNES . $filename ;
                                $doc->titre = $document['titre'];
                                $doc->description = $document['description'];
                                $doc->model_borne_id = $modelBorne->id;
                                $this->ModelBornes->Documents->save($doc);
                            }
                        }
                    }
                }

                //== Suppression document
                if (isset($data['asuppr'])) {
                    for ($i = 0; $i < count($data['asuppr']); $i++) {
                        if ($data['asuppr'][$i] !== '') {
                            $id = intval($data['asuppr'][$i]);
                            $docAsuppr = $this->ModelBornes->Documents->get($id);
                            $this->ModelBornes->Documents->delete($docAsuppr);
                        }
                    }
                }
                $this->Flash->success(__('The model borne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The model borne could not be saved. Please, try again.'));
        }
        $this->loadModel('Parties');
        $parties = $this->Parties->find('list',['valueField'=>'nom']);
        $couleurs = $this->ModelBornes->Couleurs->find('list',['valueField' => 'couleur']);
        $gammesBornes = $this->ModelBornes->GammesBornes->find('list');

        $type_imprimante = $this->ModelBornes->Equipements->find('list', ['valueField'=>'valeur'])->where(['type_equipement_id' => 1]);
        $type_appareil_photo = $this->ModelBornes->TypeEquipements->find('list', ['valueField'=>'nom'])->where(['id IN' => [2,8]]);
        $type_equipement_pied = $this->ModelBornes->TypeEquipements->find('list', ['valueField' => 'nom'])
                ->where(['TypeEquipements.id IN' => [6,9], 'TypeEquipementsGammes.gamme_borne_id' => $modelBorne->gamme_borne_id])
                ->matching('TypeEquipementsGammes')
        ;
        $this->set(compact('gammesBornes', 'modelBorne','parties','couleurs', 'type_imprimante', 'type_appareil_photo' , 'type_equipement_pied'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Model Borne id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $modelBorne = $this->ModelBornes->get($id);
        if ($this->ModelBornes->delete($modelBorne)) {
            $this->Flash->success(__('The model borne has been deleted.'));
        } else {
            $this->Flash->error(__('The model borne could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     *
     * get files uploaded to edit
     */
    public function getFichiers($id )
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        $res = [];
        $fichiers = $this->ModelBornes->Fichiers->find('all')->where(['model_borne_id'=>$id]);
        //debug($fichiers->toArray());die;
        if(!empty($fichiers)) {
            foreach ($fichiers as $fichier) {
                $fic['name'] = $fichier->nom_fichier;
                $fic['size'] = filesize(PATH_MODEL_BORNES . $fichier->nom_fichier);
                $fic['name_origine'] = $fichier->nom_origine;
                $fic['url'] = $fichier->url;
                $res [] = $fic;
            }
        }
        echo json_encode($res);
    }
}
