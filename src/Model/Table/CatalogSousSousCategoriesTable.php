<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CatalogSousSousCategories Model
 *
 * @property \App\Model\Table\CatalogSousCategoriesTable|\Cake\ORM\Association\BelongsTo $CatalogSousCategories
 *
 * @method \App\Model\Entity\CatalogSousSousCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\CatalogSousSousCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CatalogSousSousCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CatalogSousSousCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogSousSousCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogSousSousCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogSousSousCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogSousSousCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CatalogSousSousCategoriesTable extends Table
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

        $this->setTable('catalog_sous_sous_categories');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CatalogSousCategories', [
            'foreignKey' => 'catalog_sous_category_id',
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

    public function findFiltre(Query $query, array $options) 
    {
        $nom = $options['nom'] ?? null;
        $catalog_category_id = $options['catalog_category_id'] ?? null;
        $catalog_sous_category_id = $options['catalog_sous_category_id'] ?? null;

        if($nom){
            $query->where(['CatalogSousSousCategories.nom like' => "%$nom%"]);
        }

        if($catalog_category_id){
            $query->where(['CatalogSousSousCategories.catalog_category_id' => $catalog_category_id]);
        }

        if($catalog_sous_category_id){
            $query->where(['CatalogSousSousCategories.catalog_sous_category_id' => $catalog_sous_category_id]);
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
// //         $rules->add($rules->existsIn(['catalog_sous_category_id'], 'CatalogSousCategories'));
// 
        return $rules;
    }
}
