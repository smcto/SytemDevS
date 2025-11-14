<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypeEquipementsOptions Model
 *
 * @property \App\Model\Table\OptionsEquipementsTable|\Cake\ORM\Association\BelongsTo $OptionsEquipements
 * @property \App\Model\Table\TypeEquipementsTable|\Cake\ORM\Association\BelongsTo $TypeEquipements
 *
 * @method \App\Model\Entity\TypeEquipementsOption get($primaryKey, $options = [])
 * @method \App\Model\Entity\TypeEquipementsOption newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TypeEquipementsOption[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypeEquipementsOption|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeEquipementsOption|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeEquipementsOption patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TypeEquipementsOption[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypeEquipementsOption findOrCreate($search, callable $callback = null, $options = [])
 */
class TypeEquipementsOptionsTable extends Table
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

        $this->setTable('type_equipements_options');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('OptionsEquipements', [
            'foreignKey' => 'options_equipement_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TypeEquipements', [
            'foreignKey' => 'type_equipement_id',
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
// //         $rules->add($rules->existsIn(['options_equipement_id'], 'OptionsEquipements'));
// //         $rules->add($rules->existsIn(['type_equipement_id'], 'TypeEquipements'));
// 
        return $rules;
    }
}
