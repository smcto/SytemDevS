<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Text;
use Cake\Filesystem\Folder;

/**
 * DocumentMarketings Controller
 *
 * @property \App\Model\Table\DocumentMarketingsTable $DocumentMarketings
 *
 * @method \App\Model\Entity\DocumentMarketing[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentMarketingsController extends AppController
{

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if(in_array('konitys', $typeprofils) || in_array('admin', $typeprofils)) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    /**
     * index method
     *
     * @return \Cake\Http\Response|null Redirects on successful index, renders view otherwise.
     */
    public function index()
    {
        $documentMarketing = $this->DocumentMarketings->newEntity();
        $documentInBase = $this->DocumentMarketings->find()->first();
        if(!empty($documentInBase)){
            $documentMarketing = $documentInBase;
        }

        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();
            $catSpherik = $data['catalogue_spherik_file'];
            if (!empty($catSpherik) && !empty($catSpherik['name'])) {
                $res = $this->upload($catSpherik);
                if($res['success']){
                    $data['catalogue_spherik'] = $res['filename'];
                }
            }

            $catSpherik2020 = $data['catalogue_spherik_file_2020'];
            if (!empty($catSpherik2020) && !empty($catSpherik2020['name'])) {
                $res = $this->upload($catSpherik2020);
                if($res['success']){
                    $data['catalogue_spherik_2020'] = $res['filename'];
                }
            }

            $catClassik = $data['catalogue_classik_file'];
            if (!empty($catClassik) && !empty($catClassik['name'])) {
                $res = $this->upload($catClassik);
                if($res['success']){
                    $data['catalogue_classik'] = $res['filename'];
                }
            }

            /*$cglClassikPart = $data['cgl_classik_part_file'];
            if (!empty($cglClassikPart) && !empty($cglClassikPart['name'])) {
                $res = $this->upload($cglClassikPart);
                if($res['success']){
                    $data['cgl_classik_part'] = $res['filename'];
                }
            }

            $cglSpherikPart = $data['cgl_spherik_part_file'];
            if (!empty($cglSpherikPart) && !empty($cglSpherikPart['name'])) {
                $res = $this->upload($cglSpherikPart);
                if($res['success']){
                    $data['cgl_spherik_part'] = $res['filename'];
                }
            }

            $cglPro = $data['cgl_pro_file'];
            if (!empty($cglPro) && !empty($cglPro['name'])) {
                $res = $this->upload($cglPro);
                if($res['success']){
                    $data['cgl_pro'] = $res['filename'];
                }
            }*/

            //debug($data) ;

            $documentMarketing = $this->DocumentMarketings->patchEntity($documentMarketing, $data);
            //debug($documentMarketing);die;
            if ($this->DocumentMarketings->save($documentMarketing)) {
                $this->Flash->success(__('Document mis à jour.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Une erreur est survenue . Veuillez réessayer plus tard'));
        }
        $this->set(compact('documentMarketing'));
    }


    protected function upload($fileData){
        $res['success'] = false;
        if (!empty($fileData['name'])) {
           $extension = pathinfo($fileData['name'], PATHINFO_EXTENSION);
            if (in_array($extension, array('pdf'))) {
                $filename         = Text::uuid().'.'. $extension;
                $destination      = WWW_ROOT .'uploads'.DS.'document_marketings'  ;    
                $dir  = new Folder($destination, TRUE, 0755);
                $destinationPath = $dir->pwd() . DS . $filename;
                if(move_uploaded_file($fileData['tmp_name'], $destinationPath)){           
                    $res['success'] = true;
                    $res['filename'] = $filename;
                }
            }else{
                $res['success'] = false;
                $res['message'] = 'Fichier non autorisé';
            }
        }else{
            $res['success'] = false;
            $res['message'] = 'Erreur du fichier veuillez réessayer';
        }
        return $res;
    }

   
}
