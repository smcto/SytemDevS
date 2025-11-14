<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OpportuniteActions Model
 *
 * @property \App\Model\Table\OpportuniteTimelinesTable|\Cake\ORM\Association\HasMany $OpportuniteTimelines
 *
 * @method \App\Model\Entity\OpportuniteAction get($primaryKey, $options = [])
 * @method \App\Model\Entity\OpportuniteAction newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OpportuniteAction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteAction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpportuniteAction|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpportuniteAction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteAction[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteAction findOrCreate($search, callable $callback = null, $options = [])
 */
class OpportuniteActionsTable extends Table
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

        $this->setTable('opportunite_actions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('OpportuniteTimelines', [
            'foreignKey' => 'opportunite_action_id'
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
            ->scalar('name')
            ->maxLength('name', 250)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }
}
