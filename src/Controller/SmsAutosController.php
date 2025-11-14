<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Text;
use Cake\Filesystem\Folder;
use Cake\Core\Configure;

/**
 * SmsAutos Controller
 *
 * @property \App\Model\Table\SmsAutosTable $SmsAutos
 *
 * @method \App\Model\Entity\SmsAuto[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SmsAutosController extends AppController
{

    public $dossier_manuel_borne = DS . 'uploads' . DS . 'manuel_borne'.DS;
    public $path_manuel_borne  = WWW_ROOT . 'uploads' . DS . 'manuel_borne'.DS;
    
    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->Auth->allow(['voireDoc']);
    }
    
    public function isAuthorized($user)
    {
        $typeprofils = $user['typeprofils'];
        if(in_array('konitys', $typeprofils) || in_array('admin', $typeprofils)) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $smsAuto = $this->SmsAutos->newEntity();
        if($id) {
            $smsAuto = $this->SmsAutos->get($id, [
                'contain' => []
            ]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $data = $this->request->getData();
            $file_classik = $data['classik_file'];
            $destination_classik = $this->path_manuel_borne;
            $dir_classik = new Folder($destination_classik, true, 0755);
            if (empty($file_classik['error']) && !empty($file_classik['name'])) {
                $tmp = $file_classik['tmp_name'];
                $pathinfo = pathinfo($file_classik['name']);
                $extension = $pathinfo['extension'];
                $filename = Text::uuid() . "." . $extension;
                $destination_path = $dir_classik->pwd() . DS . $filename;
                
                if (move_uploaded_file($tmp, $destination_path)) {
                    $data['classik_file_name'] = $filename;
                }
            }
            
            $file_spherik = $data['spherik_file'];
            $destination_spherik = $this->path_manuel_borne;
            $dir_spherik = new Folder($destination_spherik, true, 0755);
            if (empty($file_spherik['error']) && !empty($file_spherik['name'])) {
                $tmp = $file_spherik['tmp_name'];
                $pathinfo = pathinfo($file_spherik['name']);
                $extension = $pathinfo['extension'];
                $filename = Text::uuid() . "." . $extension;
                $destination_path = $dir_spherik->pwd() . DS . $filename;
                
                if (move_uploaded_file($tmp, $destination_path)) {
                    $data['spherik_file_name'] = $filename;
                }
            }
            
            $smsAuto = $this->SmsAutos->patchEntity($smsAuto, $data);
            if ($this->SmsAutos->save($smsAuto)) {
                $this->Flash->success(__('Les paramètres sms ont été souvegarder.'));

                return $this->redirect(['controller' => 'Dashboards', 'action' => 'reglages']);
            }
            $this->Flash->error(__('The sms auto could not be saved. Please, try again.'));
        }
        
        $domaine = Configure::read('https_payement') . '/fr/manuel';
        $file_default_classik = $smsAuto->classik_file_name ? $domaine . '/classik' : '';
        $file_default_spherik = $smsAuto->spherik_file_name ? $domaine . '/spherik' : '';

        $this->set(compact('smsAuto', 'file_default_classik', 'file_default_spherik'));
    }
    
    /**
     * 
     * @param type $model
     */
    public function voireDoc($model = 'classik') {

        $smsAuto = $this->SmsAutos->findById(1)->first();
        $file_name = $smsAuto->classik_file_name;
        if($model == 'spherik') {
            $file_name = $smsAuto->spherik_file_name;
        }
        if(is_file($this->path_manuel_borne . $file_name)) {
            return $this->response->withFile($this->path_manuel_borne . $file_name);
        }
        die;
    }
    
    
    /**
     * Delete method
     *
     * @param string|null $id Sms Auto id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $smsAuto = $this->SmsAutos->get($id);
        if ($this->SmsAutos->delete($smsAuto)) {
            $this->Flash->success(__('The sms auto has been deleted.'));
        } else {
            $this->Flash->error(__('The sms auto could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
