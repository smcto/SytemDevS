<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OptionsEquipements Model
 *
 * @method \App\Model\Entity\OptionsEquipement get($primaryKey, $options = [])
 * @method \App\Model\Entity\OptionsEquipement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OptionsEquipement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OptionsEquipement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OptionsEquipement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OptionsEquipement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OptionsEquipement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OptionsEquipement findOrCreate($search, callable $callback = null, $options = [])
 */
class OptionsEquipementsTable extends Table
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

        $this->setTable('options_equipements');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

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

        return $validator;
    }
}
