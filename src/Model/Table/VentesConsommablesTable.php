<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VentesConsommables Model
 *
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property |\Cake\ORM\Association\BelongsTo $Parcs
 *
 * @method \App\Model\Entity\VentesConsommable get($primaryKey, $options = [])
 * @method \App\Model\Entity\VentesConsommable newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VentesConsommable[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VentesConsommable|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentesConsommable|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentesConsommable patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VentesConsommable[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VentesConsommable findOrCreate($search, callable $callback = null, $options = [])
 */
class VentesConsommablesTable extends Table
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

        $this->setTable('ventes_consommables');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Parcs', [
            'foreignKey' => 'parc_id'
        ]);

        $this->hasMany('VentesHasSousConsommables', [
            'foreignKey' => 'ventes_consommable_id',
            'dependent' => true, 
            'cascadeCallbacks' => true,
        ]);

        $this->hasMany('VentesHasSousAccessoires', [
            'foreignKey' => 'ventes_consommable_id',
            'dependent' => true, 
            'cascadeCallbacks' => true,
        ]);

        $this->hasMany('VentesHasDevisProduits', [
            'foreignKey' => 'ventes_consommable_id',
            'dependent' => true, 
            'cascadeCallbacks' => true,
        ]);
    }

    protected function _initializeSchema($schema)
    {
        $schema->setColumnType('checked_accessories', 'json');
        $schema->setColumnType('checked_consommables', 'json');
        $schema->setColumnType('checked_produits', 'json');
        return $schema;
    }

    public function findWithSousCategories(Query $query, array $options)
    {
        $query->contain([
            'VentesHasDevisProduits' => ['DevisProduits' => function ($q)
            {
                return $q->contain(['CatalogProduits' => function ($q)
                {
                    return $q->matching('CatalogProduitsHasCategories', function ($q)
                    {
                        return $q->where(['catalog_sous_category_id IN' => [2, 16]]);
                    });
                }]);
            }]
        ]);
        return $query;
    }

    public function findComplete(Query $query, array $options)
    {
        $query
            ->contain([
                'Clients'=>'GroupeClients', 'Users', 'Parcs'
            ])
            ->contain(['VentesHasSousAccessoires' => function ($q) {
                    return $q->order(['VentesHasSousAccessoires.id' => 'ASC'])->contain(['SousAccessoires', 'LivraisonsVentesSousAccessoires']);
                }
            ])
            ->contain(['VentesHasSousConsommables' => function ($q) {
                    return $q->order(['VentesHasSousConsommables.id' => 'ASC'])->contain(['SousTypesConsommables', 'LivraisonsVentesSousConsommables']);
                }
            ])
            ->order(['VentesConsommables.id' => 'DESC'])
        ;
            
            
        $user = isset($options['user_id']) ? $options['user_id'] : null;
        if(!empty($user)){
            $query->where(['VentesConsommables.user_id'=>$user]);
        }

        $client = isset($options['client_id']) ? $options['client_id'] : null;
        if(!empty($client)){
            $query->where(['VentesConsommables.client_id'=>$client]);
        }

        $consommable_statut = isset($options['consommable_statut']) ? $options['consommable_statut'] : null;
        if(!empty($consommable_statut)){
            $query->where(['VentesConsommables.consommable_statut'=>$consommable_statut]);
        }

        $groupe_client = isset($options['groupe_client_id'])?$options['groupe_client_id']:null;
        if(!empty($groupe_client)){
            $query->where(['GroupeClients.id'=>$groupe_client]);
        }
        
        $limit = isset($options['limit'])?$options['limit']:null;
        if(!empty($limit)){
            $query->limit($limit);
        }
        
        return $query;
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
            ->date('livraison_date')
            ->requirePresence('livraison_date', 'create')
            ->notEmpty('livraison_date');

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
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['parc_id'], 'Parcs'));

        return $rules;
    }
}
