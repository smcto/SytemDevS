<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VentesHasSousAccessoires Model
 *
 * @property \App\Model\Table\VentesConsommablesTable|\Cake\ORM\Association\BelongsTo $VentesConsommables
 * @property \App\Model\Table\AccessoiresTable|\Cake\ORM\Association\BelongsTo $Accessoires
 * @property \App\Model\Table\SousAccessoiresTable|\Cake\ORM\Association\BelongsTo $SousAccessoires
 *
 * @method \App\Model\Entity\VentesHasSousAccessoire get($primaryKey, $options = [])
 * @method \App\Model\Entity\VentesHasSousAccessoire newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VentesHasSousAccessoire[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VentesHasSousAccessoire|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentesHasSousAccessoire|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentesHasSousAccessoire patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VentesHasSousAccessoire[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VentesHasSousAccessoire findOrCreate($search, callable $callback = null, $options = [])
 */
class VentesHasSousAccessoiresTable extends Table
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

        $this->setTable('ventes_has_sous_accessoires');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('VentesConsommables', [
            'foreignKey' => 'ventes_consommable_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Accessoires', [
            'foreignKey' => 'accessoire_id'
        ]);

        $this->belongsTo('SousAccessoires', [
            'foreignKey' => 'sous_accessoire_id'
        ]);

        $this->hasMany(
            'LivraisonsVentesSousAccessoires', [
                'className' => 'LivraisonsVentesSousAccessoires',
                'foreignKey' => 'ventes_has_sous_accessoire_id',
            ]
        );
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
            ->integer('qty')
            ->allowEmpty('qty');

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
        $rules->add($rules->existsIn(['ventes_consommable_id'], 'VentesConsommables'));
        $rules->add($rules->existsIn(['accessoire_id'], 'Accessoires'));
        $rules->add($rules->existsIn(['sous_accessoire_id'], 'SousAccessoires'));

        return $rules;
    }
}
