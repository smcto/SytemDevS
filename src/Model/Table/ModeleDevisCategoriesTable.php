<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ModeleDevisCategories Model
 *
 * @method \App\Model\Entity\ModeleDevisCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\ModeleDevisCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ModeleDevisCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ModeleDevisCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModeleDevisCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModeleDevisCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ModeleDevisCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ModeleDevisCategory findOrCreate($search, callable $callback = null, $options = [])
 */
class ModeleDevisCategoriesTable extends Table
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

        $this->setTable('modele_devis_categories');
        $this->setDisplayField('name');
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }
}
