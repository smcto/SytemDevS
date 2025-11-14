<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ActuBornes Model
 *
 * @property \App\Model\Table\BornesTable|\Cake\ORM\Association\BelongsTo $Bornes
 * @property \App\Model\Table\ActuBornesHasMediasTable|\Cake\ORM\Association\HasMany $ActuBornesHasMedias
 *
 * @method \App\Model\Entity\ActuBorne get($primaryKey, $options = [])
 * @method \App\Model\Entity\ActuBorne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ActuBorne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ActuBorne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActuBorne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActuBorne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ActuBorne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ActuBorne findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ActuBornesTable extends Table
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

        $this->setTable('actu_bornes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Fichiers', [
            'foreignKey' => 'actu_borne_id'
        ]);

        $this->belongsTo('Bornes', [
            'foreignKey' => 'borne_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CategorieActus', [
            'foreignKey' => 'categorie_actus_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ActuBornesHasMedias', [
            'foreignKey' => 'actu_borne_id'
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
            ->scalar('titre')
            ->maxLength('titre', 255)
            ->requirePresence('titre', 'create')
            ->notEmpty('titre');

        $validator
            ->scalar('contenu')
            ->allowEmpty('contenu');

        $validator
            ->scalar('photos')
            ->maxLength('photos', 50)
            ->allowEmpty('photos');

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
        $rules->add($rules->existsIn(['borne_id'], 'Bornes'));

        return $rules;
    }
}
