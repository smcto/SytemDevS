<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pipelines Model
 *
 * @property \App\Model\Table\OpportunitesTable|\Cake\ORM\Association\HasMany $Opportunites
 * @property \App\Model\Table\PipelineEtapesTable|\Cake\ORM\Association\HasMany $PipelineEtapes
 *
 * @method \App\Model\Entity\Pipeline get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pipeline newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pipeline[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pipeline|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pipeline|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pipeline patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pipeline[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pipeline findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PipelinesTable extends Table
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

        $this->setTable('pipelines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Opportunites', [
            'foreignKey' => 'pipeline_id'
        ]);
        $this->hasMany('PipelineEtapes', [
            'foreignKey' => 'pipeline_id'
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

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->integer('id_in_sellsy')
            ->allowEmpty('id_in_sellsy');

        return $validator;
    }
}
