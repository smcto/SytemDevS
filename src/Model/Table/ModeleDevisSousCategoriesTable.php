<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ModeleDevisSousCategories Model
 *
 * @property \App\Model\Table\ModeleDevisCategoriesTable|\Cake\ORM\Association\BelongsTo $ModeleDevisCategories
 *
 * @method \App\Model\Entity\ModeleDevisSousCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\ModeleDevisSousCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ModeleDevisSousCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ModeleDevisSousCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModeleDevisSousCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModeleDevisSousCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ModeleDevisSousCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ModeleDevisSousCategory findOrCreate($search, callable $callback = null, $options = [])
 */
class ModeleDevisSousCategoriesTable extends Table
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

        $this->setTable('modele_devis_sous_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ModeleDevisCategories', [
            'foreignKey' => 'modele_devis_categories_id',
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }

    
    public function findFiltre(Query $query, array $options) {
        
        $catalog_categories_id = isset($options['modele_devis_categories_id'])?$options['modele_devis_categories_id']:null;
        if(!empty($catalog_categories_id)){
            $query->where(['ModeleDevisCategories.id'=>$catalog_categories_id]);
        }

        return $query;
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
        $rules->add($rules->existsIn(['modele_devis_categories_id'], 'ModeleDevisCategories'));

        return $rules;
    }
}
