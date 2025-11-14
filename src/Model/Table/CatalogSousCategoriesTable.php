<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CatalogSousCategories Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $CatalogCategories
 *
 * @method \App\Model\Entity\CatalogSousCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\CatalogSousCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CatalogSousCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CatalogSousCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogSousCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogSousCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogSousCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogSousCategory findOrCreate($search, callable $callback = null, $options = [])
 * 
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CatalogSousCategoriesTable extends Table
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

        $this->setTable('catalog_sous_categories');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');

        $this->belongsTo('CatalogCategories', [
            'foreignKey' => 'catalog_categories_id',
            'joinType' => 'INNER'
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
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        return $validator;
    }

    
    public function findFiltre(Query $query, array $options) {
        
        $catalog_categories_id = isset($options['catalog_categories_id'])?$options['catalog_categories_id']:null;
        if(!empty($catalog_categories_id)){
            $query->where(['CatalogCategories.id'=>$catalog_categories_id]);
        }

        return $query;
    }
    
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['catalog_categories_id'], 'CatalogCategories'));

        return $rules;
    }
}
