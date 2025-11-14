<?php
namespace App\Controller;

use App\Controller\AppController;

class AjaxVentesConsommablesController extends AppController
{
    public function initialize(array $config = null)
    {
        parent::initialize($config);
        $this->loadModel('Devis');
    }

    public function isAuthorized($user)
    {
        return true;
    }

    public function loadDevisByCientId($client_id)
    {
        $this->loadModel('Devis');
        $devis = $this->Devis->findByClientId($client_id)->find('list', [
            'valueField' => 'indent'
        ])->order(['Devis.id' => 'DESC']);

        $body = $devis;
        return $this->response->withType('application/json')->withStringBody(json_encode($body));
    }

    /**
     * [getDevisAndProduits description] : on vient seulement extraire les produits des sous catégories "consommables" et "accessoires"
     * @param  [type]  $devis_id                   [description]
     * @param  integer $catalog_sous_categories_id 2 = Accessoires, 16 = consommables cf table catalog_sous_categories
     * @return [array]                             [description]
     */
    public function getDevisAndProduits($devis_id, $catalog_sous_category_id = 2)
    {
        // exemple devis_id : 25634
        // exemple client : baccarat
        $devisEntity = $this->Devis->findById($devis_id)->find("WithProduitsBySouscategorie", ['catalog_sous_category_id' => $catalog_sous_category_id])->first();
        $thHidev = $devisEntity->get('ThHidev');
        $colVisibilityParams = $devisEntity->get('ColVisibilityParamsAsArray');

        $this->set(compact('devisEntity','colVisibilityParams', 'thHidev'));
    }
}
?>