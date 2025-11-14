<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tvas Model
 *
 * @method \App\Model\Entity\Tva get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tva newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tva[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tva|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tva|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tva patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tva[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tva findOrCreate($search, callable $callback = null, $options = [])
 */
class TvasTable extends Table
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

        $this->setTable('tvas');
        $this->setDisplayField('valeur');
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
            ->integer('valeur')
            ->requirePresence('valeur', 'create')
            ->notEmpty('valeur');

        return $validator;
    }
}
