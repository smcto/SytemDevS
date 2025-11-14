<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LivraisonsVentesSousConsommables Model
 *
 * @property \App\Model\Table\VentesHasSousConsommablesTable|\Cake\ORM\Association\BelongsTo $VentesHasSousConsommables
 *
 * @method \App\Model\Entity\LivraisonsVentesSousConsommable get($primaryKey, $options = [])
 * @method \App\Model\Entity\LivraisonsVentesSousConsommable newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LivraisonsVentesSousConsommable[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LivraisonsVentesSousConsommable|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LivraisonsVentesSousConsommable|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LivraisonsVentesSousConsommable patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LivraisonsVentesSousConsommable[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LivraisonsVentesSousConsommable findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LivraisonsVentesSousConsommablesTable extends Table
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

        $this->setTable('livraisons_ventes_sous_consommables');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('VentesHasSousConsommables', [
            'foreignKey' => 'ventes_has_sous_consommable_id',
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
        $rules->add($rules->existsIn(['ventes_has_sous_consommable_id'], 'VentesHasSousConsommables'));

        return $rules;
    }
}
