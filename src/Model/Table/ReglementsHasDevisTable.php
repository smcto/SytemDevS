<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReglementsHasDevis Model
 *
 * @property \App\Model\Table\ReglementsTable|\Cake\ORM\Association\BelongsTo $Reglements
 * @property \App\Model\Table\DevisTable|\Cake\ORM\Association\BelongsTo $Devis
 * @property \App\Model\Table\FacturesTable|\Cake\ORM\Association\BelongsToMany $Factures
 *
 * @method \App\Model\Entity\ReglementsHasDevi get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReglementsHasDevi newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ReglementsHasDevi[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReglementsHasDevi|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReglementsHasDevi|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReglementsHasDevi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReglementsHasDevi[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReglementsHasDevi findOrCreate($search, callable $callback = null, $options = [])
 */
class ReglementsHasDevisTable extends Table
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

        $this->setTable('reglements_has_devis');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Reglements', [
            'foreignKey' => 'reglements_id',
            'joinType' => 'INNER'
        ]);
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
// //         $rules->add($rules->existsIn(['reglements_id'], 'Reglements'));
// //         $rules->add($rules->existsIn(['devis_id'], 'Devis'));
// 
        return $rules;
    }
}
