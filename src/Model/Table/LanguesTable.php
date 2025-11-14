<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Langues Model
 *
 * @property \App\Model\Table\DevisTable|\Cake\ORM\Association\HasMany $Devis
 *
 * @method \App\Model\Entity\Langue get($primaryKey, $options = [])
 * @method \App\Model\Entity\Langue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Langue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Langue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Langue|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Langue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Langue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Langue findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LanguesTable extends Table
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

        $this->setTable('langues');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Devis', [
            'foreignKey' => 'langue_id'
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

        $validator
            ->scalar('code')
            ->maxLength('code', 11)
            ->requirePresence('code', 'create')
            ->notEmpty('code');

        return $validator;
    }
}
