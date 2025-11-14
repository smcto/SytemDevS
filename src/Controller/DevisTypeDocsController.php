<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\Folder;

/**
 * DevisTypeDocs Controller
 *
 * @property \App\Model\Table\DevisTypeDocsTable $DevisTypeDocs
 *
 * @method \App\Model\Entity\DevisTypeDoc[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevisTypeDocsController extends AppController
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
        $devisTypeDocs = $this->paginate($this->DevisTypeDocs);

        $this->set(compact('devisTypeDocs'));
    }

    /**
     * View method
     *
     * @param string|null $id Devis Type Doc id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $devisTypeDoc = $this->DevisTypeDocs->get($id, [
            'contain' => []
        ]);

        $this->set('devisTypeDoc', $devisTypeDoc);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $devisTypeDoc  = $this->DevisTypeDocs->newEntity();
        if($id) {
            $devisTypeDoc  = $this->DevisTypeDocs->get($id, [
                'contain' => []
            ]);
        }
        if ($this->request->is(['post','put'])) {
            $data = $this->request->getData();
            $file = $data['fond'];
            $destination = WWW_ROOT . "img" . DS . "devis" . DS . 'fond_pdf' . DS;
            $dir = new Folder($destination, true, 0755);
            if (empty($file['error']) && !empty($file['name'])) {
                $tmp = $file['tmp_name'];
                $pathinfo = pathinfo($file['name']);
                $filename = $pathinfo['basename'];
                $destination_path = $dir->pwd() . DS . $filename ;

                // Supprimer l'ancien si logo existe
                if (!empty($devisTypeDoc->image)) {
                    @unlink($destination . DS . $devisTypeDoc->image);
                }
                
                if (move_uploaded_file($tmp, $destination_path)) {
                    $data['image'] = $filename;
                }
            }
            $devisTypeDoc  = $this->DevisTypeDocs->patchEntity($devisTypeDoc , $data);
            if ($this->DevisTypeDocs->save($devisTypeDoc )) {
                $this->Flash->success(__('The type document mail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type document mail could not be saved. Please, try again.'));
        }
        
        $this->set(compact('devisTypeDoc','id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Devis Type Doc id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $devisTypeDoc = $this->DevisTypeDocs->get($id);
        if ($this->DevisTypeDocs->delete($devisTypeDoc)) {
            $this->Flash->success(__('The devis type doc has been deleted.'));
        } else {
            $this->Flash->error(__('The devis type doc could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
