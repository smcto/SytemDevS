<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GroupeClients Model
 *
 * @method \App\Model\Entity\GroupeClient get($primaryKey, $options = [])
 * @method \App\Model\Entity\GroupeClient newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GroupeClient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GroupeClient|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GroupeClient|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GroupeClient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GroupeClient[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GroupeClient findOrCreate($search, callable $callback = null, $options = [])
 */
class GroupeClientsTable extends Table
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

        $this->setTable('groupe_clients');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');
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
            ->maxLength('nom', 255)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        return $validator;
    }
    
    public function findFiltre(Query $query, array $options) {

        $groupe_clients = isset($options['groupe_clients'])?$options['groupe_clients']:null;

        if(!empty($groupe_clients)){
            $query->where(['GroupeClients.id = ' =>$groupe_clients]);
        }

        return $query;
    }
}
