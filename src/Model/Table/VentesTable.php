<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ventes Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Vente get($primaryKey, $options = [])
 * @method \App\Model\Entity\Vente newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Vente[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Vente|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vente|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vente patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Vente[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Vente findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VentesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('ventes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
        ]);

        $this->belongsTo('Bornes', [
            'foreignKey' => 'borne_id',
        ]);
        
        $this->belongsTo('GroupeClients', [
            'foreignKey' => 'groupe_client_id',
        ]);

        $this->belongsTo('LivraisonPayss', [
            'foreignKey' => 'livraison_pays_id',
            'className' => 'Payss'
        ]);
        
        $this->belongsTo('GammesBornes', [
            'foreignKey' => 'gamme_borne_id',
        ]);
        
        $this->belongsTo('Parcs', [
            'foreignKey' => 'parc_id',
        ]);
        
        $this->belongsTo('ParcDurees', [
            'foreignKey' => 'parc_duree_id',
        ]);

        $this->hasMany('VentesDevisUploads', [
            'foreignKey' => 'vente_id',
            'dependent' => true, // pour les suppressions automatiques des associations
            'cascadeCallbacks' => true,
        ]);
        
        $this->hasMany('VentesAccessoires', [
            'foreignKey' => 'vente_id',
            'dependent' => true, // pour les suppressions automatiques des associations
            'cascadeCallbacks' => true,
        ]);

        $this->hasMany('VentesSousConsommables', [
            'foreignKey' => 'vente_id',
            'dependent' => true, 
            'cascadeCallbacks' => true,
        ]);

        $this->hasMany('EquipementsAccessoiresVentes', [
            'foreignKey' => 'vente_id',
        ]);

        $this->hasMany('EquipementsProtectionsVentes', [
            'foreignKey' => 'vente_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);

        $this->belongsToMany('Documents', [
            'foreignKey' => 'vente_id',
            'targetForeignKey' => 'document_id',
            'joinTable' => 'ventes_documents', 
            'className' => 'Documents',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        
        $this->hasMany('EquipementVentes', [
            'foreignKey' => 'vente_id'
        ]);


    }

    protected function _initializeSchema($schema)
    {
        $schema->setColumnType('checked_accessories', 'json');
        $schema->setColumnType('checked_consommables', 'json');
        return $schema;
    }

    /**
     * afterSave callback
     *
     * @param $created boolean
     * @param $options array
     * @return void
     */
    public function beforeSave($event, $venteEntity, $options) {

        $venteDevisUploads = $this->VentesDevisUploads->find()->where(['vente_id' => $venteEntity->id]);
        if (isset($venteEntity->ventes_devis_uploads)) {
            foreach ($venteDevisUploads as $key => $venteDevisUpload) {
                if (!in_array($venteDevisUpload->id, collection($venteEntity->ventes_devis_uploads)->combine('id', 'id')->toArray())) {
                    $this->VentesDevisUploads->delete($venteDevisUpload);
                }
            }
        }

        $ventesAccessoires = $this->VentesAccessoires->find()->where(['vente_id' => $venteEntity->id]);
        if (isset($venteEntity->ventes_accessoires)) {
            foreach ($ventesAccessoires as $key => $ventesAccessoire) {
                if (!in_array($ventesAccessoire->id, collection($venteEntity->ventes_accessoires)->combine('id', 'id')->toArray())) {
                    $this->VentesAccessoires->delete($ventesAccessoire);
                }
            }
        }

        return $venteEntity;
    }

    /**
     * - pour fixer le vente_client_contact_id du brief-project
     * @return [type]              [description]
     */
    public function afterSave($event, $venteEntity, $options) {
        if (!empty($venteEntity->client->client_contacts)) {
            foreach ($venteEntity->client->client_contacts as $key => $clientContact) {


                $clientContactId = $clientContact->id;
                if ($clientContact->is_from_crea == 1) {
                    $this->updateAll(['vente_crea_contact_client_id' => $clientContactId], ['id' => $venteEntity->id]);
                }

                if ($clientContact->is_from_livraison == 1) {
                    $this->updateAll(['vente_livraison_contact_client_id' => $clientContactId], ['id' => $venteEntity->id]);
                }
            }
        }
    }
    

    public function findComplete(Query $query, array $options)
    {
        $query->contain(['LivraisonPayss', 'EquipementsAccessoiresVentes' => ['Equipements', 'TypeEquipements' => 'Equipements'], 'EquipementsProtectionsVentes' => ['Equipements', 'TypeEquipements' => 'Equipements'], 'Clients' => ['SecteursActivites', 'ClientContacts' => function ($q)
        {
            return $q->find('NotEmpty');
        },'GroupeClients'], 'GammesBornes', 'Bornes'=> ['ModelBornes' => 'GammesBornes'], 'Parcs' => 'ParcDurees', 'Documents', 'Users', 'VentesDevisUploads', 'VentesSousConsommables' => 'TypeConsommables', 'EquipementVentes' => ['TypeEquipements', 'Equipements'], 'VentesAccessoires' => function ($q)
        {
            $q = $q->order(['id' => 'ASC']);
            return $q;
        }])->order([
            'Ventes.id' => 'DESC'
        ])->group('Ventes.id');
        
        if(isset($options['limit']) && !empty($options['limit'])){
            $query->limit($options['limit']);
        }
        
        return $query;
    }
    
    public function findFiltre(Query $query, array $options) {
        
        $client = isset($options['client_id'])?$options['client_id']:null;
        if(!empty($client)){
            $query->where(['Ventes.client_id' => $client]);
        }
        
        $groupe_client = isset($options['groupe_client_id'])?$options['groupe_client_id']:null;
        if(!empty($groupe_client)){
            $query->where(['Clients.groupe_client_id' => $groupe_client]);
        }
        
        $user = isset($options['user_id'])?$options['user_id']:null;
        if(!empty($user)){
            $query->where(['Ventes.user_id'=>$user]);
        }
        
        $vente_statut = isset($options['vente_statut'])?$options['vente_statut']:null;
        if(!empty($vente_statut)){
            $query->where(['Ventes.vente_statut'=>$vente_statut]);
        }
        
        $numero = isset($options['numero'])?$options['numero']:null;
        if(!empty($numero)){
            $query->where(['Bornes.numero' => $numero]);
        }
        
        $ident = isset($options['numero_devis'])?$options['numero_devis']:null;
        if ($ident) {
            $query->contain(['Documents'])->matching('Documents')->where(['Documents.ident' => $ident]);
        }
        
        if(isset($options['mensuel']) && !empty($options['mensuel'])){
            $query->where(["DATE_FORMAT(Ventes.created, '%m-%Y') LIKE" => $options['mensuel']]);
        }
        
        if(isset($options['annuel']) && !empty($options['annuel'])){
            $query->where(["DATE_FORMAT(Ventes.created, '%Y') LIKE" => $options['annuel']]);
        }
        
        if(isset($options['dateDebut']) && !empty($options['dateDebut']) && isset($options['dateFin']) && !empty($options['dateFin'])){
            $query->where(["Ventes.created >=" => $options['dateDebut'], "Ventes.created <=" => $options['dateFin']]);
        }
        
        return $query;
    }

    public function findVentesLocaFi(Query $query, array $options)
    {
        /*$query->where([
            'Ventes.parc_id IN' => [1, 4] // ventes et location financiere
        ]);*/
        return $query;
    }

    public function findLocaExpedie(Query $query, array $options)
    {
        return $query->where([
            'Ventes.parc_id' => 4, 
            'Ventes.vente_statut' => 'expedie',
        ]);
    }

    public function findFactureNonTraitees(Query $query, array $options)
    {
        $query->where([
            'etat_facturation NOT IN' => ['accompte_regle', 'facturation_envoyee']
        ]);
        return $query;
    }

    public function findFactureTraitees(Query $query, array $options)
    {
        $query->where([
            'etat_facturation IN' => ['accompte_regle', 'facturation_envoyee']
        ]);
        return $query;
    }
    
    
    public function findCountByParc(Query $query, array $options)
    {
        $query
            ->select(['nb' => $query->func()->count('Ventes.id'),'name' => 'Parcs.nom2'])
            ->contain(['Parcs'])
            ->group(['Ventes.parc_id'])
            ->enableAutoFields(true)
        ;
        return $query;
    }
    
    public function findCountByParcAndMonth(Query $query, array $options)
    {
        $query
            ->select([
                'nb' => $query->func()->count('Ventes.id'), 
                'month' => "DATE_FORMAT(Ventes.created, '%M %Y')", 
                'x' => "DATE_FORMAT(Ventes.created, '%m')",
                'name' => 'Parcs.nom2'
            ])
            ->contain(['Parcs'])
            ->group(['Ventes.parc_id',"DATE_FORMAT(Ventes.created, '%M %Y')"])
            ->order(['Ventes.created' => 'ASC'])
            ->limit(12)
            ->enableAutoFields(true)
        ;
        return $query;
    }
    
    public function findCountByTypeClientByMonth(Query $query, array $options)
    {
        $query
            ->select(['nb' => $query->func()->count('Ventes.id'), 
                'month' => "DATE_FORMAT(Ventes.created, '%M %Y')", 
                'x' => "DATE_FORMAT(Ventes.created, '%m')",
                'name' => "Clients.client_type"
            ])
            ->contain(['Clients'])
            ->group(['Clients.client_type',"DATE_FORMAT(Ventes.created, '%M %Y')"])
            ->order(['Ventes.created' => 'ASC'])
            ->enableAutoFields(true)
        ;
        return $query;
    }

    public function findCountByUser(Query $query, array $options)
    {
        $query
            ->select(['sum' => $query->func()->sum('Ventes.facturation_montant_ht'), 'nb' => $query->func()->count('Ventes.id')])
            ->contain(['Parcs','Users'])
            ->limit(5)
            ->enableAutoFields(true)
            ->order(['sum' => 'DESC']);
        
        $query->group(['Ventes.user_id']);
        
        if(isset($options['user']) && !empty($options['user'])){
            $query->where(['Ventes.user_id' => $options['user']]);
        }
        
        if(isset($options['parc']) && !empty($options['parc'])){
            $query->where(['Ventes.parc_id' => $options['parc']]);
        }
        
        return $query;
    }
    
    public function findCaVente(Query $query, array $options)
    {
        $query
            ->select(['sum' => $query->func()->sum('Ventes.facturation_montant_ht')])
            ->contain(['Parcs','Users'])
            ->enableAutoFields(true)
        ;
        
        return $query;
    }
    
    

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('user_id')
            ->notEmpty('user_id');

        $validator
            ->scalar('type_vente')
            ->notEmpty('type_vente');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
