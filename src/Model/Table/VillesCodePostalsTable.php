<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VillesCodePostals Model
 *
 * @property \App\Model\Table\VilleCpFkVillesTable|\Cake\ORM\Association\BelongsTo $VilleCpFkVilles
 *
 * @method \App\Model\Entity\VillesCodePostal get($primaryKey, $options = [])
 * @method \App\Model\Entity\VillesCodePostal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VillesCodePostal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VillesCodePostal|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VillesCodePostal|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VillesCodePostal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VillesCodePostal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VillesCodePostal findOrCreate($search, callable $callback = null, $options = [])
 */
class VillesCodePostalsTable extends Table
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

        $this->setTable('villes_code_postals');
        $this->setDisplayField('ville_cp_fk_code_postal');
        $this->setPrimaryKey('ville_cp_id');


        $this->hasMany('VillesFrances', [
            'foreignKey' => 'ville_code_postal',
            'bindingKey' => 'ville_cp_fk_code_postal'
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
            ->allowEmpty('ville_cp_id', 'create');

        $validator
            ->scalar('ville_cp_fk_code_postal')
            ->maxLength('ville_cp_fk_code_postal', 255)
            ->allowEmpty('ville_cp_fk_code_postal');

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
        $rules->add($rules->existsIn(['ville_cp_fk_ville_id'], 'VilleCpFkVilles'));

        return $rules;
    }
}
