<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BonsCommandesProduits Model
 *
 * @property \App\Model\Table\BonsCommandesTable|\Cake\ORM\Association\BelongsTo $BonsCommandes
 * @property |\Cake\ORM\Association\BelongsTo $CatalogProduits
 *
 * @method \App\Model\Entity\BonsCommandesProduit get($primaryKey, $options = [])
 * @method \App\Model\Entity\BonsCommandesProduit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BonsCommandesProduit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BonsCommandesProduit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BonsCommandesProduit|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BonsCommandesProduit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BonsCommandesProduit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BonsCommandesProduit findOrCreate($search, callable $callback = null, $options = [])
 */
class BonsCommandesProduitsTable extends Table
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

        $this->setTable('bons_commandes_produits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('BonsCommandes', [
            'foreignKey' => 'bons_commande_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CatalogProduits', [
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
            ->scalar('reference')
            ->maxLength('reference', 255)
            ->allowEmpty('reference');

        $validator
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->allowEmpty('nom');

        $validator
            ->decimal('quantite')
            ->allowEmpty('quantite');

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
        $rules->add($rules->existsIn(['bons_commande_id'], 'BonsCommandes'));
        $rules->add($rules->existsIn(['catalog_produits_id'], 'CatalogProduits'));

        return $rules;
    }
}
