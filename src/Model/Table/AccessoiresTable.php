<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Accessoires Model
 *
 * @property \App\Model\Table\AccessoiresGammesTable|\Cake\ORM\Association\HasMany $AccessoiresGammes
 *
 * @method \App\Model\Entity\Accessoire get($primaryKey, $options = [])
 * @method \App\Model\Entity\Accessoire newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Accessoire[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Accessoire|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Accessoire|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Accessoire patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Accessoire[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Accessoire findOrCreate($search, callable $callback = null, $options = [])
 */
class AccessoiresTable extends Table
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

        $this->setTable('accessoires');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        
        
        $this->hasMany('SousAccessoires', [
            'foreignKey' => 'accessoire_id'
        ]);
    }

    public function findByGamme(Query $query, array $options)
    {
        $query
        ->contain(['AccessoiresGammes'])
        ->matching('AccessoiresGammes');
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
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        return $validator;
    }
}
