<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EvenementsHasContacts Model
 *
 * @property \App\Model\Table\EvenementsTable|\Cake\ORM\Association\BelongsTo $Evenements
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\EvenementsHasContact get($primaryKey, $options = [])
 * @method \App\Model\Entity\EvenementsHasContact newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EvenementsHasContact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EvenementsHasContact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EvenementsHasContact|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EvenementsHasContact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EvenementsHasContact[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EvenementsHasContact findOrCreate($search, callable $callback = null, $options = [])
 */
class EvenementsHasContactsTable extends Table
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

        $this->setTable('evenements_has_contacts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Evenements', [
            'foreignKey' => 'evenement_id'
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
            ->boolean('is_responsable')
            ->allowEmpty('is_responsable');

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
        $rules->add($rules->existsIn(['evenement_id'], 'Evenements'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
