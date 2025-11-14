<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VentesSousConsommables Model
 *
 * @property \App\Model\Table\VentesTable|\Cake\ORM\Association\BelongsTo $Ventes
 * @property \App\Model\Table\SousTypesConsommablesTable|\Cake\ORM\Association\BelongsTo $SousTypesConsommables
 * @property \App\Model\Table\TypeConsommablesTable|\Cake\ORM\Association\BelongsTo $TypeConsommables
 *
 * @method \App\Model\Entity\VentesSousConsommable get($primaryKey, $options = [])
 * @method \App\Model\Entity\VentesSousConsommable newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VentesSousConsommable[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VentesSousConsommable|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentesSousConsommable|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentesSousConsommable patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VentesSousConsommable[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VentesSousConsommable findOrCreate($search, callable $callback = null, $options = [])
 */
class VentesSousConsommablesTable extends Table
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

        $this->setTable('ventes_sous_consommables');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Ventes', [
            'foreignKey' => 'vente_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SousTypesConsommables', [
            'foreignKey' => 'sous_types_consommable_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TypeConsommables', [
            'foreignKey' => 'type_consommable_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['vente_id'], 'Ventes'));
        $rules->add($rules->existsIn(['sous_types_consommable_id'], 'SousTypesConsommables'));
        $rules->add($rules->existsIn(['type_consommable_id'], 'TypeConsommables'));

        return $rules;
    }
}
