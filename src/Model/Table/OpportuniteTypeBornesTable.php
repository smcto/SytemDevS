<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OpportuniteTypeBornes Model
 *
 * @method \App\Model\Entity\OpportuniteTypeBorne get($primaryKey, $options = [])
 * @method \App\Model\Entity\OpportuniteTypeBorne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OpportuniteTypeBorne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteTypeBorne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpportuniteTypeBorne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpportuniteTypeBorne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteTypeBorne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteTypeBorne findOrCreate($search, callable $callback = null, $options = [])
 */
class OpportuniteTypeBornesTable extends Table
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

        $this->setTable('opportunite_type_bornes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('nom')
            ->maxLength('nom', 250)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        return $validator;
    }
}
