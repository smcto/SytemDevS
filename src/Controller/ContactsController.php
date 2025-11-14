<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Contacts Controller
 *
 * @property \App\Model\Table\ContactsTable $Contacts
 *
 * @method \App\Model\Entity\Contact[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContactsController extends AppController
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
        $antenne = $this->request->getQuery('antenne');
        $statut = $this->request->getQuery('statut');
        $key = $this->request->getQuery('key');

        $customFinderOptions = [
            'key' => $key,
            'antenne' => $antenne,
            'statut' => $statut
        ];

        $this->paginate = [
            'contain' => ['Statuts', 'Antennes', 'Situations'],
            'finder' => [
                'filtre' => $customFinderOptions
            ],
            'conditions' => ['Contacts.user_id IS' => NULL]
        ];
        $contacts = $this->paginate($this->Contacts);
        //debug($contacts->count());die;

        $antennes = $this->Contacts->Antennes->find('list', ['valueField' => 'ville_excate']);
        $statuts = $this->Contacts->Statuts->find('list', ['valueField' => 'titre']);
        $this->set(compact('antenne','statut','key'));

        $this->set(compact('contacts','statuts','antennes'));
    }

    public function regex()
    {
        //====== 02 02 24 24 24
        //(^0[1-9]([-. ]?[0-9]{2}){4})
        $test = "0202242424";
        $res = false ;
        $test2 = "+33630682013";
        $res2 = false ;
        if (preg_match("#^0[1-9][0-9]{8}$#", $test)){
            $res = true ;
        }

        if (preg_match("#^\+33[1-9][0-9]{8}$#", $test2)){
            $res2 = true ;
        }
        debug($res2);die;
    }

    /**
     * View method
     *
     * @param string|null $id Contact id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contact = $this->Contacts->get($id, [
            'contain' => ['Statuts', 'Antennes', 'Situations']
        ]);

        $this->set('contact', $contact);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contact = $this->Contacts->newEntity();
        $data = $this->request->getData();
        if ($this->request->is('post')) {
            if(!empty($data['photo_nom']['name'])){
                $fileName = $data['photo_nom']['name'];
                $uploadPath = 'uploads/contact/';
                $uploadFile = $uploadPath.$fileName;
                if(move_uploaded_file($data['photo_nom']['tmp_name'], $uploadFile)){
                    $data['photo_nom'] = $fileName;

                }
            }
            $data['telephone_portable'] = $data['phonecode']."".$data['telephone_portable'];
            $data['telephone_fixe'] = $data['phonecode']."".$data['telephone_fixe'];
            $contact = $this->Contacts->patchEntity($contact, $data,[
                'associated' => ['Statuts', 'Situations']
            ]);
            if ($this->Contacts->save($contact)) {
                $this->Flash->success(__('The contact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contact could not be saved. Please, try again.'));
        }
        $statuts = $this->Contacts->Statuts->find('list', ['valueField' => 'titre']);
        $countries = $this->Contacts->Countrys->find('list', ['valueField' => function ($e) {
            return $e->nicename . '   +'. $e->phonecode;
        }]);
        $antennes = $this->Contacts->Antennes->find('list', ['valueField' => 'ville_principale']);
        $situations = $this->Contacts->Situations->find('list', ['valueField' => 'titre']);
        $this->set(compact('contact', 'statuts', 'antennes', 'situations', 'countries'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contact id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contact = $this->Contacts->get($id, [
            'contain' => ['Situations','Statuts', 'Countrys']
        ]);
        //debug(strlen($contact->country->phonecode)+1);die;
        $data = $this->request->getData();
        if ($this->request->is(['patch', 'post', 'put'])) {
            if(!empty($data['photo_nom']['name'])){
                $fileName = $data['photo_nom']['name'];
                $uploadPath = 'uploads/contact/';
                $uploadFile = $uploadPath.$fileName;
                if(move_uploaded_file($data['photo_nom']['tmp_name'], $uploadFile)){
                    $data['photo_nom'] = $fileName;

                }
            }
            $data['telephone_portable'] = $data['phonecode']."".$data['telephone_portable'];
            $data['telephone_fixe'] = $data['phonecode']."".$data['telephone_fixe'];
            $contact = $this->Contacts->patchEntity($contact, $data,[
                'associated' => ['Statuts', 'Situations']
            ]);
            if ($this->Contacts->save($contact)) {
                $this->Flash->success(__('The contact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contact could not be saved. Please, try again.'));
        }
        $statuts = $this->Contacts->Statuts->find('list', ['valueField' => 'titre']);
        $countries = $this->Contacts->Countrys->find('list', ['valueField' => function ($e) {
            return $e->nicename . '   +'. $e->phonecode;
        }]);
        $antennes = $this->Contacts->Antennes->find('list', ['valueField' => 'ville_principale']);
        $situations = $this->Contacts->Situations->find('list', ['valueField' => 'titre']);
        $this->set(compact('contact', 'statuts', 'antennes', 'situations','countries'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contact id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contact = $this->Contacts->get($id);
        if ($this->Contacts->delete($contact)) {
            $this->Flash->success(__('The contact has been deleted.'));
        } else {
            $this->Flash->error(__('The contact could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
