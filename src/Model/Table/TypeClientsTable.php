<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypeClients Model
 *
 * @property \App\Model\Table\OpportunitesTable|\Cake\ORM\Association\HasMany $Opportunites
 *
 * @method \App\Model\Entity\TypeClient get($primaryKey, $options = [])
 * @method \App\Model\Entity\TypeClient newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TypeClient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypeClient|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeClient|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeClient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TypeClient[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypeClient findOrCreate($search, callable $callback = null, $options = [])
 */
class TypeClientsTable extends Table
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

        $this->setTable('type_clients');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Opportunites', [
            'foreignKey' => 'type_client_id'
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
