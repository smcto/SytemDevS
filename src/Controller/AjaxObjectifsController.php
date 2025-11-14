<?php
namespace App\Controller;

use App\Controller\AppController;

class AjaxObjectifsController extends AppController
{
    public function initialize(array $config = []):void
    {
        parent::initialize($config);
    }

    public function isAuthorized($user)
    {
        return true;
    }

    public function check()
    {
        $this->loadModel('ObjectifsAnnees');
        $queries = $this->request->getQuery();
        $objectifsAnneeEntity = $this->ObjectifsAnnees->find()->where($queries)->first();
        $body = ['status' => $objectifsAnneeEntity ? 'exist' : false];
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }
}
?>