<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipementsProtectionsBornes Model
 *
 * @property \App\Model\Table\BornesTable|\Cake\ORM\Association\BelongsTo $Bornes
 * @property \App\Model\Table\TypeEquipementsTable|\Cake\ORM\Association\BelongsTo $TypeEquipements
 * @property \App\Model\Table\EquipementsTable|\Cake\ORM\Association\BelongsTo $Equipements
 *
 * @method \App\Model\Entity\EquipementsProtectionsBorne get($primaryKey, $options = [])
 * @method \App\Model\Entity\EquipementsProtectionsBorne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EquipementsProtectionsBorne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EquipementsProtectionsBorne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipementsProtectionsBorne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipementsProtectionsBorne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EquipementsProtectionsBorne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EquipementsProtectionsBorne findOrCreate($search, callable $callback = null, $options = [])
 */
class EquipementsProtectionsBornesTable extends Table
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

        $this->setTable('equipements_protections_bornes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Bornes', [
            'foreignKey' => 'borne_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TypeEquipements', [
            'foreignKey' => 'type_equipement_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Equipements', [
            'foreignKey' => 'equipement_id'
        ]);
        $this->belongsTo('NumeroSeries', [
            'foreignKey' => 'numero_serie_id'
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
            ->integer('qty')
            ->allowEmpty('qty');

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
// //         $rules->add($rules->existsIn(['borne_id'], 'Bornes'));
// //         $rules->add($rules->existsIn(['type_equipement_id'], 'TypeEquipements'));
// //         $rules->add($rules->existsIn(['equipement_id'], 'Equipements'));
// 
        return $rules;
    }
}
