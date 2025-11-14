<?php
namespace App\Traits;

use Cake\Routing\Router;
use Cake\ORM\Query;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\ServerRequest;
use Cake\Network\Session;
use Cake\Cache\Cache;
use App\Controller\Component\UtilitiesComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;

/**
 * Trait: pour dispatcher certaine methodes dans toute l'appli (comme componnent pour seulement pour les controlleurs)
 */

trait AppTrait
{
    use ModelAwareTrait;

    public function getUtilitiesComponent()
    {
        return new UtilitiesComponent(new ComponentRegistry);
    }

    function slEncryption($data){
        return $this->getUtilitiesComponent()->slEncryption($data);
    }
    
    function slDecryption($data) {
        return $this->getUtilitiesComponent()->slDecryption($data);
    }


    // ------- lié à l'import devis par exel ou api sellsy
    public function findLikeCommercial($ref_interne)
    {
        $this->loadModel('Devis');
        if (in_array($ref_interne, ['Bertrand Lecollinet', 'Bertrand Le Collinet'])) {
            $ref_interne = 'Le Collinet Bertrand';
        } elseif (in_array($ref_interne, ['Sebastien Mahé', 'M Sebastien Mahé'])) {
            $ref_interne = 'Mahé Sébastien';
        } elseif (in_array($ref_interne, ['M La Team Selfizee', 'La Team Selfizee'])) {
            $ref_interne = 'La Team Selfizee';
        }elseif (in_array($ref_interne, ["Lucie L'Hôtelier"])) {
            $ref_interne = "L'Hôtellier Lucie";
        }
        $refInterneName = explode(' ', $ref_interne);
        $ref_interne = end($refInterneName);


        $findedCommercial = $this->Devis->Commercial->find('LikeName', ['term' => $ref_interne])->first();
        if (!is_null($findedCommercial) && !in_array($findedCommercial->get('FullName'), ["Laura Kerzil", "Caroline Barraja"])) {
            $commercialEntity = $this->Devis->Commercial->find('LikeName', ['term' => $ref_interne])->first();
        } else {
            $commercialEntity = $this->Devis->Commercial->findById(84)->first();
        }
        return $commercialEntity;
    }

    /**
     * [name description]
     * @param  [type] $text_brut Tarif TTC|tarif HT
     * @return [type]            [description]
     */
    public function getCatTarifaire($categorieTarifaire)
    {
        if ($categorieTarifaire == 'N/A') {
            $categorieTarifaire = '';
        }
        if (preg_match("/{$categorieTarifaire}/i", 'Tarif TTC')) {
            $categorieTarifaire = 'ttc';
        } elseif (preg_match("/{$categorieTarifaire}/i", 'tarif HT')) {
            $categorieTarifaire = 'ht';
        } else {
            $categorieTarifaire = '';
        }
        return $categorieTarifaire;
    }

    /**
     * [buildSellsyStatus description]
     * @param  [type] $doctype invoice/estimate/proforma/delivery/order/mode
     * @return [type]          [description]
     */
    public function buildSellsyStatus($status, $doctype)
    {
        if ($doctype == 'estimate') {
            $configStatus = Configure::read('devis_status');
            $convert = [
                'read' => 'lu',
                'cancelled' => 'canceled',
                'advanced' => 'acompte',
                'partialinvoiced' => 'partially_billed',
                'invoiced' => 'billed',
            ];
        }

        // debug($doctype);
        // die();
        if ($doctype == 'invoice') {
            $configStatus = Configure::read('devis_factures_status');
            $convert = [
                'read' => 'lu',
                'cancelled' => 'canceled',
                'due' => 'fix',
                'payinprogress' => 'partial-payment',
                'late' => 'delay',
            ];
        }


        // debug($configStatus);
        // debug($convert);
        // die();
        if (isset($convert[$status])) {
            $devisStatus = $convert[$status];
        } 

        if (isset($configStatus[$status])) {
            $devisStatus = $status;
        } 

        if (!isset($devisStatus)) {
            die('status absent: '.$status);
        }

        // debug($configStatus[$devisStatus]);
        return $devisStatus;
    }

    /**
     * options doit contenir parc_id
     * @param [type] $options [description]
     */
    public function setParcTypeOnClient($options)
    {
        $data = [
            'is_location_financiere' => $options['parc_id'] == 4 ? true : false,
            'is_location_lng_duree' => $options['parc_id'] == 9 ? true : false,
            'is_borne_occasion' => $options['parc_id'] == 10 ? true : false,
            'is_vente' => $options['parc_id'] == 1 ? true : false
        ];

        return $data;
    }
}