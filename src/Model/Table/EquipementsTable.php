<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Equipements Model
 *
 * @property \App\Model\Table\TypeEquipementsTable|\Cake\ORM\Association\BelongsTo $TypeEquipements
 *
 * @method \App\Model\Entity\Equipement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Equipement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Equipement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Equipement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Equipement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Equipement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Equipement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Equipement findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EquipementsTable extends Table
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

        $this->setTable('equipements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('TypeEquipements', [
            'foreignKey' => 'type_equipement_id',
            'joinTable' => 'type_equipements'
        ]);
        $this->belongsTo('MarqueEquipements', [
            'foreignKey' => 'marque_equipement_id',
            'joinTable' => 'marque_equipements'
        ]);
        $this->hasMany('LotProduits');

        $this->belongsToMany('Bornes', [
            'foreignKey' => 'equipement_id',
            'targetForeignKey' => 'borne_id',
            'joinTable' => 'equipement_bornes'
        ]);
        
        $this->hasMany('Stock', [
            'foreignKey' => 'equipement_id',
            'className' => 'NumeroSeries',
            'conditions' => ['Stock.borne_id is null', 'Stock.lot_produit_id is not null']
        ]);
        
        $this->hasMany('Used', [
            'foreignKey' => 'equipement_id',
            'className' => 'NumeroSeries',
            'conditions' => ['Used.borne_id is not null']
        ]);
        
        $this->hasMany('EquipementsDocuments', [
            'foreignKey' => 'equipement_id',
        ]);
//        
//        $this->hasMany('NumeroSeries', [
//            'foreignKey' => 'equipement_id',
//            'conditions' => ['NumeroSeries.borne_id is null']
//        ]);
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
            ->maxLength('valeur', 250)
            ->requirePresence('valeur', 'create')
            ->notEmpty('valeur');

        $validator
            ->scalar('commentaire')
            ->allowEmpty('commentaire');

        $validator
            ->boolean('is_filtrable')
            ->allowEmpty('is_filtrable');

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
        $rules->add($rules->existsIn(['type_equipement_id'], 'TypeEquipements'));

        return $rules;
    }

    public function findFiltre(Query $query, array $options)
    {
        $search = $options['key'];

      
        if(!empty($search)){
            $query->where(['valeur LIKE' => '%'.$search.'%']);
        }

        $type_equipement = $options['type_equipement'];
        if(!empty($type_equipement)){
            $query->where(['type_equipement_id'=>$type_equipement]);
        }

        $marque_equipement = $options['marque_equipement'];
        if(!empty($marque_equipement)){
            $query->where(['marque_equipement_id'=>$marque_equipement]);
        }
        
        $doc = $options['document'];
        if(!empty($doc)){
            if ($doc == 1) {
                $query->matching('EquipementsDocuments');
            } elseif ($doc == 2) {
                $query->notMatching('EquipementsDocuments');
            }
        }

        return $query;
    }
}
