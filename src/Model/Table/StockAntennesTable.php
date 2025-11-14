<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StockAntennes Model
 *
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\BelongsTo $Antennes
 *
 * @method \App\Model\Entity\StockAntenne get($primaryKey, $options = [])
 * @method \App\Model\Entity\StockAntenne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StockAntenne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StockAntenne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StockAntenne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StockAntenne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StockAntenne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StockAntenne findOrCreate($search, callable $callback = null, $options = [])
 */
class StockAntennesTable extends Table
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

        $this->setTable('stock_antennes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Antennes', [
            'foreignKey' => 'antenne_id'
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
            ->numeric('bobine_dnp')
            ->allowEmpty('bobine_dnp');

        $validator
            ->numeric('bobine_mitsu')
            ->allowEmpty('bobine_mitsu');

        $validator
            ->numeric('imprimante_dnp')
            ->allowEmpty('imprimante_dnp');

        $validator
            ->numeric('imprimante_mitsu')
            ->allowEmpty('imprimante_mitsu');

        $validator
            ->date('date_recensement')
            ->allowEmpty('date_recensement');

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
        $rules->add($rules->existsIn(['antenne_id'], 'Antennes'));

        return $rules;
    }
}
