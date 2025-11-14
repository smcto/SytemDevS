<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BonsLivraisonsProduits Model
 *
 * @property \App\Model\Table\BonsLivraisonsTable|\Cake\ORM\Association\BelongsTo $BonsLivraisons
 * @property \App\Model\Table\CatalogProduitsTable|\Cake\ORM\Association\BelongsTo $CatalogProduits
 *
 * @method \App\Model\Entity\BonsLivraisonsProduit get($primaryKey, $options = [])
 * @method \App\Model\Entity\BonsLivraisonsProduit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BonsLivraisonsProduit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BonsLivraisonsProduit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BonsLivraisonsProduit|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BonsLivraisonsProduit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BonsLivraisonsProduit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BonsLivraisonsProduit findOrCreate($search, callable $callback = null, $options = [])
 */
class BonsLivraisonsProduitsTable extends Table
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

        $this->setTable('bons_livraisons_produits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('BonsLivraisons', [
            'foreignKey' => 'bons_livraison_id',
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
            ->decimal('quantite_livree')
            ->allowEmpty('quantite_livree');

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
        $rules->add($rules->existsIn(['bons_livraison_id'], 'BonsLivraisons'));
        $rules->add($rules->existsIn(['catalog_produits_id'], 'CatalogProduits'));

        return $rules;
    }
}
