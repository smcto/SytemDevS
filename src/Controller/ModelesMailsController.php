<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Text;

/**
 * ModelesMails Controller
 *
 * @property \App\Model\Table\ModelesMailsTable $ModelesMails
 *
 * @method \App\Model\Entity\ModelesMail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ModelesMailsController extends AppController
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
        $modelesMails = $this->paginate($this->ModelesMails);

        $this->set(compact('modelesMails'));
    }

    /**
     * View method
     *
     * @param string|null $id Modeles Mail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $modelesMail = $this->ModelesMails->get($id, [
            'contain' => ['ModelesMailsPjs']
        ]);

        $this->set('modelesMail', $modelesMail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $modelesMail = $this->ModelesMails->newEntity();
        if($id) {
            $modelesMail = $this->ModelesMails->get($id, [
                'contain' => []
            ]);
        }
        if ($this->request->is(['post','put'])) {
            $modelesMail = $this->ModelesMails->patchEntity($modelesMail, $this->request->getData());
            if ($this->ModelesMails->save($modelesMail)) {
                
                $data = $this->request->getData();
                if(!empty($data['documents_a_suppr'])){
                    $this->ModelesMails->ModelesMailsPjs->deleteAll(['modeles_mails_id' => $id, 'nom_fichier IN' => $data['documents_a_suppr']]);
                }
                if (!empty($data['models_mails_pjs'])) {
                    foreach ($data['models_mails_pjs'] as $doc){
                        $filename = $doc['nom'];
                        if (copy(PATH_TMP . $filename, PATH_MODELES_MAILS_PJS . $filename)) {
                            unlink(PATH_TMP . $filename);
                            $doc = $this->ModelesMails->ModelesMailsPjs->newEntity();
                            $doc->nom_fichier = $filename;
                            $doc->chemin = PATH_MODELES_MAILS_PJS . $filename ;
                            $doc->modeles_mails_id = $modelesMail->id;
                            $this->ModelesMails->ModelesMailsPjs->save($doc);
                        }
                    }
                }
                $this->Flash->success(__('The modeles mail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The modeles mail could not be saved. Please, try again.'));
        }
        $this->set(compact('modelesMail','id'));
    }
    
    public function duplicateModeleMail($id = null) {
        
        if($id) {
            $modelesMail = $this->ModelesMails->get($id, [
                'contain' => []
            ])->toArray();
            unset($modelesMail['id']);
            $newModelesMail = $this->ModelesMails->newEntity($modelesMail);
            if ($this->ModelesMails->save($newModelesMail)) {
                $this->Flash->success(__('The modeles mail has been duplicated.'));

                return $this->redirect(['action' => 'add', $newModelesMail->id]);
            }
            $this->Flash->error(__('The modeles mail could not be duplicated. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Modeles Mail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $modelesMail = $this->ModelesMails->get($id);
        if ($this->ModelesMails->delete($modelesMail)) {
            $this->Flash->success(__('The modeles mail has been deleted.'));
        } else {
            $this->Flash->error(__('The modeles mail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * uploadPjs
     */
    public function uploadPjs(){
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $res["success"] = false;
            $res["type_upload"] = $data['type_upload'];
            if (!empty($data)) {
                $file = $data["file"];
                $fileName = $file['name'];
                $infoFile = pathinfo($fileName);
                $fileExtension = $infoFile["extension"];
                $extensionValide = array('doc', 'docx', 'pdf', 'png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');
                if (in_array($fileExtension, $extensionValide)) {
                    $newName = Text::uuid() . '.' . $fileExtension;
                    $tmpFilePath = $file['tmp_name'];
                    //ini_set('upload_max_filesize', '40M');
                    //ini_set('post_max_size', '40M');
                    //set_time_limit(0);
                    if (move_uploaded_file($tmpFilePath, PATH_TMP.$newName)) {
                        $res["success"] = true;
                        $res["name"] = $newName;
                    }else {$res["error"] = "Fichier non importé";}
                } else {$res["error"] = "Fichier invalide format";}
            }else {$res["error"] = "Donnée vide";}
            echo json_encode($res);
        }
    }
    /**
     *
     * get documents uploaded to edit
     */
    public function getPjs($id )
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        $res = [];
        $this->loadModel('ModelesMailsPjs');
        $fichiers = $this->ModelesMailsPjs->find('all')->where(['modeles_mails_id'=>$id]);
        if(!empty($fichiers)) {
            foreach ($fichiers as $fichier) {
                if(is_file(PATH_MODELES_MAILS_PJS . $fichier->nom_fichier)){
                    $fic['id'] = $fichier->id;
                    $fic['name'] = $fichier->nom_fichier;
                    $fic['url'] = $fichier->url;
                    $fic['url_viewer'] = $fichier->url_viewer;
                    $fic['size'] = filesize(PATH_MODELES_MAILS_PJS . $fichier->nom_fichier);
                    $infoFile = pathinfo($fichier->nom_fichier);
                    $fileExtension = $infoFile["extension"];
                    $fic['extension'] = $fileExtension;
                    $res [] = $fic;
                }
            }
        }
        echo json_encode($res);
    }
    
}
