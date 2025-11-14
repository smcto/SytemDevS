<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SecteursActivites Model
 *
 * @method \App\Model\Entity\SecteursActivite get($primaryKey, $options = [])
 * @method \App\Model\Entity\SecteursActivite newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SecteursActivite[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SecteursActivite|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SecteursActivite|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SecteursActivite patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SecteursActivite[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SecteursActivite findOrCreate($search, callable $callback = null, $options = [])
 */
class SecteursActivitesTable extends Table
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

        $this->setTable('secteurs_activites');
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

        return $validator;
    }
}
