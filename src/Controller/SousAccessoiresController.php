<?php
namespace App\Controller;

use App\Controller\AppController;

class SousAccessoiresController extends AppController
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


    public function index()
    {
        $this->paginate = [
            'contain' => ['Accessoires']
        ];
        $sousAccessoires = $this->paginate($this->SousAccessoires);

        $this->set(compact('sousAccessoires'));
    }

    public function view($id = null)
    {
        $sousAccessoire = $this->SousAccessoires->get($id, [
            'contain' => ['Accessoires', 'GammesBornes']
        ]);

        $this->set('sousAccessoire', $sousAccessoire);
    }

    public function add($accessoire_id)
    {
        $sousAccessoire = $this->SousAccessoires->newEntity();
        if ($this->request->is('post')) {
            $sousAccessoire = $this->SousAccessoires->patchEntity($sousAccessoire, $this->request->getData());

            if ($this->SousAccessoires->save($sousAccessoire)) {
                $this->Flash->success(__('The declination has been saved.'));

                return $this->redirect(['controller' => 'Accessoires']);
            }
            $this->Flash->error(__('The declination could not be saved. Please, try again.'));
        }
        $accessoires = $this->SousAccessoires->Accessoires->find('list', ['limit' => 200]);
        $gammesBornes = $this->SousAccessoires->GammesBornes->find('list', ['limit' => 200]);
        $accessoires = $this->SousAccessoires->Accessoires->find('list');
        $this->set(compact('accessoires', 'sousAccessoire', 'accessoires', 'gammesBornes', 'accessoire_id'));
    }

    public function edit($id = null)
    {
        $sousAccessoire = $this->SousAccessoires->get($id, [
            'contain' => ['GammesBornes']
        ]);
        $accessoire_id = $sousAccessoire->accessoire_id;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data =  $this->request->getData();
            $sousAccessoire = $this->SousAccessoires->patchEntity($sousAccessoire, $data);
            if ($this->SousAccessoires->save($sousAccessoire)) {
                $this->Flash->success(__('The declination has been saved.'));

                return $this->redirect(['controller' => 'Accessoires']);
            }
            $this->Flash->error(__('The declination could not be saved. Please, try again.'));
        }
        $accessoires = $this->SousAccessoires->Accessoires->find('list', ['limit' => 200]);
        $gammesBornes = $this->SousAccessoires->GammesBornes->find('list', ['limit' => 200]);
        $accessoires = $this->SousAccessoires->Accessoires->find('list');
        $this->set(compact('sousAccessoire', 'accessoires', 'gammesBornes', 'accessoire_id'));
    }


    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sousAccessoire = $this->SousAccessoires->get($id);
        if ($this->SousAccessoires->delete($sousAccessoire)) {
            $this->Flash->success(__('The declination has been deleted.'));
        } else {
            $this->Flash->error(__('The declination could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Accessoires']);
    }
}
