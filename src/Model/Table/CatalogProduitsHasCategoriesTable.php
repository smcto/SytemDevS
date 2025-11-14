<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CatalogProduitsHasCategories Model
 *
 * @property \App\Model\Table\CatalogProduitsTable|\Cake\ORM\Association\BelongsTo $CatalogProduits
 * @property \App\Model\Table\CatalogCategoriesTable|\Cake\ORM\Association\BelongsTo $CatalogCategories
 * @property \App\Model\Table\CatalogSousCategoriesTable|\Cake\ORM\Association\BelongsTo $CatalogSousCategories
 *
 * @method \App\Model\Entity\CatalogProduitsHasCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\CatalogProduitsHasCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CatalogProduitsHasCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CatalogProduitsHasCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogProduitsHasCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogProduitsHasCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogProduitsHasCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogProduitsHasCategory findOrCreate($search, callable $callback = null, $options = [])
 */
class CatalogProduitsHasCategoriesTable extends Table
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

        $this->setTable('catalog_produits_has_categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CatalogProduits', [
            'foreignKey' => 'catalog_produit_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CatalogCategories', [
            'foreignKey' => 'catalog_category_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CatalogSousCategories', [
            'foreignKey' => 'catalog_sous_category_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CatalogSousSousCategories', [
            'foreignKey' => 'catalog_sous_sous_category_id',
            'joinType' => 'LEFT'
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

        return $validator;
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
        $rules->add($rules->existsIn(['catalog_produit_id'], 'CatalogProduits'));
        $rules->add($rules->existsIn(['catalog_category_id'], 'CatalogCategories'));
        $rules->add($rules->existsIn(['catalog_sous_category_id'], 'CatalogSousCategories'));

        return $rules;
    }
}
