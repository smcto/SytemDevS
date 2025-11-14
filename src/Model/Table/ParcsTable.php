<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Parcs Model
 *
 * @property \App\Model\Table\BornesTable|\Cake\ORM\Association\HasMany $Bornes
 *
 * @method \App\Model\Entity\Parc get($primaryKey, $options = [])
 * @method \App\Model\Entity\Parc newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Parc[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Parc|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Parc|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Parc patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Parc[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Parc findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ParcsTable extends Table
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

        $this->setTable('parcs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Bornes', [
            'foreignKey' => 'parc_id'
        ]);

        $this->hasMany('ParcDurees', [
            'foreignKey' => 'parc_id'
        ]);
    }

    public function findVente(Query $query, array $options)
    {
        $query->where([
            'id IN' => [1, 4, 9, 10]
        ]);
        return $query;
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
}
