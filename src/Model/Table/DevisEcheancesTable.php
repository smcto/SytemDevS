<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DevisEcheances Model
 *
 * @method \App\Model\Entity\DevisEcheance get($primaryKey, $options = [])
 * @method \App\Model\Entity\DevisEcheance newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DevisEcheance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DevisEcheance|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisEcheance|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisEcheance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DevisEcheance[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DevisEcheance findOrCreate($search, callable $callback = null, $options = [])
 */
class DevisEcheancesTable extends Table
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

        $this->setTable('devis_echeances');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo(
            'Devis', [
                'className' => 'Devis',
                'foreignKey' => 'devis_id',
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
            ->decimal('montant')
            ->allowEmpty('montant');

        $validator
            ->date('date')
            ->allowEmpty('date');

        $validator
            ->boolean('is_payed')
            ->allowEmpty('is_payed');

        return $validator;
    }
}
