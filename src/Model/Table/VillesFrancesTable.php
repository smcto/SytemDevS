<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VillesFrances Model
 *
 * @method \App\Model\Entity\VillesFrance get($primaryKey, $options = [])
 * @method \App\Model\Entity\VillesFrance newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VillesFrance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VillesFrance|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VillesFrance|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VillesFrance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VillesFrance[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VillesFrance findOrCreate($search, callable $callback = null, $options = [])
 */
class VillesFrancesTable extends Table
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

        $this->setTable('villes_frances');
        $this->setDisplayField('ville_nom');
        $this->setPrimaryKey('ville_id');
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
            ->nonNegativeInteger('ville_id')
            ->allowEmpty('ville_id', 'create');

        $validator
            ->scalar('ville_departement')
            ->maxLength('ville_departement', 3)
            ->allowEmpty('ville_departement');

        $validator
            ->scalar('ville_slug')
            ->maxLength('ville_slug', 255)
            ->allowEmpty('ville_slug')
            ->add('ville_slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('ville_nom')
            ->maxLength('ville_nom', 45)
            ->allowEmpty('ville_nom');

        $validator
            ->scalar('ville_nom_simple')
            ->maxLength('ville_nom_simple', 45)
            ->allowEmpty('ville_nom_simple');

        $validator
            ->scalar('ville_nom_reel')
            ->maxLength('ville_nom_reel', 45)
            ->allowEmpty('ville_nom_reel');

        $validator
            ->scalar('ville_nom_soundex')
            ->maxLength('ville_nom_soundex', 20)
            ->allowEmpty('ville_nom_soundex');

        $validator
            ->scalar('ville_nom_metaphone')
            ->maxLength('ville_nom_metaphone', 22)
            ->allowEmpty('ville_nom_metaphone');

        $validator
            ->scalar('ville_code_postal')
            ->maxLength('ville_code_postal', 255)
            ->allowEmpty('ville_code_postal');

        $validator
            ->scalar('ville_commune')
            ->maxLength('ville_commune', 3)
            ->allowEmpty('ville_commune');

        $validator
            ->scalar('ville_code_commune')
            ->maxLength('ville_code_commune', 5)
            ->notEmpty('ville_code_commune')
            ->add('ville_code_commune', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('ville_arrondissement');

        $validator
            ->scalar('ville_canton')
            ->maxLength('ville_canton', 4)
            ->allowEmpty('ville_canton');

        $validator
            ->allowEmpty('ville_amdi');

        $validator
            ->nonNegativeInteger('ville_population_2010')
            ->allowEmpty('ville_population_2010');

        $validator
            ->nonNegativeInteger('ville_population_1999')
            ->allowEmpty('ville_population_1999');

        $validator
            ->nonNegativeInteger('ville_population_2012')
            ->allowEmpty('ville_population_2012');

        $validator
            ->integer('ville_densite_2010')
            ->allowEmpty('ville_densite_2010');

        $validator
            ->numeric('ville_surface')
            ->allowEmpty('ville_surface');

        $validator
            ->numeric('ville_longitude_deg')
            ->allowEmpty('ville_longitude_deg');

        $validator
            ->numeric('ville_latitude_deg')
            ->allowEmpty('ville_latitude_deg');

        $validator
            ->scalar('ville_longitude_grd')
            ->maxLength('ville_longitude_grd', 9)
            ->allowEmpty('ville_longitude_grd');

        $validator
            ->scalar('ville_latitude_grd')
            ->maxLength('ville_latitude_grd', 8)
            ->allowEmpty('ville_latitude_grd');

        $validator
            ->scalar('ville_longitude_dms')
            ->maxLength('ville_longitude_dms', 9)
            ->allowEmpty('ville_longitude_dms');

        $validator
            ->scalar('ville_latitude_dms')
            ->maxLength('ville_latitude_dms', 8)
            ->allowEmpty('ville_latitude_dms');

        $validator
            ->integer('ville_zmin')
            ->allowEmpty('ville_zmin');

        $validator
            ->integer('ville_zmax')
            ->allowEmpty('ville_zmax');

        $validator
            ->nonNegativeInteger('ville_population_2010_order_france')
            ->allowEmpty('ville_population_2010_order_france');

        $validator
            ->nonNegativeInteger('ville_densite_2010_order_france')
            ->allowEmpty('ville_densite_2010_order_france');

        $validator
            ->nonNegativeInteger('ville_surface_order_france')
            ->allowEmpty('ville_surface_order_france');

        $validator
            ->nonNegativeInteger('ville_population_2010_order_dpt')
            ->allowEmpty('ville_population_2010_order_dpt');

        $validator
            ->nonNegativeInteger('ville_densite_2010_order_dpt')
            ->allowEmpty('ville_densite_2010_order_dpt');

        $validator
            ->nonNegativeInteger('ville_surface_order_dpt')
            ->allowEmpty('ville_surface_order_dpt');

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
        $rules->add($rules->isUnique(['ville_code_commune']));
        $rules->add($rules->isUnique(['ville_slug']));

        return $rules;
    }
}
