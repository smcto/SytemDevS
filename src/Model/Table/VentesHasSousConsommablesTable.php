<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VentesBelongsConsommables Model
 *
 * @property \App\Model\Table\VentesConsomablesTable|\Cake\ORM\Association\BelongsTo $VentesConsomables
 * @property \App\Model\Table\TypeConsommablesTable|\Cake\ORM\Association\BelongsTo $TypeConsommables
 *
 * @method \App\Model\Entity\VentesBelongsConsommable get($primaryKey, $options = [])
 * @method \App\Model\Entity\VentesBelongsConsommable newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VentesBelongsConsommable[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VentesBelongsConsommable|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentesBelongsConsommable|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentesBelongsConsommable patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VentesBelongsConsommable[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VentesBelongsConsommable findOrCreate($search, callable $callback = null, $options = [])
 */
class VentesHasSousConsommablesTable extends Table
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

        $this->setTable('ventes_has_sous_consommables');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('VentesConsommables', [
            'foreignKey' => 'ventes_consommable_id',
        ]);
        
        $this->belongsTo('VenteConsommables', [
            'joinTable' => 'ventes_consommable', 
            'joinType' => 'INNER',
            'bindingKey' => 'id',
            'foreignKey' => 'ventes_consommable_id',
            'className' => 'VentesConsommables'
        ]);
        
        $this->belongsTo('TypeConsommables', [
            'foreignKey' => 'type_consommable_id',
        ]);
        
        $this->belongsTo('SousTypesConsommables', [
            'foreignKey' => 'sous_types_consommable_id',
        ]);

        $this->hasMany(
            'LivraisonsVentesSousConsommables', [
                'className' => 'LivraisonsVentesSousConsommables',
                'foreignKey' => 'ventes_has_sous_consommable_id',
            ]
        );
    }

    public function findCountByTypeConsommables(Query $query, array $options)
    {
        $query
            ->select(['nb' => $query->func()->sum('VentesHasSousConsommables.qty'), 'name' => 'TypeConsommables.name'])
            ->contain(['TypeConsommables','VenteConsommables'])
            ->group(['VentesHasSousConsommables.type_consommable_id'])
            ->enableAutoFields(true)
        ;
        return $query;
    }
    
    public function findFiltre(Query $query, array $options) {
        
        if(isset($options['mensuel']) && !empty($options['mensuel'])){
            $query->where(["DATE_FORMAT(VenteConsommables.created, '%m-%Y') LIKE" => $options['mensuel']]);
        }
        if(isset($options['annuel']) && !empty($options['annuel'])){
            $query->where(["DATE_FORMAT(VenteConsommables.created, '%Y') LIKE" => $options['annuel']]);
        }
        if(isset($options['dateDebut']) && !empty($options['dateDebut']) && isset($options['dateFin']) && !empty($options['dateFin'])){
            $query->where(["VenteConsommables.created >=" => $options['dateDebut'], "VenteConsommables.created <=" => $options['dateFin']]);
        }
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
            ->integer('qty')
            ->allowEmpty('qty');

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
        $rules->add($rules->existsIn(['ventes_consommable_id'], 'VentesConsommables'));
        $rules->add($rules->existsIn(['sous_types_consommable_id'], 'SousTypesConsommables'));

        return $rules;
    }
}
