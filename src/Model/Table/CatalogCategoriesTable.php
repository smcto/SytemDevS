<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CatalogCategories Model
 *
 * @method \App\Model\Entity\CatalogCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\CatalogCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CatalogCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CatalogCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogCategory findOrCreate($search, callable $callback = null, $options = [])
 * 
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CatalogCategoriesTable extends Table
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

        $this->setTable('catalog_categories');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->hasMany(
            'CatalogSousCategories', [
                'className' => 'CatalogSousCategories',
                'foreignKey' => 'catalog_categories_id',
            ]
        );
        
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
