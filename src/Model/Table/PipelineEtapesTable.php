<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PipelineEtapes Model
 *
 * @property \App\Model\Table\PipelinesTable|\Cake\ORM\Association\BelongsTo $Pipelines
 * @property \App\Model\Table\OpportunitesTable|\Cake\ORM\Association\HasMany $Opportunites
 *
 * @method \App\Model\Entity\PipelineEtape get($primaryKey, $options = [])
 * @method \App\Model\Entity\PipelineEtape newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PipelineEtape[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PipelineEtape|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PipelineEtape|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PipelineEtape patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PipelineEtape[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PipelineEtape findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PipelineEtapesTable extends Table
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

        $this->setTable('pipeline_etapes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pipelines', [
            'foreignKey' => 'pipeline_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Opportunites', [
            'foreignKey' => 'pipeline_etape_id',
            'sort' => ['Opportunites.created'=>'DESC']
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
            ->maxLength('nom', 500)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        $validator
            ->integer('id_in_sellsy')
            ->allowEmpty('id_in_sellsy');

        $validator
            ->integer('rank')
            ->allowEmpty('rank');

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
        $rules->add($rules->existsIn(['pipeline_id'], 'Pipelines'));

        return $rules;
    }
}
