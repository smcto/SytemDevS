<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypeEquipements Model
 *
 * @property \App\Model\Table\EquipementsTable|\Cake\ORM\Association\HasMany $Equipements
 *
 * @method \App\Model\Entity\TypeEquipement get($primaryKey, $options = [])
 * @method \App\Model\Entity\TypeEquipement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TypeEquipement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypeEquipement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeEquipement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeEquipement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TypeEquipement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypeEquipement findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MarqueEquipementsTable extends Table
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

        $this->setTable('marque_equipements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Equipements', [
            'foreignKey' => 'marque_equipement_id'
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
            ->scalar('marque')
            ->maxLength('marque', 250)
            ->allowEmpty('marque');

        return $validator;
    }
}
