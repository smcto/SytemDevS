<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OpportuniteTimelines Model
 *
 * @property \App\Model\Table\OpportunitesTable|\Cake\ORM\Association\BelongsTo $Opportunites
 * @property \App\Model\Table\OpportuniteActionsTable|\Cake\ORM\Association\BelongsTo $OpportuniteActions
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PipelineEtapesTable|\Cake\ORM\Association\BelongsTo $PipelineEtapes
 * @property |\Cake\ORM\Association\BelongsTo $OpportuniteStatuts
 *
 * @method \App\Model\Entity\OpportuniteTimeline get($primaryKey, $options = [])
 * @method \App\Model\Entity\OpportuniteTimeline newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OpportuniteTimeline[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteTimeline|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpportuniteTimeline|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpportuniteTimeline patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteTimeline[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteTimeline findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OpportuniteTimelinesTable extends Table
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

        $this->setTable('opportunite_timelines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Opportunites', [
            'foreignKey' => 'opportunite_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OpportuniteActions', [
            'foreignKey' => 'opportunite_action_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('PipelineEtapes', [
            'foreignKey' => 'pipeline_etape_id'
        ]);
        $this->belongsTo('OpportuniteStatuts', [
            'foreignKey' => 'opportunite_statut_id'
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
            ->integer('time_action')
            ->requirePresence('time_action', 'create')
            ->notEmpty('time_action');

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
        $rules->add($rules->existsIn(['opportunite_action_id'], 'OpportuniteActions'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['pipeline_etape_id'], 'PipelineEtapes'));
        $rules->add($rules->existsIn(['opportunite_statut_id'], 'OpportuniteStatuts'));

        return $rules;
    }
}
