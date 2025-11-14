<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Text;

/**
 * ActuBornes Controller
 * // Nemany
 * @property \App\Model\Table\ActuBornesTable $ActuBornes
 *
 * @method \App\Model\Entity\ActuBorne[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActuBornesController extends AppController
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
            //'contain' => ['Bornes', 'CategorieActus']
            'contain' => ['Bornes' => ['ModelBornes' => 'GammesBornes']]
        ];
        $actuBornes = $this->paginate($this->ActuBornes);

        $this->set(compact('actuBornes'));
    }

    /**
     * View method
     *
     * @param string|null $id Actu Borne id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $actuBorne = $this->ActuBornes->get($id, [
            'contain' => ['Bornes', 'ActuBornesHasMedias', 'CategorieActus']
        ]);

        $this->set('actuBorne', $actuBorne);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($borne_id = null)
    {
        $actuBorne = $this->ActuBornes->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $actuBorne = $this->ActuBornes->patchEntity($actuBorne, $data);

            if ($this->ActuBornes->save($actuBorne)) {
                //======= Photos
                if (!empty($data['documents'])) {
                    foreach ($data['documents'] as $doc){
                        $filename = $doc['nom'];
                        if (copy(PATH_TMP . $filename, PATH_ACTU_BORNES . $filename)) {
                            unlink(PATH_TMP . $filename);
                            $doc = $this->ActuBornes->Fichiers->newEntity();
                            $doc->nom_fichier = $filename;
                            $doc->chemin = PATH_ACTU_BORNES . $filename ;
                            $doc->actu_borne_id = $actuBorne->id;
                            $this->ActuBornes->Fichiers->save($doc);
                        }
                    }
                }

                $this->Flash->success(__('The actu borne has been saved.'));
                if($borne_id) {
                    return $this->redirect(['controller' => 'Bornes', 'action' => 'view', $borne_id]);
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The actu borne could not be saved. Please, try again.'));
        }
        $bornes = $this->ActuBornes->Bornes->find('list',['valueField' => 'numero']);
        $categorietickets = $this->ActuBornes->CategorieActus->find('all');
        $this->set(compact('actuBorne', 'bornes','categorietickets'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Actu Borne id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $actuBorne = $this->ActuBornes->get($id, [
            'contain' => ['Fichiers']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $actuBorne = $this->ActuBornes->patchEntity($actuBorne, $data);
            if ($this->ActuBornes->save($actuBorne)) {
                //======= Photos
                if (!empty($data['documents'])) {
                    foreach ($data['documents'] as $doc){
                        $filename = $doc['nom'];
                        if (copy(PATH_TMP . $filename, PATH_ACTU_BORNES . $filename)) {
                            unlink(PATH_TMP . $filename);
                            $doc = $this->ActuBornes->Fichiers->newEntity();
                            $doc->nom_fichier = $filename;
                            $doc->chemin = PATH_ACTU_BORNES . $filename ;
                            $doc->actu_borne_id = $actuBorne->id;
                            $this->ActuBornes->Fichiers->save($doc);
                        }
                    }
                }

                $this->Flash->success(__('The actu borne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The actu borne could not be saved. Please, try again.'));
        }
        $bornes = $this->ActuBornes->Bornes->find('list',['valueField' => 'numero']);
        $categorietickets = $this->ActuBornes->CategorieActus->find('all');
        $this->set(compact('actuBorne', 'bornes','categorietickets'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Actu Borne id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $borne_id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $actuBorne = $this->ActuBornes->get($id);
        if ($this->ActuBornes->delete($actuBorne)) {
            $this->Flash->success(__('The actu borne has been deleted.'));
        } else {
            $this->Flash->error(__('The actu borne could not be deleted. Please, try again.'));
        }

        if($borne_id) {
            return $this->redirect(['controller' => 'Bornes', 'action' => 'view', $borne_id]);
        }
        return $this->redirect(['action' => 'index']);
    }

    public function uploadPhotos(){
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            //debug($data); die;
            $res["success"] = false;
            //debug(count($data["file"]));die;
            if (!empty($data)) {
                $file = $data["file"];
                $fileName = $file['name'];
                $infoFile = pathinfo($fileName);
                $fileExtension = $infoFile["extension"];
                $extensionValide = array('doc', 'docx', 'pdf', 'png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');
                if (in_array($fileExtension, $extensionValide)) {
                    $newName = Text::uuid() . '.' . $fileExtension;
                    $path_tmp = 'uploads/tmp/';
                    $destinationFileName = $path_tmp . $newName;
                    $tmpFilePath = $file['tmp_name'];
                    if (move_uploaded_file($tmpFilePath, $destinationFileName)) {
                        $res["success"] = true;
                        $res["name"] = $newName;
                    }
                } else {$res["error"] = "Fichier invalide format";}
            }
            echo json_encode($res);
        }
    }
}
