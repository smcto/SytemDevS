<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailsHasUsers Model
 *
 * @property \App\Model\Table\EmailsTable|\Cake\ORM\Association\BelongsTo $Emails
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\EmailsHasUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailsHasUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmailsHasUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailsHasUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailsHasUser|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailsHasUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailsHasUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailsHasUser findOrCreate($search, callable $callback = null, $options = [])
 */
class EmailsHasUsersTable extends Table
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

        $this->setTable('emails_has_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Emails', [
            'foreignKey' => 'email_id'
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

        $validator
            ->boolean('is_expediteur')
            ->allowEmpty('is_expediteur');

        $validator
            ->boolean('is_destinateur')
            ->allowEmpty('is_destinateur');

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
        $rules->add($rules->existsIn(['email_id'], 'Emails'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
