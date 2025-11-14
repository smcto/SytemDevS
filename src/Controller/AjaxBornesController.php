<?php
namespace App\Controller;

use App\Controller\AppController;

class AjaxBornesController extends AppController
{
    
    public function initialize(array $config = []) {
        parent::initialize($config);
        $this->loadModel('Bornes');
        $this->Auth->allow(['equipementByGamme']);
    }

    public function isAuthorized($user) {
        return true;
    }

    public function equipementByGamme($gamme_id, $borne_id = null, $model_borne_id = null) {
        
        $this->viewBuilder()->setLayout('ajax');
        
        $this->loadModel('GammesBornes');
        $gamme = $this->GammesBornes->find('all')->where(['id' => $gamme_id])->contain(['TypeEquipements'])->first();
        
        $old_equipements = [];
        if($borne_id) {
            $this->loadModel('EquipementBornes');
            $values = $this->EquipementBornes->find('all')->where(['borne_id' => $borne_id]);
            foreach ($values as $value) {
                $old_equipements[$value->type_equipement_id] = $value;
            }
        }
        
        $this->loadModel('Fournisseurs');
        $fournisseur = $this->Fournisseurs->find('list',[
            'keyField' => 'id',
            'valueField'=> 'nom',]
        );
        
        $this->set(compact('gamme', 'old_equipements', 'fournisseur'));
    }
    
    public function AccessoiresByGamme($gamme_id = null)
    {
        $this->loadModel('Accessoires');
        $accessoires = $this->Accessoires
            ->find()
            ->contain(['SousAccessoires' => 'SousAccessoiresGammes'])
            ->matching('SousAccessoires.SousAccessoiresGammes')
            ->where(['SousAccessoiresGammes.gamme_borne_id' => $gamme_id])
            ->group('Accessoires.id')
        ;
        $this->set(compact('accessoires'));
    }
    
    
    public function equipementByModelBorne($model_borne_id = null) {
        
        $this->viewBuilder()->setLayout('ajax');
        
        $equipements = [];
        if($model_borne_id) {
            $this->loadModel('ModelBorneHasEquipements');
            $values = $this->ModelBorneHasEquipements->find('all')->where(['model_borne_id' => $model_borne_id]);
            foreach ($values as $value) {
                $equipements[$value->type_equipement_id] = $value->equipement_id;
            }
        }
        
        return $this->response->withType('application/json')->withStringBody(json_encode($equipements));
    }

    public function findByParcId($parc_id)
    {
        $parcs = $this->Bornes->find('WithAnnotation')->find('list', ['valueField' => 'annotation_numero']);
        return $this->response->withType('application/json')->withStringBody(json_encode($parcs));
    }
    
}