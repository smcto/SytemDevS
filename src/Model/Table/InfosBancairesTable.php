<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InfosBancaires Model
 *
 * @method \App\Model\Entity\InfosBancaire get($primaryKey, $options = [])
 * @method \App\Model\Entity\InfosBancaire newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InfosBancaire[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InfosBancaire|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InfosBancaire|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InfosBancaire patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InfosBancaire[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InfosBancaire findOrCreate($search, callable $callback = null, $options = [])
 */
class InfosBancairesTable extends Table
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

        $this->setTable('infos_bancaires');
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('adress')
            ->maxLength('adress', 255)
            ->requirePresence('adress', 'create')
            ->notEmpty('adress');

        $validator
            ->scalar('bic')
            ->maxLength('bic', 255)
            ->requirePresence('bic', 'create')
            ->notEmpty('bic');

        $validator
            ->scalar('iban')
            ->maxLength('iban', 255)
            ->requirePresence('iban', 'create')
            ->notEmpty('iban');

        return $validator;
    }
}
