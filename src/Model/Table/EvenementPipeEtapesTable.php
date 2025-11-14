<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EvenementPipeEtapes Model
 *
 * @property \App\Model\Table\PipeEtapesTable|\Cake\ORM\Association\BelongsTo $PipeEtapes
 * @property \App\Model\Table\EvenementsTable|\Cake\ORM\Association\BelongsTo $Evenements
 *
 * @method \App\Model\Entity\EvenementPipeEtape get($primaryKey, $options = [])
 * @method \App\Model\Entity\EvenementPipeEtape newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EvenementPipeEtape[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EvenementPipeEtape|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EvenementPipeEtape|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EvenementPipeEtape patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EvenementPipeEtape[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EvenementPipeEtape findOrCreate($search, callable $callback = null, $options = [])
 */
class EvenementPipeEtapesTable extends Table
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

        $this->setTable('evenement_pipe_etapes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PipeEtapes', [
            'foreignKey' => 'pipe_etape_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Evenements', [
            'foreignKey' => 'evenement_id',
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
        $rules->add($rules->existsIn(['pipe_etape_id'], 'PipeEtapes'));
        $rules->add($rules->existsIn(['evenement_id'], 'Evenements'));

        return $rules;
    }
}
