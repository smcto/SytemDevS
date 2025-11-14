<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypeAnimations Model
 *
 * @property \App\Model\Table\EvenementsTable|\Cake\ORM\Association\HasMany $Evenements
 *
 * @method \App\Model\Entity\TypeAnimation get($primaryKey, $options = [])
 * @method \App\Model\Entity\TypeAnimation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TypeAnimation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypeAnimation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeAnimation|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeAnimation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TypeAnimation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypeAnimation findOrCreate($search, callable $callback = null, $options = [])
 */
class TypeAnimationsTable extends Table
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

        $this->setTable('type_animations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Evenements', [
            'foreignKey' => 'type_animation_id'
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
            ->allowEmpty('nom');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        return $validator;
    }
}
