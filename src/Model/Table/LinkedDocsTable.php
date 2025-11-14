<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LinkedDocs Model
 *
 * @property \App\Model\Table\OpportunitesTable|\Cake\ORM\Association\BelongsTo $Opportunites
 * @property \App\Model\Table\DevisTable|\Cake\ORM\Association\BelongsTo $Devis
 * @property \App\Model\Table\FacturesTable|\Cake\ORM\Association\BelongsTo $Factures
 *
 * @method \App\Model\Entity\LinkedDoc get($primaryKey, $options = [])
 * @method \App\Model\Entity\LinkedDoc newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LinkedDoc[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LinkedDoc|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LinkedDoc|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LinkedDoc patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LinkedDoc[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LinkedDoc findOrCreate($search, callable $callback = null, $options = [])
 */
class LinkedDocsTable extends Table
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

        $this->setTable('linked_docs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Opportunites', [
            'foreignKey' => 'opportunite_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Devis', [
            'foreignKey' => 'devi_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('DevisFactures', [
            'foreignKey' => 'facture_id',
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

        $validator
            ->scalar('context')
            ->maxLength('context', 250)
            ->allowEmpty('context');

        $validator
            ->scalar('doc_doctype')
            ->maxLength('doc_doctype', 250)
            ->allowEmpty('doc_doctype');

        $validator
            ->integer('doc_docid_in_sellsy')
            ->allowEmpty('doc_docid_in_sellsy');

        $validator
            ->scalar('doc_label')
            ->maxLength('doc_label', 250)
            ->allowEmpty('doc_label');

        $validator
            ->scalar('step_label')
            ->maxLength('step_label', 250)
            ->allowEmpty('step_label');

        $validator
            ->integer('linkedid_in_sellsy')
            ->allowEmpty('linkedid_in_sellsy');

        $validator
            ->scalar('ident_in_sellsy')
            ->maxLength('ident_in_sellsy', 250)
            ->allowEmpty('ident_in_sellsy');

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
        $rules->add($rules->existsIn(['opportunite_id'], 'Opportunites'));
        $rules->add($rules->existsIn(['devi_id'], 'Devis'));
        $rules->add($rules->existsIn(['facture_id'], 'DevisFactures'));

        return $rules;
    }
}
