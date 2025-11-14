<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Countrys Model
 *
 * @method \App\Model\Entity\Country get($primaryKey, $options = [])
 * @method \App\Model\Entity\Country newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Country[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Country|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Country|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Country patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Country[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Country findOrCreate($search, callable $callback = null, $options = [])
 */
class CountrysTable extends Table
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

        $this->setTable('countrys');
        $this->setDisplayField('name');
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
            ->scalar('iso')
            ->maxLength('iso', 2)
            ->requirePresence('iso', 'create')
            ->notEmpty('iso');

        $validator
            ->scalar('name')
            ->maxLength('name', 80)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('nicename')
            ->maxLength('nicename', 80)
            ->requirePresence('nicename', 'create')
            ->notEmpty('nicename');

        $validator
            ->scalar('iso3')
            ->maxLength('iso3', 3)
            ->allowEmpty('iso3');

        $validator
            ->allowEmpty('numcode');

        $validator
            ->integer('phonecode')
            ->requirePresence('phonecode', 'create')
            ->notEmpty('phonecode');

        $validator
            ->scalar('name_fr')
            ->maxLength('name_fr', 80)
            ->requirePresence('name_fr', 'create')
            ->notEmpty('name_fr');

        return $validator;
    }
}
