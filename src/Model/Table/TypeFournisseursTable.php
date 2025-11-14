<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypeFournisseurs Model
 *
 * @property \App\Model\Table\FournisseursTable|\Cake\ORM\Association\HasMany $Fournisseurs
 *
 * @method \App\Model\Entity\TypeFournisseur get($primaryKey, $options = [])
 * @method \App\Model\Entity\TypeFournisseur newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TypeFournisseur[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypeFournisseur|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeFournisseur|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeFournisseur patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TypeFournisseur[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypeFournisseur findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TypeFournisseursTable extends Table
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

        $this->setTable('type_fournisseurs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Fournisseurs', [
            'foreignKey' => 'type_fournisseur_id'
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

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        return $validator;
    }
}
