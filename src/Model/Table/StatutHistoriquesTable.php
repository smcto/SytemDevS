<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StatutHistoriques Model
 *
 * @property \App\Model\Table\DevisTable|\Cake\ORM\Association\BelongsTo $Devis
 * @property \App\Model\Table\DevisFacturesTable|\Cake\ORM\Association\BelongsTo $DevisFactures
 *
 * @method \App\Model\Entity\StatutHistorique get($primaryKey, $options = [])
 * @method \App\Model\Entity\StatutHistorique newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StatutHistorique[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StatutHistorique|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StatutHistorique|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StatutHistorique patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StatutHistorique[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StatutHistorique findOrCreate($search, callable $callback = null, $options = [])
 */
class StatutHistoriquesTable extends Table
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

        $this->setTable('statut_historiques');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Devis', [
            'foreignKey' => 'devi_id'
        ]);
        $this->belongsTo('DevisFactures', [
            'foreignKey' => 'devis_facture_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
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
            ->scalar('statut_document')
            ->maxLength('statut_document', 250)
            ->requirePresence('statut_document', 'create')
            ->notEmpty('statut_document');

        $validator
            //->dateTime('time')
            ->notEmpty('time');

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
        $rules->add($rules->existsIn(['devi_id'], 'Devis'));
        $rules->add($rules->existsIn(['devis_facture_id'], 'DevisFactures'));

        return $rules;
    }
}
