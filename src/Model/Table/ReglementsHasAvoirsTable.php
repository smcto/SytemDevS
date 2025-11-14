<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReglementsHasAvoirs Model
 *
 * @property \App\Model\Table\ReglementsTable|\Cake\ORM\Association\BelongsTo $Reglements
 * @property \App\Model\Table\AvoirsTable|\Cake\ORM\Association\BelongsTo $Avoirs
 *
 * @method \App\Model\Entity\ReglementsHasAvoir get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReglementsHasAvoir newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ReglementsHasAvoir[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReglementsHasAvoir|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReglementsHasAvoir|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReglementsHasAvoir patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReglementsHasAvoir[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReglementsHasAvoir findOrCreate($search, callable $callback = null, $options = [])
 */
class ReglementsHasAvoirsTable extends Table
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

        $this->setTable('reglements_has_avoirs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Reglements', [
            'foreignKey' => 'reglements_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Avoirs', [
            'foreignKey' => 'avoir_id',
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
        $rules->add($rules->existsIn(['reglements_id'], 'Reglements'));
        $rules->add($rules->existsIn(['avoir_id'], 'Avoirs'));

        return $rules;
    }
}
