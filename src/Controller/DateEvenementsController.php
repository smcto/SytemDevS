<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Evenements Controller
 *
 * @property \App\Model\Table\DateEvenementsTable $DateEvenements
 *
 * @method \App\Model\Entity\Evenement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DateEvenementsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('RequestHandler');

    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if (in_array('admin', $typeprofils)) {
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
        $antenne = $this->request->getQuery('antenne');
        $type_evenement = $this->request->getQuery('type_evenement');
        $type_animation = $this->request->getQuery('type_animation');
        $type_client = $this->request->getQuery('type_client');
        $key = $this->request->getQuery('key');

        $customFinderOptions = [
            'key' => $key,
            'antenne' => $antenne,
            'type_evenement' => $type_evenement,
            'type_animation' => $type_animation,
            'type_client' => $type_client
        ];

        $this->paginate = [
            'contain' => ['Evenements'=>[ 'TypeEvenements', 'TypeAnimations', 'Clients', 'Antennes']],
            'finder' => [
                'filtre' => $customFinderOptions
            ]
        ];
        $dateEvenements = $this->paginate($this->DateEvenements);
        //debug($dateEvenements);die;

        $typeEvenements = $this->DateEvenements->Evenements->TypeEvenements->find('list', ['valueField' => 'nom']);
        $typeAnimations = $this->DateEvenements->Evenements->TypeAnimations->find('list', ['valueField' => 'nom']);
        $antennes = $this->DateEvenements->Evenements->Antennes->find('list', ['valueField' => 'ville_principale']);
        $clientTypes = ['corporation' => 'Professionel', 'person' => 'Particulier'];

        $lang = $this->request->getParam('lang');
        $this->set(compact('antenne', 'key', 'type_client', 'type_evenement', 'type_animation', 'lang'));
        $this->set(compact('dateEvenements', 'antennes', 'typeEvenements', 'clientTypes', 'typeAnimations'));
    }

    public function getDatesEvents(){
        $start = $this->request->getQuery('start');
        $end = $this->request->getQuery('end');
        $antenne = $this->request->getQuery('antenne');
        $type_evenement = $this->request->getQuery('type_evenement');
        $type_animation = $this->request->getQuery('type_animation');
        $type_client = $this->request->getQuery('type_client');
        $search = $this->request->getQuery('key');

        $query = $this->DateEvenements->find('all', ['contain'=>['Evenements'=>['TypeEvenements', 'TypeAnimations', 'Clients', 'Antennes']]]);
        $query->where(['DateEvenements.date_debut IS NOT'=> NULL, 'DateEvenements.date_fin IS NOT'=> NULL]);

        //=========== FILTRE

        if(!empty($start) && !empty($end)) {
            $query->where(function ($exp) use ($start, $end) {
                $exp->lte('DateEvenements.date_debut', $end);
                $exp->gte('DateEvenements.date_debut', $start);
                return $exp;
            });
        }

        if(!empty($search)){
            $query->contain('Evenements', function ($q) use ($search){
                //return $q->where(['Evenements.nom_event LIKE' => '%'.$search.'%'])->where(['Evenements.lieu_exact LIKE' => '%'.$search.'%']);
                return $q->where(['Evenements.nom_event LIKE' => '%'.$search.'%', 'OR' =>['Evenements.lieu_exact LIKE' => '%'.$search.'%']]);
            });
            /*$query->contain('Evenements.Clients', function ($q) use ($search){
                return $q->where(['Clients.nom LIKE' => '%'.$search.'%'])->orWhere(['Clients.prenom LIKE' => '%'.$search.'%']);
            });
            $query->contain('Evenements.Antennes', function ($q) use ($search){
                return $q->where(['Antennes.ville_principale LIKE' => '%'.$search.'%']);
            });*/
        }

        if(!empty($type_evenement)){
            $query->contain('Evenements', function ($q) use ($type_evenement){
                return $q->where(['Evenements.type_evenement_id ' => $type_evenement]);
            });
        }

        if(!empty($type_animation)){
            $query->contain('Evenements', function ($q) use ($type_animation){
                return $q->where(['Evenements.type_animation_id ' => $type_animation]);
            });
        }

        if(!empty($type_client)){
            $query->contain(['Evenements' => ['Clients' => function ($q) use ($type_client){
                return $q->where(['Clients.client_type ' => $type_client]);
            }]
            ]);
        }
        if(!empty($antenne)){
            $query->contain('Evenements', function ($q) use ($antenne){
                return $q->where(['Evenements.antenne_id ' => $antenne]);
            });
        }

        /*debug($query->count());
        debug($query->toArray());die;*/
        /*foreach ($query as $ev){
            debug($ev->evenement->client);
        }die;*/
        //echo json_encode($events->toArray());
        $this->set('events', $query);
    }

    public function getEvent($id){
        $event = $this->DateEvenements->get(intval($id), ['contain'=>['Evenements'=>['TypeEvenements', 'TypeAnimations', 'Clients']]]);
        $this->set('event', $event);
    }
}