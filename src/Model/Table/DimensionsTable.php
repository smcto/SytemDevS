<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Dimensions Model
 *
 * @property \App\Model\Table\ModelBornesTable|\Cake\ORM\Association\BelongsTo $ModelBornes
 * @property \App\Model\Table\PartiesTable|\Cake\ORM\Association\BelongsTo $Parties
 *
 * @method \App\Model\Entity\Dimension get($primaryKey, $options = [])
 * @method \App\Model\Entity\Dimension newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Dimension[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Dimension|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Dimension|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Dimension patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Dimension[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Dimension findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DimensionsTable extends Table
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

        $this->setTable('dimensions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ModelBornes', [
            'foreignKey' => 'model_borne_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Parties', [
            'foreignKey' => 'partie_id',
            'joinType' => 'INNER'
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
            ->scalar('dimension')
            ->maxLength('dimension', 250)
            ->allowEmpty('dimension');

        $validator
            ->scalar('poids')
            ->maxLength('poids', 250)
            ->allowEmpty('poids');

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
        $rules->add($rules->existsIn(['model_borne_id'], 'ModelBornes'));
        $rules->add($rules->existsIn(['partie_id'], 'Parties'));

        return $rules;
    }
}
