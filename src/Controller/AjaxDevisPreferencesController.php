<?php
namespace App\Controller;

use App\Controller\AppController;

class AjaxDevisPreferencesController extends AppController
{
    public function initialize(array $config = [])
    {
        parent::initialize($config);
    }

    public function isAuthorized($user)
    {
        // code
        return true;
    }

    public function getInfoBanque($id)
    {
        $this->loadModel('InfosBancaires');
        $infosBancaire = $this->InfosBancaires->find()->where(['InfosBancaires.id' => $id])->first();      
        $this->set(compact('infosBancaire'));
    }
}