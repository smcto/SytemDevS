<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Fichier;
use Cake\Utility\Text;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 *
 * @method \App\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostsController extends AppController
{

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if($action == "index" || $action == "view"){
                return true;
        }

        if($action == "add" || $action == "edit" || $action == "delete"|| $action == "viewFile"){
            if(array_intersect(['admin', 'konitys'], $typeprofils)) {
                return true;
            }
        }

        if($action == "uploadDocuments" || $action == "deleteFichier" || $action == "getFichiers"){
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
        $etat = $this->request->getQuery('etat');
        $categorie = $this->request->getQuery('categorie');
        $key = $this->request->getQuery('key');

        $user_connected = $this->Auth->user();
        $customFinderOptions = [
            'typeprofil_ids' => $user_connected['typeprofilskeys'],
            'typeprofils' => $user_connected['typeprofils'],
            'key' => $key,
            'etat' => $etat,
            'categorie' => $categorie
        ];

        $this->paginate = [
            'contain' => ['Categories','TypeProfils'],
            'finder' => [
                'filtre' => $customFinderOptions
            ],
            'group' =>'Posts.id',
        ];
        $posts = $this->paginate($this->Posts);
        //debug($user_connected['typeprofilskeys']);die;
        $this->loadModel('Categories');
        $categories = $this->Categories->find('list', ['valueField'=>'nom']);
        //$etats = ['public'=>'Public', 'private'=>'Privé'];
        $etats = ['public'=>'Publié', 'private'=>'Brouillon'];

        $this->set(compact('posts', 'categories', 'categorie', 'etat', 'etats', 'key', 'user_connected'));
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => ['Categories','TypeProfils', 'Fichiers']
        ]);
        //debug($post);die;

        $this->set('post', $post);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $post = $this->Posts->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $post = $this->Posts->patchEntity($post, $data);
            //debug($data);die;

            if ($this->Posts->save($post)) {
                //======= photo illustration
                if (!is_dir(PATH_DOCUMENTATIONS)) {
                    mkdir(PATH_DOCUMENTATIONS, 0777);
                }
                if (!empty($data['photo_file']['name'])) {
                    $extension = pathinfo($data['photo_file']['name'], PATHINFO_EXTENSION);
                    $newFilename = Text::uuid() . "." . $extension;
                    if (move_uploaded_file($data['photo_file']['tmp_name'], PATH_DOCUMENTATIONS . $newFilename)) {
                        $post->photo_illustration_name = $newFilename;
                        $this->Posts->save($post);
                    }
                }
                //======= documents
                if (!empty($data['documents'])) {
                    foreach ($data['documents'] as $key => $doc){
                        if(isset($doc['nom']) && !empty($doc['nom'])) {
                            $filename = $doc['nom'];
                            if (copy(PATH_TMP . $filename, PATH_DOCUMENTATIONS . $filename)) {
                                unlink(PATH_TMP . $filename);
                                $doc = $this->Posts->Fichiers->newEntity();
                                $doc->nom_fichier = $filename;
                                $doc->nom_origine = $doc['nom_origine'];
                                $doc->chemin = PATH_DOCUMENTATIONS . $filename;
                                $doc->post_id = $post->id;
                                $this->Posts->Fichiers->save($doc);
                            }
                        }
                    }
                }
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        /*$categories = $this->Posts->Categories->find('list',['valueField'=>'nom','groupField'=>'parent_category.nom'])
                                                ->contain('ParentCategories');*/
        
        $categories  = $this->Posts->Categories->ParentCategories->find('treeList', [
                                                                        'keyPath' => 'id',
                                                                        'valuePath' => 'nom',
                                                                        'spacer' => '-'
                                                                    ]);
        
       
        $typeProfils = $this->Posts->TypeProfils->find('list',['valueField'=>'nom']);
       
        $this->set(compact('post','categories','typeProfils'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => ['Categories','TypeProfils', 'Fichiers']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $post = $this->Posts->patchEntity($post, $data);
            if ($this->Posts->save($post)) {
                //======= photo illustration
                if (!is_dir(PATH_DOCUMENTATIONS)) {
                    mkdir(PATH_DOCUMENTATIONS, 0777);
                }
                if (!empty($data['photo_file']['name'])) {
                    $extension = pathinfo($data['photo_file']['name'], PATHINFO_EXTENSION);
                    $newFilename = Text::uuid() . "." . $extension;
                    if (move_uploaded_file($data['photo_file']['tmp_name'], PATH_DOCUMENTATIONS . $newFilename)) {
                        $post->photo_illustration_name = $newFilename;
                        $this->Posts->save($post);
                    }
                }

                //======= documents
                if (!empty($data['documents'])) {
                    foreach ($data['documents'] as $key => $doc){
                        if(isset($doc['nom']) && !empty($doc['nom'])) {
                            $filename = $doc['nom'];
                            if (copy(PATH_TMP . $filename, PATH_DOCUMENTATIONS . $filename)) {
                                unlink(PATH_TMP . $filename);
                                $doc = $this->Posts->Fichiers->newEntity();
                                $doc->nom_fichier = $filename;
                                $doc->nom_origine = $doc['nom_origine'];
                                $doc->chemin = PATH_DOCUMENTATIONS . $filename;
                                $doc->post_id = $post->id;
                                $this->Posts->Fichiers->save($doc);
                            }
                        }
                    }
                }

                //======= documents à suppr
                if (!empty($data['documents_a_suppr'])) {
                    foreach ($data['documents_a_suppr'] as $key => $doc){
                        $filename = $doc['nom'];
                        $fichier = $this->Posts->Fichiers->find('all')->where(['nom_fichier'=>$filename ])->first();
                        $this->Posts->Fichiers->delete($this->Posts->Fichiers->get($fichier->id));
                        if(file_exists(PATH_DOCUMENTATIONS . $filename)){
                            unlink(PATH_DOCUMENTATIONS . $filename);
                        }
                    }
                }
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        /*$categories = $this->Posts->Categories->find('list',['valueField'=>'nom','groupField'=>'parent_category.nom'])
                                                ->contain('ParentCategories')
                                                ->where(['Categories.parent_id IS NOT'=>NULL]);*/
        
       $categories  = $this->Posts->Categories->ParentCategories->find('treeList', [
                                                                        'keyPath' => 'id',
                                                                        'valuePath' => 'nom',
                                                                        'spacer' => '-'
                                                                    ]);
                                                                    
        $typeProfils = $this->Posts->TypeProfils->find('list',['valueField'=>'nom']);
       
        $this->set(compact('post','categories','typeProfils'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Posts->get($id);
        if ($this->Posts->delete($post)) {
            $this->Flash->success(__('The post has been deleted.'));
        } else {
            $this->Flash->error(__('The post could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     *
     * Upload files to tmp
     */
    public function uploadDocuments(){
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
                        $destinationFileName = PATH_TMP . $newName;
                        $tmpFilePath = $file['tmp_name'];
                        if (move_uploaded_file($tmpFilePath, $destinationFileName)) {
                            $res["success"] = true;
                            $res["name"] = $newName;
                            $res["name_origine"] = $file['name'];
                        }
                    } else {$res["error"] = "Fichier invalide format";}
                }
            echo json_encode($res);
        }
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
        $fichiers = $this->Posts->Fichiers->find('all')->where(['post_id'=>$id]);
        //debug($fichiers->toArray());die;
        if(!empty($fichiers)) {
            foreach ($fichiers as $fichier) {
                $fic['id'] = $fichier->id;
                $fic['name'] = $fichier->nom_fichier;
                $fic['url'] = $fichier->url;
                $fic['url_viewer'] = $fichier->url_viewer;
                $fic['size'] = filesize(PATH_DOCUMENTATIONS . $fichier->nom_fichier);
                $fic['name_origine'] = $fichier->nom_origine;
                $infoFile = pathinfo($fichier->nom_fichier);
                $fileExtension = $infoFile["extension"];
                $fic['extension'] = $fileExtension;
                $res [] = $fic;
            }
        }
        echo json_encode($res);
    }

    /**
     *
     * Delete file into tmp
     */
    public function deleteFile($filename )
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        $res ['success'] = false;
        if(file_exists(PATH_TMP . $filename)){
            unlink(PATH_TMP . $filename);
            $res ['success'] = true;
        }
        echo json_encode($res);
    }

    /**
     *
     * Delete file into tmp
     */
    public function deleteFichier($id )
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        $res ['success'] = false;
        $fichier = $this->Posts->Fichiers->get($id);
        if(file_exists(PATH_DOCUMENTATIONS . $fichier->nom_fichier)){
            unlink(PATH_DOCUMENTATIONS . $fichier->nom_fichier);
            $this->Posts->Fichiers->delete($fichier);
            $res ['success'] = true;
        }
        echo json_encode($res);
    }


    public function viewFile($idPost = null)
    {
        $post = $this->Posts->get($idPost);
        $path = PATH_DOCUMENTATIONS.$post->photo_illustration_name;

        $extension = explode('.', $post->photo_illustration_name)[1];
        $this->response->header([
            'Content-Type' => 'application/' . $extension,
        ]);
        //$this->response->withHeader('X-Extra', 'My header');
        /*$this->response->withHeader(
            'Content-Type' , 'application/' . $extension
        );*/
        //debug($post->photo_illustration_name);die;
        $this->response->file($path, [
            'download' => false,
            'name' => "dd"]);

        //debug($this->response);die;
        return $this->response;
    }
}
