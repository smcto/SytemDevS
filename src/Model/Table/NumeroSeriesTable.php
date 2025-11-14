<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NumeroSeries Model
 *
 * @property \App\Model\Table\LotProduitsTable|\Cake\ORM\Association\BelongsTo $LotProduits
 * @property \App\Model\Table\BornesTable|\Cake\ORM\Association\BelongsTo $Bornes
 *
 * @method \App\Model\Entity\NumeroSeries get($primaryKey, $options = [])
 * @method \App\Model\Entity\NumeroSeries newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NumeroSeries[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NumeroSeries|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NumeroSeries|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NumeroSeries patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NumeroSeries[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NumeroSeries findOrCreate($search, callable $callback = null, $options = [])
 */
class NumeroSeriesTable extends Table
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

        $this->setTable('numero_series');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('LotProduits', [
            'foreignKey' => 'lot_produit_id'
        ]);
        $this->belongsTo('Equipements', [
            'foreignKey' => 'equipement_id'
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
            ->scalar('serial_nb')
            ->maxLength('serial_nb', 255)
            ->allowEmpty('serial_nb');

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
        $rules->add($rules->existsIn(['lot_produit_id'], 'LotProduits'));

        return $rules;
    }
}
