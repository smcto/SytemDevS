<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CatalogUnites Model
 *
 * @method \App\Model\Entity\CatalogUnites get($primaryKey, $options = [])
 * @method \App\Model\Entity\CatalogUnites newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CatalogUnites[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CatalogUnites|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogUnites|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogUnites patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogUnites[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogUnites findOrCreate($search, callable $callback = null, $options = [])
 * 
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CatalogUnitesTable extends Table
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

        $this->setTable('catalog_unites');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
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
