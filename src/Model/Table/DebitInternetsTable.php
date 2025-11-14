<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DebitInternets Model
 *
 * @method \App\Model\Entity\DebitInternet get($primaryKey, $options = [])
 * @method \App\Model\Entity\DebitInternet newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DebitInternet[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DebitInternet|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DebitInternet|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DebitInternet patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DebitInternet[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DebitInternet findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DebitInternetsTable extends Table
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

        $this->setTable('debit_internets');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Antennes', [
            'foreignKey' => 'debit_internet_id'
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
            ->scalar('valeur')
            ->maxLength('valeur', 25)
            ->requirePresence('valeur', 'create')
            ->notEmpty('valeur');

        $validator
            ->scalar('information')
            ->maxLength('information', 255)
            ->requirePresence('information', 'create')
            ->notEmpty('information');

        return $validator;
    }
}
