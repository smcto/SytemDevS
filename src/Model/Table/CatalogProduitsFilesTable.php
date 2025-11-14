<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CatalogProduitsFiles Model
 *
 * @property \App\Model\Table\CatalogProduitsTable|\Cake\ORM\Association\BelongsTo $CatalogProduits
 *
 * @method \App\Model\Entity\CatalogProduitsFile get($primaryKey, $options = [])
 * @method \App\Model\Entity\CatalogProduitsFile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CatalogProduitsFile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CatalogProduitsFile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogProduitsFile|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CatalogProduitsFile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogProduitsFile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CatalogProduitsFile findOrCreate($search, callable $callback = null, $options = [])
 * 
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CatalogProduitsFilesTable extends Table
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

        $this->setTable('catalog_produits_files');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        
        $this->belongsTo('CatalogProduits', [
            'foreignKey' => 'catalog_produits_id',
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
            ->scalar('nom_fichier')
            ->maxLength('nom_fichier', 255)
            ->requirePresence('nom_fichier', 'create')
            ->notEmpty('nom_fichier');

        $validator
            ->scalar('chemin')
            ->maxLength('chemin', 255)
            ->requirePresence('chemin', 'create')
            ->notEmpty('chemin');

        $validator
            ->scalar('nom_origine')
            ->maxLength('nom_origine', 255)
            ->allowEmpty('nom_origine');

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
        $rules->add($rules->existsIn(['catalog_produits_id'], 'CatalogProduits'));

        return $rules;
    }
}
