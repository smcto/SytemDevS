<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Messageries Controller
 *
 * @property \App\Model\Table\MessageriesTable $Messageries
 *
 * @method \App\Model\Entity\Messagery[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MessageriesController extends AppController
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
            'contain' => ['Clients', 'Users'],
        ];
        $messageries = $this->paginate($this->Messageries);


        $this->set(compact('messageries'));
    }

    /**
     * View method
     *
     * @param string|null $id Messagery id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $messagery = $this->Messageries->get($id, [
            'contain' => []
        ]);

        $this->set('messagery', $messagery);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $messagery = $this->Messageries->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            //debug(strlen($data['destinateur']));die;
            if(!empty($data['destinateur'])) {
                $phonecode = substr($data['destinateur'], 0, (strlen($data['destinateur']) - 9));
                //$phone = substr($data['destinateur'], (strlen($data['destinateur']) - 9), 9);
                $this->loadModel('Countrys');
                $phonecodes = $this->Countrys->find('list', ['valueField' => function ($e) { return '+' . $e->phonecode;}])->toArray();
                $data['phonecode'] = $phonecode;
                $data['phonecodes'] = $phonecodes;
            }

            if(empty($data['destinateur']) && empty($data['users']['_ids']) && empty($data['clients']['_ids'])){
                $this->Flash->error(__('The messagery could not be saved. Some field is required.'));
            } else {

                $messagery = $this->Messageries->patchEntity($messagery, $data, ['associated' => ['Users', 'Clients']]);
                if ($this->Messageries->save($messagery)) {
                    //===== ENVOI SMS
                    $this->loadComponent('Smsenvoi');
                    $messagery = $this->Messageries->get($messagery->id, [
                        'contain' => ['Users', 'Clients']
                    ]);
                    $numero_clients = [];
                    $numero_users = [];
                    if (!empty($messagery->clients)) {
                        foreach ($messagery->clients as $client) {
                            if (!empty($client->telephone)) {
                                $numero_clients [] = $client->telephone;
                            }
                        }
                    }
                    if (!empty($messagery->users)) {
                        foreach ($messagery->users as $user) {
                            if (!empty($user->telephone_portable)) {
                                $numero_users [] = $user->telephone_portable;
                            }
                        }
                    }
                    $destinateurs = $numero_clients + $numero_users;
                    if(!empty($messagery->destinateur)) $destinateurs [] = $messagery->destinateur;
                    $destinateurs = implode(',', $destinateurs);
                    //debug($destinateurs);die;

                    $confirmation_sms = "SMS NON ENVOYE";
                    if (!empty($destinateurs)) {
                        $result = $this->Smsenvoi->sendSMS($destinateurs, $messagery->message, 'PREMIUM', 'Selfizee');
                        if ($result['success']) {
                            $confirmation_sms = "SMS ENVOYE";
                            $messagery->is_sent = true;
                            $this->Messageries->save($messagery);
                        } else {
                            $confirmation_sms = $confirmation_sms . "( " . $result['message'] . " )";
                        }
                    }

                    $this->Flash->success(__('The messagery has been saved. ' . $confirmation_sms));

                    if(!empty($data['source'])) return $this->redirect($this->referer());
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The messagery could not be saved. Please, try again.'));
            }
        }
        $users = $this->Messageries->Users->find('list', ['valueField' => 'full_name', 'conditions'=>['telephone_portable IS NOT'=> '']]);
        $clients = $this->Messageries->Clients->find('list', ['valueField' => 'full_name', 'conditions'=>['telephone IS NOT'=> '']]);
        //debug($clients->count());die;

        $this->set(compact('messagery', 'users', 'clients'));
    }

    public function send($dest = null){

        if(empty($dest)) {
            $dest = "+261347387775,+261334152674";
        }
        $this->loadComponent('Smsenvoi');
        //$result = $this->Smsenvoi->sendSMS($numeroDestinataire, $message, 'PREMIUM', $nomEmmetteur);
        $result = $this->Smsenvoi->sendSMS($dest, 'Test message API SMS ENVOI ;)', 'PREMIUM', "TEST SMS ;)");
        debug($result);
        die;
    }

    /**
     * Edit method
     *
     * @param string|null $id Messagery id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $messagery = $this->Messageries->get($id, [
            'contain' => ['Users', 'Clients']
        ]);
        /*$numero_clients = [];
        $numero_users = [];
        foreach ($messagery->clients as $client){
            if(!empty($client->telephone)){
                $numero_clients [] = $client->telephone;
            }
        }
        foreach ($messagery->users as $user){
            if(!empty($user->telephone_portable)){
                $numero_users [] = $user->telephone_portable;
            }
        }

        $destinateurs = $numero_clients + $numero_users;
        debug($destinateurs);
        debug(implode(',',$destinateurs));die;*/
        if ($this->request->is(['patch', 'post', 'put'])) {
            $messagery = $this->Messageries->patchEntity($messagery, $this->request->getData());
            if ($this->Messageries->save($messagery)) {
                $this->Flash->success(__('The messagery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The messagery could not be saved. Please, try again.'));
        }
        $this->set(compact('messagery'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Messagery id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $messagery = $this->Messageries->get($id);
        if ($this->Messageries->delete($messagery)) {
            $this->Flash->success(__('The messagery has been deleted.'));
        } else {
            $this->Flash->error(__('The messagery could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
