<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MessageriesHasUsers Model
 *
 * @property \App\Model\Table\MessageriesTable|\Cake\ORM\Association\BelongsTo $Messageries
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\MessageriesHasUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\MessageriesHasUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MessageriesHasUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MessageriesHasUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MessageriesHasUser|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MessageriesHasUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MessageriesHasUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MessageriesHasUser findOrCreate($search, callable $callback = null, $options = [])
 */
class MessageriesHasUsersTable extends Table
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

        $this->setTable('messageries_has_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Messageries', [
            'foreignKey' => 'messagerie_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
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
        $rules->add($rules->existsIn(['messagerie_id'], 'Messageries'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
