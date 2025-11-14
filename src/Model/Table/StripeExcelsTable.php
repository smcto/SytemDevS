<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StripeExcels Model
 *
 * @property \App\Model\Table\StripeCsvsTable|\Cake\ORM\Association\BelongsTo $StripeCsvs
 *
 * @method \App\Model\Entity\StripeExcel get($primaryKey, $options = [])
 * @method \App\Model\Entity\StripeExcel newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StripeExcel[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StripeExcel|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StripeExcel|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StripeExcel patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StripeExcel[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StripeExcel findOrCreate($search, callable $callback = null, $options = [])
 */
class StripeExcelsTable extends Table
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

        $this->setTable('stripe_excels');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('StripeCsvs', [
            'foreignKey' => 'stripe_csv_id'
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
            ->date('date')
            ->allowEmpty('date');

        $validator
            ->scalar('piece')
            ->maxLength('piece', 255)
            ->allowEmpty('piece');

        $validator
            ->scalar('compte')
            ->maxLength('compte', 255)
            ->allowEmpty('compte');

        $validator
            ->scalar('libelle')
            ->maxLength('libelle', 255)
            ->allowEmpty('libelle');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmpty('description');

        $validator
            ->numeric('debit')
            ->allowEmpty('debit');

        $validator
            ->numeric('credit')
            ->allowEmpty('credit');

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
        $rules->add($rules->existsIn(['stripe_csv_id'], 'StripeCsvs'));

        return $rules;
    }
}
