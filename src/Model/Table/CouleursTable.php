<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Couleurs Model
 *
 * @method \App\Model\Entity\Couleur get($primaryKey, $options = [])
 * @method \App\Model\Entity\Couleur newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Couleur[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Couleur|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Couleur|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Couleur patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Couleur[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Couleur findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CouleursTable extends Table
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

        $this->setTable('couleurs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        
        $this->belongsToMany('ModelBornes', [
            'className' => 'ModelBornes',
            'joinTable' => 'model_bornes_has_couleurs',
            'targetForeignKey' =>'model_borne_id',
            'foreignKey' => 'couleur_id'
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
            ->scalar('couleur')
            ->maxLength('couleur', 250)
            ->requirePresence('couleur', 'create')
            ->notEmpty('couleur');

        return $validator;
    }
}
