<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OpportuniteCommentaires Model
 *
 * @property \App\Model\Table\OpportunitesTable|\Cake\ORM\Association\BelongsTo $Opportunites
 * @property \App\Model\Table\StaffsTable|\Cake\ORM\Association\BelongsTo $Staffs
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\OpportuniteCommentaire get($primaryKey, $options = [])
 * @method \App\Model\Entity\OpportuniteCommentaire newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OpportuniteCommentaire[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteCommentaire|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpportuniteCommentaire|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpportuniteCommentaire patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteCommentaire[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OpportuniteCommentaire findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OpportuniteCommentairesTable extends Table
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

        $this->setTable('opportunite_commentaires');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Opportunites', [
            'foreignKey' => 'opportunite_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Staffs', [
            'foreignKey' => 'staff_id'
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
            ->integer('commentaire_id_in_sellsy')
            ->allowEmpty('commentaire_id_in_sellsy');

        $validator
            ->integer('timestamp')
            ->allowEmpty('timestamp');

        $validator
            ->scalar('date_format')
            ->maxLength('date_format', 250)
            ->allowEmpty('date_format');

        $validator
            ->scalar('titre')
            ->allowEmpty('titre');

        $validator
            ->scalar('commentaire')
            ->allowEmpty('commentaire');

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
        $rules->add($rules->existsIn(['opportunite_id'], 'Opportunites'));
        $rules->add($rules->existsIn(['staff_id'], 'Staffs'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
