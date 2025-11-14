<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DevisFacturesProduits Model
 *
 * @property \App\Model\Table\CatalogUnitesTable|\Cake\ORM\Association\BelongsTo $CatalogUnites
 * @property \App\Model\Table\DevisFacturesTable|\Cake\ORM\Association\BelongsTo $DevisFactures
 * @property \App\Model\Table\CatalogProduitsTable|\Cake\ORM\Association\BelongsTo $CatalogProduits
 *
 * @method \App\Model\Entity\DevisFacturesProduit get($primaryKey, $options = [])
 * @method \App\Model\Entity\DevisFacturesProduit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DevisFacturesProduit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DevisFacturesProduit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisFacturesProduit|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisFacturesProduit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DevisFacturesProduit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DevisFacturesProduit findOrCreate($search, callable $callback = null, $options = [])
 */
class DevisFacturesProduitsTable extends Table
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

        $this->setTable('devis_factures_produits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CatalogUnites', [
            'foreignKey' => 'catalog_unites_id'
        ]);
        $this->belongsTo('DevisFactures', [
            'foreignKey' => 'invoice_id'
        ]);
        $this->belongsTo('CatalogProduits', [
            'foreignKey' => 'catalog_produit_id'
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
            ->integer('titre')
            ->allowEmpty('titre');

        $validator
            ->scalar('reference')
            ->maxLength('reference', 255)
            ->allowEmpty('reference');

        $validator
            ->decimal('quantite_usuelle')
            ->allowEmpty('quantite_usuelle');

        $validator
            ->decimal('prix_reference_ht')
            ->allowEmpty('prix_reference_ht');

        $validator
            ->decimal('remise_value')
            ->allowEmpty('remise_value');

        $validator
            ->scalar('remise_unity')
            ->allowEmpty('remise_unity');

        $validator
            ->scalar('nom_interne')
            ->allowEmpty('nom_interne');

        $validator
            ->scalar('nom_commercial')
            ->maxLength('nom_commercial', 11)
            ->allowEmpty('nom_commercial');

        $validator
            ->scalar('description_commercial')
            ->allowEmpty('description_commercial');

        $validator
            ->scalar('commentaire_ligne')
            ->allowEmpty('commentaire_ligne');

        $validator
            ->scalar('titre_ligne')
            ->allowEmpty('titre_ligne');

        $validator
            ->decimal('sous_total')
            ->allowEmpty('sous_total');

        $validator
            ->scalar('type_ligne')
            ->requirePresence('type_ligne', 'create')
            ->notEmpty('type_ligne');

        $validator
            ->integer('i_position')
            ->requirePresence('i_position', 'create')
            ->notEmpty('i_position');

        $validator
            ->allowEmpty('line_option');

        $validator
            ->decimal('tva')
            ->allowEmpty('tva');

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
        $rules->add($rules->existsIn(['catalog_unites_id'], 'CatalogUnites'));
        $rules->add($rules->existsIn(['invoice_id'], 'DevisFactures'));
        $rules->add($rules->existsIn(['catalog_produit_id'], 'CatalogProduits'));

        return $rules;
    }
}
