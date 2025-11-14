<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CategorieActus Model
 *
 * @method \App\Model\Entity\CategorieActus get($primaryKey, $options = [])
 * @method \App\Model\Entity\CategorieActus newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CategorieActus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CategorieActus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CategorieActus|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CategorieActus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CategorieActus[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CategorieActus findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CategorieActusTable extends Table
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

        $this->setTable('categorie_actus');
        $this->setDisplayField('titre');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ActuBornes', [
            'foreignKey' => 'categorie_actus_id'
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
            ->scalar('titre')
            ->maxLength('titre', 225)
            ->requirePresence('titre', 'create')
            ->notEmpty('titre');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        return $validator;
    }
}
