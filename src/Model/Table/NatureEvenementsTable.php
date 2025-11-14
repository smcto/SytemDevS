<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NatureEvenements Model
 *
 * @method \App\Model\Entity\NatureEvenement get($primaryKey, $options = [])
 * @method \App\Model\Entity\NatureEvenement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NatureEvenement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NatureEvenement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NatureEvenement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NatureEvenement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NatureEvenement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NatureEvenement findOrCreate($search, callable $callback = null, $options = [])
 */
class NatureEvenementsTable extends Table
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

        $this->setTable('nature_evenements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Evenements', [
            'foreignKey' => 'nature_evenement_id'
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
            ->scalar('type')
            ->maxLength('type', 20)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->scalar('options')
            ->maxLength('options', 255)
            ->requirePresence('options', 'create')
            ->notEmpty('options');

        return $validator;
    }
}
