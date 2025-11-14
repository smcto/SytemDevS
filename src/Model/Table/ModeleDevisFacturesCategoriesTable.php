<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ModeleDevisFacturesCategories Model
 *
 * @property \App\Model\Table\DevisFacturesTable|\Cake\ORM\Association\HasMany $DevisFactures
 * @property \App\Model\Table\ModeleDevisFacturesSousCategoriesTable|\Cake\ORM\Association\HasMany $ModeleDevisFacturesSousCategories
 *
 * @method \App\Model\Entity\ModeleDevisFacturesCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ModeleDevisFacturesCategory findOrCreate($search, callable $callback = null, $options = [])
 */
class ModeleDevisFacturesCategoriesTable extends Table
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

        $this->setTable('modele_devis_factures_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('DevisFactures', [
            'foreignKey' => 'modele_devis_facture_category_id'
        ]);
        $this->hasMany('ModeleDevisFacturesSousCategories', [
            'foreignKey' => 'modele_devis_facture_category_id'
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
}
