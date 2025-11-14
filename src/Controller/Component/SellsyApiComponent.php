<?php

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\SellsyCurlComponent;
use Cake\Utility\Hash;

class SellsyApiComponent extends Component
{
    public $SellsyCurl;
    public $components = ['Utilities'];

    public function initialize(array $config)
    {
        parent::initialize($config);
        if ($this->SellsyCurl == null) {
            $this->SellsyCurl = new SellsyCurlComponent(new ComponentRegistry());
        }
    }

    public function request($requestSettings, $requestFile = false, $showJSON = false)
    {
        $req = $this->SellsyCurl->requestApi($requestSettings, $requestFile = false, $showJSON= false);
        return isset($req->response) ? $req->response : null;
    }

    /**
     * Nb client ~= 3000
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    
    public function getClient($client_id = 12763673)
    {
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Client.getOne',
            'params' => array(
                'clientid'     => $client_id
            ),
        );
        $client = $this->sellsyCurlComponent->requestApi($request)->response;
        debug($client);die;
    }

    public function getProspect($prospect_id = 24672319)
    {
        $this->sellsyCurlComponent = new SellsyCurlComponent(new ComponentRegistry());
        $request = array(
            'method' => 'Prospects.getOne',
            'params' => array(
                'id'     => $prospect_id
            ),
        );
        $prospect = $this->sellsyCurlComponent->requestApi($request)->response;
        debug($prospect);die;
    }


    public function getAllCustomersList($params = [])
    {
        $requestRetrieveInfos = [
            'method' => 'Client.getList',
            'params' => [
                // 'clientid' => 12763673,
                'pagenum' => 1,
                'nbperpage' => 10
            ]
        ];

        $response = $this->request($requestRetrieveInfos);

        return $response;
    }

    public function getAllDocumentsList($params = [])
    {
        $requestRetrieveInfos = [
            'method' => 'Document.getList',
            'params' => [
                'doctype' => 'estimate',
                'pagination' => [
                    'nbperpage' => 10
                ]
            ]
        ];

        $response = $this->request($requestRetrieveInfos);
        $infos = isset($response->infos) ? $response->infos : null;
        $nbpages  = isset($infos->nbpages) ? $infos->nbpages  : 0;


        $documents = [];

        for ($i = 1; $i <= $nbpages; $i++) {
            $request = [
                'method' => 'Document.getList',
                'params' => [
                    'doctype' => 'estimate',
                    'pagination' => [
                        'pagenum' => $i,
                        'nbperpage' => 10
                    ]
                ]
            ];
            
            $documentsF = json_decode(json_encode($this->request($request)->result), true);
            $documents = array_merge($documents, $documentsF);
        }

        return $documents;
    }
}
?>