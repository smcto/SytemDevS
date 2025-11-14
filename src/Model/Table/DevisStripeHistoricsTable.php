<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DevisStripeHistorics Model
 *
 * @property \App\Model\Table\PaymentsTable|\Cake\ORM\Association\BelongsTo $Payments
 * @property \App\Model\Table\TransactionsTable|\Cake\ORM\Association\BelongsTo $Transactions
 * @property \App\Model\Table\DevisTable|\Cake\ORM\Association\BelongsTo $Devis
 * @property \App\Model\Table\DevisEcheancesTable|\Cake\ORM\Association\BelongsTo $DevisEcheances
 *
 * @method \App\Model\Entity\DevisStripeHistoric get($primaryKey, $options = [])
 * @method \App\Model\Entity\DevisStripeHistoric newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DevisStripeHistoric[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DevisStripeHistoric|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisStripeHistoric|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisStripeHistoric patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DevisStripeHistoric[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DevisStripeHistoric findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DevisStripeHistoricsTable extends Table
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

        $this->setTable('devis_stripe_historics');
        $this->setDisplayField('amount');
        $this->setPrimaryKey('id');

        $this->belongsTo('Devis', [
            'foreignKey' => 'devis_id'
        ]);
        $this->belongsTo('DevisEcheances', [
            'foreignKey' => 'devis_echeance_id'
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
            ->scalar('object')
            ->maxLength('object', 30)
            ->allowEmpty('object');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->integer('amount')
            ->allowEmpty('amount');

        $validator
            ->scalar('failure_message')
            ->allowEmpty('failure_message');

        $validator
            ->scalar('payment_method')
            ->maxLength('payment_method', 255)
            ->allowEmpty('payment_method');

        $validator
            ->scalar('receipt_email')
            ->maxLength('receipt_email', 150)
            ->allowEmpty('receipt_email');

        $validator
            ->scalar('receipt_url')
            ->maxLength('receipt_url', 350)
            ->allowEmpty('receipt_url');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['devis_id'], 'Devis'));
        return $rules;
    }
}
