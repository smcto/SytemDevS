<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DevisFacturesEcheances Model
 *
 * @property \App\Model\Table\DevisTable|\Cake\ORM\Association\BelongsTo $Devis
 *
 * @method \App\Model\Entity\DevisFacturesEcheance get($primaryKey, $options = [])
 * @method \App\Model\Entity\DevisFacturesEcheance newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DevisFacturesEcheance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DevisFacturesEcheance|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisFacturesEcheance|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisFacturesEcheance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DevisFacturesEcheance[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DevisFacturesEcheance findOrCreate($search, callable $callback = null, $options = [])
 */
class DevisFacturesEcheancesTable extends Table
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

        $this->setTable('devis_factures_echeances');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Devis', [
            'foreignKey' => 'devis_id'
        ]);

        
        $this->belongsTo('DevisFactures', [
            'foreignKey' => 'devis_facture_id',
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
            ->decimal('montant')
            ->allowEmpty('montant');

        $validator
            ->date('date')
            ->allowEmpty('date');

        $validator
            ->boolean('is_payed')
            ->notEmpty('is_payed');

        $validator
            ->boolean('is_accompte')
            ->notEmpty('is_accompte');

        $validator
            ->date('date_paiement')
            ->allowEmpty('date_paiement');

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
// //         $rules->add($rules->existsIn(['devis_id'], 'Devis'));
// 
        return $rules;
    }
}
