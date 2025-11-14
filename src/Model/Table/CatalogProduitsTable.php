<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CatalogProduits Model
 *
 * @property \App\Model\Table\CatalogSousCategoriesTable|\Cake\ORM\Association\BelongsTo $CatalogSousCategories
 *
 * @method \App\Model\Entity\CatalogProduit get($primaryKey, $options = [])
 * @method \App\Model\Entity\CatalogProduit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CatalogProduit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CatalogProduit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogProduit|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogProduit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogProduit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogProduit findOrCreate($search, callable $callback = null, $options = [])
 * 
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CatalogProduitsTable extends Table
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

        $this->setTable('catalog_produits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');

//        $this->belongsTo('CatalogSousCategories', [
//            'foreignKey' => 'catalog_sous_categories_id',
//            'joinType' => 'INNER'
//        ]);
//        
        $this->belongsTo('CatalogUnites', [
            'foreignKey' => 'catalog_unites_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->hasMany('CatalogProduitsFiles', [
            'foreignKey' => 'catalog_produits_id'
        ]);
        
        $this->hasMany('CatalogProduitsDocuments', [
            'className' => 'CatalogProduitsFiles',
            'foreignKey' => 'catalog_produits_id',
            'conditions' => ['CatalogProduitsDocuments.is_document' => 1]
        ]);
        
        $this->hasMany('CatalogProduitsPhotos', [
            'className' => 'CatalogProduitsFiles',
            'foreignKey' => 'catalog_produits_id',
            'conditions' => ['CatalogProduitsPhotos.is_document' => 0]
        ]);
        
        $this->hasMany('CatalogProduitsHasCategories', [
            'foreignKey' => 'catalog_produit_id'
        ]);
        
        $this->hasMany('DevisProduits', [
            'foreignKey' => 'catalog_produits_id'
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
            ->scalar('nom_commercial')
            ->maxLength('nom_commercial', 255)
            ->requirePresence('nom_commercial', 'create')
            ->notEmpty('nom_commercial');

        $validator
            ->scalar('nom_interne')
            ->maxLength('nom_interne', 255)
            ->requirePresence('nom_interne', 'create')
            ->notEmpty('nom_interne');

        $validator
            ->scalar('description_commercial')
            ->requirePresence('description_commercial', 'create')
            ->notEmpty('description_commercial');

        $validator
            ->scalar('prix_reference_ht')
            ->maxLength('prix_reference_ht', 20)
            ->requirePresence('prix_reference_ht', 'create')
            ->notEmpty('prix_reference_ht');

        $validator
            ->scalar('code_comptable')
            ->maxLength('code_comptable', 255)
            ->requirePresence('code_comptable', 'create')
            ->notEmpty('code_comptable');

        $validator
            ->scalar('reference')
            ->maxLength('reference', 255)
            ->requirePresence('reference', 'create')
            ->notEmpty('reference');

        return $validator;
    }

    public function findComplete(Query $query, array $options)
    {
        $query->contain(['CatalogProduitsHasCategories' => ['CatalogCategories', 'CatalogSousCategories'], 'CatalogProduitsDocuments', 'CatalogProduitsPhotos']);
        return $query;
    }
    
    public function findFiltre(Query $query, array $options) {
        
        $search = isset($options['key'])?trim($options['key']):null;
        if(!empty($search)){
            $query->where([
                'OR' => [
                    ['CatalogProduits.nom_commercial LIKE' => '%'.$search.'%'],
                    ['CatalogProduits.nom_interne LIKE' => '%'.$search.'%'],
//                    ['CatalogSousCategories.nom LIKE' => '%'.$search.'%'],
//                    ['CatalogCategories.nom LIKE' => '%'.$search.'%'],
                    ['CatalogProduits.mots_cles LIKE' => '%'.$search.'%'],
                    ['CatalogProduits.code_comptable LIKE' => '%'.$search.'%']
                ]
            ]);
        }
        
        $code_comptable = isset($options['code']) ? $options['code'] : null;
        if($code_comptable){
            $query->where(['CatalogProduits.code_comptable LIKE' => "%$code_comptable%"]);
        }


        $catalog_category_id = isset($options['catalog_category_id']) ? $options['catalog_category_id']:null;
        $catalog_sous_category_id = isset($options['catalog_sous_category_id']) ? $options['catalog_sous_category_id']:null;
        $catalog_sous_sous_category_id = isset($options['catalog_sous_sous_category_id']) ? $options['catalog_sous_sous_category_id']:null;


        $nom_commercial = isset($options['nom_commercial'])?$options['nom_commercial']:null;
        if(!empty($nom_commercial)){
            $query->where(['CatalogProduits.nom_commercial LIKE'=> '%'.$nom_commercial.'%']);
        }

        $pro_part = isset($options['pro_part'])?$options['pro_part']:null;
        if(!empty($pro_part)){
            $query->where(["CatalogProduits.$pro_part"=> true]);
        }

        if(!empty($catalog_category_id)){
            $query->matching('CatalogProduitsHasCategories', function ($q) use($catalog_category_id, $catalog_sous_category_id, $catalog_sous_sous_category_id)
            {
                $q->where(['CatalogProduitsHasCategories.catalog_category_id' => $catalog_category_id]);

                if (!is_null($catalog_sous_category_id) && !empty($catalog_sous_category_id)) {
                    $q->where(['CatalogProduitsHasCategories.catalog_sous_category_id' => $catalog_sous_category_id]);
                }

                if (!is_null($catalog_sous_sous_category_id) && !empty($catalog_sous_sous_category_id)) {
                    $q->where(['CatalogProduitsHasCategories.catalog_sous_sous_category_id' => $catalog_sous_sous_category_id]);
                }

                return $q;
            })->group('CatalogProduits.id');
        }


        return $query;
    }
    
    
    /**
     * beforeSave callback
     *
     * @param $options array
     * @return boolean
     */
    public function beforeSave($event, $entity, $options) {
                
        if($entity->catalog_produits_has_categories) {
            
            foreach ($entity->catalog_produits_has_categories as $category) {
                
                if ($category->catalog_sous_category_id == 16) {
                    $entity->set('is_consommable', 1);
                }
            }
        }
        
        return true;
    }
    
    
}
