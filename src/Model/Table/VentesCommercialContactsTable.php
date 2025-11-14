<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VentesCommercialContacts Model
 *
 * @property \App\Model\Table\VentesTable|\Cake\ORM\Association\BelongsTo $Ventes
 *
 * @method \App\Model\Entity\VentesCommercialContact get($primaryKey, $options = [])
 * @method \App\Model\Entity\VentesCommercialContact newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VentesCommercialContact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VentesCommercialContact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentesCommercialContact|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentesCommercialContact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VentesCommercialContact[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VentesCommercialContact findOrCreate($search, callable $callback = null, $options = [])
 */
class VentesCommercialContactsTable extends Table
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

        $this->setTable('ventes_commercial_contacts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Ventes', [
            'foreignKey' => 'vente_id',
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
            ->scalar('full_name')
            ->maxLength('full_name', 255)
            ->allowEmpty('full_name');

        $validator
            ->scalar('telfixe')
            ->maxLength('telfixe', 100)
            ->allowEmpty('telfixe');

        $validator
            ->scalar('telportable')
            ->maxLength('telportable', 100)
            ->allowEmpty('telportable');

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
        $rules->add($rules->existsIn(['vente_id'], 'Ventes'));

        return $rules;
    }
}
