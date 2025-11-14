<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SousTypesConsommables Model
 *
 * @property \App\Model\Table\TypeConsommablesTable|\Cake\ORM\Association\BelongsTo $TypeConsommables
 *
 * @method \App\Model\Entity\SousTypesConsommable get($primaryKey, $options = [])
 * @method \App\Model\Entity\SousTypesConsommable newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SousTypesConsommable[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SousTypesConsommable|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SousTypesConsommable|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SousTypesConsommable patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SousTypesConsommable[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SousTypesConsommable findOrCreate($search, callable $callback = null, $options = [])
 */
class SousTypesConsommablesTable extends Table
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

        $this->setTable('sous_types_consommables');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

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
        $rules->add($rules->existsIn(['type_consommable_id'], 'TypeConsommables'));

        return $rules;
    }
}
