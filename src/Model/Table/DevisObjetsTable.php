<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DevisObjets Model
 *
 * @property \App\Model\Table\DevisTable|\Cake\ORM\Association\BelongsTo $Devis
 *
 * @method \App\Model\Entity\DevisObjet get($primaryKey, $options = [])
 * @method \App\Model\Entity\DevisObjet newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DevisObjet[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DevisObjet|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisObjet|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisObjet patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DevisObjet[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DevisObjet findOrCreate($search, callable $callback = null, $options = [])
 */
class DevisObjetsTable extends Table
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

        $this->setTable('devis_objets');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Devis', [
            'foreignKey' => 'devis_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

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
        $rules->add($rules->existsIn(['devis_id'], 'Devis'));

        return $rules;
    }
}
