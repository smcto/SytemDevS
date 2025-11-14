<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FactureDeductions Model
 *
 * @method \App\Model\Entity\FactureDeduction get($primaryKey, $options = [])
 * @method \App\Model\Entity\FactureDeduction newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FactureDeduction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FactureDeduction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FactureDeduction|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FactureDeduction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FactureDeduction[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FactureDeduction findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FactureDeductionsTable extends Table
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

        $this->setTable('facture_deductions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->decimal('ca_ht_deduire')
            ->allowEmpty('ca_ht_deduire');

        $validator
            ->decimal('avoir_ht_deduire')
            ->allowEmpty('avoir_ht_deduire');

        $validator
            ->decimal('pca_part')
            ->allowEmpty('pca_part');

        $validator
            ->decimal('pca_pro')
            ->allowEmpty('pca_pro');

        $validator
            ->integer('annee')
            ->allowEmpty('annee');

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['annee']));

        return $rules;
    }
}
