<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DevisProduits Model
 *
 * @method \App\Model\Entity\DevisProduit get($primaryKey, $options = [])
 * @method \App\Model\Entity\DevisProduit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DevisProduit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DevisProduit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisProduit|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisProduit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DevisProduit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DevisProduit findOrCreate($search, callable $callback = null, $options = [])
 */
class DevisProduitsTable extends Table
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

        $this->setTable('devis_produits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo(
            'CatalogProduits', [
                'foreignKey' => 'catalog_produits_id'
            ]
        );
        
        $this->belongsTo('CatalogUnites', [
            'foreignKey' => 'catalog_unites_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('UnitesInternes', [
            'foreignKey' => 'unites_interne_id',
            'class' => 'CatalogUnites'
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
            ->scalar('nom_interne')
            ->allowEmpty('nom_interne');

        $validator
            ->scalar('nom_commercial')
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
            ->boolean('saut_ligne')
            ->allowEmpty('saut_ligne');

        $validator
            ->decimal('sous_total')
            ->allowEmpty('sous_total');

        $validator
            ->boolean('saut_page')
            ->allowEmpty('saut_page');

        return $validator;
    }
}
