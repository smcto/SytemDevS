<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Adresses Model
 *
 * @method \App\Model\Entity\Adress get($primaryKey, $options = [])
 * @method \App\Model\Entity\Adress newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Adress[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Adress|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Adress|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Adress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Adress[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Adress findOrCreate($search, callable $callback = null, $options = [])
 */
class AdressesTable extends Table
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

        $this->setTable('adresses');
        $this->setDisplayField('adresse');
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
            ->scalar('adresse')
            ->maxLength('adresse', 255)
            ->allowEmpty('adresse');

        $validator
            ->scalar('cp')
            ->maxLength('cp', 255)
            ->allowEmpty('cp');

        $validator
            ->scalar('ville')
            ->maxLength('ville', 255)
            ->allowEmpty('ville');

        $validator
            ->scalar('pays')
            ->maxLength('pays', 255)
            ->requirePresence('pays', 'create')
            ->notEmpty('pays');

        return $validator;
    }
}
