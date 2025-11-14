<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

class ObjectifsController extends AppController
{
    public function initialize(array $config = []):void
    {
        parent::initialize($config);

        $this->loadModel('Users');
        $this->loadModel('DevisTypeDocs');
        $this->loadModel('ObjectifsCommerciaux');
        $this->loadModel('ObjectifsAnnees');

        $annees = Configure::read('annees');
        $mois = Configure::read('mois');
        $this->set(compact('annees', 'mois'));
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $typeprofils = $user['typeprofils'];
        if(array_intersect(['admin', 'konitys'], $typeprofils)) {
            return true;
        }
        //return parent::isAuthorized($user);
    }

    /**
     * on liste les profils de type commerciaux
     * @return [type] [description]
     */
    public function index()
    {
        $group_user = 2;
        $customFinderOptions = [
            'typeProfil' => 11, // commercial
            'group_user' => $group_user
        ];
        $commerciaux = $this->Users->find('filtre', $customFinderOptions)->contain(['Clients', 'Antennes', 'Fournisseurs', 'Profils', 'Situations', 'Statuts', 'AntennesRattachees']);
        $this->set(compact('commerciaux', 'group_user'));
    }

    public function add($commercial_id, $objectifs_annee_id = null)
    {
        $commercial = $this->Users->findById($commercial_id)->first();
        $annee = $this->request->getQuery('annee');

        if ($this->ObjectifsAnnees->find()->where(['annee' => $annee, 'user_id' => $commercial->id])->first() && $objectifs_annee_id == null) {
            $this->Flash->error("L'objectif $annee existe déjà");
            return $this->redirect($this->referer());
        }


        $objectifsAnneeEntity =  $this->ObjectifsAnnees->newEntity();

        if ($objectifs_annee_id) {
            $objectifsAnneeEntity = $this->ObjectifsAnnees->findById($objectifs_annee_id)->contain(['ObjectifsCommerciaux' => 'DevisTypeDocs'])->first();
        }

        if ($this->request->is(['post', 'put', 'patch'])) {

            $data = $this->request->getData();
            $data['user_id'] = $commercial_id;

            $objectifsAnneeEntity =  $this->ObjectifsAnnees->patchEntity($objectifsAnneeEntity, $data);

            if($this->ObjectifsAnnees->save($objectifsAnneeEntity)) {
                $this->Flash->success("L'objectif a bien été enregistré");
                return $this->redirect(['action' => 'view', $commercial_id]);
            }
            
            return $this->redirect($this->referer());
        }
        $devisTypeDocs = $this->DevisTypeDocs->find();
        $this->set(compact('commercial', 'devisTypeDocs', 'annee', 'objectifsAnneeEntity', 'objectifs_annee_id'));
    }

    public function view($commercial_id)
    {
        $commercial = $this->Users->findById($commercial_id)->first();
        $objectifsAnnees = $this->ObjectifsAnnees->findByUserId($commercial_id)->order(['annee' => 'desc']);
        $this->set(compact('commercial', 'objectifsAnnees'));
    }
}
?>