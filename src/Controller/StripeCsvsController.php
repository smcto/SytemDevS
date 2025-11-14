<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Text;

/**
 * StripeCsvs Controller
 *
 * @property \App\Model\Table\StripeCsvsTable $StripeCsvs
 *
 * @method \App\Model\Entity\StripeCsv[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StripeCsvsController extends AppController
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
        $stripeCsvs = $this->paginate($this->StripeCsvs);

        $this->set(compact('stripeCsvs'));
    }

    /**
     * View method
     *
     * @param string|null $id Stripe Csv id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stripeCsv = $this->StripeCsvs->get($id, [
            'contain' => ['StripeExcels']
        ]);

        $this->set('stripeCsv', $stripeCsv);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $stripeCsv = $this->StripeCsvs->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            date_default_timezone_set('Europe/Paris');
            $heure_now = date("H:i:s");
            $data['date_import'] = $data['date_import']. " ".$heure_now;
            //debug($data);die;
            $newFilename = "";
            if (!empty($data['stripe_csv_file']['name'])) {
                $extension = pathinfo($data['stripe_csv_file']['name'], PATHINFO_EXTENSION);
                $newFilename = Text::uuid() . "." . $extension;
                $path = 'uploads/stripes_csv/';
                if (move_uploaded_file($data['stripe_csv_file']['tmp_name'], $path . $newFilename)) {
                    $data['filename'] = $newFilename;
                    $data['filename_origin'] = $data['stripe_csv_file']['name'];
                }
                //==== traitement du fichier
                /*$file = fopen($data['stripe_csv_file']['tmp_name'], "r");
                if($file) {
                    while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $stripeCsv = $this->StripeCsvs->newEntity();
                        if(count($getData) > 15 && $getData[0] != "id"){
                            //debug($getData);
                            $stripeCsv->date_import = $data['date_import'];
                            $stripeCsv->filename = $data['filename'];
                            $stripeCsv->filename_origin = $data['filename_origin'];

                            $stripeCsv->id_stripe = $getData[0];
                            $stripeCsv->description = $getData[1];
                            $stripeCsv->seller_message = $getData[2];
                            $stripeCsv->created = $getData[3];
                            $stripeCsv->amount = $getData[4];
                            $stripeCsv->amount_refunded = $getData[5];
                            $stripeCsv->currency = $getData[6];
                            $stripeCsv->converted_amount = $getData[7];
                            $stripeCsv->converted_amount_refunded = $getData[8];
                            $stripeCsv->fee = $getData[9];
                            $stripeCsv->tax = $getData[10];
                            $stripeCsv->converted_currency = $getData[11];
                            $stripeCsv->status = $getData[12];
                            $stripeCsv->statement_descriptor = $getData[13];
                            $stripeCsv->customerId = $getData[14];
                            $stripeCsv->customer_description = $getData[15];
                            $stripeCsv->customer_email = $getData[16];
                            $stripeCsv->captured = $getData[17];
                            $stripeCsv->cardId = $getData[18];
                            $stripeCsv->invoiceId = $getData[19];
                            $stripeCsv->transfert = $getData[20];
                            /*if($this->StripeCsvs->save($stripeCsv)){
                                debug($stripeCsv->id_stripe);
                            }
                        }
                        //debug($stripeCsv);
                    }
                }die;*/
            }
            $stripeCsv = $this->StripeCsvs->patchEntity($stripeCsv, $data);
            if ($this->StripeCsvs->save($stripeCsv)) {
                $this->Flash->success(__('The stripe csv has been saved.'));

                return $this->redirect(['action' => 'index', $data['filename'],$data['filename_origin']]);
            } else {
                if ( file_exists('uploads/stripes_csv/' . $newFilename)) {
                    unlink('uploads/stripes_csv/' . $newFilename);
                }
            }
            $this->Flash->error(__('The stripe csv could not be saved. Please, try again.'));
        }
        $this->set(compact('stripeCsv'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Stripe Csv id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stripeCsv = $this->StripeCsvs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stripeCsv = $this->StripeCsvs->patchEntity($stripeCsv, $this->request->getData());
            if ($this->StripeCsvs->save($stripeCsv)) {
                $this->Flash->success(__('The stripe csv has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stripe csv could not be saved. Please, try again.'));
        }
        $this->set(compact('stripeCsv'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stripe Csv id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stripeCsv = $this->StripeCsvs->get($id);
        if ($this->StripeCsvs->delete($stripeCsv)) {
            $this->Flash->success(__('The stripe csv has been deleted.'));
        } else {
            $this->Flash->error(__('The stripe csv could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
