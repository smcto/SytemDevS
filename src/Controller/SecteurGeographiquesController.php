<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SecteurGeographiques Controller
 *
 * @property \App\Model\Table\SecteurGeographiquesTable $SecteurGeographiques
 */
class SecteurGeographiquesController extends AppController
{
    public function initialize(array $config = [])
    {
        parent::initialize($config);
    }

    /**
     * /api/secteur-geographiques/get-all.json
     * @return [type] [description]
     */
    public function getAll()
    {
        $secteursGeos = $this->SecteurGeographiques->find()->select(['id', 'nom']);
        return $this->response->withType('application/json')->withStringBody(json_encode($secteursGeos));
    }
}
