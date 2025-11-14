<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DevisFacturesFooter Controller
 *
 * @property \App\Model\Table\DevisFacturesFooterTable $DevisFacturesFooter
 *
 * @method \App\Model\Entity\DevisFacturesFooter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevisFacturesFooterController extends AppController
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
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $devisFacturesFooter = $this->DevisFacturesFooter->findById(1)->first();
        if ($this->request->is(['post', 'put'])) {
            $devisFacturesFooter = $this->DevisFacturesFooter->patchEntity($devisFacturesFooter, $this->request->getData());
            if ($this->DevisFacturesFooter->save($devisFacturesFooter)) {
                $this->Flash->success(__('The devis factures footer has been saved.'));

                return $this->redirect(['controller' => 'Dashboards', 'action' => 'reglages']);
            }
            $this->Flash->error(__('The devis factures footer could not be saved. Please, try again.'));
        }
        $this->set(compact('devisFacturesFooter'));
    }

}
