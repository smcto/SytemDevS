<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BonsPreparationsProduits Model
 *
 * @property \App\Model\Table\BonsPreparationsTable|\Cake\ORM\Association\BelongsTo $BonsPreparations
 * @property \App\Model\Table\CatalogProduitsTable|\Cake\ORM\Association\BelongsTo $CatalogProduits
 *
 * @method \App\Model\Entity\BonsPreparationsProduit get($primaryKey, $options = [])
 * @method \App\Model\Entity\BonsPreparationsProduit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BonsPreparationsProduit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BonsPreparationsProduit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BonsPreparationsProduit|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BonsPreparationsProduit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BonsPreparationsProduit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BonsPreparationsProduit findOrCreate($search, callable $callback = null, $options = [])
 */
class BonsPreparationsProduitsTable extends Table
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

        $this->setTable('bons_preparations_produits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('BonsPreparations', [
            'foreignKey' => 'bons_preparation_id',
            'joinType' => 'INNER'
        ]);
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
            ->scalar('reference')
            ->maxLength('reference', 255)
            ->allowEmpty('reference');

        $validator
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->allowEmpty('nom');

        $validator
            ->scalar('description_commercial')
            ->allowEmpty('description_commercial');

        $validator
            ->decimal('quantite')
            ->requirePresence('quantite', 'create')
            ->notEmpty('quantite');

        $validator
            ->decimal('quantite_livree')
            ->allowEmpty('quantite_livree');

        $validator
            ->decimal('rest')
            ->allowEmpty('rest');

        $validator
            ->scalar('observation')
            ->allowEmpty('observation');

        $validator
            ->scalar('statut')
            ->allowEmpty('statut');

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
        $rules->add($rules->existsIn(['bons_preparation_id'], 'BonsPreparations'));
        $rules->add($rules->existsIn(['catalog_produits_id'], 'CatalogProduits'));

        return $rules;
    }
}
