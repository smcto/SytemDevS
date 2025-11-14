<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SousAccessoires Model
 *
 * @property \App\Model\Table\AccessoiresTable|\Cake\ORM\Association\BelongsTo $Accessoires
 *
 * @method \App\Model\Entity\SousAccessoire get($primaryKey, $options = [])
 * @method \App\Model\Entity\SousAccessoire newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SousAccessoire[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SousAccessoire|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SousAccessoire|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SousAccessoire patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SousAccessoire[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SousAccessoire findOrCreate($search, callable $callback = null, $options = [])
 */
class SousAccessoiresTable extends Table
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

        $this->setTable('sous_accessoires');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('GammesBornes', [
            'foreignKey' => 'sous_accessoire_id',
            'targetForeignKey' => 'gamme_borne_id',
            'joinTable' => 'accessoires_gammes',
            'through' => 'SousAccessoiresGammes',
            'className' => 'GammesBornes', 
        ]);
        
        $this->hasMany('SousAccessoiresGammes', [
            'foreignKey' => 'sous_accessoire_id'
        ]);

        $this->belongsTo('Accessoires', [
            'foreignKey' => 'accessoire_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

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
        $rules->add($rules->existsIn(['accessoire_id'], 'Accessoires'));

        return $rules;
    }
}
