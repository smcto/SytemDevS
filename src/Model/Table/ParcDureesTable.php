<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ParcDurees Model
 *
 * @property \App\Model\Table\ParcsTable|\Cake\ORM\Association\BelongsTo $Parcs
 * @property \App\Model\Table\BornesTable|\Cake\ORM\Association\HasMany $Bornes
 * @property \App\Model\Table\VentesTable|\Cake\ORM\Association\HasMany $Ventes
 *
 * @method \App\Model\Entity\ParcDuree get($primaryKey, $options = [])
 * @method \App\Model\Entity\ParcDuree newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ParcDuree[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ParcDuree|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ParcDuree|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ParcDuree patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ParcDuree[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ParcDuree findOrCreate($search, callable $callback = null, $options = [])
 */
class ParcDureesTable extends Table
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

        $this->setTable('parc_durees');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Parcs', [
            'foreignKey' => 'parc_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Bornes', [
            'foreignKey' => 'parc_duree_id'
        ]);
        $this->hasMany('Ventes', [
            'foreignKey' => 'parc_duree_id'
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
            ->scalar('valeur')
            ->maxLength('valeur', 255)
            ->allowEmpty('valeur');

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
// //         $rules->add($rules->existsIn(['parc_id'], 'Parcs'));
// 
        return $rules;
    }
}
