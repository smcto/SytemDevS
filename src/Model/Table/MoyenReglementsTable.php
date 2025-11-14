<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MoyenReglements Model
 *
 * @property \App\Model\Table\ReglementsTable|\Cake\ORM\Association\HasMany $Reglements
 *
 * @method \App\Model\Entity\MoyenReglement get($primaryKey, $options = [])
 * @method \App\Model\Entity\MoyenReglement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MoyenReglement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MoyenReglement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MoyenReglement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MoyenReglement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MoyenReglement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MoyenReglement findOrCreate($search, callable $callback = null, $options = [])
 */
class MoyenReglementsTable extends Table
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

        $this->setTable('moyen_reglements');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Reglements', [
            'foreignKey' => 'moyen_reglement_id'
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }
}
