<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PipeEtapes Model
 *
 * @property \App\Model\Table\PipesTable|\Cake\ORM\Association\BelongsTo $Pipes
 * @property \App\Model\Table\EvenementPipeEtapesTable|\Cake\ORM\Association\HasMany $EvenementPipeEtapes
 *
 * @method \App\Model\Entity\PipeEtape get($primaryKey, $options = [])
 * @method \App\Model\Entity\PipeEtape newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PipeEtape[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PipeEtape|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PipeEtape|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PipeEtape patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PipeEtape[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PipeEtape findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PipeEtapesTable extends Table
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

        $this->setTable('pipe_etapes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pipes', [
            'foreignKey' => 'pipe_id',
            'joinType' => 'INNER'
        ]);
       /* $this->hasMany('EvenementPipeEtapes', [
            'foreignKey' => 'pipe_etape_id'
        ]);*/
        
        $this->belongsToMany('Evenements', [
            'joinTable' => 'evenement_pipe_etapes',
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
            ->integer('ordre')
            ->requirePresence('ordre', 'create')
            ->notEmpty('ordre');

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
        $rules->add($rules->existsIn(['pipe_id'], 'Pipes'));

        return $rules;
    }

    public function findFiltre(Query $query, array $options) {

        $pipe = $options['pipe'];

        if(!empty($pipe)){
            $query->where(['pipe_id' => $pipe]);
        }

        return $query;
    }
}
