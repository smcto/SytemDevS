<?php
namespace App\Controller;

use App\Controller\AppController;

class AjaxVillesCodePostalsController extends AppController
{
    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->loadModel('VillesCodePostals');
    }

    public function isAuthorized($user)
    {
        return true;
    }

    public function getByCp($ville_code_postal = null)
    {
        $body = [];
        if ($ville_code_postal != null) {
            $villesFrances = $this->VillesCodePostals->VillesFrances->find()->where(['ville_code_postal LIKE' => '%'.$ville_code_postal.'%'])->find('list', [
                'keyField' => 'ville_nom',
                'valueField' => 'ville_nom'
            ])->limit('500');

            $body = $villesFrances->toArray();
        }

        if (empty($body)) {
            $body = false;
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }
}
?>
