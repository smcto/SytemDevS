<?php
namespace App\Controller;

use App\Controller\AppController;

class AjaxModelBornesController extends AppController
{
    
    public function initialize(array $config = []) {
        parent::initialize($config);
        $this->Auth->allow(['equipementByGamme']);
    }

    public function isAuthorized($user) {
        return true;
    }

    public function equipementByGamme($gamme_id, $model_borne_id = null) {
        
        $this->viewBuilder()->setLayout('ajax');
        
        $this->loadModel('GammesBornes');
        $gamme = $this->GammesBornes->find('all')->where(['id' => $gamme_id])->contain(['TypeEquipements'])->first();
        
        $old_equipements = [];
        if($model_borne_id) {
            $this->loadModel('ModelBorneHasEquipements');
            $values = $this->ModelBorneHasEquipements->find('all')->where(['model_borne_id' => $model_borne_id]);
            foreach ($values as $value) {
                $old_equipements[$value->type_equipement_id] = $value;
            }
        }
        
        $this->loadModel('Equipements');
        $equipements = $this->Equipements->find('list',[
            'keyField' => 'id',
            'valueField'=>'valeur',
            'groupField' => 'type_equipement_id'
        ])->toArray();
        
        $this->set(compact('gamme', 'old_equipements', 'equipements'));
    }
    
}