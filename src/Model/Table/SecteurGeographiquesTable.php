<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SecteurGeographiques Model
 *
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\HasMany $Antennes
 *
 * @method \App\Model\Entity\SecteurGeographique get($primaryKey, $options = [])
 * @method \App\Model\Entity\SecteurGeographique newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SecteurGeographique[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SecteurGeographique|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SecteurGeographique|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SecteurGeographique patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SecteurGeographique[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SecteurGeographique findOrCreate($search, callable $callback = null, $options = [])
 */
class SecteurGeographiquesTable extends Table
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

        $this->setTable('secteur_geographiques');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Antennes', [
            'foreignKey' => 'secteur_geographique_id'
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
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->allowEmpty('nom');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmpty('description');

        return $validator;
    }
}
