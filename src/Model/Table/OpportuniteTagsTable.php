<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OpportuniteTags Model
 *
 * @property \App\Model\Table\OpportunitesTable|\Cake\ORM\Association\BelongsTo $Opportunites
 *
 * @method \App\Model\Entity\OpportuniteTag get($primaryKey, $options = [])
 * @method \App\Model\Entity\OpportuniteTag newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OpportuniteTag[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteTag|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpportuniteTag|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpportuniteTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteTag[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteTag findOrCreate($search, callable $callback = null, $options = [])
 */
class OpportuniteTagsTable extends Table
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

        $this->setTable('opportunite_tags');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Opportunites', [
            'foreignKey' => 'opportunite_id',
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
            ->scalar('nom')
            ->maxLength('nom', 250)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

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

        return $rules;
    }
}
