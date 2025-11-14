<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypeProfils Model
 *
 * @property \App\Model\Table\UserTypeProfilsTable|\Cake\ORM\Association\HasMany $UserTypeProfils
 *
 * @method \App\Model\Entity\TypeProfil get($primaryKey, $options = [])
 * @method \App\Model\Entity\TypeProfil newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TypeProfil[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypeProfil|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeProfil|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeProfil patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TypeProfil[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypeProfil findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TypeProfilsTable extends Table
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

        $this->setTable('type_profils');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        /*$this->hasMany('UserTypeProfils', [
            'foreignKey' => 'type_profil_id'
        ]);*/

        $this->belongsToMany('Users', [
            'className' => 'Users',
            'through' => 'UserTypeProfils',
            'joinTable' => 'user_type_profils',
            'targetForeignKey' =>'user_id',
            'foreignKey' => 'type_profil_id',
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

        $validator
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        return $validator;
    }
}
