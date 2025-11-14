<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypeConsommables Model
 *
 * @method \App\Model\Entity\TypeConsommable get($primaryKey, $options = [])
 * @method \App\Model\Entity\TypeConsommable newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TypeConsommable[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypeConsommable|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeConsommable|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeConsommable patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TypeConsommable[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypeConsommable findOrCreate($search, callable $callback = null, $options = [])
 */
class TypeConsommablesTable extends Table
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

        $this->setTable('type_consommables');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany(
            'SousTypesConsommables', [
                'foreignKey' => 'type_consommable_id',
                'dependent' => true,
                'cascadeCallbacks' => true,
            ]
        );
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
}
