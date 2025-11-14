<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Text;
use Cewi\Excel;
/**
 * StripeCsvFiles Controller
 *
 * @property \App\Model\Table\StripeCsvFilesTable $StripeCsvFiles
 *
 * @method \App\Model\Entity\StripeCsvFile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StripeCsvFilesController extends AppController
{

    public $helpers = ['Cewi/Excel.Excel'];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler', [
            'viewClassMap' => ['xlsx' => 'Cewi/Excel.Excel']
        ]);
    }


    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        return true;
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
            'order' => ['id'=> 'DESC'],
        ];
        $stripeCsvFiles = $this->paginate($this->StripeCsvFiles);

        $this->set(compact('stripeCsvFiles'));
    }

    /**
     * View method
     *
     * @param string|null $id Stripe Csv File id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stripeCsvFile = $this->StripeCsvFiles->get($id, [
            'contain' => ['StripeCsvs']
        ]);

        $this->set('stripeCsvFile', $stripeCsvFile);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $stripeCsvFile = $this->StripeCsvFiles->newEntity();
        if ($this->request->is('post')) {

            $data = $this->request->getData();
            date_default_timezone_set('Europe/Paris');
            $heure_now = date("H:i:s");
            $data['date_import'] = $data['date_import'] . " " . $heure_now;
            //debug($data);die;
            $newFilename = "";

            $stripeCsvFile = $this->StripeCsvFiles->patchEntity($stripeCsvFile, $data);
            //======= Upload file
            if (!is_dir(PATH_STRIPES_CSV)) {
                mkdir(PATH_STRIPES_CSV, 0777);
            }
            if (!empty($data['stripe_csv_file']['name'])) {
                $extension = pathinfo($data['stripe_csv_file']['name'], PATHINFO_EXTENSION);
                $newFilename = Text::uuid() . "." . $extension;
                $path = PATH_STRIPES_CSV;
                if (move_uploaded_file($data['stripe_csv_file']['tmp_name'], $path . $newFilename)) {
                    $stripeCsvFile->filename = $newFilename;
                    $stripeCsvFile->filename_origin = $data['stripe_csv_file']['name'];

                    if ($this->StripeCsvFiles->save($stripeCsvFile)) {
                        //==== traitement du fichier
                        $file = fopen($path . $newFilename, "r");
                        if ($file) {
                            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                                $stripeCsv = $this->StripeCsvFiles->StripeCsvs->newEntity();
                                if (count($getData) > 15 && $getData[0] != "id") {
                                    //debug($getData);
                                    $stripeCsv->stripe_csv_file_id = $stripeCsvFile->id;
                                    $stripeCsv->date_import = $data['date_import'];
                                    $stripeCsv->filename = $newFilename;
                                    $stripeCsv->filename_origin = $data['stripe_csv_file']['name'];

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
                                    if ($this->StripeCsvFiles->StripeCsvs->save($stripeCsv)) {
                                        //debug($stripeCsv->id_stripe);
                                    }
                                }
                                //debug($stripeCsv);
                            }
                        }

                        $this->Flash->success(__('The stripe csv file has been saved.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('The stripe csv file could not be saved. Please, try again.'));
                }
            }
            $this->Flash->error(__('The stripe csv file could not be saved. Please, try again.'));
        }
        $this->set(compact('stripeCsvFile'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Stripe Csv File id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function export($id = null)
    {
        /*$this->loadModel('Clients');
        $client = $this->Clients->find('all', ['contain'=>'Documents'])
            ->innerJoinWith('Documents', function ($q)  { return $q->where(['Documents.ident' =>'DK-201808-02283']);
            })->first();
        debug($client->client_type);die;*/
        $this->viewBuilder()->setLayout('xlsx/default');
        $stripeCsvFile = $this->StripeCsvFiles->get($id, [
            'contain' => ['StripeCsvs']
        ]);

        $excel_export = [];
        $stripe_excels = [];
        $is_export_excel = false;
        $total_amount = 0;
        $total_fee = 0;
        foreach ($stripeCsvFile->stripe_csvs as $stripe_csv) {
            //debug($stripe_csv->toArray())
            $stripeExcel = $this->StripeCsvFiles->StripeCsvs->StripeExcels->newEntity();

            $this->loadModel('Clients');
            $client = $this->Clients->find('all')
                            ->innerJoinWith('Documents', function ($q) use ($stripe_csv) { return $q->where(['Documents.ident' =>$stripe_csv->description ]);
                            })->first();
            if(!empty($client)) {
                $total_amount = $total_amount + $stripe_csv->amount;
                $total_fee = $total_fee + $stripe_csv->fee;

                $stripeExcel->date = $stripe_csv->date_import;
                $stripeExcel->piece = $stripe_csv->description;
                if($client->client_type == "person"){
                    $stripeExcel->compte = "C".$client->nom.$client->prenom;
                } else if($client->client_type == "corporation"){
                    $stripeExcel->compte = "C".$client->nom;
                }
                $stripeExcel->description = 'ECLATEMENT STRIPE '.$stripe_csv->date_import->format('m/Y');
                $stripeExcel->debit = '';
                $stripeExcel->credit = $stripe_csv->amount;
                $stripeExcel->stripe_csv_id = $stripe_csv->id;
                $stripeExcel->stripe_csv_file_id = $stripeCsvFile->id;
                if ($this->StripeCsvFiles->StripeCsvs->StripeExcels->save($stripeExcel)) {
                    $stripeExcel = $stripeExcel->toArray();
                    unset($stripeExcel['stripe_csv_id']);
                    unset($stripeExcel['stripe_csv_file_id']);
                    unset($stripeExcel['id']);
                    $stripe_excels [] = $stripeExcel;
                    $is_export_excel = true;
                }
            }
        }

        //debug($stripe_excels);die;
        if($is_export_excel){
            $stripeExcel_av_derniere_ligne ['date'] = $stripe_excels[0]['date'];
            $stripeExcel_av_derniere_ligne ['piece'] = "";
            $stripeExcel_av_derniere_ligne ['compte'] = "Cstripe";
            $stripeExcel_av_derniere_ligne ['description'] = 'ECLATEMENT STRIPE '.$stripe_excels[0]['date']->format('m/Y');
            $stripeExcel_av_derniere_ligne ['debit'] = ($total_amount - $total_fee);
            $stripe_excels [] = $stripeExcel_av_derniere_ligne;

            $stripeExcel_derniere_ligne ['date'] = $stripe_excels[0]['date'];
            $stripeExcel_derniere_ligne ['piece'] = "";
            $stripeExcel_derniere_ligne ['compte'] = "Cstripe";
            $stripeExcel_derniere_ligne ['description'] = 'ECLATEMENT STRIPE '.$stripe_excels[0]['date']->format('m/Y');
            $stripeExcel_derniere_ligne ['debit'] = $total_fee;
            $stripe_excels [] = $stripeExcel_derniere_ligne;

            $stripeCsvFile->is_export_excel = $is_export_excel;
            $this->StripeCsvFiles->save($stripeCsvFile);
        }
        //$this->set('stripeCsvs', $excel_export);
        $this->set('stripeCsvs', $stripe_excels);
    }

    /**
     * Edit method
     *
     * @param string|null $id Stripe Csv File id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stripeCsvFile = $this->StripeCsvFiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stripeCsvFile = $this->StripeCsvFiles->patchEntity($stripeCsvFile, $this->request->getData());
            if ($this->StripeCsvFiles->save($stripeCsvFile)) {
                $this->Flash->success(__('The stripe csv file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stripe csv file could not be saved. Please, try again.'));
        }
        $this->set(compact('stripeCsvFile'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stripe Csv File id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stripeCsvFile = $this->StripeCsvFiles->get($id);
        if ($this->StripeCsvFiles->delete($stripeCsvFile)) {
            $this->Flash->success(__('The stripe csv file has been deleted.'));
        } else {
            $this->Flash->error(__('The stripe csv file could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function refreshList(){
        $this->viewBuilder()->setLayout('ajax');
        /*$stripeCsvFiles = $this->StripeCsvFiles->find('all', [
            'contain' => []
        ]);*/
        $this->paginate = [
            'order' => ['id'=> 'DESC'],
        ];
        $stripeCsvFiles = $this->paginate($this->StripeCsvFiles);
        $this->set('stripeCsvFiles', $stripeCsvFiles);
    }
}
