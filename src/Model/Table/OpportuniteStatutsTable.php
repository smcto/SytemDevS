<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OpportuniteStatuts Model
 *
 * @property \App\Model\Table\OpportunitesTable|\Cake\ORM\Association\HasMany $Opportunites
 *
 * @method \App\Model\Entity\OpportuniteStatut get($primaryKey, $options = [])
 * @method \App\Model\Entity\OpportuniteStatut newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OpportuniteStatut[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteStatut|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpportuniteStatut|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpportuniteStatut patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteStatut[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteStatut findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OpportuniteStatutsTable extends Table
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

        $this->setTable('opportunite_statuts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Opportunites', [
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
            ->scalar('nom')
            ->maxLength('nom', 250)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        return $validator;
    }
}
