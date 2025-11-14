<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ObjectifsAnnees Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ObjectifsCommerciauxTable|\Cake\ORM\Association\HasMany $ObjectifsCommerciaux
 *
 * @method \App\Model\Entity\ObjectifsAnnee get($primaryKey, $options = [])
 * @method \App\Model\Entity\ObjectifsAnnee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ObjectifsAnnee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ObjectifsAnnee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ObjectifsAnnee|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ObjectifsAnnee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ObjectifsAnnee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ObjectifsAnnee findOrCreate($search, callable $callback = null, $options = [])
 */
class ObjectifsAnneesTable extends Table
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

        $this->setTable('objectifs_annees');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('ObjectifsCommerciaux', [
            'foreignKey' => 'objectifs_annee_id'
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
            ->integer('annee')
            ->allowEmpty('annee');

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
// //         $rules->add($rules->existsIn(['user_id'], 'Users'));
// 
        return $rules;
    }
}
