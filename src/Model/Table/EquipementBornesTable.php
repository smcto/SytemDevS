<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipementBornes Model
 *
 * @property \App\Model\Table\EquipementsTable|\Cake\ORM\Association\BelongsTo $Equipements
 * @property \App\Model\Table\BornesTable|\Cake\ORM\Association\BelongsTo $Bornes
 * @property \App\Model\Table\TypeEquipementsTable|\Cake\ORM\Association\BelongsTo $TypeEquipements
 * @property \App\Model\Table\NumeroSeriesTable|\Cake\ORM\Association\BelongsTo $NumeroSeries
 *
 * @method \App\Model\Entity\EquipementBorne get($primaryKey, $options = [])
 * @method \App\Model\Entity\EquipementBorne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EquipementBorne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EquipementBorne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipementBorne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipementBorne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EquipementBorne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EquipementBorne findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EquipementBornesTable extends Table
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

        $this->setTable('equipement_bornes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Equipements', [
            'foreignKey' => 'equipement_id'
        ]);
        $this->belongsTo('Bornes', [
            'foreignKey' => 'borne_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TypeEquipements', [
            'foreignKey' => 'type_equipement_id'
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
            ->scalar('precisions')
            ->maxLength('precisions', 255)
            ->allowEmpty('precisions');

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
        $rules->add($rules->existsIn(['equipement_id'], 'Equipements'));
        $rules->add($rules->existsIn(['borne_id'], 'Bornes'));
        $rules->add($rules->existsIn(['type_equipement_id'], 'TypeEquipements'));
        $rules->add($rules->existsIn(['numero_serie_id'], 'NumeroSeries'));

        return $rules;
    }
}
