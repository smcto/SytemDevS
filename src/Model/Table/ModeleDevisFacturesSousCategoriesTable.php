<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ModeleDevisFacturesSousCategories Model
 *
 * @property \App\Model\Table\ModeleDevisFacturesCategoriesTable|\Cake\ORM\Association\BelongsTo $ModeleDevisFacturesCategories
 * @property \App\Model\Table\DevisFacturesTable|\Cake\ORM\Association\HasMany $DevisFactures
 *
 * @method \App\Model\Entity\ModeleDevisFacturesSousCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesSousCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesSousCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesSousCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesSousCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesSousCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesSousCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesSousCategory findOrCreate($search, callable $callback = null, $options = [])
 */
class ModeleDevisFacturesSousCategoriesTable extends Table
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

        $this->setTable('modele_devis_factures_sous_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ModeleDevisFacturesCategories', [
            'foreignKey' => 'modele_devis_factures_category_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('DevisFactures', [
            'foreignKey' => 'modele_devis_factures_sous_category_id'
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['modele_devis_factures_category_id'], 'ModeleDevisFacturesCategories'));

        return $rules;
    }
}
