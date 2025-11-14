<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DevisPreferences Model
 *
 * @property \App\Model\Table\InfoBancairesTable|\Cake\ORM\Association\BelongsTo $InfoBancaires
 *
 * @method \App\Model\Entity\DevisPreference get($primaryKey, $options = [])
 * @method \App\Model\Entity\DevisPreference newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DevisPreference[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DevisPreference|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisPreference|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisPreference patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DevisPreference[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DevisPreference findOrCreate($search, callable $callback = null, $options = [])
 */
class DevisPreferencesTable extends Table
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

        $this->setTable('devis_preferences');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('InfosBancaires', [
            'className' => 'InfosBancaires',
            'foreignKey' => 'info_bancaire_id'
        ]);

        $this->belongsTo('Adresses', [
            'className' => 'Adresses',
            'foreignKey' => 'adress_id'
        ]);
    }

    protected function _initializeSchema($schema)
    {
        $schema->setColumnType('moyen_reglements', 'json');
        return $schema;
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
            ->scalar('moyen_reglements')
            ->allowEmpty('moyen_reglements');

        $validator
            ->scalar('delai_reglements')
            ->allowEmpty('delai_reglements');

        $validator
            ->decimal('accompte_value')
            ->allowEmpty('accompte_value');

        $validator
            ->scalar('accompte_unity')
            ->allowEmpty('accompte_unity');

        return $validator;
    }

    public function findComplete(Query $query, array $options)
    {
        // $query->contain(['InfosBancaires', 'Adresses']); ça dupliquer l'infobancaire 
        $query->contain(['Adresses']);
        return $query;
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
        // $rules->add($rules->existsIn(['info_bancaire_id'], 'InfoBancaires'));
        return $rules;
    }
}
