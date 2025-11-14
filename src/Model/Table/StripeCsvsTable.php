<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StripeCsvs Model
 *
 * @property \App\Model\Table\StripeExcelsTable|\Cake\ORM\Association\HasMany $StripeExcels
 *
 * @method \App\Model\Entity\StripeCsv get($primaryKey, $options = [])
 * @method \App\Model\Entity\StripeCsv newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StripeCsv[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StripeCsv|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StripeCsv|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StripeCsv patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StripeCsv[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StripeCsv findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StripeCsvsTable extends Table
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

        $this->setTable('stripe_csvs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('StripeExcels', [
            'foreignKey' => 'stripe_csv_id'
        ]);

        $this->belongsTo('StripeCsvFiles', [
            'foreignKey' => 'stripe_csv_file_id'
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
            ->scalar('id_stripe')
            ->maxLength('id_stripe', 255)
            ->allowEmpty('id_stripe');

        $validator
            ->dateTime('date_import')
            ->allowEmpty('date_import');

        $validator
            ->integer('description')
            ->allowEmpty('description');

        $validator
            ->scalar('seller_message')
            ->maxLength('seller_message', 255)
            ->allowEmpty('seller_message');

        $validator
            ->numeric('amount')
            ->allowEmpty('amount');

        $validator
            ->numeric('amount_refunded')
            ->allowEmpty('amount_refunded');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 255)
            ->allowEmpty('currency');

        $validator
            ->numeric('converted_amount')
            ->allowEmpty('converted_amount');

        $validator
            ->numeric('converted_amount_refunded')
            ->allowEmpty('converted_amount_refunded');

        $validator
            ->integer('fee')
            ->allowEmpty('fee');

        $validator
            ->integer('tax')
            ->allowEmpty('tax');

        $validator
            ->scalar('converted_currency')
            ->maxLength('converted_currency', 255)
            ->allowEmpty('converted_currency');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->allowEmpty('status');

        $validator
            ->scalar('statement_descriptor')
            ->maxLength('statement_descriptor', 255)
            ->allowEmpty('statement_descriptor');

        $validator
            ->integer('customerId')
            ->allowEmpty('customerId');

        $validator
            ->scalar('customer_description')
            ->maxLength('customer_description', 255)
            ->allowEmpty('customer_description');

        $validator
            ->scalar('customer_email')
            ->maxLength('customer_email', 255)
            ->allowEmpty('customer_email');

        $validator
            ->scalar('captured')
            ->maxLength('captured', 255)
            ->allowEmpty('captured');

        $validator
            ->scalar('cardId')
            ->maxLength('cardId', 255)
            ->allowEmpty('cardId');

        $validator
            ->scalar('invoiceId')
            ->maxLength('invoiceId', 255)
            ->allowEmpty('invoiceId');

        $validator
            ->scalar('transfert')
            ->maxLength('transfert', 255)
            ->allowEmpty('transfert');

        return $validator;
    }
}
