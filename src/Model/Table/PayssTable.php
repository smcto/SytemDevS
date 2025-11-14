<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payss Model
 *
 * @method \App\Model\Entity\Pays get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pays newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pays[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pays|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pays|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pays patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pays[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pays findOrCreate($search, callable $callback = null, $options = [])
 */
class PayssTable extends Table
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

        $this->setTable('payss');
        $this->setDisplayField('name_fr');
        $this->setPrimaryKey('id');

        $this->hasMany('Users', [
            'foreignKey' => 'pays_id'
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
            ->allowEmpty('numcode')
            ;

        $validator
            ->scalar('name_fr')
            ->maxLength('name_fr', 80)
            ->allowEmpty('numcode')
            ;

        return $validator;
    }

    public function findListAsc(Query $query, array $options)
    {
        $query->find('list')->where(['name_fr >' => 0])->order(['name_fr' => 'ASC']);
        return $query;
    }
}
