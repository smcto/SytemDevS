<?php
namespace App\Controller;

use App\Controller\AppController;

class ImportsController extends AppController
{
    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->loadComponent('SpreadSheet');

    }

    public function isAuthorized($user)
    {
        return true;
    }

    public function synchClient()
    {
        $clients = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/export_clients_531931593780725.csv');

        foreach ($clients as $i => $client) {
            $insert = [];
            if ($i != 1) {
                $insert['mobile'] = isset($clientContact->mobile) ? $clientContact->mobile : null;
                $insert['telephone'] = isset($clientContact->tel) ? $clientContact->tel : null;

                $clientEntity= $this->Clients->findByIdInSellsy(intval($idSellsy))->contain(['ClientContacts'])->first();
                if($clientEntity !== null){
                    $clientEntity = $this->Clients->patchEntity($clientEntity, $insert, ['validate' => false]);
                }

            }
        }

    }
}
?>